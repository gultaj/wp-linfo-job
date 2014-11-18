<?php $object = get_post_type_object(get_query_var('post_type')); ?>

<?php get_header();?>
<div id="primary" class="col-xs-9">
    <div class="row">
        <div id="content" class="col-xs-12" role="main">
            <div><?php Wp_Linfo_Job_Public::breadcrumbs( $object ) ?></div>
            <div class="content-header row"> <?php Wp_Linfo_Job_Public::title( $object ) ?> </div>
            <div class="job__aside_links"><?= Wp_Linfo_Job_Public::get_archive_link('resume') ?></div>
            <div class="vacancy__list">
                <div class="vacancy__list_header">
                    <div class="vacancy__name">Вакансия</div>   
                    <div class="vacancy__company">Организация</div>
                    <div class="vacancy__salary">Оплата</div>    
                </div>
                <?php foreach (Wp_Linfo_Job_Public::get_vacancies() as $vacancy) : ?>
                <a href="<?= get_permalink( $vacancy->ID ) ?>" class="vacancy">
                    <div class="vacancy__name"><?= $vacancy->post_title ?></div>   
                    <div class="vacancy__company"><?= $vacancy->company ?></div>
                    <div class="vacancy__salary"><?= $vacancy->salary ?></div>
                </a>
                <?php endforeach; ?>
            </div>
            <div class="job__pagination"> <?php lidainfo_paging_nav() ?> </div>
        </div>
    </div>
</div>
<?php get_sidebar('left'); ?>
<?php get_footer(); ?>