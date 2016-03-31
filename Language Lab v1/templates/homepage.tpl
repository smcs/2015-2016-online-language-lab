/*  this is a template for log in/sign up page*/


{extends file="page.tpl"}

{block name="content"}

<div class="container page-header"

<div class="row">
<div class="col-mg-12">

	<h1 class="text-center">Welcome to the Language Lab!</h1>
	<h3 class="text-center">Please sign in with your St. Mark's School email and password.</h3>

</div>
</div>
</div>

<div class="container">
	<div class="row">
		<div class="col-mg-12">
			<div class="text-center">
			<button type="button" class="btn btn-info btn-lg" onclick="swap('#swap')">Log in</button>
		</div>
			
		</div>
		

	</div>

</div>


{/block}

{block name="post-bootstrap-scripts"}

<script type="text/javascript" scr="homepage.js"></script>
<script>
	function swap(e){
		$(e).emplty();
		$(e).append("");
		pasuser();
	}
</script>

{/block}