<table>
	<tr>
		<td>Срок размещения&nbsp;</td>
		<td>
		<?php if ($current_screen->action == 'add') : ?>
			<select name="<?= $name ?>[expiry]"><?php self::dropdown('expiry', key(self::$expiry)) ?></select></td>
		<?php else : ?>
			&nbsp;<strong> до <?= date('d.m.Y', $expiry) ?></strong>
			<input type="hidden" name="<?= $name ?>[expiry]" value="<?= $expiry ?>">
		<?php endif; ?>
	</tr>
	<tr>
		<td>Образование</td>
		<td><select name="<?= $name ?>[edu]"><?php self::dropdown('education', $edu) ?></select></td>
	</tr>
	<tr>
		<td>Режим работы</td>
		<td><select name="<?= $name ?>[shift]"><?php self::dropdown('shift', $shift) ?></select></td>
	</tr>
	<tr>
		<td>Вид работы</td>
		<td><select name="<?= $name ?>[type]"><?php self::dropdown('type', $type) ?></select></td>
	</tr>
	<tr>
		<td>Опыт</td>
		<td><select name="<?= $name ?>[stage]"><?php self::dropdown('stage', $stage) ?></select></td>
	</tr>
	<tr> <td>Зарплата</td> <td><input type="text" size="50" name="<?= $name ?>[salary]" value="<?= $salary ?>" /></td> </tr>

	<tr> <th style="padding-top:20px;text-align:left;">Контакты</th> <th></th></tr>

	<tr> <td>Организация</td> 	  <td><input type="text" size="50" name="<?= $name ?>[company]" value="<?= htmlentities($company) ?>" /></td> </tr>
	<tr> <td>Адрес</td>    		  <td><input type="text" size="50" name="<?= $name ?>[contact][address]" value="<?= $contact['address'] ?>" /></td> </tr>
	<tr> <td>Телефон</td>  		  <td><input type="text" size="50" name="<?= $name ?>[contact][phone]" value="<?= $contact['phone'] ?>" /></td> </tr>
	<tr> <td>E-mail</td>   		  <td><input type="text" size="50" name="<?= $name ?>[contact][email]" value="<?= $contact['email'] ?>" /></td> </tr>
	<tr> <td>Сайт</td>     		  <td><input type="text" size="50" name="<?= $name ?>[contact][site]" value="<?= $contact['site'] ?>" /></td> </tr>
	<tr> <td>Контактное лицо</td> <td><input type="text" size="50" name="<?= $name ?>[contact][name]" value="<?= $contact['name'] ?>" /></td> </tr>
	<tr> <td>Описание</td> 		  <td style="padding-top:20px"><textarea name="<?= $name ?>[desc]" id="" cols="70" rows="10"><?= $desc ?></textarea></td> </tr>
</table>