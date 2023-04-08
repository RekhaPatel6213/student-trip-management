<div class="px-3">
  <div class="form-check form-check-inline">
    <input class="form-check-input" id="{!! $id !!}Yes" type="radio" name="{!! $name !!}" value="YES" {{ $checked === 'YES' ? 'checked' : '' }} />
    <label class="form-check-label" for="{!! $id !!}Yes">Yes</label>
  </div>
  <div class="form-check form-check-inline">
    <input class="form-check-input" id="{!! $id !!}No" type="radio" name="{!! $name !!}" value="NO" {{ $checked === 'NO' ? 'checked' : '' }}/>
    <label class="form-check-label" for="{!! $id !!}No">No</label>
  </div>
</div>
