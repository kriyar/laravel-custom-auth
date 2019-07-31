$("input").on('focusout', function(){
	$(this).each(function(i, e){
		if($(e).val() != ""){
			$(e).addClass('not-empty');
		}else{
			$(e).removeClass('not-empty');
		}
	});
});


$('#username').keypress(function (e) {
    var regex = new RegExp("^[a-zA-Z0-9]+$");
    var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
    if (regex.test(str)) {
        return true;
    }
    e.preventDefault();
    return false;
});
