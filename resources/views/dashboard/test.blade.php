@extends('layouts.dashboard-ultra')

@section('title', 'Test Dashboard')
@section('page_title', 'Test Dashboard')

@section('content')
<div class="container">
    <h1>Test Dashboard Ultra</h1>
    <p>Si vous voyez ce message, le layout fonctionne correctement.</p>
    
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i>
        Layout dashboard-ultra.blade.php fonctionne !
    </div>
</div>
@endsection
