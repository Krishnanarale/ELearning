@extends('layouts.app')

@section('content')
<div class="container">
<div class="panel panel-default">
  <div class="panel-heading">
      <h3>Subject Data</h3>
      <button type="button" class="btn btn-success" data-toggle="modal" data-target="#subjectModal">Add Subject</button>
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
                      <th>Subject</th>
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
                      <th>Subject</th>
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



<div id="subjectModal" class="modal">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Add subject</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="level">Level:</label>
          <select type="select" class="form-control addsubjectfield" id="level">

          </select>
        </div>
        <div class="form-group">
          <label for="level">Course:</label>
          <select type="select" class="form-control addsubjectfield" id="course">
            
          </select>
        </div>
        <div class="form-group">
          <label for="level">subject:</label>
          <input type="text" class="form-control addsubjectfield" id="subject" placeholder="Enter subject">
        </div>
        <div class="form-group">
          <label for="description">Description:</label>
          <input type="text" class="form-control addsubjectfield" id="description" placeholder="Enter description">
        </div>
        <div class="form-group">
          <label for="file">Thumbnail:</label>
          <input type="file" class="form-control addsubjectfield" id="thumbnail">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success" id="addsubjectbtn">Submit</button>
      </div>
    </div>

  </div>
</div>

<div id="updatesubjectModal" class="modal">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <input type="hidden" id="usubjectid">
      <div class="modal-header">
        <h4 class="modal-title">Update subject</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="level">Level:</label>
          <select type="select" class="form-control updatesubject" id="ulevel">

          </select>
        </div>
        <div class="form-group">
          <label for="level">Course:</label>
          <select type="select" class="form-control updatesubject" id="ucourse">

          </select>
        </div>
        <div class="form-group">
          <label for="level">Course:</label>
          <input type="text" class="form-control updatesubject" id="usubjectname" placeholder="Enter Subject">
        </div>
        <div class="form-group">
          <label for="description">Description:</label>
          <input type="text" class="form-control updatesubject" id="udescription" placeholder="Enter description">
        </div>
        <div class="form-group">
          <img id="usubjectthumb" style="height: 100px; width: 100px;" src="">
        </div>

        <div class="form-group">
          <label for="file">Thumbnail:</label>
          <input type="file" class="form-control updatesubject" id="uthumbnail">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success" id="updatesubjectbtn">Submit</button>
      </div>
    </div>
  </div>
</div>

<div id="deletesubjectModal" class="modal" >
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <input type="hidden" id="dsubjectid">
      <div class="modal-header">
        <h4 class="modal-title">Delete subject</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
          <p>Are you sure to delete this record ?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success" data-val="" id="deletesubjectbtn">Delete</button>
      </div>
    </div>
  </div>
</div>
@section('pagescript')
    <script src="{{ asset('js/subjects.js') }}" defer></script>
@stop
@endsection