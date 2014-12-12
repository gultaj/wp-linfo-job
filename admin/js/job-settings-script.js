(function( $ ) {
	'use strict';

	$("#load_parse_file").click(function() {
		var files = $("#job_parse_file")[0].files;
		if (files.length) {
			var formdata = new FormData();
			formdata.append('action', 'job_parse_file');
			formdata.append('job_parse', files[0]);
			$(".preloader").toggleClass("visible");
			$.ajax({url: ajaxurl, type: "POST", data: formdata, processData: false, contentType: false,
				success: function (response) {
					console.log('Got this from the server: ' + response);
					$("#job_parse_file").val('');
					$(".preloader").toggleClass("visible");
					$("#load_parse_file").parent().append('<p class="description">'+response+'</p>');
				}
			});
		}
	})

})( jQuery );
