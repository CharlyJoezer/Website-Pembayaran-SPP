@extends('template.template')
@section('content')

@if(Auth::guard('petugas')->check())
    <span>Anda Masuk sebagai, <b>Petugas</b></span>
@elseif(Auth::guard('siswa')->check())
    <span>Anda Masuk sebagai, <b>Siswa</b></span>
@endif
    
@endsection