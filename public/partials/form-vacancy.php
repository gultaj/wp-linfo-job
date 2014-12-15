<form method="post" id="vacancy-form" class="form-horizontal <?= isset($_GET['resume'])?'':'is-active' ?>" role="form">
	<fieldset>
		<div class="form-group">
			<label for="title" class="col-xs-3 control-label">Должность <span class="text-danger">*</span></label>
			<div class="col-xs-9">
				<input type="text" name="vacancy[title]" class="form-control" id="title" placeholder="Должность" require>
			</div>
		</div>
		<div class="form-group">
			<label for="edu" class="col-xs-3 control-label">Образование</label>
			<div class="col-xs-4">
				<select name="vacancy[edu]" class="form-control" id="edu"><?php Job_Meta_Boxes::dropdown('education') ?></select>							
			</div>
		</div>
		<div class="form-group">
			<label for="shift" class="col-xs-3 control-label">Режим работы</label>
			<div class="col-xs-4">
				<select name="vacancy[shift]" class="form-control" id="shift"><?php Job_Meta_Boxes::dropdown('shift') ?></select>
			</div>
		</div>
		<div class="form-group">
			<label for="type" class="col-xs-3 control-label">Занятость</label>
			<div class="col-xs-4">
				<select name="vacancy[type]" class="form-control" id="type"><?php Job_Meta_Boxes::dropdown('type') ?></select>
			</div>
		</div>		
		<div class="form-group">
			<label for="stage" class="col-xs-3 control-label">Опыт</label>
			<div class="col-xs-4">
				<select name="vacancy[stage]" class="form-control" id="stage"><?php Job_Meta_Boxes::dropdown('stage') ?></select>
			</div>
		</div>
		<div class="form-group">
			<label for="salary" class="col-xs-3 control-label">Оплата <span class="text-danger">*</span></label>
			<div class="col-xs-4">
				<input type="text" class="form-control" size="50" name="vacancy[salary]" id="salary" placeholder="Желаемая оплата" require>
			</div>
		</div>
		<div class="form-group">
			<label for="desc" class="col-xs-3 control-label">Дополнительно</label>
			<div class="col-xs-6">
				<textarea class="form-control" name="vacancy[desc]" id="desc" cols="70" rows="10"></textarea>
			</div>
		</div>
		<div class="form-group">
			<label for="expiry" class="col-xs-3 control-label">Срок размещения</label>
			<div class="col-xs-4">
				<select name="vacancy[expiry]" id="expiry" class="form-control">
					<?php Job_Meta_Boxes::dropdown('expiry', key(Job_Meta_Boxes::$expiry)) ?>
				</select>
			</div>
		</div>
	</fieldset>
	<fieldset>
		<legend>Контактная информация</legend>
		<div class="form-group">
			<label for="company" class="col-xs-3 control-label">Организация <span class="text-danger">*</span></label>
			<div class="col-xs-9">
				<input type="text" size="50" name="vacancy[company]" class="form-control" id="company" placeholder="Организация" require />
			</div>
		</div>
		<div class="form-group">
			<label for="contact_address" class="col-xs-3 control-label">Адрес</label>
			<div class="col-xs-9">
				<input type="text" size="50" name="vacancy[contact][address]" class="form-control" id="contact_address" placeholder="Адрес" />
			</div>
		</div>
		<div class="form-group">
			<label for="contact_phone" class="col-xs-3 control-label">Телефон</label>
			<div class="col-xs-5">
				<input type="text" size="50" name="vacancy[contact][phone]" class="form-control" id="contact_phone" placeholder="Номер телефона" />
			</div>
		</div>
		<div class="form-group">
			<label for="contact_email" class="col-xs-3 control-label">E-mail</label>
			<div class="col-xs-5">
				<input type="text" name="vacancy[contact][email]" size="50" class="form-control" id="contact_email" placeholder="Электронная почта">
				<p class="help-block">На этот e-mail будет выслан код для редактирования вакансии.</p>
				<input type="checkbox" name="vacancy[contact][show_email]"> отображать e-mail в вакансии
			</div>
		</div>
		<div class="form-group">
			<label for="contact_site" class="col-xs-3 control-label">Сайт</label>
			<div class="col-xs-5">
				<input type="text" size="50" name="vacancy[contact][site]" class="form-control" id="contact_site" placeholder="Сайт"/>
			</div>
		</div>
		<div class="form-group">
			<label for="contact_name" class="col-xs-3 control-label">Контактное лицо</label>
			<div class="col-xs-5">
				<input type="text" name="vacancy[contact][name]" class="form-control" id="contact_name" placeholder="Контактное лицо">
			</div>
		</div>
	</fieldset>

	<fieldset><legend></legend>
		<div class="form-group">
			<p class="col-xs-offset-1 require_fields"><span class="text-danger">*</span> - поля обязательные для заполнения</p>
			<div class="col-xs-offset-3 col-xs-9">
				<button type="submit" id="send-vacancy" class="btn btn-primary">Отправить</button>
				<button type="submit" name="cancel" value="<?= @$_SERVER['HTTP_REFERER']; ?>" class="btn btn-default">Отмена</button>
			</div>
		</div>
	</fieldset>
	<?php wp_nonce_field('create-vacancy','create-vacancy-nonce'); ?>
</form>