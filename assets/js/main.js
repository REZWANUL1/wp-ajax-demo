(function ($) {
	$(document).ready(function () {
		$(".action-button").on("click", function () {
			let task = $(this).data("task");
			window[task]();
		});
	});
})(jQuery);

//? simple ajax call
function simple_ajax_call() {
	let $ = jQuery;
	let name = prompt("What is your Name?");
	$.post(
		plugindata.ajax_url,
		{ action: "ajd_simple", data: name },
		function (data) {
			console.log(data);
		}
	);
}

//? privilege ajax call
//? non privilege ajax call
function unp_ajax_call() {
	let $ = jQuery;
	let name = prompt("What is your Name?");
	$.post(
		plugindata.ajax_url,
		{ action: "unp_call", data: name },
		function (data) {
			console.log(data);
		}
	);
}

//? non privilege ajax call
function ajd_localize_script() {
	let $ = jQuery;
	console.log(bucket);
	$.post(
		plugindata.ajax_url,
		{ action: "adj_process_user", person: bucket },
		function (data) {
			console.log(data);
		}
	);
}

//? nonce
function ajd_secure_ajax_call() {
	let $ = jQuery;
	$.post(
		plugindata.ajax_url,
		{
			action: "ajd_protected",
			secret: "Secret code",
			ajd_nonce: plugindata.ajd_nonce,
		},
		function (data) {
			console.log(data);
		}
	);
}
