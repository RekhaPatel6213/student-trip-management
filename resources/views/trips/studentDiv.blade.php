<div class="row gx-2" id="studentInfo_{{$key}}_{{$sKey}}">
  <input type="hidden" name="ids_{{$key}}[]" id="id_{{$key}}_{{$sKey}}" value="{{$student->id??null}}">
  <div class="col-sm-3 d-flex flex-row">
    <label class="form-label fs--2 m-0 me-3 p-1" for="firstName_{{$key}}_{{$sKey}}">{{__('message.firstName')}}</label>
    <div>
      <input name="firstname_{{$key}}[]" id="firstName_{{$key}}_{{$sKey}}" type="text" class="form-control form-control-sm firstName" autocomplete="off" maxlength="50" required="" placeholder="First Name" style="height: 29px;" value="{{$student->first_name??''}}"/>
    </div>
  </div>
  <div class="col-sm-3 d-flex flex-row">
    <label class="form-label fs--2 m-0 me-3  p-1" for="lastName_{{$key}}_{{$sKey}}">{{__('message.lastName')}}</label>
    <div>
      <input name="lastname_{{$key}}[]" id="lastName_{{$key}}_{{$sKey}}" type="text" class="form-control form-control-sm" autocomplete="off" maxlength="50" required="" placeholder="Last Name" style="height: 29px;" value="{{$student->last_name??''}}"/>
    </div>
  </div>
  <div class="col-sm-5 d-flex flex-row">
    <div class="form-check form-check-inline px-1 mb-0" data-id="{{$key}}">
      <input class="form-check-input gender gender_{{$key}}" name="gender_{{$key}}[{{$sKey}}]" id="male_{{$key}}_{{$sKey}}" type="radio" value="MALE" {{ isset($student->gender) && $student->gender === 'MALE' ? 'checked' : 'checked' }}/>
      <label class="form-check-label mb-0" for="male_{{$key}}_{{$sKey}}">M</label>
    </div>
    <div class="form-check form-check-inline px-1 mb-0" data-id="{{$key}}">
      <input class="form-check-input gender gender_{{$key}}" name="gender_{{$key}}[{{$sKey}}]" id="female_{{$key}}_{{$sKey}}" type="radio" value="FEMALE" {{ isset($student->gender) && $student->gender === 'FEMALE' ? 'checked' : '' }}/>
      <label class="form-check-label mb-0" for="female_{{$key}}_{{$sKey}}">F</label>
    </div>
    
    
    <a href="javascript://" class="disabilityChange">
      <input type="hidden" name="disability_{{$key}}[]" id="disability_{{$key}}_{{$sKey}}" value="{{ $student->is_disability??'NO' }}">
      <span class="fas fab fa-accessible-icon mx-2 mt-1 mb-2 fs-1 {{ isset($student->is_disability) && $student->is_disability === 'YES' ? 'text-scicon' : 'text-scicon-disable' }}"></span>
    </a>

    <div class="studentNote {{ $student->note??null !== null ? 'd-none' : 'd-none'}} me-3 w-100">
      <input name="notes_{{$key}}[]" id="note_{{$key}}_{{$sKey}}" type="text" class="form-control form-control-sm" autocomplete="off" maxlength="250" value="{{$student->note??''}}"/>
      <a class="m-2 fs--2 font-sans-serif saveNoteBtn" href="javascript://">Save</a>
      <a class="m-2 fs--2 font-sans-serif cancleNoteBtn" href="javascript://">Cancel</a>
    </div>
    <a class="m-2 mt-1 ms-3 fs--2 font-sans-serif w-100 text-nowrap addNoteBtn{{isset($student->note) && $student->note !== null ? ' d-none1': ''}}" href="javascript://">{{ __('message.addNote') }}</a>
    
    <div class="w-100">
      <select name="cabin_id_{{$key}}[]" id="cabinId_{{$key}}_{{$sKey}}" class="form-select form-select-sm cabinId" style="height: 29px;">
          <option value="">Cabin</option>
          @if($teacherCabins)
            @foreach($teacherCabins as $gender => $allCabin)
            @php
              $disabled = (isset($student->gender) && $student->gender === 'MALE' && $gender === 'Female') ? 'disabled' : ((isset($student->gender) && $student->gender === 'FEMALE' && $gender === 'Male') ? 'disabled' : ((!isset($student->gender) && $gender === 'Female') ? 'disabled' : ''));
            @endphp

              {{--@if($cabin->block_week !== null && in_array($weekYear, $cabin->block_week))
              @else--}}
              @foreach($allCabin as $cabin)
                <option value="{{ $cabin }}" {{ ($student->teacher_cabin_id ?? '') == $cabin ? "selected" : "" }} data-gender="{{ $gender }}" {{ $disabled }}> {{ $cabin }} </option>
              @endforeach
              {{--@endif--}}
            @endforeach
          @endif
      </select>
    </div>
  </div>
  <div class="col-sm-1 text-end">
    @if(isset($showDelete) && $showDelete === true)
      <button class="btn btn-link text-end p-0 ms-2 removeStudent {{ $student->id??'' === null ? '' : 'd-none'}}" data-key="{{$key}}" data-class-id="{{$key}}_{{$sKey}}" type="button" title="Delete"><span class="text-500 fas fa-trash-alt"></span></button>
    @endif
  </div>
</div>