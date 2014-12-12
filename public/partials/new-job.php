<?php $object = get_post_type_object(get_query_var('post_type')); ?>

<?php get_header(); ?>
<div id="primary" class="col-xs-9">
	<div class="row">
		<div id="content" class="col-xs-12" role="main">
			<div><?php Wp_Linfo_Job_Public::breadcrumbs( $object ) ?></div>
            <div class="content-header row"><div class="col-xs-12"><h2>Добавить</h2></div></div>
			<ul class="nav nav-tabs job__tabs">
                <li role="navigation" class="active"><a href="#" id="vacancy">Вакансия</a></li>
                <li role="navigation"><a href="#" id="resume">Резюме</a></li>
            </ul>
			<?php require "form-vacancy.php" ?>
			<?php require "form-resume.php" ?>
		</div>
	</div>
</div>
<?php get_sidebar('left'); ?>
<?php get_footer(); ?>