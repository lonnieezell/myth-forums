<?php

/**
 * The goal of this file is to allow developers a location
 * where they can overwrite core procedural functions and
 * replace them with their own. This file is loaded during
 * the bootstrap process and is called during the frameworks
 * execution.
 *
 * This can be looked at as a `master helper` file that is
 * loaded early on, and may also contain additional functions
 * that you'd like to use throughout your entire application
 *
 * @link: https://codeigniter4.github.io/CodeIgniter4/
 *
 * @param string $class
 * @param bool   $getShared
 *
 * @return
 */

/**
 * Simple model factory with singleton support.
 *
 * @param string $class
 * @param bool   $getShared
 *
 * @return mixed
 */
function model(string $class, bool $getShared = true)
{
    return service('models')->factory($class, $getShared);
}

/**
 * Returns whether the current URI path matches the given $path.
 * Supports the '*' wildcard, like:
 *
 * is_uri('/forums*')
 *
 * @param string $path
 *
 * @return bool
 */
function has_uri(string $path=''): bool
{
    $current = service('request')->uri->getPath();

    return strpos($current, trim($path)) === 0;
}
