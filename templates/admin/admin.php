<div class="wrap">

    <h2><?php _e('PKJ Any Post Type', 'pkj-any-post-type') ?></h2>
    <?php if (empty($available_schemas)): ?>
        <div class="error">
            <p><?php _e('Could not find any Custom Post Types that have hierarchical set to true.', 'pkj-any-post-type'); ?></p>
            <strong><?php _e('Sample implementation:', 'pkj-any-post-type'); ?>:</strong>
            <pre>
register_post_type('news',
    array(
        'labels' => array(
        'name' => __('News'),
        'singular_name' => __('News item')
    ),
    'public' => true,
    'hierarchical' => true
    )
)
// do not add 'rewrite' => array('slug' => '...').
            </pre>
        </div>
    <?php endif ?>


    <form method="post" action="options.php">

        <?php settings_fields( 'pkj-any-parent-type-admin-menu' ); ?>
        <?php do_settings_sections( 'pkj-any-parent-type-admin-menu' ); ?>
        <?php submit_button(); ?>

    </form>
</div>