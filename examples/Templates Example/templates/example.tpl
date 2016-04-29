{extends file="page.tpl"}

{block name="content"}
	<div class="container">
		<div class="page-header">
			<h1>{$title}<small>Example of BootstrapSmarty in action!</small></h1>
		</div>
	</div>
	
	<div class="container">
		<p>{$paragraph}</p>
	</div>
	
	{include file="fragment.tpl"}
	
	<div class="container">
		{foreach $list as $item}
			<p class="col-sm-3">{$item}</p>
		{/foreach}
	</div>
{/block}