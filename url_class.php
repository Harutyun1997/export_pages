<?php
require_once 'include/database.php';


class Url extends Database
{
    public static $table_name = 'urls';
    public static $db_fields = [
        'id',
        'url',
        'xml',
    ];
    public $id;
    public $url;
    public $html;
    public $xml;

    public function __construct($url)
    {
        $this->url = $url;
        $this->html = file_get_contents($url);
        $this->xml = $this->clear_html_css_js($this->html);
    }

    public function index_words()
    {
        $words = explode(" ", $this->xml);
        $result = [];

        foreach ($words as $word) {
            if (isset($result[$word])) {
                $result[$word]++;
            } else {
                $result[$word] = 1;
            }
        }

        if (isset($this->id)) {
            foreach ($result as $word => $count) {
                $content = new Word($word, $count, $this->id);
                $content->save();
            }
        }
    }

    /**
     * @return array
     */
    public function get_all_urls()
    {
        $urls = explode('<a href="', $this->html);
        $index_urls = [];
        foreach ($urls as $value) {
            $position = strpos($value, '"', 1);
            $value = substr($value, 0, $position);
            $position = strpos($value, '#', 0);
            $pos = strpos($value, "<!DOCTYPE html><html><head><meta name=", 0);
            $another_page = strpos($value, 'http', 0);
            if ($position === false && strlen($value) > 1 && $pos === false && $another_page === false) {
                $position = strpos($this->url, '/', 13);
                if ($position !== false) {
                    $index_urls[] = substr_replace($this->url, $value, $position);
                } else {
                    $index_urls[] = $this->url . $value;
                }
            }
        }

        return $index_urls;
    }

    public function save()
    {
        $sql = " SELECT id FROM " . static::$table_name . " WHERE url = '$this->url'";
        $result = $this->get_sql_result($sql);

        if (isset($result) && isset($result[0]) && isset($result[0][0])) {
            $this->id = $result[0][0];
        }

        if (!isset($this->id)) {
            $this->id = parent::save();
        }
        return $this->id;
    }

    public static function handle_url($entered_url, $indexed_words)
    {
        $is_new_word = array_search($entered_url, $indexed_words) === false;

        if (!$is_new_word) {
            return false;
        }

        $indexed_words[] = $entered_url;
        $url = new Url($entered_url);

        if ($url->save()) {
            $url->index_words();
            $urls = $url->get_all_urls();

            foreach ($urls as $found_url) {
                $url->handle_url($found_url, $indexed_words);
            }
        }
    }
}
