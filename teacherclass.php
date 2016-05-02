<!-- this should be templated -- SDB 4/29 -->


<div class="container">
  <div class="row">
    <div class="col-sm-3">
      <h1 class="page-header">Students</h1>
      <ul class="nav nav-sidebar">
        <li><a href="#">Student 1</a></li>
        <li><a href="#">Student 2</a></li>
        <li><a href="#">Student 3</a></li>
        <li><a href="#">Student 4</a></li>
      </ul>
      <ul class="nav nav-sidebar">
        <li><a href="">Nav item again</a></li>
        <li><a href="">One more nav</a></li>
        <li><a href="">Another nav item</a></li>
      </ul>

    </div>
    <div class="col-sm-3">
      <h1 class="page-header">Assignments</h1>
      <ul class="nav nav-sidebar">
        <li><a href="#">Task 1</a></li>
        <li><a href="#">Task 2</a></li>
        <li><a href="#">Task 3</a></li>
        <li><a href="#">Task 4</a></li>
      </ul>
      <ul class="nav nav-sidebar">
        <li><a href="">Nav item again</a></li>
        <li><a href="">One more nav</a></li>
        <li><a href="">Another nav item</a></li>
      </ul>
      <ul class="nav nav-sidebar">
        <button id="addclass" type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
          <span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span> New Assignment
        </button>
      </ul>

    </div>

    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">New Assignment</h4>
          </div>
          <div class="modal-body">
            <div class="input-group">
             <span class="input-group-addon" id="basic-addon1">Assignment Title</span>
             <input type="text" class="form-control" placeholder="Title" aria-describedby="basic-addon1">
             
           </div>
           <div class="input-group">
            <span class="input-group-addon" id="basic-addon1">Students</span>
            <input type="text" class="form-control" placeholder="Drag and drop" aria-describedby="basic-addon1">
            
          </div>
          <div class="input-group">
            <span class="input-group-addon" id="basic-addon1">Instructions</span>
            <input type="text" class="form-control" placeholder="Istructions" aria-describedby="basic-addon1">
            
          </div>
          <div class="input-group">
            <span class="input-group-addon" id="basic-addon1">Upload media</span>
            <input type="text" class="form-control" placeholder="Upload" aria-describedby="basic-addon1">
            
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>

</div>
</div>


