{extends file="page.tpl"}

{block name="content"}

	<div id="wrapper" class="container">
		<div id="menu" class="col-sm-4">
			<ul>
				<li><a href="javascript:divReplaceWith('#submenu', 'option-a.php');">Option A</a></li>
				<li><a href="javascript:divReplaceWith('#submenu', 'option-b.php');">Option B</a></li>
			</ul>
		</div>
		<div id="submenu" class="col-sm-8"></div>
	</div>

{/block}

{block name="post-bootstrap-scripts"}

	<script src="js/main.js"></script>
	
{/block}