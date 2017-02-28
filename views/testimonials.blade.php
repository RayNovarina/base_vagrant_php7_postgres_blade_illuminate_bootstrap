@extends('base')

@section('browsertitle')
  Testimonials
@stop

@section('content')
  <br><br>
  <div class="list-group">
    <a href="/testimonials" class="list-group-item active">
      <h4 class="list-group-item-heading">Testimonials</h4>
      <br>
    </a>
    @foreach ($testimonials as $testimonial)
      <a href="/testimonial/{!! $testimonial->id !!}"
         class="list-group-item">
        <h4 class="list-group-item-heading">{!! $testimonial->title !!}</h4>
        <p class="list-group-item-text">
          {!! date('D. F d, Y', strtotime($testimonial->created_at)) !!}
        </p>
        <p class="list-group-item-text">
          {!! $testimonial->testimonial !!}
        </p>
      </a>
    @endforeach
  </div>
@stop
