{extends file="subpage.tpl"}

{block name="subcontent"}

<div class="container">
	{foreach $data as $row}
		<p{if $data['id']==$row} class="selected"{/if}>{$data['value']} <a class="btn btn-default" href="controller.php?row={$data['id']}">Select</a>
	{/foreach}
</div>

{/block}