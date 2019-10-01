<?php namespace Myth\Forums\Entities;

use CodeIgniter\Entity;

class Topic extends Entity
{
    /**
     * Returns the body as a snippet, with HTML and any
     * other code stripped, limited to $words words in length.
     *
     * @param int $words
     *
     * @return string
     */
    public function snippet(int $words = 50): string
    {
        if (empty($this->html)) {
            return '';
        }

        helper('text');

        return word_limiter(strip_tags($this->html), $words);
    }
}
