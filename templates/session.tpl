{extends file="subpage.tpl"}

{block name="head-scripts"}
	
	<script>
		var id = '{$id}';
	</script>
	
{/block}

{block name="subcontent"}

	<div id="videos" class="container">
		<span class="col-sm-2">
		<span class="embed-responsive embed-responsive-4by3">
		<div id="subscriber" class="embed-responsive-item"></div>
		</span>
		</span>
		<span class="col-sm-4">
		<span class="embed-responsive embed-responsive-4by3">
		<div id="publisher" class="embed-responsive-item"></div>
		</span>
		</span>
	</div>
	
{/block}

{block name="post-bootstrap-scripts"}
	
	<script src="https://static.opentok.com/v2/js/opentok.min.js"></script>
	<script src="js/session.js"></script>
	
{/block}
