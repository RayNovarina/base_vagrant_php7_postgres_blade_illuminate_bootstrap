@extends('base')

@section('browsertitle')
  Add Testimonial
@stop

@section('content')
  <div class="row">
    <div class="col-md-2">
    </div>

    <div class="col-md-8">

    <h1><a href="/add-testimonial" class="page-title-link">Add Testimonial</a></h1>

    <hr>

    <form id="testimonialform" name="testimonialform" class="form-horizontal"
      action="/add-testimonial" method="post">
      
      <input type="hidden" name="_token"
             value="{!! htmlspecialchars($signer->getSignature()) !!}">

      <div class="form-group">
        <label for="title" class="col-sm-2 control-label">Title</label>
        <div class="col-sm-10">
          <input type="text" class="form-control required" id="title"
            name="title" placeholder="Title">
        </div>
      </div>

      <div class="form-group">
        <label for="testimonial" class="col-sm-2 control-label">Testimonial</label>
        <div class="col-sm-10">
          <textarea class="form-control required" id="testimonial"
            name="testimonial" placeholder="Testimonial"></textarea>
        </div>
      </div>

      <hr>

      <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
          <button type="submit" class="btn btn-primary">Save Testimonial</button>
        </div>
      </div>

    </form>
  </div>

  <div class="col-md-2">
  </div>

</div>
@stop

@section('bottomjs')
<script>
  $(document).ready(function(){
    // alert('add-testimonial page ready');
    $('#testimonialform').validate();
  });
</script>
@stop
