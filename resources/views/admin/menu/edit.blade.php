@extends('admin.layouts.app')
@section('title', 'Edit Menu Item')
@section('crumb', 'Frontend Menu · Edit')
@section('active', 'frontend-menu')
@section('content')
<div class="saas-editor"><form method="POST" action="{{ route('admin.menu.update', $menuItem) }}">@csrf @method('PUT') @include('admin.menu.form')<div class="saas-editor__actions"><button class="btn btn--primary saas-btn saas-btn--save">Save changes</button></div></form></div>
@endsection
