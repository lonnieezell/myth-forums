<?php namespace Myth\Parsers;

/**
 * Class MarkdownParser
 *
 * Used for formatting topic/post bodies.
 *
 * @package Myth\Parsers
 */
class MarkdownParser implements ParserInterface
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
        // @todo Implement @-user references - https://github.com/erusev/parsedown/issues/281
        $parser = new \Parsedown();

        // Don't trust users
        $parser->setSafeMode(true);

        return $parser->text($text);
    }
}
