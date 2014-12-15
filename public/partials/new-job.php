<?php $object = get_post_type_object(get_query_var('post_type')); ?>

<?php get_header(); ?>
<div id="primary" class="col-xs-9">
	<div class="row">
		<div id="content" class="col-xs-12" role="main">
			<div><?php Wp_Linfo_Job_Public::breadcrumbs( $object ) ?></div>
            <div class="content-header row"><div class="col-xs-12">
            	<h2>Добавление 
            		<span class="<?= isset($_GET['resume'])?'':'is-active' ?>">вакансии</span>
            		<span class="<?= isset($_GET['resume'])?'is-active':'' ?>">резюме</span>
            	</h2>
            </div></div>
			<ul class="nav nav-tabs job__tabs">
                <li role="navigation" class="<?= !isset($_GET['resume'])?'active':'' ?>"><a href="#" id="vacancy">Добавить вакансию</a></li>
                <li role="navigation" class="<?= isset($_GET['resume'])?'active':'' ?>"><a href="#" id="resume">Добавить резюме</a></li>
            </ul>
			<?php require "form-vacancy.php" ?>
			<?php require "form-resume.php" ?>
		</div>
	</div>
</div>
<?php get_sidebar('left'); ?>
<?php get_footer(); ?>