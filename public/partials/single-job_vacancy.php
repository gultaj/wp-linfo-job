<?php $object = get_queried_object();
      $post_type = get_post_type_object( $object->post_type ); ?>

<?php get_header();?>
<div id="primary" class="col-xs-9">
    <div class="row">
        <div class="col-xs-12">
            <div id="content" class="" role="main">
                <div><?php Wp_Linfo_Job_Public::breadcrumbs( $post_type ) ?></div>
                <div class="content-header row"> <?php Wp_Linfo_Job_Public::title( $post_type ) ?> </div>
                <div class="job__aside_links"><?= Wp_Linfo_Job_Public::get_archive_link('resume') ?></div>
                <div class="vacancy__list">
                <pre>
                    <?php print_r($object) ?>
                    <?php print_r(Wp_Linfo_Job_Public::get_vacancy_data($object->ID)) ?>
                </pre>
                </div>
                <div class="job__pagination"> <?php lidainfo_paging_nav() ?> </div>
            </div>
        </div>
    </div>
</div>
<?php get_sidebar('left'); ?>
<?php get_footer(); ?>