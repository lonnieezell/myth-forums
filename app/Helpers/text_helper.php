<?php

if (! function_exists('slugify'))
{
    function slugify(string $str)
    {
        $str = str_replace(' ', '-', $str);
        $str = preg_replace('/[^a-zA-Z0-9\-_]/', '', $str);
        $str = strtolower($str);

        return $str;
    }
}
