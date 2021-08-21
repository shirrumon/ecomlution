(function ($) {

	$(function () {
		$('.wpfaipc').iconpicker(wpfaipc.opt).on('iconpickerUpdated', function () {
			$(this).trigger('change');
		});
	});

})(jQuery);