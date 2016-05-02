/*this is a template for teacher's dashboard*/


{extends file="page.tpl"}

{block name="post-bootstrap-stylesheets"}
<link rel="stylesheet" type="text/css" href="css/teacherdash.css">
{/block}

{block name="content"}

<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand">Language Lab. Welcome, username.</a>
    </div>
    <div id="navbar" class="navbar-collapse collapse">
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#">Dashboard</a></li>
        <li><a href="#">Settings</a></li>
        <li><a href="#">Profile</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="container-fluid">
  <div id="sidebar" class="col-sm-3">
    <h1 class="page-header">Dashboard</h1>
    <ul class="nav nav-sidebar">
      <li class="active"><a href="javascript:divReplaceWith('#submenu', 'teacherclass.php);">Español 1 Verde <span class="sr-only">(current)</span></a></li>
      <li><a href="javascript:divReplaceWith('#submenu', 'teacherclass.php');">Español 2 Anaranjado </a></li>
      <li><a href="javascript:divReplaceWith('#submenu', 'teacherclass.php');">Español 3 Rojo</a></li>
      <li><a href="javascript:divReplaceWith('#submenu', 'teacherclass.php');">Español 4 Marron</a></li>
    </ul>
    <ul class="nav nav-sidebar">
      <li><a href="">Nav item again</a></li>
      <li><a href="">One more nav</a></li>
      <li><a href="">Another nav item</a></li>
    </ul>
    <ul class="nav nav-sidebar">
      <button id="addclass" type="button" class="btn btn-primary btn-lg">
        <span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span> Add class.
      </button>
    </ul>
  </div>
  <div id="submenu" class="col-sm-8"></div>
</div>

{/block}

{block name="post-bootstrap-scripts"}
<script src="js/teacherdash.js"></script>


{/block}


