{extends file="subpage.tpl"}

{block name="subcontent"}

	<div class="container">
		<div id="ot-streams"></div>
	</div>

	<div class="container">
		<p>Context: <code>{$context}</code></p>
		<p>User: <code>{$user}</code></p>
	</div>

{/block}

{block name="post-bootstrap-scripts"}

	<script src="https://static.opentok.com/v2/js/opentok.min.js"></script>
	<script src="../js/language-lab.js"></script>
	<script src="../js/student.js"></script>
	<script>
		Student.init('{$rootURL}', '{$context}', '{$user}');
	</script>

{/block}
