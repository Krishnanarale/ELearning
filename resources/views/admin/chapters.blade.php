@extends('layouts.app')

@section('content')
<div class="container">
<div class="panel panel-default">
  <div class="panel-heading">
    <h2>Chapters Data</h2>
    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#chapterModal">Add Chapter</button>
  </div>
<section class="content">
      <!-- <div class="row"> -->
        <div class="col-xs-12">
          <div class="box box-default">
            <div class="box-header">
              <div class="btn-group" role="group" aria-label="...">
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">

              <table id="example" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                      <th>Sr.</th>
                      <th>Chapter</th>
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
                      <th>Chapter</th>
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



<div id="chapterModal" class="modal">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Add Chapter</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="level">Level:</label>
          <select type="select" class="form-control addchapterfield" id="level">

          </select>
        </div>
        <div class="form-group">
          <label for="level">Course:</label>
          <select type="select" class="form-control addchapterfield" id="course">
            <option value="-1" selected="selected">Select Course</option>
          </select>
        </div>
        <div class="form-group">
          <label for="level">Subject:</label>
          <select type="select" class="form-control addchapterfield" id="subject">
            <option value="-1" selected="selected">Select Subject</option>
          </select>
        </div>
        <div class="form-group">
          <label for="level">Chapter:</label>
          <input type="text" class="form-control addchapterfield" id="chapter" placeholder="Enter Chapter">
        </div>
        <div class="form-group">
          <label for="description">Description:</label>
          <input type="text" class="form-control addchapterfield" id="description" placeholder="Enter description">
        </div>
        <div class="form-group">
          <label for="file">Thumbnail:</label>
          <input type="file" class="form-control addchapterfield" id="thumbnail">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success" id="addchapterbtn">Submit</button>
      </div>
    </div>

  </div>
</div>

<div id="updatechapterModal" class="modal">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <input type="hidden" id="uchapterid">
      <div class="modal-header">
        <h4 class="modal-title">Update Chapter</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="level">Level:</label>
          <select type="select" class="form-control updatechapter" id="ulevel">

          </select>
        </div>
        <div class="form-group">
          <label for="level">Course:</label>
          <select type="select" class="form-control updatechapter" id="ucourse">

          </select>
        </div>
        <div class="form-group">
          <label for="level">Subject:</label>
          <select type="select" class="form-control updatechapter" id="usubject">

          </select>
        </div>
        <div class="form-group">
          <label for="level">Chapter:</label>
          <input type="text" class="form-control updatechapter" id="uchapter" placeholder="Enter Chapter">
        </div>
        <div class="form-group">
          <label for="description">Description:</label>
          <input type="text" class="form-control updatechapter" id="udescription" placeholder="Enter description">
        </div>
        <div class="form-group">
          <img id="uchapterthumb" style="height: 100px; width: 100px;" src="">
        </div>

        <div class="form-group">
          <label for="file">Thumbnail:</label>
          <input type="file" class="form-control updatechapter" id="uthumbnail">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success" id="updatechapterbtn">Submit</button>
      </div>
    </div>
  </div>
</div>

<div id="deletechapterModal" class="modal" >
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <input type="hidden" id="dchapterid">
      <div class="modal-header">
        <h4 class="modal-title">Delete Chapter</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
          <p>Are you sure to delete this chapter ?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success" data-val="" id="deletechapterbtn">Delete</button>
      </div>
    </div>
  </div>
</div>
@section('pagescript')
    <script src="{{ asset('js/chapters.js') }}" defer></script>
@stop
@endsection