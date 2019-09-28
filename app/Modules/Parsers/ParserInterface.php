<?php namespace Myth\Parsers;

interface ParserInterface
{
    /**
     * Handles the actual parsing and formatting
     * of the raw string (topic/post body)
     *
     * @param string $text
     *
     * @return string
     */
    public function parse(string $text) : string;
}
