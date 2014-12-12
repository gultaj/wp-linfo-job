<?php $object = get_post_type_object(get_query_var('post_type')); ?>

<?php get_header();?>
<div id="primary" class="col-xs-9">
    <div class="row">
        <div id="content" class="col-xs-12" role="main">
            <div><?php Wp_Linfo_Job_Public::breadcrumbs( $object ) ?></div>
            <div class="content-header row"> <?php Wp_Linfo_Job_Public::title( $object ) ?> </div>
            <div class="job__flash"><?= Wp_Linfo_Job_Public::flashmessages() ?></div>
            <ul class="nav nav-tabs">
                <li role="navigation" class="active"><a href="">Вакансии</a></li>
                <li role="navigation"><a href="<?= Wp_Linfo_Job_Public::get_archive_link('resume') ?>">Резюме</a></li>
            </ul>
        <?php if (!($vacancies = Wp_Linfo_Job_Public::get_vacancies())) : ?>
        	<h3>Ничего не найдено.</h3>
        	<a class="primary" href="<?= home_url('/'.$object->rewrite['slug'].'?new' ); ?>">Добавте свою вакансию</a>
        <?php else : ?>
            <div class="job__list">
                <div class="job__list_header">
                    <div class="job__list_name">Вакансия</div>   
                    <div class="job__list_company">Организация</div>
                    <div class="job__list_salary">Оплата</div>    
                </div>
                <?php foreach ($vacancies as $vacancy) : ?>
                <a href="<?= get_permalink( $vacancy->ID ) ?>" class="job__item">
                    <div class="job__item_name"><?= $vacancy->post_title ?></div>   
                    <div class="job__item_company"><?= $vacancy->company ?></div>
                    <div class="job__item_salary"><?= $vacancy->salary ?></div>
                </a>
                <?php endforeach; ?>
            </div>
            <div class="job__pagination"> <?php lidainfo_paging_nav() ?> </div>
        <?php endif; ?>
        </div>
    </div>
</div>
<?php get_sidebar('left'); ?>
<?php get_footer(); ?>