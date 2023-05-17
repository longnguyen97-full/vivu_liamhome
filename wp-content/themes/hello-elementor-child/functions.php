<?php

/**
 * Define constants
 */
define('CHILD_DIR', get_stylesheet_directory());
define('INC', CHILD_DIR . '/inc');
define('CLASSES', INC . '/classes');

/**
 * Require files
 */
require_once(INC . '/setup.php');
require_once(INC . '/helper.php');
require_once(INC . '/filter_nav_menu_items.php');
require_once(CLASSES . '/authentication.php');
