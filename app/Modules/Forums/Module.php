<?php namespace Myth\Forums;

use App\Core\BaseModule;
use App\Core\Menus;
use Myth\Menus\Menu;
use Myth\Menus\MenuItem;

/**
 * Forums Module Info class
 *
 * @package Myth\Forums
 */
class Module extends BaseModule
{
    public function initAdmin()
    {
        $menu = Menus::get('admin');

        $collection = $menu->createCollection('forums', 'Forums');
        $collection->setFontAwesomeIcon('far fa-comment-alt fa-2x');

        // Tags
        $item = (new MenuItem())
            ->setTitle('Tags and Categories')
            ->setAltText('Tags')
            ->setFontAwesomeIcon('fas fa-tags')
            ->setNamedRoute('forum-admin-tags');
        $collection->addItem($item);
    }
}
