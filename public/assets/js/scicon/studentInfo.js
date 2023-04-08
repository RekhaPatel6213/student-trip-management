$(document).on('click', '.editTeacherBtn', function () {
  $(this).parent().find('input').removeClass('d-none');
  $(this).parent().find('span').addClass('d-none');
  $(this).addClass('d-none');
});

$(document).on('blur', '.editTeacherInput', function () {
  var teacher = $(this).val();
  $(this).parent().find('span').removeClass('d-none').text(teacher);
  $(this).next().removeClass('d-none');
  $(this).addClass('d-none');
});

$(document).on('click', '.editTripDateBtn', function () {
  $(this).parent().find('input').removeClass('d-none');
  $(this).parent().find('span').addClass('d-none');
  $(this).addClass('d-none');
});

$(document).on('change', '.editTripDateInput', function () {
  var tripDate = $(this).val();
  var someDate = new Date(tripDate);
  var day = someDate.getDay();

  $(this).parents().find('input[name="days"]').val(day == 1 ? 5 : 4);

  someDate.setDate(someDate.getDate() + parseInt($(this).attr('data-day')));
  var tripEndDate = String(someDate.getMonth() + 1).padStart(2, '0') + '/' + String(someDate.getDate()).padStart(2, '0') + '/' + someDate.getFullYear();

  $(this).parent().find('span').removeClass('d-none').text(tripDate+' - '+tripEndDate);
  $(this).next().removeClass('d-none');
  $(this).addClass('d-none');
});

$(document).on('click', '.disabilityChange', function () {
  var svgimg = $(this).find('.fa-accessible-icon');
  var disability = $(this).find('input').val();

  if(disability == 'NO'){
    $(this).find('input').val('YES');
    var svgimgClass = svgimg.attr("class").replace('text-scicon-disable', 'text-scicon');
  } else {
    $(this).find('input').val('NO');
    var svgimgClass = svgimg.attr("class").replace('text-scicon', 'text-scicon-disable');
  }

  svgimg.attr("class", svgimgClass);  
});

$(document).on('click', '.addNoteBtn', function () {
  $(this).parent().find('.studentNote').removeClass('d-none');
  $(this).addClass('d-none');
});

$(document).on('click', '.saveNoteBtn', function () {
  $(this).parent().next('.addNoteBtn').removeClass('d-none');
  $(this).parent().addClass('d-none');
});

$(document).on('click', '.cancleNoteBtn', function () {
  $(this).parent().find('input').val('');
  $(this).parent().next('.addNoteBtn').removeClass('d-none');
  $(this).parent().addClass('d-none');
});

$(document).on('click', '.gender', function () {
  var gender = $(this).val();
  var cabin = $(this).parent().parent().find('.cabinId');
  var cabinId = cabin.attr('id');

  $('#'+cabinId+' option').prop('disabled', false);
  if(gender == 'FEMALE'){
    $('#'+cabinId+' option[data-gender="Male"]').prop('disabled', true);
  } else {
    $('#'+cabinId+' option[data-gender="Female"]').prop('disabled', true);
  }

  var classId = $(this).parent().attr('data-id');
  var count = $(this).parents().find('#studentCount_'+classId).val();
  var boyCount = $('.gender_'+classId+'[value="MALE"]:checked').length;
  var girlCount = $('.gender_'+classId+'[value="FEMALE"]:checked').length;
  $("#studentCountInfo_"+classId).text((parseInt(count)+1)+' ('+boyCount+'M, '+girlCount+'F)');
});


function submitStudentForm(formId, url){
  $.ajax({
    url: url,
    method: "post",
    'beforeSend': function (request) {
      var token = $('meta[name=csrf-token]').attr("content");
      request.setRequestHeader("X-CSRF-TOKEN", token);
    },
    data: $("#"+formId).serializeArray(),
    success: function (res) {
      if(res.status == true){
        location.reload();
      }
    },
    error: function (jqXHR, exception) {
      $(".loading").hide();
      swal.fire(
        'Warning',
        'Please try again...!',
        'warning'
      );
    }
  });
}

function showStudentDetail(studentDetail, isCabin){
  var modalId  = 'studentUpdateModal';

  $('#'+modalId+' #cabinId option').prop('disabled', false);
  if(studentDetail.gender == 'MALE'){
    $('#'+modalId+' #cabinId option[data-gender="Female"]').prop('disabled', true);
  } else {
    $('#'+modalId+' #cabinId option[data-gender="Male"]').prop('disabled', true);
  }

  $("#"+modalId+" #studentId").val(studentDetail.id);
  $("#"+modalId+" #firstName").val(studentDetail.first_name);
  $("#"+modalId+" #lastName").val(studentDetail.last_name);
  if(isCabin == true){
    $("#"+modalId+" #schoolId").empty().append('<option value="'+studentDetail.schedule.school_id+'" selected>'+studentDetail.schedule.school.name+'</option>');
    $("#"+modalId+" #teacher").val(studentDetail.schedule.teacher??'');
  } else {
    $("#"+modalId+" #schoolId, #"+modalId+" #teacher").parent().parent().addClass('d-none');
  }
  $("#"+modalId+" #"+studentDetail.gender.toLowerCase()).prop("checked",true);
  $("#"+modalId+" #cabinId").val(studentDetail.teacher_cabin_id);
  $("#"+modalId+" #note").val(studentDetail.note);
  $("#"+modalId+" #disability").val(studentDetail.is_disability);

  var svgimg = $("#"+modalId+" .fa-accessible-icon");
  var svgimgClassArray =  svgimg.attr("class").split(' ');
  if(studentDetail.is_disability == 'NO' && $.inArray('text-scicon', svgimgClassArray) != -1){
    var svgimgClass = svgimg.attr("class").replace('text-scicon', 'text-scicon-disable');
  } else if(studentDetail.is_disability == 'YES' && $.inArray('text-scicon-disable', svgimgClassArray) != -1){
    var svgimgClass = svgimg.attr("class").replace('text-scicon-disable', 'text-scicon');
  }
  svgimg.attr("class", svgimgClass);

  $("#"+modalId).modal('show');
}