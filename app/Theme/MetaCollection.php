<?php namespace App\Theme;

class MetaCollection
{
    /**
     * All meta tags to display on the page.
     * @var array
     */
    protected $metaTags = [];

    /**
     * Sets the value for a single meta tag.
     *
     * @param string $key
     * @param string $value
     *
     * @return $this
     */
    public function setTag(string $key, string $value)
    {
        $this->metaTags[$key] = $value;

        return $this;
    }

    /**
     * Generates all meta data tags.
     */
    public function tags()
    {
        $out = '';

        foreach ($this->metaTags as $key => $value)
        {
            $out ="<meta name=\"{$key}\" content=\"{$value}\">\n";
        }

        return $out;
    }
}
