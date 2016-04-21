{extends file="subpage.tpl"}

{block name="subcontent"}

	<div class="container">
		<p>{$message}</p>
		{foreach $dumps as $dump}
			<pre>{$dump}</pre>
		{/foreach}
	</div>

{/block}