<?php namespace Myth\Forums\Entities;

use CodeIgniter\Entity;

class Tag extends Entity
{
    /**
     * The Tag "type", based on is_structural.
     *
     * @return string
     */
    public function typeString()
    {
        return $this->is_structural
            ? 'primary'
            : 'secondary';
    }

    /**
     * Handle our admin UI toggle.
     *
     * @param null $value
     */
    protected function setPublic($value = null)
    {
        if ($value === 'on')
        {
            $this->attributes['public'] = 1;
        }
        elseif ($value === 'off')
        {
            $this->attributes['public'] = 0;
        }
        else
        {
            $this->attributes['public'] = $value;
        }
    }
}
