(function( $ ) {
	'use strict';

	$("#load_parse_file").click(function() {
		if (!$("#job_parse_file").val().length) {
			alert("No file!");
		}
	})

})( jQuery );
