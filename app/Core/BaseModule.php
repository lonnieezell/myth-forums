<?php namespace App\Core;

/**
 * Class BaseModule
 *
 * All modules that need to have some input into
 * the execution cycle should create a Modules.php in their
 * primary folder that extends this class.
 *
 * @package App\Core
 */
class BaseModule
{
    /**
     * Handles any initialization that needs to happen
     * for the admin. Called on every page in the admin,
     * so primary use is setting up the menus, etc.
     */
    public function initAdmin() {}
}
