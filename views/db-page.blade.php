@extends('base')

@section('browsertitle')
  {{ $browser_title }}
@stop

@section('content')
  @if(Acme\auth\Roles::isAdmin())
  <!-- NOTE: edit-form will include $page_content within a CKEditor form -->
    @include('admin.admin-edit-form')
  @else
    {!! $page_content !!}
  @endif
@stop
