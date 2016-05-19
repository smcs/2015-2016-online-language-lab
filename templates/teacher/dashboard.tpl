{extends file="subpage.tpl"}

{block name="subcontent"}

	<div class="container">
		<div class="row">
			<div class="container col-xs-6">
				<p class="droppable-label">Classroom<p>
				<ul id="ot-streams" class="droppable connected"></ul>
			</div>
			<div class="container col-xs-6">
				<button class="btn btn-default" onclick="javascript:Teacher.addGroup();">Add Group</button>
				<div id="groups" class="row"></div>
			</div>
		</div>
	</div>

{/block}

{block name="post-bootstrap-scripts"}

	<script src="../js/jquery-ui.min.js"></script>
	<script src="https://static.opentok.com/v2/js/opentok.min.js"></script>
	<script src="../js/language-lab.js"></script>
	<script src="../js/teacher.js"></script>
	<script>
		$('.connected').sortable({
			connectWith: '.connected',
			placeholder: 'draggable-placeholder'
		});
		Teacher.init('{$rootURL}', '{$context}', '{$user}');
	</script>

{/block}
