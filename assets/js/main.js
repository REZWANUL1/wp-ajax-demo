(function ($) {
	$(document).ready(function () {
		$(".action-button").on("click", function () {
			let task = $(this).data("task");
			window[task]();
		});
	});
})(jQuery);

function simple_ajax_call() {
	alert(plugindata.ajax_url);
}
