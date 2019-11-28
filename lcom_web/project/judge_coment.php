<?php


function dark_word_check($text)
{
    /*********************
     *	$textにチェック対象のテキスト、$ng_word_arrayにはNGワードの配列が入ります。
     *	$text中にNGワードが存在しなければ、0を返します。
     *********************/
    $dark_word_array = array('ころす', '殺す', '死ね', 'バカ', 'あほ', 'ばか', '死んだほうが', 'ブサ', '不細工', 'きもすぎ', 'しね');

    str_replace($dark_word_array, $dark_word_array, $text, $count);
    return $count;
}

function light_word_check($text)
{
    /*********************
     *	$textにチェック対象のテキスト、$ng_word_arrayにはNGワードの配列が入ります。
     *	$text中にNGワードが存在しなければ、0を返します。
     *********************/
    $light_word_array = array('好き', 'ありがと', 'さんきゅ', 'きれい', 'すばらしい', '綺麗', '素晴らしい', '美しい', 'うつくしい', 'いいね', 'いいと思');

    str_replace($light_word_array, $light_word_array, $text, $count);
    return $count;
}
