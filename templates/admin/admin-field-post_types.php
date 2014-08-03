<?php foreach($available_schemas as $superPostType => $lookupLabel): $info  = isset($selected[$superPostType]) ? $selected[$superPostType] : array('values' => array()); ?>
    <p>
        <label><strong><?php echo $lookupLabel?> </strong> can have parent types:</label>
        <div class="tagchecklist pkj-selectedlist" data-section="<?php echo $superPostType ?>">

        <?php foreach($info['values'] as $postType): ?>
            <span>
                <input name="pkj-any-parent-post_types[<?php echo $superPostType?>][]" type="hidden" value="<?php echo $postType; ?>" />
                <a  class="ntdelbutton">X</a>&nbsp;
                <?php if (isset($lookup[$postType])): ?>
                    <?php echo $lookup[$postType] ?>
                <?php else: ?>
                    <?php echo $postType; ?>
                <?php endif ?>
            </span>
        <?php endforeach ?>
        </div>

        <input placeholder="<?php _e('Add post type','pkj-any-post-type')?>" type="text" data-section="<?php echo $superPostType ?>" class="pkj-selectlist-add" />
    </p>
<?php endforeach ?>
<?php if (empty($selected)): ?>
<?php _e('No CPT found, see error message.','pkj-any-post-type')?>
<?php endif ?>

