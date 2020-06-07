$('#addchapterbtn').click(() => {
    let form_data = new FormData();
    let file = $('#thumbnail').prop('files')[0];
    let level = $('#level').val();
    let course = $('#course').val();
    let subject = $('#subject').val();
    let chapter = $('#chapter').val();
    let description = $('#description').val();
    form_data.append('thumbnail', file);
    form_data.append('subject', subject);
    form_data.append('chapter', chapter);
    form_data.append('level', level);
    form_data.append('course', course);
    form_data.append('description', description);

    $.ajax({
        url: '/api/chapter',
        method: 'post',
        dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        crossDomain: true,
        data: form_data,
        success: (res) => {
          if(res.status == 'success'){
            chaptersLoader();
            $('#chapterModal').modal('toggle');
            notify('success', 'Chapter added successfully');
            $('.addchapterfield').val('');
          }else{
            notify('danger', 'Failed to add chapter');
          }
        }
    });

});

$('#updatechapterbtn').click(() => {
    let chapterid = $('#uchapterid').val();
    let form_data = new FormData();
    let file = $('#uthumbnail').prop('files')[0];
    let level = $('#ulevel').val();
    let course = $('#ucourse').val();
    let subject = $('#usubject').val();
    let chapter = $('#uchapter').val();
    let description = $('#udescription').val();
    form_data.append('thumbnail', file);
    form_data.append('level', level);
    form_data.append('subject', subject);
    form_data.append('chapter', chapter);
    form_data.append('course', course);
    form_data.append('description', description);
    $.ajax({
        url: '/api/chapter/'+chapterid+'',
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
            chaptersLoader();
            $('#updatechapterModal').modal('toggle');
            notify('success', 'Chapter updated successfully');
            $('.updatechapter').val('');
          }else{
            notify('error', 'Failed to update chapter');
          }
        }
    });

});

$('#deletechapterbtn').click(() => {
  let chapter = $('#deletechapterbtn').attr('data-val');
  $.ajax({
    url: '/api/chapter/'+chapter,
    method: 'delete',
    dataType: 'json',
    success: (res) => {
      if(res.status == 'success'){
        $('#deletechapterModal').modal('toggle');
        chaptersLoader();
        $('#deletechapterbtn').attr('data-val', '');
        notify('success', 'Chapter deleted successfully');
      }else{
        notify('error', 'Failed to delete chapter');
      }
    }
  })
});

const chaptersLoader = () => {
  let url = '/api/chapters';
  apploader(url);
}

$(document).ready(function(){
  chaptersLoader();
});

const apploader = (url) => {
    let i = 1;
    $('#example').DataTable().destroy();
    $('#example').DataTable({
      "ajax": url,
      "scrollX": true,
      "columns": [
            { "data": (data, type) => { return i++; }},
            { "data": "chapter"},
            { "data": "subject_name"},
            { "data": "course_name"},
            { "data": "level_name"},
            { "data": "description"},
            { "data": (data, type) => { return '<img style="height: 50px; width: 50px;" src="/uploads/chapters/'+data.thumbnail+'">'; } },
            { "data": (data, type) => { if(data.status == '1'){ return '<span class="badge badge-success">Active</span>'; }else{ return '<span class="badge badge-danger">Deactive</span>'; }}},
            { "data": (data, type) => { return '<a class="infobtn btn btn-success" style="padding-right: 20%;" data-value='+data.id+'><i class="fa fa-pencil"></i> &nbsp; view</a>'}},
            { "data": (data, type) => { return '<a class="deletebtn btn btn-danger" data-value='+data.id+'><i  class="fa fa-trash"></i>&nbsp;delete</a>'}},
        ],
        "initComplete": function () {
            var api = this.api();
            api.$('.deletebtn').click(function(){
                  var deptid = $(this).data('value');
                  $('#dchapterid').attr('data-val', '');
                  $('#deletechapterbtn').attr('data-val', deptid);
                  $('#deletechapterModal').modal();
                });
 
            api.$('.infobtn').click( function () {
              let id = $(this).data('value');
              $('.updatelevel').val('');
                $.ajax({
                  url: '/api/chapter/'+id+'',
                  dataType:'json',
                  method: 'GET',
                  success: function(res) {
                      if(res.status == 'success'){
                        console.log(res.data);
                        $('.updatechapter').val('');
                        $('.updatecourse').val('');
                        let data = res.data;
                        $('#ulevel').html('');
                         $('#ucourse').html('');
                        let newlist = '<option value="-1" selected="selected">Select Level</option>';
                        let courselist = '';
                        let levelSelected = res.data.level_id;
                        let courseSelected = res.data.course_id;
                        let subjectSelected = res.data.subject_id;
                        let selectedThumbnail = res.data.thumbnail;

                        $.ajax({
                          url: '/api/levels',
                          method: 'get',
                          dataType: 'json',
                          success: (res) => {
                              let newlist = '';
                              if(res.status == 'success'){
                                res.data.forEach((item, index) => {
                                  if(item.id == levelSelected){
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
                          url: '/api/level/'+levelSelected+'/courses',
                          method: 'get',
                          dataType: 'json',
                          success: (res) => {
                              let newlist = '';
                              if(res.status == 'success'){
                                res.data.forEach((item, index) => {
                                  if(item.id == courseSelected){
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

                        let subjectslist = '';
                        $.ajax({
                          url: '/api/course/'+courseSelected+'/subjects',
                          method: 'get',
                          dataType: 'json',
                          success: (res) => {
                              console.log(res);
                              let newlist = '';
                              if(res.status == 'success'){
                                res.data.forEach((item, index) => {
                                  if(item.id == subjectSelected){
                                    subjectslist += '<option selected="selected" value="'+item.id+'">'+item.subject+'</option>';
                                  }else{
                                    subjectslist += '<option value="'+item.id+'">'+item.subject+'</option>';
                                  }
                                });
                                console.log(subjectslist);
                                $('#usubject').html(subjectslist);
                              }else{
                                notify('error', 'Failed to retrive courses');
                                $('#usubject').html(subjectslist);
                              }
                          }
                        });

                        $('#uchapterid').val(res.data.id);
                        $('#uchapter').val(res.data.chapter);
                        $('#udescription').val(res.data.description);
                        $('#uchapterthumb').attr('src', '/uploads/chapters/'+selectedThumbnail+'');
                        $('#updatechapterModal').modal('toggle');
                      }else{
                        notify('error', 'Chapter not found');
                      }
                    }
                  });
            });
        }

    });
}


$("#chapterModal").on('show.bs.modal', function(){
    $('.addlevelfield').val('');
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

$('#course').change(() => {
  let course = $('#course').val();
  let subjectlist = '<option value="-1" selected>Select subject</option>';
  $.ajax({
    url: '/api/course/'+course+'/subjects',
    method: 'get',
    dataType: 'json',
    success: (res) => {
      if(res.status == 'success'){
        res.data.forEach((item, index) => {
            subjectlist += '<option value="'+item.id+'">'+item.subject+'</option>';
        });
        $('#subject').html(subjectlist);
      }else{
        notify('error', 'Failed to retrive subjects');
        $('#subject').html(subjectlist);
      }
    }
  })
});

$('#ucourse').change(() => {
  let course = $('#ucourse').val();
  console.log('cor'+ course);
  let subjectlist = '<option value="-1" selected>Select subject</option>';
  $.ajax({
    url: '/api/course/'+course+'/subjects',
    method: 'get',
    dataType: 'json',
    success: (res) => {
      if(res.status == 'success'){
        res.data.forEach((item, index) => {
            subjectlist += '<option value="'+item.id+'">'+item.subject+'</option>';
        });
        $('#usubject').html('');
        $('#usubject').html(subjectlist);
      }else{
        notify('error', 'Failed to retrive subjects');
        $('#usubject').html('');
        $('#usubject').html(subjectlist);
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