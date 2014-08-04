<?php
/**
 * Created by PhpStorm.
 * User: peecdesktop
 * Date: 03.08.14
 * Time: 16:03
 */

class Pkj_AnyParentType_Rewrite {

    private $rewriteRulesOldPostObject;

    public static function instance()
    {
        static $inst = null;
        if ($inst === null) {
            $inst = new Pkj_AnyParentType_Rewrite();
        }
        return $inst;
    }

    /**
     * Rewrite rules is so we don't get any 404 on the pages.
     */
    private function __construct () {

        add_filter( 'post_type_link', array($this, 'rewrite_rules_linkrewrite'), 10, 3 );
        add_action('rewrite_rules_array', array($this, 'rewrite_rules_add_rules'));

        add_action('pre_post_update', array($this, 'rewrite_rules_pre_save'));
        add_action( 'save_post', array($this, 'rewrite_rules_save_post') );
    }

    /**
     * Determines if we should rewrite the rule for this post, only if certain conditions are set..
     * @param $post
     * @return bool
     */
    public function rewrite_rules_should_rewrite ($post) {
        $postTypeSchema = Pkj_AnyParentType_Global::instance()->get_post_type_schema();

        $allowedPostTypes = array_keys($postTypeSchema);

        $should = in_array($post->post_type, $allowedPostTypes)  && 'publish' == $post->post_status;

        // Check if the PARENT matches any of the selected onces in admin cp:
        if ($should && $post->post_parent) {
            $allowedParentPostTypes = isset($postTypeSchema[$post->post_type]) ? $postTypeSchema[$post->post_type]['values'] : array();
            $parentPost = get_post($post->post_parent);
            $should = in_array($parentPost->post_type, $allowedParentPostTypes);
        }

        return $should;
    }

    public function rewrite_rules_pre_save ($post_id) {
        $post = get_post($post_id);
        if ($this->rewrite_rules_should_rewrite($post)) {
            $this->rewriteRulesOldPostObject = $post;
        }
    }

    public function rewrite_rules_save_post ($post_id) {
        $post = get_post($post_id);
        if ($this->rewrite_rules_should_rewrite($post)) {
            $flush = true;

            // For performance, do we need to flush ?
            /*
            if ($this->rewriteRulesOldPostObject) {
                // Check if parent id or name changed.
                if ($post->post_name || 
                    $post->post_parent == $this->rewriteRulesOldPostObject->post_parent) {
                    $flush = false;
                }
            } breaks WPML*/
            if ($flush) {
                $rule = $this->rewrite_rules_get_rule($post);
                add_rewrite_rule($rule['from'], $rule['to'], 'top'); // RULES MUST BE ON TOP...
                flush_rewrite_rules(); // We need to flush the rules
            }
        }
    }



    public function rewrite_rules_linkrewrite ($post_link, $post, $leavename) {
        if ( !$this->rewrite_rules_should_rewrite($post)) {
            return $post_link;
        }

        $post_link = str_replace( '/' . $post->post_type . '/', '/', $post_link );
        return $post_link;
    }

    public function rewrite_rules_add_rules ($existingRules) {
        global $post;

        $postTypeSchema = Pkj_AnyParentType_Global::instance()->get_post_type_schema();

        
        
        foreach($postTypeSchema as $postType => $info) {
            // suppress_filters for wpml
            $q = new WP_Query("suppress_filters=1&nopaging=true&post_type=$postType");
            while ( $q->have_posts() ) {
                $q->the_post();
                //var_dump($post);
                if ($this->rewrite_rules_should_rewrite($post)) {
                    $rule = $this->rewrite_rules_get_rule($post);
                    $existingRules = array_merge(array($rule['from'] => $rule['to']), $existingRules);
                }
            }
            wp_reset_postdata();
        }
        return $existingRules;
    }

    public function rewrite_rules_get_rule($post) {
        $slug = '';
        // If the post has a parent, we need the slug for the parent - that we append to the URL.
        if ($post->post_parent) {
            $url_endpoint = get_permalink($post->post_parent);
            $url_endpoint = parse_url( $url_endpoint );
            $slug = substr($url_endpoint['path'], 1); // remove initial slash.
        }

        // WPML compability, remove such as "fr" "nb" from the "from part".
        if (defined('ICL_LANGUAGE_CODE')) {
            global $sitepress;
            $dl = $sitepress->get_default_language();
            $codelen = strlen(ICL_LANGUAGE_CODE);

            if ($dl != ICL_LANGUAGE_CODE && 
                substr($slug, 0, $codelen+1) == ICL_LANGUAGE_CODE.'/') {
                $slug = substr($slug, 3);
            }
        }
        return array(
            'from' => $slug.$post->post_name.'$',
            'to' => 'index.php?'.$post->post_type.'='.$post->post_name
        );
    }

} 
