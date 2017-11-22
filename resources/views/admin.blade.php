@extends('layouts.admin')

@section('content')
  <page-header></page-header>

  <top-notifications v-cloak></top-notifications>

  <router-view></router-view>

  <growl-notifications v-cloak></growl-notifications>

  <vue-progress-bar></vue-progress-bar>
@endsection