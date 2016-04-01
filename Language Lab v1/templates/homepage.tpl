/*  this is a template for the homepage*/


{extends file="page.tpl"}

{block name="content"}

<div class="container page-header"

<div class="row">
<div class="col-mg-12">

	<h1 class="text-center">Welcome to the Language Lab!</h1>
	<h3 class="text-center">Please log in.</h3>

</div>
</div>
</div>

<div class="container">
	<div class="row">
		<div class="col-mg-12">

			<div class="text-align-center">
			<a type="button" class="btn btn-info btn-lg" href="login.php">Log in</a></div>
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