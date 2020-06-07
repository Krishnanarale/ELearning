$('#addsubjectbtn').click(() => {
    // $('.addsubjectfield').val('');
    let file = $('#thumbnail').prop('files')[0];
    let level = $('#level').val();
    let course = $('#course').val();
    let subject = $('#subject').val();
    let description = $('#description').val();
    
    // if(level == ''){
    //    $('#levelspan').show();
    //    return false;
    // }else{
    //    $('#levelspan').hide();
    // }
    // if(course == '' || undefined || '-1'){
    //    return false;
    //    $('#coursespan').show();
    // }else{
    //    $('#coursespan').hide();
    // }
    // if(subject == ''){
    //    return false;
    //    $('#subjectspan').show();
    // }else{
    //    $('#subjectspan').hide();
    // }
    // if(description == ''){
    //    return false;
    //    $('#descriptionspan').show();
    // }else{
    //    $('#descriptionspan').hide();
    // }
    // if(file == ''){
    //    return false;
    //    $('#filespan').show();
    // }else{
    //    $('#filespan').hide();
    // }

    let form_data = new FormData();
    form_data.append('thumbnail', file);
    form_data.append('subject', subject);
    form_data.append('level', level);
    form_data.append('course', course);
    form_data.append('description', description);

    $.ajax({
        url: '/api/subject',
        method: 'post',
        dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        crossDomain: true,
        data: form_data,
        success: (res) => {
          if(res.status == 'success'){
            let url = '/api/subjects';
            apploader(url);
            $('#subjectModal').modal('toggle');
            notify('success', 'Subject added successfully');
          }else{
            notify('error', 'Failed to add subject');
          }
        }
    });

});

$('#updatesubjectbtn').click(() => {
    $('#subject, #description, #thumbnail').val('');
    let subjectid = $('#usubjectid').val();
    let form_data = new FormData();
    let file = $('#uthumbnail').prop('files')[0];
    let level = $('#ulevel').val();
    let course = $('#ucourse').val();
    let subject = $('#usubjectname').val();
    let description = $('#udescription').val();
    form_data.append('thumbnail', file);
    form_data.append('level', level);
    form_data.append('subject', subject);
    form_data.append('course', course);
    form_data.append('description', description);
    $.ajax({
        url: '/api/subject/'+subjectid+'',
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
            subjectsLoader();
            $('#updatesubjectModal').modal('toggle');
            notify('success', 'Subject updated successfully');
          }else{
            notify('error', 'Failed to update subject');
          }
        }
    });

});

$('#deletesubjectbtn').click(() => {
  let subject = $('#deletesubjectbtn').attr('data-val');
  $.ajax({
    url: '/api/subject/'+subject,
    method: 'delete',
    dataType: 'json',
    success: (res) => {
      if(res.status == 'success'){
        $('#deletesubjectModal').modal('toggle');
        subjectsLoader();
        notify('success', 'Subject deleted successfully');
      }else{
        notify('error', 'Failed to delete subject');
      }
    }
  })
});

const subjectsLoader = () => {
  let url = '/api/subjects';
  apploader(url);
}

$(document).ready(function(){
  subjectsLoader();
});

const apploader = (url) => {
    let i = 1;
    $('#example').DataTable().destroy();
    $('#example').DataTable({
      "ajax": url,
      "scrollX": true,
      "columns": [
            { "data": (data, type) => { return i++; }},
            { "data": "subject"},
            { "data": "course_name"},
            { "data": "level_name"},
            { "data": "description"},
            { "data": (data, type) => { return '<img style="height: 50px; width: 50px;" src="/uploads/subjects/'+data.thumbnail+'">'; } },
            { "data": (data, type) => { if(data.status == '1'){ return '<span class="badge badge-success">Active</span>'; }else{ return '<span class="badge badge-danger">Deactive</span>'; }}},
            { "data": (data, type) => { return '<a class="infobtn btn btn-success" data-value='+data.id+'><i class="fa fa-pencil"></i> &nbsp; view</a>'}},
            { "data": (data, type) => { return '<a class="deletebtn btn btn-danger" data-value='+data.id+'><i  class="fa fa-trash"></i>&nbsp;delete</a>'}},
        ],
        "initComplete": function () {
            var api = this.api();
            api.$('.deletebtn').click(function(){
                  var deptid = $(this).data('value');
                  $('#dsubjectid').attr('data-val', '');
                  $('#deletesubjectbtn').attr('data-val', deptid);
                  $('#deletesubjectModal').modal();
                });
 
            api.$('.infobtn').click( function () {
              let id = $(this).data('value');
              $('.updatelevel').val('');
                $.ajax({
                  url: '/api/subject/'+id+'',
                  dataType:'json',
                  method: 'GET',
                  success: function(res) {
                      if(res.status == 'success'){
                        $('.updatecourse').val('');
                        let data = res.data;
                        $('#ulevel').html('');
                         $('#ucourse').html('');
                        let newlist = '<option value="-1" selected="selected">Select Level</option>';
                        let courselist = '';
                        let levelSelected = res.data.level;

                        $.ajax({
                          url: '/api/levels',
                          method: 'get',
                          dataType: 'json',
                          success: (res) => {
                              let newlist = '';
                              if(res.status == 'success'){
                                res.data.forEach((item, index) => {
                                  if(item.id == res.data.level_id){
                                    newlist += '<option selected="selected" value="'+item.id+'">'+item.level+'</option>';
                                  }else{
                                    newlist += '<option value="'+item.id+'">'+item.level+'</option>';
                                  }
                                });
                                
                                $('#ulevel').html(newlist);
                              }else{
                                notify('error', 'Failed to retrive levels');
                                $('#ulevel').html(list);
                              }
                          }
                        });

                       
                        $.ajax({
                          url: '/api/level/'+res.data.level_id+'/courses',
                          method: 'get',
                          dataType: 'json',
                          success: (res) => {
                              console.log(res);
                              let newlist = '';
                              if(res.status == 'success'){
                                res.data.forEach((item, index) => {
                                  if(item.id == res.data.course){
                                    courselist += '<option selected="selected" value="'+item.id+'">'+item.course+'</option>';
                                  }else{
                                    courselist += '<option value="'+item.id+'">'+item.course+'</option>';
                                  }
                                });
                                
                                $('#ucourse').html(courselist);
                              }else{
                                notify('error', 'Failed to retrive courses');
                                $('#ucourse').html(courselist);
                              }
                          }
                        });

                        $('#usubjectid').val(res.data.id);
                        $('#usubjectname').val(res.data.subject);
                        $('#udescription').val(res.data.description);
                        $('#usubjectthumb').attr('src', '/uploads/subjects/'+res.data.thumbnail+'');
                        $('#updatesubjectModal').modal('toggle');
                      }else{
                        notify('error', 'Course not found');
                      }
                    }
                  });
            });
        }

    });
}


$("#subjectModal").on('show.bs.modal', function(){
    $('.addsubjectfield').val('');
    $('#level').html('');
      $.ajax({
        url: '/api/levels',
        method: 'get',
        dataType: 'json',
        success: (res) => {
            let newlist = '';
            if(res.status == 'success'){
              let newlist = '<option value="-1" selected="selected">Select Level</option>';
              res.data.forEach((item, index) => {
                  newlist += '<option value="'+item.id+'">'+item.level+'</option>';
              });              
              $('#level').html(newlist);
              $('#course').html('<option value="-1" selected="selected">Select Course</option>');
            }else{
              notify('error', 'Failed to retrive levels');
              $('#level').html(newlist);
            }
        }
      });

});


$('#level').change(() => {
  let level = $('#level').val();
  let courselist = '<option value="-1" selected>Select course</option>';
  $.ajax({
    url: '/api/level/'+level+'/courses',
    method: 'get',
    dataType: 'json',
    success: (res) => {
      if(res.status == 'success'){
        res.data.forEach((item, index) => {
            courselist += '<option value="'+item.id+'">'+item.course+'</option>';
        });
        
        $('#course').html(courselist);
        return true;
      }else{
        notify('error', 'Failed to retrive courses');
        $('#course').html(courselist);
        return false;
      }
    }
  })
});

$('#ulevel').change(() => {
  let level = $('#ulevel').val();
  let courselist = '<option value="-1" selected>Select course</option>';
  $.ajax({
    url: '/api/level/'+level+'/courses',
    method: 'get',
    dataType: 'json',
    success: (res) => {
      if(res.status == 'success'){
        res.data.forEach((item, index) => {
            courselist += '<option value="'+item.id+'">'+item.course+'</option>';
        });
        
        $('#ucourse').html(courselist);
        return true;
      }else{
        notify('error', 'Failed to retrive courses');
        $('#ucourse').html(courselist);
        return false;
      }
    }
  })
});

// $("#updatesubjectModal").on('show.bs.modal', function(){
//     $('.updatecourse').val('');
// });

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


let coursesList = (id) => {
      $('#ucourse').html('');
      let courselist = '';
      $.ajax({
        url: '/api/courses',
        method: 'get',
        dataType: 'json',
        success: (res) => {
            let newlist = '';
            if(res.status == 'success'){
              res.data.forEach((item, index) => {
                if(item.id == id){
                  courselist += '<option selected="selected" value="'+item.id+'">'+item.course+'</option>';
                }else{
                  courselist += '<option value="'+item.id+'">'+item.course+'</option>';
                }
              });
              
              $('#ucourse').html(courselist);
              return true;
            }else{
              notify('error', 'Failed to retrive courses');
              $('#ucourse').html(courselist);
              return false;
            }
        }
      });
} 