wp.customize.bind('ready', function () {
	wp.customize.panel('ttt_pnwc', function (panel) {
		panel.expanded.bind(function (isExpanded) {
			if (isExpanded) {
				wp.customize.previewer.previewUrl.set(ttt_pnwc_customizer_info.popup_notices_url);
			}
		});
	});
	wp.customize.section.each(function (section) {
		if (section.id.search('ttt_pnwc') != -1) {
			section.expanded.bind(function (isExpanded) {
				if (isExpanded) {
					wp.customize.previewer.refresh();
				}
			});
		}
	});
})