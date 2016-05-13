{extends file="page.tpl"}

{block name="post-bootstrap-stylesheets"}
    <link href="css/StudentDashboard.css" rel="stylesheet">
{/block}

{block name="page-content"}
          <h1 class="page-header" id="welcome" >Welcome, {$fullname}</h1>

          <div class="container">
            <div id="ot-streams"></div>
          </div>

          <h2 class="sub-header">Assignments</h2>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Tag</th>
                  <th>TO-DO</th>
                  <th>Due</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td><span class="label label-success">BIOE 24</span></td>
                  <td><a href="Test.html">Lorem</a></td>
                  <td>Today</td>
                </tr>
                <tr>
                  <td><span class="label label-warning">BIOE 1A</span></td>
                  <td><a href="Test.html">amet</a></td>
                  <td>Today</td>
                </tr>
                <tr>
                  <td><span class="label label-info">Miriram Pe</span></td>
                  <td><a href="Test.html">Integer</a></td>
                  <td>Today</td>
                </tr>

              </tbody>
            </table>
          </div>
{/block}

{block name="post-bootstrap-scripts"}
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Load my Js file -->
    <script src="js/StudentDashboard.js"></script>
    <script src="https://static.opentok.com/v2/js/opentok.min.js"></script>
    <script src="js/session.js"></script>
    <script>
        app.init('{$rootURL}', '{$id}');
    </script>
{/block}
