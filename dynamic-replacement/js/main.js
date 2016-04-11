function divReplaceWith(selector, url) {
	$.get(url, function(response) {
		$(selector).html(response);
	})
}