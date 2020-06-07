@extends('layouts.app')

@section('content')
<div class="container">
<div class="panel panel-default">
  <div class="panel-heading">
                <h2>Courses Data</h2>
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#courseModal">Add Course</button>
</div>
<section class="content">
      <!-- <div class="row"> -->
        <div class="col-xs-12">
          <div class="box box-default">
            <div class="box-header">
              <!-- <h3 class="box-title">All Students</h3> -->

              <div class="btn-group" role="group" aria-label="...">
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">

              <table id="example" class="table table-striped table-bordered display nowrap" style="width:100%">
                <thead>
                    <tr>
                      <th>Sr.</th>
                      <th>Course</th>
                      <th>Level</th>
                      <th>Description</th>
                      <th>Icon</th>
                      <th>Status</th>
                      <th>Action</th>
                      <th>Option</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                      <th>Sr.</th>
                      <th>Course</th>
                      <th>Level</th>
                      <th>Description</th>
                      <th>Icon</th>
                      <th>Status</th>
                      <th>Action</th>
                      <th>Option</th>
                    </tr>
                </tfoot>
            </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      <!-- </div> -->
    </section>
</div>
</div>



<div id="courseModal" class="modal">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Add course</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="level">Level:</label>
          <select type="select" class="form-control addcoursefield" id="level">

          </select>
        </div>
        <div class="form-group">
          <label for="level">course:</label>
          <input type="text" class="form-control addcoursefield" id="course" placeholder="Enter course">
        </div>
        <div class="form-group">
          <label for="description">Description:</label>
          <input type="text" class="form-control addcoursefield" id="description" placeholder="Enter description">
        </div>
        <div class="form-group">
          <label for="file">Thumbnail:</label>
          <input type="file" class="form-control addcoursefield" id="thumbnail">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success" id="addcoursebtn">Submit</button>
      </div>
    </div>

  </div>
</div>

<div id="updatecourseModal" class="modal">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <input type="hidden" id="ucourseid">
      <div class="modal-header">
        <h4 class="modal-title">Update Course</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="level">Level:</label>
          <select type="select" class="form-control updatecourse" id="ulevel">

          </select>
        </div>
        <div class="form-group">
          <label for="level">Course:</label>
          <input type="text" class="form-control updatecourse" id="ucoursename" placeholder="Enter Course">
        </div>
        <div class="form-group">
          <label for="description">Description:</label>
          <input type="text" class="form-control updatecourse" id="udescription" placeholder="Enter description">
        </div>
        <div class="form-group">
          <img id="ucoursethumb" style="height: 100px; width: 100px;" src="">
        </div>

        <div class="form-group">
          <label for="file">Thumbnail:</label>
          <input type="file" class="form-control updatecourse" id="uthumbnail">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success" id="updatecoursebtn">Submit</button>
      </div>
    </div>
  </div>
</div>

<div id="deletecourseModal" class="modal" >
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <input type="hidden" id="dcourseid">
      <div class="modal-header">
        <h4 class="modal-title">Delete level</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
          <p>Are you sure to delete this record ?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success" data-val="" id="deletecoursebtn">Delete</button>
      </div>
    </div>
  </div>
</div>
@section('pagescript')
    <script src="{{ asset('js/courses.js') }}" defer></script>
@stop
@endsection