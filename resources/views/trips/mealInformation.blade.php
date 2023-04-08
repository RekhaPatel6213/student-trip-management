@php $key = $key+ 1; @endphp
<form method="POST" name="mealRegistration_{{$key}}" id="mealRegistration_{{$key}}" novalidate="" class="mealRegistration" files="true" enctype="multipart/form-data">
  @csrf
  <input type="hidden" name="schedule_id_{{$key}}" value="{{ $schedule->id ?? '' }}" id="schoolId">
  <input type="hidden" name="all_classes_{{$key}}" value="{{ base64_encode($scheduleId) }}">
  <input type="hidden" id="studentCount_{{$key}}" value="{{ count($schedule->studentInfo) > 0 ? (count($schedule->studentInfo)-1) : 0 }}">
  <input type="hidden" name="key" value="{{$key}}">

  <div class="noteshide">
  <p id="pargraph1">Community Eligible Provisional has changed in SY 2022-2023 California.Per USDA and Education code (EC) 49501.5,California now falls under California Universal Meals. Public school districts,country offices of education,and charter schools serving students in grades transitional kindergarten through grade 12 (TK-12) must provide two meals free of charge(breakfast and lunch) during each school day to students requesting a meal,regardless of their free or reduced-price meal eligibility.</p>
  </div>
  <div class="fs--1 mb-3">
      <div class="row gx-2">
        <div class="col-3 col-sm-2 fw-bold">Teacher</div>
        <div class="col">{{ $schedule->teacher }}</div>
      </div>
      <div class="row gx-2">
        <div class="col-3 col-sm-2 fw-bold">No. of students</div>
        <div class="col">{{ $schedule->students }}</div>
      </div>
      <div class="row gx-2 mb-3">
        <div class="col-3 col-sm-2 fw-bold">Trip date</div>
        <div class="col">{{ $schedule->trip_date }} @if($schedule->type === 'WEEK') {{ '- '.\Carbon\Carbon::create($schedule->trip_date)->addDays($schedule->days)->format(config('constants.DATE_FORMATE'))}} @endif</div>
      </div>
  </div>

  <div id="editMealRegistration_{{$key}}">
  <div class="hidedefaultpro">
    <div class="row gx-2">
      <div class="col-3 col-sm-2 fw-bold">Default provision</div>
      <div class="col">
        <div class="row gx-2 mb-3">
          <div class="col-2 col-sm-2 text-center">Free</div>
          <div class="col-3 col-sm-2">
            <div class=" input-group has-validation">
              <input class="form-control freeAmount" type="number" name="free_amount_{{$key}}" id="freeAmount_{{$key}}" value="{{ $schedule->free_amount }}" data-id="{{$key}}"/>
              <span class="input-group-text">%</span>
            </div>
            <div class="col"></div>
          </div>
        </div>
        <div class="row gx-2 mb-3">
          <div class="col-2 col-sm-2 text-center ">Paid</div>
          <div class="col-3 col-sm-2">
            <div class=" input-group has-validation">
              <input class="form-control paidAmount" type="number" name="paid_amount_{{$key}}" id="paidAmount_{{$key}}" value="{{ $schedule->paid_amount }}" data-id="{{$key}}"/>
              <span class="input-group-text">%</span>
            </div>
            <div class="col"></div>
          </div>
        </div>
        <div class="row gx-2 mb-3">
          <div class="col-2 col-sm-2 text-center ">Reduced</div>
          <div class="col-3 col-sm-2">
            <div class=" input-group has-validation">
              <input class="form-control reducedAmount" type="number" name="reduced_amount_{{$key}}" id="reducedAmount_{{$key}}"  value="{{ $schedule->reduced_amount }}" data-id="{{$key}}"/>
              <span class="input-group-text">%</span>
            </div>
          </div>
          <div class="col"></div>
        </div>
      </div>
    </div>
  </div>
  
  <div class="hidestudents">
    <h5 class="mb-3 text-nowrap py-2 py-xl-0">Students</h5>
    <div class="div-striped mb-3">
      <div>
        @if(count($schedule->studentInfo) > 0)
          @foreach($schedule->studentInfo as $sKey => $student)
            <div class="row gx-2">
              <div class="col-3 col-sm-2 p-3">{{$student->student_name}}</div>
              <div class="col-3 col-sm-2 p-2">
                <select name="meal_type_{{$key}}[]" id="mealType_{{$key}}_{{$sKey}}" class="form-select mealType_{{$key}}">
                  <option value="Free" {{ $student->free_meal == 'YES' ? "selected" : "" }}>Free</option>
                  <option value="Paid" {{ $student->paid_meal == 'YES' ? "selected" : "" }}>Paid</option>
                  <option value="Reduced" {{ $student->reduced_meal == 'YES' ? "selected" : "" }}>Reduced</option> 
                </select>
              </div>

              @php
                $mealAmount = $student->free_meal == 'YES' ? $student->free_amount : ($student->paid_meal == 'YES' ? $student->paid_amount : $student->reduced_meal)
              @endphp
              <div class="col-3 col-sm-2 p-2">
                <div class=" input-group has-validation">
                  <input type="hidden" name="students_{{$key}}[]" value="{{$student->id}}" />
                  <input class="form-control mealAmount_{{$key}}" type="number" name="meal_amount_{{$key}}[]" id="mealAmount_{{$key}}_{{$sKey}}" value="{{$mealAmount}}" />
                  <span class="input-group-text">%</span>
                </div>
              </div>
              <div class="col p-2"></div>
            </div>
          @endforeach
        @endif
      </div>
    </div>
  </div>

    <h5 class="mb-3 text-nowrap py-2 py-xl-0">Name & Signature</h5>
    <div class="row gx-2 mb-3">
      <div class="col-3 col-sm-2 p-1">Your Full Name</div>
      <div class="col-5 col-sm-4">
        <input class="form-control" type="text" name="meal_name_{{$key}}" id="mealName_{{$key}}" value="{{$schedule->meal_name}}"/>
      </div>
      <div class="col p-2"></div>
    </div>
    <div class="row gx-2 mb-3">
      <div class="col-3 col-sm-2 p-1">Title</div>
      <div class="col-5 col-sm-4">
        <input class="form-control" type="text" name="meal_title_{{$key}}" id="mealTitle_{{$key}}" value="{{$schedule->meal_title??''}}"/>
      </div>
      <div class="col p-2"></div>
    </div>
    <div class="row gx-2">
        <div class="col-3 col-sm-2 p-1 mb-1">Current Date</div>
        <div class="col-5 col-sm-4">{{ \Carbon\Carbon::now()->format(config("constants.DATE_FORMATE")) }}</div>
        <div class="col p-2"></div>
      </div>
    <div class="row gx-2">
      <div class="col-8 col-sm-6 p-3">
        @if($schedule->meal_signature === null)
          <div id="sig_{{$key}}"></div>
          <br/>
          <textarea id="signature64_{{$key}}" name="signature_{{$key}}" style="display: none"></textarea>
         
          <div class="invalid-feedback" id="signature_{{$key}}-error">This field is required.</div>
          <button class="btn btn-sm btn-outline-warning" id="clear_{{$key}}">Clear</button>
        @else
        <div class="d-flex justify-content-center border rounded-3 p-2">
          <img class="me-2 main_logo" src="{{ asset('storage/signatures/'.$schedule->meal_signature) }}" alt="" width="150" height="100">
        </div>
        @endif
      </div>
      <div class="col p-2"></div>
    </div>
    <div class="form-check">
      <input class="form-check-input" name="tesrms_policy_{{$key}}" id="flexCheckIndeterminate_{{$key}}" type="checkbox" value=""/><label class="form-check-label" for="flexCheckIndeterminate">I confirm my qualification and agree to Terms & Conditions</label>
<label class="error invalid-feedback" id="tesrms_policy_{{$key}}-error" for="tesrms_policy_{{$key}}"></label>
    </div>
    <div class="mb-3 d-flex">
      @if($schedule->meal_signature === null && count($schedule->studentInfo) > 0)
        <button class="btn btn-primary d-block mt-3 me-3 ms-0" type="button" onclick="reviewMeal({{$key}}, {{ $schedule->id ?? '' }})">{{ __('message.review') }}</button>
      @endif
    </div>
  </div>

  <div id="viewMealRegistration_{{$key}}" class="d-none">
    <div class="row gx-2">
      <div class="col-3 col-sm-2 fw-bold">Free meals</div>
      <div class="col" id="freeMealCount"></div>
    </div>
    <div class="row gx-2">
      <div class="col-3 col-sm-2 fw-bold">Paid</div>
      <div class="col" id="paidMealCount"></div>
    </div>
    <div class="row gx-2 mb-3">
      <div class="col-3 col-sm-2 fw-bold">Reduced</div>
      <div class="col" id="reducedMealCount"></div>
    </div>

    <h5 class="mb-3 text-nowrap py-2 py-xl-0">Students</h5>
    <div class="div-striped mb-3">
      <div>
        @if(count($schedule->studentInfo) > 0)
          @foreach($schedule->studentInfo as $sKey => $student)
            <div class="row gx-2">
              <div class="col-3 col-sm-2">{{$student->student_name}}</div>
              <div class="col-3 col-sm-2 mealTypeText_{{$key}}">{{ $student->free_meal == 'YES' ? 'Free' : ($student->paid_meal == 'YES' ? 'Paid' : 'Reduced')}}</div>
              <div class="col"></div>
            </div>
          @endforeach
        @endif
      </div>
    </div>

    <h5 class="mb-3 text-nowrap py-2 py-xl-0">Name & Signature</h5>
    <div class="row gx-2 mb-0">
      <div class="col-3 col-sm-2">{{$schedule->meal_name}}</div>
      <div class="col"></div>
    </div>
    <div class="row gx-2 mb-0">
      <div class="col-3 col-sm-2" id="reviewMealTitle_{{$key}}">{{$schedule->meal_title}}</div>
      <div class="col"></div>
    </div>
    <div class="row gx-2">
      <div class="col-3 col-sm-">
        <div class="d-flex justify-content-left">
          {{-- Storage::url($schedule->meal_signature) --}}
          <img class="me-2 main_logo" id="reviewSignature_{{$key}}" src="{{ $schedule->meal_signature ? asset('storage/signatures/'.$schedule->meal_signature) : '' }}" alt="" width="150" height="100">
        </div>
      </div>
      <div class="col"></div>
    </div>
    <div class="row gx-2 mb-3">
      <div class="col-3 col-sm-2">{{ \Carbon\Carbon::now()->format(config("constants.DATE_FORMATE")) }}</div>
      <div class="col"></div>
    </div>

    <div class="mb-3 d-flex">
      @if($schedule->meal_signature === null)
        <button class="btn btn-primary d-block mt-3 me-3 ms-0" type="button" onclick="submitMeal({{$key}}, {{ $schedule->id ?? '' }})">{{ __('message.submit') }}</button>
        <button class="btn btn-primary d-block mt-3 me-3 ms-0" type="button" onclick="editMeal({{$key}}, {{ $schedule->id ?? '' }})">{{ __('message.edit') }}</button>
      @endif
    </div>
  </div>

</form>

@push('scripts')
  <script type="text/javascript">
      var sig_{{$key}} = $('#sig_{{$key}}').signature({
          syncField: '#signature64_{{$key}}',
          syncFormat: 'PNG'
      });


      $('#clear_{{$key}}').click(function(e) {
          e.preventDefault();
          sig_{{$key}}.signature('clear');
          $("#signature64_{{$key}}").val('');
      });
  </script>
@endpush