@extends('emails.base-email')

@section('body')
<p>
  Welcome to Acme!
</p>

<p>
  Please <a href="{!! getenv('HOST') !!}/verify-account?token={!! $token !!}&toAddr={!! $toAddr !!}">click here to activate</a> your account.
@stop
