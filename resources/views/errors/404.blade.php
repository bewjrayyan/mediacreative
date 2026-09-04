@extends('layouts.app')

@section('title', '404 - Page Not Found')

@section('content')
<div class="error-wrap">
    <div class="error-code">404</div>
    <h1>Page Not Found</h1>
    <p>Sorry, the page you're looking for doesn't exist or has been moved.</p>
    <a href="{{ route('home') }}" class="btn btn-primary btn-lg">Go Back Home</a>
</div>
@endsection