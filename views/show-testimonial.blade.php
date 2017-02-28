@extends('base')

@section('browsertitle')
  Show Testimonial
@stop

@section('content')
  <div class="row">
    <div class="col-md-2">
    </div>

    <div class="col-md-8">

    <h1><a href="/testimonial/{{ $testimonial->id }}" class="page-title-link">Show Testimonial</a></h1>

    <hr>

    <form id="testimonialform" name="testimonialform" class="form-horizontal"
      action="" method="">

      <input type="hidden" name="_token"
             value="">

      <div class="form-group">
        <label for="title" class="col-sm-2 control-label">Title</label>
        <div class="col-sm-10">
          <input type="text" class="form-control required" id="title"
            name="title" value="{{ $testimonial->title }}">
        </div>
      </div>

      <div class="form-group">
        <label for="testimonial" class="col-sm-2 control-label">Testimonial</label>
        <div class="col-sm-10">
          <textarea class="form-control required" id="testimonial"
            name="testimonial" >{{ $testimonial->testimonial }}</textarea>
        </div>
      </div>

    </form>
  </div>

  <div class="col-md-2">
  </div>

</div>
@stop
