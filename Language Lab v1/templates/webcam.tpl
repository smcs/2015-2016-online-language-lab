{extends file="page.tpl"}

{block name="content"}

<div class="container page-header"
<h1>This is a language lab website.</h1>
</div>

<div class="container">
<h3>It has a webcam capture feature.</h3>
<p>Click the button below to enable your webcam.</p>

<div id="swap"><p><button type="button" onclick="swap('#swap')"><img src="images/button_webcam.gif"></button></p></div>
</div> 

{/block}

{block name="post-bootstrap-scripts"}

 <script src="../webrtc-samples/js/adapter.js"></script>
 <script src="../webrtc-samples/js/common.js"></script>
 <script type="text/javascript" src="index.js"></script>
 <script>
	function swap(e) {
		$(e).empty();
		$(e).append('<video id="gum-local" autoplay></video>');
		videoFunction();
	}
</script>

{/block}
