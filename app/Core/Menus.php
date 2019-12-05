<?php namespace App\Core;

use Myth\Menus\Menu;

/**
 * Class Menus
 *
 * Site-wide menu management in one simple spot.
 *
 * @package App\Core
 */
class Menus
{
    /**
     * Menu cache
     *
     * @var array
     */
    protected static $menus = [];

    /**
     * Get an instance of a menu with alias $menuName
     *
     * @param string $menuName
     *
     * @return Menu
     */
    public static function get(string $menuName): Menu
    {
        if (! isset(static::$menus[$menuName])) {
            static::$menus[$menuName] = new Menu();
        }

        return static::$menus[$menuName];
    }
}
