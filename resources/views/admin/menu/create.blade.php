@extends('admin.layouts.app')
@section('title', 'Add Menu Item')
@section('crumb', 'Frontend Menu · Create')
@section('active', 'frontend-menu')
@section('content')
<div class="saas-editor"><form method="POST" action="{{ route('admin.menu.store') }}">@csrf @include('admin.menu.form')<div class="saas-editor__actions"><button class="btn btn--primary saas-btn saas-btn--save">Create menu item</button></div></form></div>
@endsection
