jQuery(document).ready(function( $ ) {
	'use strict';
	$('body').on('click', '#check_key', checkKey);

	var html = '<div id="popover-group"><div class="input-group"><input type="text" id="edit_key" class="form-control input-sm"><span class="input-group-btn"><button class="btn btn-default btn-sm" id="check_key" type="button"> &raquo; </button></span></div>';
	$('.vacancy__remove').popover({html: true, content: html, placement: 'bottom'});

	$('#send-job').click(function() {
		var errors;
		$('.has-error').removeClass('has-error');
		$('.help-block').remove();
		$('.alert').remove();
		if (errors = hasErrors()) {
			showErrors(errors);
			return false;
		}
	});

	function checkKey() {
		var key = $.trim($('#edit_key').val());
		if (key.length == 6) {
			var data = {action: 'check_job_key', obj_id: $('#obj_id').val(), user_key: key };
			$('#edit_key').parent().removeClass('has-error');
			$('#edit_key, #check_key').attr('disabled', true);
			$.post(ajax_object.ajax_url, data, function(response) {
				if (response === 'OK') {
					var type = ($("#job_type").val() == 'vacancy') ? 'вакансию' : 'резюме';
					if (confirm('Вы действительно хотите удалить '+type+'?')) {
						data.action = 'remove_job';
						$.post(ajax_object.ajax_url, data, function(response) {
							if (response === 'OK') {
								var url = window.location.origin + window.location.pathname.replace(/id[0-9]+\//gi, '');
								window.location.replace(url);
							}
						});
					} else {
						$('#edit_key, #check_key').attr('disabled', false);	
					}
				} else {
					$('#edit_key, #check_key').attr('disabled', false);
				}
			});
		} else {
			$('#edit_key').parent().addClass('has-error');
		}
		return false;
	}

	function hasErrors() {
		var errors = [];
		var elems = ['title', 'company', 'salary'];
		for (var i = 0; i < elems.length; i++) {
			var length = $.trim($('#' + elems[i]).val()).length;
			if (!length) {
				errors.push({id: elems[i], message: 'Поле не может быть пустым'});
			} else if (length < 3) {
				errors.push({id: elems[i], message: 'Количество символов не может быть меньше 3-х'});
			}
		};
		return (errors.length) ? errors : false;
	}

	function showErrors(errors) {
		var fields = [];
		for (var i = 0; i < errors.length; i++) {
			var elem = $('#' + errors[i].id).parent();
			fields.push('<li>'+$('label[for='+errors[i].id+']').text()+'</li>');
			var desc = '<span class="help-block">'+errors[i].message+'</span>';
			elem.addClass('has-error');
			elem.append(desc);
		};
		var alert = '<div class="alert alert-danger" role="alert">'+
			'<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button>'+
			'<strong>Чтобы продолжить устраните все ошибки!</strong>'+
			'<br><br>Поля с ошибками: <ul>'+fields.join('')+'</ul> </div>';
		$('#job-form').before(alert);
		$('body').scrollTop(0);
	}
});
