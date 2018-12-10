<?php
require_once 'include/database.php';
require_once 'word_class.php';
require_once 'url_class.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $indexed_words = [];
    $url = $_POST['name'];

    if (empty($url)) {
        echo 'Please enter URL';
    }

    Url::handle_url($url, $indexed_words);
    echo "The URL has been indexed successfully!";
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $word = $_GET["name"];
    if (empty($url)) {
        echo 'Word';
    }
    $result = Word::search_word($word);
    echo json_encode($result);
}