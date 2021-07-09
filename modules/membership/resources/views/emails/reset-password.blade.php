@extends('membership::emails.layout')

@section('title', 'Reset Password Games Modules')

@section('content')
<p>Hi {{ $user->name ?? 'Sobat Games' }},</p>
<p>Berikut adalah password yang bisa kamu gunakan sementara</p>
<p style="font-size: 28px;">{{ $user->new_password ?? '-' }}</p>
<br />
@endsection