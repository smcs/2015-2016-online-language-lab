{extends file="subpage.tpl"}

{block name="subcontent"}

	<div class="container">
		<div class="row">
			<div class="container col-xs-6">
				<p>
					<button class="btn btn-default" disabled="disabled">Random Pairings</button>
					<button class="btn btn-default" disabled="disabled">Pre-recorded</button>
				</p>
				<div id="wrapper-ot-streams" class="droppable">
					<p class="label label-primary">Classroom</p>
					<ul id="ot-streams" class=" connected"></ul>
				</div>
			</div>
			<div class="container col-xs-6">
				<p>
					<button class="btn btn-default" onclick="javascript:Teacher.addGroup();">Add Group</button>
					<button class="btn btn-danger" onclick="javascript:Teacher.resetGroups();">Reset Groups</button>
				</p>
				<div id="groups"></div>
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
		/* enable drag and drop sortable widgets */
		$('.connected').sortable({
			connectWith: '.connected',
			placeholder: 'draggable-placeholder col-xs-4'
		});

		/* fire up the OpenTok app */
		Teacher.init('{$rootURL}', '{$context}', '{$user}');
	</script>

{/block}
