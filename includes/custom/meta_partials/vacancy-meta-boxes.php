<?php ?>
<table>
	
	<tr>
		<td>Образование</td>
		<td><select name="<?= $name ?>[edu]" id=""><?php self::dropdown('education') ?></select></td>
	</tr>
	<tr>
		<td>Режим работы</td>
		<td><select name="<?= $name ?>[shift]" id=""><?php self::dropdown('shift') ?></select></td>
	</tr>
	<tr>
		<td>Вид работы</td>
		<td><select name="<?= $name ?>[type]" id=""><?php self::dropdown('type') ?></select></td>
	</tr>
	<tr>
		<td>Опыт</td>
		<td><select name="<?= $name ?>[stage]" id=""><?php self::dropdown('stage') ?></select></td>
	</tr>
	<tr> <td>Зарплата</td> <td><input type="text" size="50" name="<?= $name ?>[salary]" value="" /></td> </tr>

	<tr> <th style="padding-top:20px;text-align:left;">Контакты</th> <th></th></tr>
	<tr> <td>Организация</td> <td><input type="text" size="50" name="<?= $name ?>[contact][company]" value="" /></td> </tr>
	<tr> <td>Адрес</td>    <td><input type="text" size="50" name="<?= $name ?>[contact][address]" value="" /></td> </tr>
	<tr> <td>Телефон</td>  <td><input type="text" size="50" name="<?= $name ?>[contact][phone]" value="" /></td> </tr>
	<tr> <td>E-mail</td>   <td><input type="text" size="50" name="<?= $name ?>[contact][email]" value="" /></td> </tr>
	<tr> <td>Сайт</td>     <td><input type="text" size="50" name="<?= $name ?>[contact][site]" value="" /></td> </tr>
	<tr> <td>Описание</td> <td style="padding-top:20px"><textarea name="<?= $name ?>[desc]" id="" cols="70" rows="10"></textarea></td> </tr>
</table>