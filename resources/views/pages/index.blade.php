@extends('layout')

@section('app-content')
  <index-page :user="{{ $user }}"></index-page>
@endsection