<div class="modal fade" id="sendNewRequestModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content position-relative">
      <div class="position-absolute top-0 end-0 mt-2 me-2 z-index-1">
        <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-0">
        <div class="rounded-top-lg py-3 ps-4 pe-6 bg-light">
          <h4 class="mb-1 fs-1" id="modalExampleDemoLabel">Invite Schools</h4>
        </div>
        <div class="px-0">
          <p class="text-black px-4">You can update the standard Invitation template before sending.</p>

          <div class="mb-3 px-0" id="schoolsTable" data-list='{"valueNames":["name","district"]}'>
            <!-- <form class="position-relative" data-bs-toggle="search" data-bs-display="static"> -->
              <input type="hidden" name="requestType" id="requestType">
            <div id="table-schools-replace-element" class="mb-3 px-4">
              <div class="search-box" >
                <input class="form-control search-input search form-control-sm" type="search" placeholder="Search..." aria-label="Search" />
                <span class="fas fa-search search-box-icon"></span>
              </div>
            </div>
            <div class="table-responsive scrollbar scrollbar-overlay" style="max-height: 20rem">
              <table class="table table-sm table-striped fs--1 mb-0 overflow-hidden">
                <thead class="bg-200 text-900">
                  <tr>
                    <th>
                      <div class="form-check fs-0 mb-0 d-flex align-items-center">
                        <input class="form-check-input" id="checkbox-bulk-schools-select" type="checkbox" data-bulk-select='{"body":"table-schools-body","actions":"table-schools-actions","replacedElement":"table-schools-replace-element"}' />
                      </div>
                    </th>
                    <th class="pe-1 align-middle white-space-nowrap" data-sort="name">SCHOOL</th>
                    <th class="pe-1 align-middle white-space-nowrap" data-sort="district">DISTRICT</th>
                  </tr>
                </thead>
                <tbody class="list" id="table-schools-body">
                  @if(count($schools) > 0)
                    @foreach($schools as $school)
                      <tr class="btn-reveal-trigger" data-id="School#{{ $school->id }}">
                        <td class="align-middle py-2 border-bottom-0" style="width: 28px;">
                          <div class="form-check fs-0 mb-0 d-flex align-items-center">
                            <input class="form-check-input formCheckClass" type="checkbox" id="school-{{ $school->id }}" data-bulk-select-row="data-bulk-select-row" value="{{ $school->id }}"/>
                          </div>
                        </td>
                        <td class="name align-middle white-space-nowrap py-2 text-scicon border-bottom-0">{{ $school->name }}</td>
                        <td class="district align-middle white-space-nowrap py-2 text-black border-bottom-0">{{ $school->district->name ?? '' }}</td>
                      </tr>
                    @endforeach
                  @endif
                </tbody>
              </table>
            </div>
            <!-- </form> -->
          </div>
        </div>
      </div>
      <div class="modal-footer border-top-0 justify-content-start pt-0">
        <button class="btn btn-success btn-sm d-block fs--1" type="button" id="sendInvites">Send Invites(<span id="selectedSchoolCount">0</span>)</button>
        <button class="btn btn-secondary btn-sm d-block fs--1" type="button" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script type="text/javascript">

  $("#checkbox-bulk-schools-select").change(function(){
    if(this.checked) {
      var countCheckedCheckboxes = $checkboxes.filter(':checked').length;
      $('#selectedSchoolCount').text(countCheckedCheckboxes);
    } else {
      $('#selectedSchoolCount').text(0);
    }
  });

  var $checkboxes = $('input.formCheckClass[type=checkbox]');
  $checkboxes.change(function(){
    var countCheckedCheckboxes = $checkboxes.filter(':checked').length;
    $('#selectedSchoolCount').text(countCheckedCheckboxes);
  });

  $("#sendInvites").click(function(){
    var ids = [];
    $checkboxes.filter(':checked').each(function () {
      ids.push($(this).val());
    });

    if(ids.length > 0){
      /*swal.fire({
        title: "{{ __('actions.areYouSureWantMove') }}",
        text:"",
        icon:'warning',
        type:"warning",
        showCancelButton:!0,
        confirmButtonText:"{{ __('actions.moveButton') }}"
      }).then(function (e) {
        if (e.value) {*/
          $(".loading").show();
          $.ajax({
            url: "{{ route('schools.send.preSchedule') }}",
            method: "post",
            'beforeSend': function (request) {
              $(".loading").show();
              var token = $('meta[name=csrf-token]').attr("content");
              request.setRequestHeader("X-CSRF-TOKEN", token);
            },
            data: {
              schoolIds: ids,
              villageType: "{{$village}}",
              type: $("#requestType").val()
            },
            success: function (res) {
              swal.fire(
                'Success',
                res.message,
                res.result == true ? 'success' : 'error'
              );
              $(".loading").hide();
              if(res.result == true){
                  location.reload();
                }
            },
            error: function(xhr, status, error){
              $('.loading').hide();
            }
          });
        /*}
      });*/
    } else {
      swal.fire(
        'Warning',
        'Please select at least one school.',
        'warning'
      );
    }
  })

  function remind(type, schoolId){
    $(".loading").show();
    $.ajax({
      url: "{{ route('schools.resend.preSchedule') }}",
      method: "post",
      'beforeSend': function (request) {
        $(".loading").show();
        var token = $('meta[name=csrf-token]').attr("content");
        request.setRequestHeader("X-CSRF-TOKEN", token);
      },
      data: {
        schoolId: schoolId,
        type: type
      },
      success: function (res) {
        swal.fire(
          'Success',
          res.message,
          res.result == true ? 'success' : 'error'
        );
        $(".loading").hide();
        if(res.result == true){
          location.reload();
        }
      }
    });
  }
  
</script>
@endpush