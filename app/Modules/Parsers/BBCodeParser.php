<?php namespace Myth\Parsers;

use ChrisKonnertz\BBCode\BBCode;

/**
 * Class BBCodeParser
 *
 * Used for formatting topic/post bodies.
 *
 * @package Myth\Parsers
 */
class BBCodeParser implements ParserInterface
{
    /**
     * Handles the actual parsing and formatting
     * of the raw string (topic/post body)
     *
     * @param string $text
     *
     * @return string
     */
    public function parse(string $text) : string
    {
        $parser = new BBCode();

        return $parser->render($text);
    }
}
