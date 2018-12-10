<?php
require_once 'include/database.php';

class  Word extends Database
{
    public static $table_name = 'words';
    public static $db_fields = [
        'id',
        'word',
        'count',
        'url_id',
    ];
    public $id;
    public $word;
    public $count;
    public $url_id;

    public function __construct($word, $count, $url_id)
    {
        $this->word = $word;
        $this->count = $count;
        $this->url_id = $url_id;
    }

    public function save()
    {
        $sql = " SELECT * FROM " . static::$table_name . " WHERE word = '$this->word '";
        $const = $this->get_sql_result($sql);
        if (isset($const) && isset($const[0]) && isset($const[0][0]) && isset($const[0][2])) {

            $this->id = $const[0][0];
            $this->count += $const[0][2];
        }

        return parent::save();
    }

    public static function search_word($word)
    {
        $sql = "SELECT w.word,u.url FROM words w INNER JOIN urls u ON w.`url_id` = u.`id`WHERE w.`word` LIKE '$word%' ORDER BY w.count DESC";

        return parent::get_sql_result($sql);
    }
}

