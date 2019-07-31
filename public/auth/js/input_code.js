$( function() {
	var charLimit = 1;
	$(".num-input").keydown(function(e) {

			var keys = [8, 9, 19, 20, 27, 33, 34, 35, 36, 37, 38, 39, 40, 45, 46, 144, 145];

			if (e.which == 8 && this.value.length == 0) {
				$(this).prev(".num-input").focus();
			} else if (jQuery.inArray(e.which, keys) >= 0) {
				return true;
			} else if (e.shiftKey || e.which <= 48 || e.which >= 58) {
				return false;
			}
		}).keyup(function () {
			if (this.value.length >= charLimit) {
				$(this).next(":input").focus();
				return false;
			}
		});

		$('#verify-code6').on('keyup', function() {
    if($(this).val().length == 1) {
        $('form').submit();
    }
});
});
