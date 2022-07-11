@extends('layout')

@section('app-content')
  <auth-settings-page :user="{{ $user }}"></auth-settings-page>
@endsection