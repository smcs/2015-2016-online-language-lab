{$name="Model-View-Controller"}
{$category="Example"}
{extends file="subpage.tpl"}

{block name="subcontent"}

<div class="container">
	{foreach $data as $dataRow}
		<p{if $dataRow['id']==$row} class="selected"{/if}>{$dataRow['value']} <a class="btn btn-default" href="controller.php?row={$dataRow['id']}">Select</a>
	{/foreach}
</div>

{/block}