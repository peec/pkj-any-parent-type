<?php
/**
 * Created by PhpStorm.
 * User: peecdesktop
 * Date: 03.08.14
 * Time: 01:15
 */

class Pkj_AnyParentType_AdminPage {

    const ADMIN_PAGE_NAME = 'pkj-any-parent-type-admin-menu';

    public static function instance()
    {
        static $inst = null;
        if ($inst === null) {
            $inst = new Pkj_AnyParentType_AdminPage();
        }
        return $inst;
    }
    private function __construct () {
        add_action('admin_menu', array($this, 'admin_menu'));
        add_action('admin_init', array($this, 'admin_init'));


        add_action('admin_enqueue_scripts', function ($hook_suffix) {
            if( 'settings_page_pkj-any-parent-type-admin-menu' != $hook_suffix ) return;
            wp_enqueue_script( 'pkj-apt-admin-ajax-script', plugins_url( '/js/pkj-any-parent-type-admin.js', PKJ_PLUGIN_ANY_PARENT_TYPE_FILE ),
                array('jquery',
                    'jquery-ui-autocomplete'
                )
            );
        });

        if (is_admin () ){
            add_action( 'wp_ajax_pkj_search_post_types', array($this, 'ajax_search_post_types') );
        }


        add_filter( 'plugin_action_links_' . plugin_basename(PKJ_PLUGIN_ANY_PARENT_TYPE_PATH) . '/boostrap.php', array($this, 'filter_plugin_links'));

    }



    public function filter_plugin_links ($links) {
        $settings_link = '<a href="'. get_admin_url(null, 'options-general.php?page=' . self::ADMIN_PAGE_NAME) .'">Settings</a>';
        array_unshift( $links, $settings_link );
        return $links;

    }

    public function ajax_search_post_types () {
        $data = array(
            'selected' => Pkj_AnyParentType_Global::instance()->get_post_type_schema(),
            'lookup' => Pkj_AnyParentType_Global::instance()->get_lookup_schema()
        );
        wp_send_json_success($data);
    }

    public function admin_init () {


        add_settings_section(
            'pkj-any-parent-type-setting_section',
            __('Settings', 'pkj-any-post-type'),
            function () {
                Pkj_AnyParentType_Global::instance()->render('admin/admin-section-intro.php');
            },
            self::ADMIN_PAGE_NAME
        );

        // Add the field with the names and function to use for our new
        // settings, put it in our new section
        add_settings_field(
            'pkj-any-parent-post_types',
            __('Post type configuration', 'pkj-any-parent-type'),
            array($this, 'settings_field_view'),
            self::ADMIN_PAGE_NAME,
            'pkj-any-parent-type-setting_section'
        );
        // Register the setting for $_POST to work.
        register_setting( self::ADMIN_PAGE_NAME, 'pkj-any-parent-post_types' );

    }



    public function settings_field_view () {

        Pkj_AnyParentType_Global::instance()->render('admin/admin-field-post_types.php', array(
            'selected' => Pkj_AnyParentType_Global::instance()->get_post_type_schema(),
            'lookup' => Pkj_AnyParentType_Global::instance()->get_lookup_schema(),
            'available_schemas' => Pkj_AnyParentType_Global::instance()->get_available_post_type_schemas()
        ));
    }

    public function admin_menu () {
        add_options_page(
            __('PKJ Any Parent Type', 'pkj-any-parent-type'),
            __('Any Parent Type', 'pkj-any-parent-type'),
            'manage_options',
            'pkj-any-parent-type-admin-menu',
            array($this, 'options')
        );
    }

    public function options () {

        if ( !current_user_can( 'manage_options' ) )  {
            wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
        }
        if(isset($_GET['settings-updated']) && $_GET['settings-updated'])
        {
            // We need to rewrite.

            flush_rewrite_rules();
        }

        Pkj_AnyParentType_Global::instance()->render('admin/admin.php', array(
            'available_schemas' => Pkj_AnyParentType_Global::instance()->get_available_post_type_schemas(),
        ));
    }




} 