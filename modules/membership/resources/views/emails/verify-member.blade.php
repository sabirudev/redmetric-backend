@extends('membership::emails.layout')

@section('title', 'Verifikasi Member Games Modules')

@section('content')
<p>Hi {{ $member->user->name ?? 'Sobat Games' }},</p>
<p>Terima kasih telah menjadi bagian dari <a href="http://gamesstadium.com">Games Modules</a></p>
<p>Untuk tahap berikutnya, silahkan klik "Verifikasi Akun Saya" dibawah ini untuk verifikasi membership Games Modules
  Kamu :).</p>
<br />
@endsection