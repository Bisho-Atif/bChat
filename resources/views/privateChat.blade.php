@extends('layouts.base')

@section('header')
  <h3 class="text-center" >Private Chat to {{ $user->name }} </h3>
@endsection

@section('messagesPanel')
@endsection

@section('content')
  @include('layouts.chat.messagesContainer')
  @include('layouts.chat.onlineUsers')
@endsection

@section('js')
  @include('js.privateJs');
@endsection