<?php namespace Myth\Parsers;

class RenderPipeline
{
    /**
     * The primary method for the render pipeline - it loads the correct
     * parser, parses it into HTML and runs through a few other parsers
     * to handle things like @mentions and #hashtags.
     *
     * @param string|null $body
     * @param string|null $parser
     *
     * @return string
     */
    public function render(string $body = null, string $parser = null): string
    {
        if (empty($body))
        {
            return '';
        }

        // Load parser to use for this post.
        $useParser = ! empty($parser)
            ? $parser
            : config('Parsers')->defaultParser;

        $parsers = config('Parsers')->availableParsers;

        // No parser found - then should be raw text,
        // just do a simple formatting to preserve returns.
        if (! isset($parsers[$useParser]))
        {
            return nl2br($body);
        }

        $useParser = $parsers[$useParser];
        $parser = new $useParser();

        $body = $parser->parse($body);

        $body = $this->convertMentions($body);
        $body = $this->convertHashtags($body);

        return $body;
    }

    /**
     * Attempt to replace any @username mentions within the string
     * with a link to the existing user, if any.
     *
     * @param string $body
     *
     * @return string
     */
    protected function convertMentions(string $body): string
    {
        $regex = "/@+([\w\.]+)/";

        $body = preg_replace($regex, '<a href="/forum/members/$1">$0</a>', $body);

        return $body;
    }

    /**
     * Attempt to replace any @username mentions within the string
     * with a link to the existing user, if any.
     *
     * @param string $body
     *
     * @return string
     */
    protected function convertHashtags(string $body): string
    {
        $regex = "/#+([\w\.]+)/";

        $body = preg_replace($regex, '<a href="/forum/hashtag/$1">$0</a>', $body);

        return $body;
    }
}
