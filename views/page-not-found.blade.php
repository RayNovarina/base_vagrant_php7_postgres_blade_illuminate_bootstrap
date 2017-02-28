@extends('base')

@section('browsertitle')
  Page not Found
@stop

@section('content')
  <h1>Page ({{ $_SERVER['REQUEST_URI'] }}) not found!
  </h1>
  <p>User&nbsp;
    @if (Acme\auth\LoggedIn::user() == false) *NOT* @endif
    logged in.
  </p>
  <p>User is&nbsp;
    @if (Acme\auth\Roles::isAdmin() == false) *NOT* @endif
    an admin.
  </p>
@stop
