{extends file="subpage.tpl"}

{block name="subcontent"}

	<div class="container">
		<div id="ot-streams">
		</div>
	</div>

{/block}

{block name="post-bootstrap-scripts"}

	<script src="https://static.opentok.com/v2/js/opentok.min.js"></script>
	<script src="../js/language-lab.js"></script>
	<script src="../js/teacher.js"></script>
	<script>
		Teacher.init('{$rootURL}', '{$context}', '{$user}');
	</script>

{/block}
