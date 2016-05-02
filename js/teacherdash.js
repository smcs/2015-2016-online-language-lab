function divReplaceWith(selector, url) {
	$.get(url, function(response) {
		$(selector).html(response);
	})
}

$(".nav li").on("click", function() {
	$(".nav li").removeClass("active");
	$(this).addClass("active");
});
