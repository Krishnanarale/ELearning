
$(function(){
    let token = getCookie('XSRF-TOKEN');
    
    $.ajaxSetup({
      beforeSend: function(xhr, settings) {
        $('.loading').show();
        // xhr.setUrl.replace(encodeURIComponent(settings.url));
        xhr.setRequestHeader('X-CSRF-TOKEN', $('#_requesttoken').attr('value'));
      }
    });

    $(document).ajaxComplete(function() {
       $('.loading').hide();
    });

    $(document).ajaxError(function() {
        notify('error', 'Oops something went wrong, Please try again');
        console.log('Ajax request error');
    });
});

let getCookie = (cname) => {
  let name = cname + "=";
  let decodedCookie = decodeURIComponent(document.cookie);
  let ca = decodedCookie.split(';');
  for(let i = 0; i <ca.length; i++) {
    let c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}


let notify = (alertType, message) => {
    Swal.fire({
      toast: true,
      position: 'top-end',
      type: alertType,
      title: message,
      showConfirmButton: false,
      timer: 2000
    });
}