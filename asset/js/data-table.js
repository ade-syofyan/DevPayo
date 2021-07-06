(function ($) {
	"use strict";
	$(function () {
		$(`#order-listing`).DataTable({
			aLengthMenu: [
				[5, 10, 15, -1],
				[5, 10, 15, "All"],
			],
			iDisplayLength: 10,
			ordering: false,
			language: { search: "" },
		});
		$(`#order-listing`).each(function () {
			var datatable = $(this);
			// SEARCH - Add the placeholder for Search and Turn this into in-line form control
			var search_input = datatable
				.closest(".dataTables_wrapper")
				.find("div[id$=_filter] input");
			search_input.attr("placeholder", "Search");
			search_input.removeClass("form-control-sm");
			// LENGTH - Inline-Form control
			var length_sel = datatable
				.closest(".dataTables_wrapper")
				.find("div[id$=_length] select");
			length_sel.removeClass("form-control-sm");
		});

		for (let index = 1; index < 50; index++) {
			$(`#order-listing${index}`).DataTable({
				aLengthMenu: [
					[5, 10, 15, -1],
					[5, 10, 15, "All"],
				],
				iDisplayLength: 10,
				ordering: false,
				language: { search: "" },
			});
			$(`#order-listing${index}`).each(function () {
				var datatable = $(this);
				// SEARCH - Add the placeholder for Search and Turn this into in-line form control
				var search_input = datatable
					.closest(".dataTables_wrapper")
					.find("div[id$=_filter] input");
				search_input.attr("placeholder", "Search");
				search_input.removeClass("form-control-sm");
				// LENGTH - Inline-Form control
				var length_sel = datatable
					.closest(".dataTables_wrapper")
					.find("div[id$=_length] select");
				length_sel.removeClass("form-control-sm");
			});
		}
	});

	$("#order-list").DataTable({
		aLengthMenu: [
			[5, 10, 15, -1],
			[5, 10, 15, "All"]
		],
		iDisplayLength: 5,
		ordering: false,
		language: { search: "" }
	});
	$("#order-list").each(function() {
		var datatable = $(this);
		// SEARCH - Add the placeholder for Search and Turn this into in-line form control
		var search_input = datatable
			.closest(".dataTables_wrapper")
			.find("div[id$=_filter] input");
		search_input.attr("placeholder", "Search");
		search_input.removeClass("form-control-sm");
		// LENGTH - Inline-Form control
		var length_sel = datatable
			.closest(".dataTables_wrapper")
			.find("div[id$=_length] select");
		length_sel.removeClass("form-control-sm");
	});

})(jQuery);
