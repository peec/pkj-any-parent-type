<?php
/*
Plugin Name: PKJ Any Parent Type
Text Domain: pkj-any-parent-type
Plugin URI: https://github.com/peec/pkj-any-parent-type
Description: This plugin lets you select what parent pages you allow to set for custom post types. By default only the same type is allowed.
Version: 0.0.3
Author: Petter Kjelkenes
Author URI: http://pkj.no
License: GPLv2 or later
*/

define('PKJ_PLUGIN_ANY_PARENT_TYPE_PATH', dirname(__FILE__));
define('PKJ_PLUGIN_ANY_PARENT_TYPE_NAME', 'pkj-any-parent-type');
define('PKJ_PLUGIN_ANY_PARENT_TYPE_FILE', __FILE__);


$classes = array(
    'Pkj_AnyParentType_Global',
    'Pkj_AnyParentType_AdminPage',
    'Pkj_AnyParentType_Rewrite',
    'Pkj_AnyParentType_MetaBox'
);

foreach($classes as $class) {
    include PKJ_PLUGIN_ANY_PARENT_TYPE_PATH. "/includes/$class.php";
}

Pkj_AnyParentType_Global::instance();
Pkj_AnyParentType_AdminPage::instance();
Pkj_AnyParentType_MetaBox::instance();
Pkj_AnyParentType_Rewrite::instance();
