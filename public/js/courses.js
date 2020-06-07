$('#addcoursebtn').click(() => {
    let form_data = new FormData();
    let file = $('#thumbnail').prop('files')[0];
    let level = $('#level').val();
    let course = $('#course').val();
    let description = $('#description').val();
    form_data.append('thumbnail', file);
    form_data.append('level', level);
    form_data.append('course', course);
    form_data.append('description', description);

    $.ajax({
        url: '/api/course',
        method: 'post',
        dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        crossDomain: true,
        data: form_data,
        success: (res) => {
          if(res.status == 'success'){
            let url = '/api/courses';
            apploader(url);
            $('#courseModal').modal('toggle');
            notify('success', 'Course added successfully');
          }else{
            notify('danger', 'Failed to add course');
          }
        }
    });

});

$('#updatecoursebtn').click(() => {
    let courseid = $('#ucourseid').val();
    let form_data = new FormData();
    let file = $('#uthumbnail').prop('files')[0];
    let level = $('#ulevel').val();
    let course = $('#ucoursename').val();
    let description = $('#udescription').val();
    form_data.append('thumbnail', file);
    form_data.append('level', level);
    form_data.append('course', course);
    form_data.append('description', description);
    $.ajax({
        url: '/api/course/'+courseid+'',
        method: 'post',
        dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        crossDomain: true,
        data: form_data,
        success: (res) => {
          if(res.status == 'success'){
            $('#example').DataTable().destroy();
            let url = '/api/courses';
            apploader(url);
            $('#updatecourseModal').modal('toggle');
            notify('success', 'Course updated successfully');
          }else{
            notify('error', 'Failed to update course');
          }
        }
    });

});

$('#deletecoursebtn').click(() => {
  let course = $('#deletecoursebtn').attr('data-val');
  $.ajax({
    url: '/api/course/'+course,
    method: 'delete',
    dataType: 'json',
    success: (res) => {
      if(res.status == 'success'){
        $('#deletecourseModal').modal('toggle');
        coursesLoader();
        notify('success', 'Course deleted successfully');
      }else{
        notify('error', 'Failed to delete course');
      }
    }
  })
});

const coursesLoader = () => {
  let url = '/api/courses';
  apploader(url);
}

$(document).ready(function(){
  coursesLoader();
});

const apploader = (url) => {
    let i = 1;
    $('#example').DataTable().destroy();
    $('#example').DataTable({
      "ajax": url,
      "scrollX": true,
      "columns": [
            { "data": (data, type) => { return i++; }},
            { "data": "course"},
            { "data": "level_name"},
            { "data": "description"},
            { "data": (data, type) => { return '<img style="height: 50px; width: 50px;" src="/uploads/courses/'+data.thumbnail+'">'; } },
            { "data": (data, type) => { if(data.status == '1'){ return '<span class="badge badge-success">Active</span>'; }else{ return '<span class="badge badge-danger">Deactive</span>'; }}},
            { "data": (data, type) => { return '<a class="infobtn btn btn-success" data-value='+data.id+'><i class="fa fa-pencil"></i> &nbsp; view</a>'}},
            { "data": (data, type) => { return '<a class="deletebtn btn btn-danger" data-value='+data.id+'><i  class="fa fa-trash"></i>&nbsp;delete</a>'}},
        ],
        "initComplete": function () {
            var api = this.api();

            api.$('.deletebtn').click(function(){
                  var deptid = $(this).data('value');
                  $('#dcourseid').attr('data-val', '');
                  $('#deletecoursebtn').attr('data-val', deptid);
                  $('#deletecourseModal').modal();
                });
 
            api.$('.infobtn').click( function () {
              let id = $(this).data('value');
              $('.updatelevel').val('');
                $.ajax({
                  url: '/api/course/'+id+'',
                  dataType:'json',
                  method: 'GET',
                  success: function(res) {
                      if(res.status == 'success'){
                        let data = res.data;
                        $('#ucoursename').val(res.data.course);
                        $('#ucoursethumb').attr('src', '/uploads/courses/'+res.data.thumbnail+'');
                        levelsList(res.data.level);
                        $('#updatecourseModal').modal('toggle');
                        $('#ucoursename').val(res.data.course);
                        $('#udescription').val(res.data.description);
                        $('#ucourseid').val(res.data.id);
                      }else{
                        notify('error', 'Course not found');
                      }
                    }
                  });
            });
        }

    });
}


$("#courseModal").on('show.bs.modal', function(){
    $('.addcoursefield').val('');
    $('#level').html('');
      let newlist = '<option value="-1" selected="selected">Select Level</option>';
      $.ajax({
        url: '/api/levels',
        method: 'get',
        dataType: 'json',
        success: (res) => {
            if(res.status == 'success'){
              res.data.forEach((item, index) => {
                  newlist += '<option value="'+item.id+'">'+item.level+'</option>';
              });
              
              $('#level').html(newlist);
              return true;
            }else{
              notify('error', 'Failed to retrive levels');
              $('#level').html(list);
              return false;
            }
        }
      });
});

$("#updatecourseModal").on('show.bs.modal', function(){
    $('.updatecourse').val('');
    // let list = levelsList();
    // $('#ulevel').html(list);
});

let levelsList = (id) => {
      $('#ulevel').html('');
      let newlist = '<option value="-1" selected="selected">Select Level</option>';
      $.ajax({
        url: '/api/levels',
        method: 'get',
        dataType: 'json',
        success: (res) => {
            let newlist = '';
            if(res.status == 'success'){
              res.data.forEach((item, index) => {
                if(item.id == id){
                  newlist += '<option selected="selected" value="'+item.id+'">'+item.level+'</option>';
                }else{
                  newlist += '<option value="'+item.id+'">'+item.level+'</option>';
                }
              });
              
              $('#ulevel').html(newlist);
              return true;
            }else{
              notify('error', 'Failed to retrive levels');
              $('#ulevel').html(list);
              return false;
            }
        }
      });
}
