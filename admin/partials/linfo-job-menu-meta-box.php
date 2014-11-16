<div id="job-archive" class="posttypediv">
    <div id="tabs-panel-job-archive" class="tabs-panel tabs-panel-active">
        <ul id="job-archive-checklist" class="categorychecklist form-no-clear">
            <?= walk_nav_menu_tree(
                array_map('wp_setup_nav_menu_item', [$ob_post_type]),
                0, (object)['walker' => $walker]
            ); ?>
        </ul>
    </div>
</div>
<p class="button-controls">
    <span class="add-to-menu">
        <input type="submit" class="button-secondary submit-add-to-menu" id="submit-job-archive"
               name="add-job-archive-menu-item" value="<?php esc_attr_e('Add to Menu'); ?>"/>
        <span class="spinner"></span>
    </span>
</p>