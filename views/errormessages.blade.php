@if (isset($_SESSION['msgs']))
  <div class="alert alert-danger alert-dismissible" role="alert">
    <ul>
      @foreach($_SESSION['msgs'] as $error)
        <li>{!! $error !!}</li>
      @endforeach
    </ul>
  </div>
@endif
