{extends file="subpage.tpl"}

{block name="subcontent"}

<div class="container">
	<div class="container col-sm-6">
		<a href="session.php" class="btn btn-default">Start a New Session</a>
	</div>
	<div class="container col-sm-6">
		{include file="active-sessions.tpl"}
	</div>
</div>

{/block}