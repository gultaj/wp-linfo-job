<form method="post" id="resume-form" class="form-horizontal <?= isset($_GET['resume'])?'is-active':'' ?>" role="form">
	<fieldset>
		<div class="form-group">
			<label for="resume_title" class="col-sm-3 control-label">Должность <span class="text-danger">*</span></label>
			<div class="col-sm-9">
				<input type="text" name="resume[title]" class="form-control" id="resume_title" placeholder="Должность" require>
			</div>
		</div>
		<div class="form-group">
			<label for="resume_salary" class="col-sm-3 control-label">Оплата <span class="text-danger">*</span></label>
			<div class="col-sm-4">
				<input type="text" class="form-control" size="50" name="resume[salary]" id="resume_salary" placeholder="Желаемая оплата" require>
			</div>
		</div>
		<div class="form-group">
			<label for="resume_edu" class="col-sm-3 control-label">Образование</label>
			<div class="col-sm-4">
				<select name="resume[edu]" class="form-control" id="resume_edu"><?php Job_Meta_Boxes::dropdown('education') ?></select>							
			</div>
		</div>		
		<div class="form-group">
			<label for="resume_stage" class="col-sm-3 control-label">Опыт</label>
			<div class="col-sm-4">
				<select name="resume[stage]" class="form-control" id="resume_stage"><?php Job_Meta_Boxes::dropdown('stage') ?></select>
			</div>
		</div>
		<div class="form-group">
			<label for="resume_desc" class="col-sm-3 control-label">Дополнительно</label>
			<div class="col-sm-6">
				<textarea class="form-control" name="resume[desc]" id="resume_desc" cols="70" rows="10"></textarea>
			</div>
		</div>
		<div class="form-group">
			<label for="resume_expiry" class="col-sm-3 control-label">Срок размещения</label>
			<div class="col-sm-4">
				<select name="resume[expiry]" id="resume_expiry" class="form-control">
					<?php Job_Meta_Boxes::dropdown('expiry', key(Job_Meta_Boxes::$expiry)) ?>
				</select>
			</div>
		</div>
	</fieldset>
	<fieldset>
		<legend>Контактная информация</legend>
		<div class="form-group">
			<label for="resume_company" class="col-sm-3 control-label">Контактное лицо <span class="text-danger">*</span></label>
			<div class="col-sm-5">
				<input type="text" name="resume[company]" class="form-control" id="resume_company" placeholder="Контактное лицо">
			</div>
		</div>
		<div class="form-group">
			<label for="resume_contact_phone" class="col-sm-3 control-label">Телефон</label>
			<div class="col-sm-5">
				<input type="text" size="50" name="resume[contact][phone]" class="form-control" id="resume_contact_phone" placeholder="Номер телефона" />
			</div>
		</div>
		<div class="form-group">
			<label for="resume_contact_email" class="col-sm-3 control-label">E-mail</label>
			<div class="col-sm-5">
				<input type="text" name="resume[contact][email]" size="50" class="form-control" id="resume_contact_email" placeholder="Электронная почта">
				<p class="help-block">На этот e-mail будет выслан код для удаления резюме.</p>
				<input type="checkbox" name="resume[contact][show_email]"> отображать e-mail в резюме
			</div>
		</div>
	</fieldset>

	<fieldset><legend></legend>
		<div class="form-group">
			<p class="col-xs-offset-1 require_fields"><span class="text-danger">*</span> - поля обязательные для заполнения</p>
			<div class="col-sm-offset-3 col-sm-9">
				<button type="submit" id="send-resume" class="btn btn-primary">Отправить</button>
				<button type="submit" name="cancel" value="<?= @$_SERVER['HTTP_REFERER']; ?>" class="btn btn-default">Отмена</button>
			</div>
		</div>
	</fieldset>
	<?php wp_nonce_field('create-resume','create-resume-nonce'); ?>
</form>