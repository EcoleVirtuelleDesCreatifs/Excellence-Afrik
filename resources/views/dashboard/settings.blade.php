@extends('layouts.dashboard-ultra')

@section('title', 'Paramètres')
@section('page_title', 'Paramètres')

@section('breadcrumbs')
    <li class="breadcrumb-item active">Paramètres</li>
@endsection

@section('content')
<div class="d-flex justify-content-center align-items-center" style="min-height: 60vh;">
    <div class="text-center">
        <i class="fas fa-cogs fa-3x text-muted mb-3"></i>
        <h3 class="text-muted">Paramètres</h3>
        <p class="text-muted">La gestion des utilisateurs est disponible dans l'onglet "Gestion des Utilisateurs"</p>
        <a href="{{ route('dashboard.users') }}" class="btn btn-primary">
            <i class="fas fa-users me-2"></i>Accéder à la gestion des utilisateurs
        </a>
    </div>
</div>
@endsection