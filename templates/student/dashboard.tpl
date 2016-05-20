{extends file="subpage.tpl"}

{block name="subcontent"}

	<div class="container">
		<ul id="ot-streams">
			<li id="ot-streams-placeholder">
				<h1>Waiting for teacher <i class="fa fa-refresh fa-spin"></i></h1>
			</li>
		</ul>
	</div>

{/block}

{block name="post-bootstrap-scripts"}

	<script src="https://static.opentok.com/v2/js/opentok.min.js"></script>
	<script src="../js/language-lab.js"></script>
	<script src="../js/student.js"></script>
	<script>
		Student.init('{$rootURL}', '{$context}', '{$user}', '{$fullName}');
	</script>

{/block}
