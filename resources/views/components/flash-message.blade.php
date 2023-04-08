@if ($message = Session::get('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ $message }}
        <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
  
@if ($message = Session::get('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ $message }}
        <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
   
@if ($message = Session::get('warning'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ $message }}
        <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
   
@if ($message = Session::get('info'))
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        {{ $message }}
        <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
  
@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?php //echo '<pre>'; print_r($errors); echo '</pre>'; ?>
        <strong>Whoops!</strong> There were some problems with your input.
        <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif