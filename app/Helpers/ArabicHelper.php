<?php


function arabic_slug($string = null, $separator = "-")
{
    if (is_null($string)) {
        return "";
    }

    // Remove spaces from the beginning and from the end of the string
    $string = trim($string);

    // Keep Arabic characters, Latin characters, numbers, and some specific punctuation
    $string = preg_replace("/[^a-zA-Z0-9_ ءاأإآؤئبتثجحخدذرزسشصضطظعغفقكلمنهويةى-]/u", "", $string);

    // Remove multiple dashes or whitespaces
    $string = preg_replace("/[\s-]+/", " ", $string);

    // Convert whitespaces and underscores to the given separator
    $string = preg_replace("/[\s_]/", $separator, $string);

    return $string;

}
