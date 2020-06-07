@extends('layouts.app')

@section('content')
    <div class="container">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h2>Levels Data</h2>
          <button type="button" class="btn btn-success" data-toggle="modal" data-target="#levelModal">Add Level</button>
        </div>
      <section class="content">
              <div class="col-xs-12">
                <div class="box box-default">
                  <div class="box-header">
                    <div class="btn-group" role="group" aria-label="...">
                    </div>
                  </div>
                  <div class="box-body">

                    <table id="example" class="table table-striped table-bordered display nowrap" style="width:100%">
                      <thead>
                          <tr>
                            <th>Sr.</th>
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
                </div>
              </div>
          </section>
      </div>
      </div>

      <div id="levelModal" class="modal" role="dialog">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Add Level</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
              <div class="form-group">
                <label for="level">Level:</label>
                <input type="text" class="form-control addlevelfield" id="level" placeholder="Enter level">
              </div>
              <div class="form-group">
                <label for="description">Description:</label>
                <input type="text" class="form-control addlevelfield" id="description" placeholder="Enter description">
              </div>
              <div class="form-group">
                <label for="file">Thumbnail:</label>
                <input type="file" class="form-control addlevelfield" id="thumbnail">
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-success" id="addlevelbtn">Submit</button>
            </div>
          </div>

        </div>
      </div>

      <div id="updatelevelModal" class="modal" role="dialog">
        <div class="modal-dialog">

          <div class="modal-content">
            <input type="hidden" id="ulevelid">
            <div class="modal-header">
              <h4 class="modal-title">Add Level</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
              <div class="form-group">
                <label for="level">Level:</label>
                <input type="text" class="form-control updatelevel" id="ulevel" placeholder="Enter level">
              </div>
              <div class="form-group">
                <label for="description">Description:</label>
                <input type="text" class="form-control updatelevel" id="udescription" placeholder="Enter description">
              </div>
              <div class="form-group">
                <img id="ulevelthumb" style="height: 100px; width: 100px;" src="">
              </div>

              <div class="form-group">
                <label for="file">Thumbnail:</label>
                <input type="file" class="form-control updatelevel" id="uthumbnail">
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-success" id="updatelevelbtn">Submit</button>
            </div>
          </div>
        </div>
      </div>

      <div id="deletelevelModal" class="modal" role="dialog">
        <div class="modal-dialog">

          <div class="modal-content">
            <input type="hidden" id="dlevelid">
            <div class="modal-header">
              <h4 class="modal-title">Delete level</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p>Are you sure to delete this record ?</p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-success" data-val="" id="deletelevelbtn">Delete</button>
            </div>
          </div>
        </div>
      </div>

@section('pagescript')
    <script src="{{ asset('js/levels.js') }}" defer></script>
@stop
@endsection