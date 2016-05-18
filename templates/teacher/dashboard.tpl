{extends file="subpage.tpl"}

{block name="subcontent"}
	<div class="row">
	<div class="container col-xs-6">
		<div id="ot-streams" class="source connected">
		</div>
	</div>
	<div class="container col-xs-6">
		<button class="btn btn-default" onclick="javascript:Teacher.addGroup();">Add Group</button>
		<div id="groups" class="target connected">
		</div>
	</div>

{/block}

{block name="post-bootstrap-scripts"}

	<script src="../js/jquery-ui.min.js"></script>
	<script src="https://static.opentok.com/v2/js/opentok.min.js"></script>
	<script src="../js/language-lab.js"></script>
	<script src="../js/teacher.js"></script>
	<script>
		$(function() {
			$('.source, .target').sortable({
				connectWith: '.connected'
			});
		});
		Teacher.init('{$rootURL}', '{$context}', '{$user}');
	</script>

{/block}
