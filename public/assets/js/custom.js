jQuery.validator.addMethod("uploadFile", function (val, element) {
    var size = element.files[0].size;
    if (size > 1048576) {// checks the file more than 1 MB
      return false;
    } else {
      return true;
    }
}, "File type error");

$(document).ready(function($){
  $('.phonemask').usPhoneFormat({
    format:'(xxx) xxx-xxxx'
  });

  $(".datetimepicker").flatpickr({
    dateFormat: datePickerFormate,
    //maxDate: "03/15/2023",
    disableMobile:true,
  });
});

function deleteRecords(route, ids, name){
  if(ids.length > 0){
    swal.fire({
      title:deleteTitle.replace(":page", name),
      text:deleteSubText,
      icon:'warning',
      type:"warning",
      showCancelButton:!0,
      confirmButtonText:deleteButton
    }).then(function (e) {
      $('.bulk-actions option').removeAttr("selected");
      if (e.value) {
        $(".loading").show();
        $.ajax({
          url: route,
          method: "delete",
          'beforeSend': function (request) {
            var token = $('meta[name=csrf-token]').attr("content");
            request.setRequestHeader("X-CSRF-TOKEN", token);
          },
          data: {
            ids: ids
          },
          success: function (res) {
            swal.fire(
              deletedIcon,
              res.message,
              res.result == true ? 'success' : 'error'
            );

            $.each(ids,function(key,value){
              $('.btn-reveal-trigger[data-id="'+name+'#'+value+'"]').remove();
            });

            $(".loading").hide();
          }
        });
      }
    });
  } else {
    swal.fire(
      'Warning',
      'Please select at least one record.',
      'warning'
    );
  }
}

function getDetails(id, routeName){
  $.ajax({
    url:routeName.replace(/:id/,id),
    method: "get",
    beforeSend:function(){
      $('.loading').show();
    },
    success: function (result) {
      $('.loading').hide();
      showModal(result.data);
    },
    error: function(xhr, status, error){
      $('.loading').hide();
    }
  })
}

//Form validation
$(document).ready(function () {
  /*$('#sendNewRequest').validate({
    rules: {
      school_id: "required",
    },
    messages: {
      school_id: "{{__('validation.required',['attribute'=>__('message.school')])}}",
    },
    errorPlacement: function(error, element) {
      $(element).addClass('is-invalid');
      error.insertAfter(element).addClass('invalid-feedback');
    },
    unhighlight: function(element) { // revert the change done by hightlight
      $(element).removeClass('is-invalid').next('div.error').remove();
    },
  });*/
});