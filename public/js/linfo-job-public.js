jQuery(document).ready(function( $ ) {
	'use strict';
	$('body').on('focusin', '.user_key', function() {
		$(this).parent().addClass('active');
	}).on('focusout', '.user_key', function() {
		$(this).parent().removeClass('active')
	});

	$('.delete-vacancy').click(function() {
		var input = $('.job__delete_box>input');
		if ($.trim(input.val()).length == 6) {
			var data = {
				action: 'check_key',
				vacancy_id: '',
				user_key: ''
			};
			$.post(ajax_object.ajax_url, data, function(response) {
				if (response == 'OK') {
					var span = $(document.createElement('span')).text('На e-mail указанный при регистрации выслан новый ключ').css("font-size","12px").hide();
					$("#popover-group").slideToggle("fast");
					$(".popover-title").text('');
					$(".popover-content").append(span);	
					span.slideToggle("fast");
				}
			});
		}
		.focusin();

		return false;
	});

	$('#send-vacancy').click(function() {
		var errors;
		$('.has-error').removeClass('has-error');
		$('.help-block').remove();
		$('.alert').remove();
		if (errors = hasErrors()) {
			showErrors(errors);
			return false;
		}
	});

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
