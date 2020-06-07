$('#addlevelbtn').click(() => {
    let form_data = new FormData();
    let file = $('#thumbnail').prop('files')[0];
    let level = $('#level').val();
    let description = $('#description').val();
    form_data.append('thumbnail', file);
    form_data.append('level', level);
    form_data.append('description', description);
    $.ajax({
        url: '/api/level',
        method: 'post',
        dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        crossDomain: true,
        data: form_data,
        success: (res) => {
          if(res.status == 'success'){
            $('#levelModal').modal('toggle');
            let url = '/api/levels';
            apploader(url);
            notify('success', 'Level added successfully');
          }else{
            notify('warning', 'Failed to add level');
          }
        }
    });
});

$('#updatelevelbtn').click(() => {
    let levelid = $('#ulevelid').val();
    let form_data = new FormData();
    let file = $('#uthumbnail').prop('files')[0];
    let level = $('#ulevel').val();
    let description = $('#udescription').val();

    form_data.append('thumbnail', file);
    form_data.append('level', level);
    form_data.append('description', description);
    $.ajax({
        url: '/api/level/'+levelid+'',
        method: 'post',
        dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        crossDomain: true,
        data: form_data,
        success: (res) => {
          if(res.status == 'success'){
            $('#updatelevelModal').modal('toggle');
            $('#example').DataTable().destroy();
            let url = '/api/levels';
            apploader(url);
            notify('success', 'Level updated successfully');
          }else{
            notify('danger', 'Failed to update level');
          }
        }
    });
});

$('#deletelevelbtn').click(() => {
  let level = $('#deletelevelbtn').attr('data-val');
  $.ajax({
    url: '/api/level/'+level,
    method: 'delete',
    dataType: 'json',
    success: (res) => {
      if(res.status == 'success'){
        levelLoader();
        notify('success', 'Level Deleted');
        $('#deletelevelModal').modal('toggle');
      }else{
        notify('danger', 'Failed to delete level');
      }
    }
  })
});

let levelLoader = () => {
  let url = '/api/levels';
  apploader(url);
}

$(document).ready(function(){
  levelLoader();
});

const apploader = (url) => {
    let i = 1;
    $('#example').DataTable().destroy();
    $('#example').DataTable({
      "ajax": url,
      "scrollX": true,
      "columns": [
            { "data": (data, type) => { return i++; }},
            { "data": "level"},
            { "data": "description"},
            { "data": (data, type) => { return '<img style="height: 50px; width: 50px;" src="/uploads/levels/'+data.thumbnail+'">'; } },
            { "data": (data, type) => { if(data.status == '1'){ return '<span class="badge badge-success">Active</span>'; }else{ return '<span class="badge badge-danger">Deactive</span>'; }}},
            { "data": (data, type) => { return '<a class="infobtn btn btn-success" data-value='+data.id+'><i class="fa fa-pencil"></i> &nbsp; view</a>'}},
            { "data": (data, type) => { return '<a class="deletebtn btn btn-danger" data-value='+data.id+'><i  class="fa fa-trash"></i>&nbsp;delete</a>'}},
        ],
        "initComplete": function () {
            var api = this.api();

            api.$('.deletebtn').click(function(){
                  var deptid = $(this).data('value');
                  $('#dlevelid').attr('data-val', '');
                  $('#deletelevelbtn').attr('data-val', deptid);
                  $('#deletelevelModal').modal();
                });
 
            api.$('.infobtn').click( function () {
              let id = $(this).data('value');
              $('.updatelevel').val('');
                $.ajax({
                  url: '/api/level/'+id+'',
                  dataType:'json',
                  method: 'GET',
                  success: function(res) {
                      if(res.status == 'success'){
                        let data = res.data;
                        $('#ulevelid').val(data.id);
                        $('#ulevel').val(data.level);
                        $('#udescription').val(data.description);
                        $('#ulevelthumb').attr('src', '/uploads/levels/'+data.thumbnail+'');
                        $('#updatelevelModal').modal('toggle');
                      }else{
                        notify('danger', 'Level data not found');
                      }
                    }
                  });
            });
        }

    });
}


$("#levelModal").on('show.bs.modal', function(){
  $('.addlevelfield').val('');
});