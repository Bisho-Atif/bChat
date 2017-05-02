@extends('layouts.base')

@section('header')
  <h3 class="text-center" >Hello, {{ Auth::user()->name }}</h3>
  <h5 class="text-center">This is bChat</h5>
@endsection

@section('content')
  @include('layouts.chat.onlineUsers')
@endsection
