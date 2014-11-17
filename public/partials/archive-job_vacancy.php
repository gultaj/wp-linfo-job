<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Wp_Linfo_Job
 * @subpackage Wp_Linfo_Job/public/partials
 */
?>

<?php get_header();?>
<div id="primary" class="col-xs-9">
    <div class="row">
        <div class="col-xs-12">
            <div id="content" class="" role="main">
                <div><?php $liAdverts->show_breadcrumbs() ?></div>
                <?php if( $liAdverts->flash->hasFlash('success') ) : ?>
                    <div class="alert alert-success alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <strong>ПОЗДРАВЛЯЕМ!</strong> <?= $liAdverts->flash->getFlash('success'); ?>
                    </div>
                <?php endif; ?>
                <?php if( $liAdverts->flash->hasFlash('warning') ) : ?>
                    <div class="alert alert-warning alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <strong><?= $liAdverts->flash->getFlash('warning'); ?></strong> 
                    </div>
                <?php endif; ?>
                <div class="content-header row">
                    <div class="col-xs-12"><h2>Вакансии</h2></div>
                </div>
                <div class="vacancy__list">
                    <!-- <pre><?php print_r(Wp_Linfo_Job_Public::get_vacancies()) ?></pre> -->
                    <?php foreach (Wp_Linfo_Job_Public::get_vacancies() as $vacancy) : ?>
                    <div class="vacancy">
                        <div class="vacancy__name"><?= $vacancy->post_title ?></div>   
                        <div class="vacancy__company"><?= $vacancy->company ?></div>
                        <div class="vacancy__salary"><?= $vacancy->salary ?></div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php get_sidebar('left'); ?>
<?php get_footer(); ?>