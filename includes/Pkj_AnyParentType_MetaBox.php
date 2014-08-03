<?php
/**
 * Created by PhpStorm.
 * User: peecdesktop
 * Date: 03.08.14
 * Time: 16:10
 */

class Pkj_AnyParentType_MetaBox {

    public static function instance()
    {
        static $inst = null;
        if ($inst === null) {
            $inst = new Pkj_AnyParentType_MetaBox();
        }
        return $inst;
    }


    private function __construct () {
        // test code.
        add_action('admin_menu', function() {
            remove_meta_box('pageparentdiv', 'chapter', 'normal');
        });


        add_action('add_meta_boxes', array($this, 'add_meta_boxes_add'));
    }

    public function add_meta_boxes_add () {
        $optionSchemas = Pkj_AnyParentType_Global::instance()->get_post_type_schema();

        $isFirst = true;
        foreach ($optionSchemas as $ownerPageType => $schema) {
            add_meta_box(
                'pkj-any-post-type-metabox',
                __('Parent object', 'pkj-any-parent-type'),
                array($this, 'add_meta_boxes_add_callback'),
                $ownerPageType,
                'side',
                'high',
                array(
                    'schema' => $schema
                )
            );
            $isFirst = false;
        }
    }

    public function add_meta_boxes_add_callback ($post, $box) {
        global $post;
        $schema = $box['args']['schema'];
        $lookup = Pkj_AnyParentType_Global::instance()->get_lookup_schema();
        $post_type_object = get_post_type_object($post->post_type);

        $isFirst = true;
        foreach($schema['values'] as $k => $pageType) {
            $pages = wp_dropdown_pages(array(
                    'post_type' => $pageType,
                    'selected' => $post->post_parent,
                    'name' => 'selection-parent-id-'.$pageType,
                    'id' => 'selection-parent-id-'.$pageType,
                    'show_option_none' => __('(no parent)'),
                    'sort_column' => 'menu_order, post_title',
                    'echo' => 0)
            );

            // Only ONCE:
            if ($isFirst) {
                ?>
                <script>
                    jQuery(function ($) {
                        $( "select[name^='selection-parent-id-']").each(function () {
                            $(this).change(function () {
                                $('#parent_id').val($(this).val());
                                var status = $('#parent_id_status');
                                var newText = $(this).children(':selected').text();
                                status.text(newText);
                                $( "select[name^='selection-parent-id-']").not(this).val('');
                            });
                        });
                    });
                </script>
                <?php
                echo "<p><strong>".__('Selected parent', 'pkj-any-parent-type').":</strong>
                <span id='parent_id_status'>
                ".($post->post_parent ? get_the_title($post->post_parent) : __('(no parent)') )."
                </span></p>
                <input type='hidden' id='parent_id' name='parent_id' value='{$post->post_parent}' />";
            }

            if (!empty($pages)) {
                $label = $lookup[$pageType];
                echo "<p><strong>{$label}: </strong> ";
                echo $pages;
                echo "</p>";
            } // end empty pages check
            $isFirst = false;
        }
    }

} 