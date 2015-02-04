<?php $object = get_post_type_object(get_query_var('post_type')); ?>

<?php get_header(); ?>
<div id="primary" class="col-xs-9">
	<div class="row">
		<div id="content" class="col-xs-12" role="main">
			<div><?php Wp_Linfo_Job_Public::breadcrumbs( $object ) ?></div>
            <div class="content-header row"><div class="col-xs-12"><h2>Новое резюме</h2></div></div>
<!--             <div class="job__aside_links"><?= Wp_Linfo_Job_Public::get_archive_link('resume') ?></div> -->
			<form method="post" id="job-form" class="form-horizontal" role="form">
				<fieldset>
					<legend>Резюме</legend>
					<div class="form-group">
						<label for="title" class="col-sm-3 control-label">Должность <span class="text-danger">*</span></label>
						<div class="col-sm-9">
							<input type="text" name="resume[title]" class="form-control" id="title" placeholder="Должность" require>
						</div>
					</div>
					<div class="form-group">
						<label for="salary" class="col-sm-3 control-label">Оплата <span class="text-danger">*</span></label>
						<div class="col-sm-4">
							<input type="text" class="form-control" size="50" name="resume[salary]" id="salary" require>
						</div>
					</div>
					<div class="form-group">
						<label for="edu" class="col-sm-3 control-label">Образование</label>
						<div class="col-sm-4">
							<select name="resume[edu]" class="form-control" id="edu"><?php Job_Meta_Boxes::dropdown('education') ?></select>							
						</div>
					</div>		
					<div class="form-group">
						<label for="stage" class="col-sm-3 control-label">Опыт</label>
						<div class="col-sm-4">
							<select name="resume[stage]" class="form-control" id="stage"><?php Job_Meta_Boxes::dropdown('stage') ?></select>
						</div>
					</div>
					<div class="form-group">
						<label for="desc" class="col-sm-3 control-label">Дополнительно</label>
						<div class="col-sm-4">
							<textarea name="resume[desc]" id="desc" cols="70" rows="10"></textarea>
						</div>
					</div>
					<div class="form-group">
						<label for="expiry" class="col-sm-3 control-label">Срок размещения</label>
						<div class="col-sm-4">
							<select name="resume[expiry]" id="expiry" class="form-control">
								<?php Job_Meta_Boxes::dropdown('expiry', key(Job_Meta_Boxes::$expiry)) ?>
							</select>
						</div>
					</div>
				</fieldset>
				<fieldset>
					<legend>Контактная информация</legend>
					<div class="form-group">
						<label for="company" class="col-sm-3 control-label">Контактное лицо <span class="text-danger">*</span></label>
						<div class="col-sm-5">
							<input type="text" name="resume[company]" class="form-control" id="company" placeholder="Контактное лицо">
						</div>
					</div>
					<div class="form-group">
						<label for="contact_phone" class="col-sm-3 control-label">Телефон</label>
						<div class="col-sm-5">
							<input type="text" size="50" name="resume[contact][phone]" class="form-control" id="contact_phone" />
						</div>
					</div>
					<div class="form-group">
						<label for="contact_email" class="col-sm-3 control-label">E-mail</label>
						<div class="col-sm-5">
							<input type="text" name="resume[contact][email]" size="50" class="form-control" id="contact_email" placeholder="Электронная почта">
							<p class="help-block">На этот e-mail будет выслан код для удаления резюме.</p>
							<input type="checkbox" name="resume[contact][show_email]"> отображать e-mail в резюме
						</div>
					</div>
				</fieldset>

				<fieldset><legend></legend>
					<div class="form-group">
						<p class="require_fields"><span class="text-danger">*</span> - поля обязательные для заполнения</p>
						<div class="col-sm-offset-3 col-sm-9">
							<button type="submit" id="send-job" class="btn btn-primary">Отправить</button>
							<button type="submit" name="cancel" value="<?= @$_SERVER['HTTP_REFERER']; ?>" class="btn btn-default">Отмена</button>
						</div>
					</div>
				</fieldset>
				<?php wp_nonce_field('create-resume','create-resume-nonce'); ?>
			</form>
		</div>
	</div>
</div>
<?php get_sidebar('left'); ?>
<?php get_footer(); ?>