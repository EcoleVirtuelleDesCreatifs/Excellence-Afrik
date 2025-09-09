@extends('layouts.dashboard-ultra')

@section('title', 'Mon Profil - Excellence Afrik')
@section('page_title', 'Mon Profil')

@push('styles')
<style>
.profile-container {
    max-width: 800px;
    margin: 0 auto;
    padding: 2rem;
}

.profile-header {
    background: linear-gradient(135deg, #1a1a1a 0%, #000000 100%);
    border-radius: 1rem;
    padding: 2rem;
    margin-bottom: 2rem;
    color: #D4AF37;
    position: relative;
    overflow: hidden;
}

.profile-header::before {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    width: 200px;
    height: 200px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    transform: translate(50%, -50%);
}

.profile-header h1 {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    position: relative;
    z-index: 1;
}

.profile-header p {
    font-size: 1.1rem;
    opacity: 0.9;
    margin: 0;
    position: relative;
    z-index: 1;
}

.profile-card {
    background: #ffffff;
    border-radius: 1rem;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    padding: 2rem;
    margin-bottom: 2rem;
}

.profile-info {
    display: flex;
    align-items: center;
    gap: 1.5rem;
    margin-bottom: 2rem;
    padding: 1.5rem;
    background: #f8f9fa;
    border-radius: 0.75rem;
    border-left: 4px solid #D4AF37;
}

.profile-avatar {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #D4AF37 0%, #B8941F 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 2rem;
    font-weight: bold;
}

.profile-details h3 {
    margin: 0 0 0.5rem 0;
    font-size: 1.5rem;
    font-weight: 600;
    color: #333;
}

.profile-role {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.25rem 0.75rem;
    border-radius: 1rem;
    font-size: 0.875rem;
    font-weight: 500;
}

.role-admin {
    background: #dc354520;
    color: #dc3545;
}

.role-directeur {
    background: #fd7e1420;
    color: #fd7e14;
}

.role-journaliste {
    background: #0d6efd20;
    color: #0d6efd;
}

.form-section {
    margin-bottom: 2rem;
}

.form-section-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: #333;
    margin-bottom: 1rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid #f0f0f0;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 500;
    color: #555;
}

.form-label.required::after {
    content: ' *';
    color: #dc3545;
}

.form-control {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 2px solid #e9ecef;
    border-radius: 0.5rem;
    font-size: 1rem;
    transition: all 0.2s ease;
    background: #fff;
}

.form-control:focus {
    outline: none;
    border-color: #D4AF37;
    box-shadow: 0 0 0 0.2rem rgba(212, 175, 55, 0.25);
}

.form-control:invalid {
    border-color: #dc3545;
}

.invalid-feedback {
    display: block;
    width: 100%;
    margin-top: 0.25rem;
    font-size: 0.875rem;
    color: #dc3545;
}

.btn-primary {
    background: linear-gradient(135deg, #D4AF37 0%, #B8941F 100%);
    color: white;
    border: none;
    padding: 0.75rem 2rem;
    border-radius: 0.5rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(212, 175, 55, 0.3);
    color: white;
}

.btn-secondary {
    background: #6c757d;
    color: white;
    border: none;
    padding: 0.75rem 2rem;
    border-radius: 0.5rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-secondary:hover {
    background: #5a6268;
    color: white;
}

.alert {
    padding: 1rem 1.25rem;
    margin-bottom: 1.5rem;
    border: 1px solid transparent;
    border-radius: 0.5rem;
}

.alert-success {
    color: #155724;
    background-color: #d4edda;
    border-color: #c3e6cb;
}

.password-section {
    background: #f8f9fa;
    padding: 1.5rem;
    border-radius: 0.75rem;
    border: 1px solid #dee2e6;
}

.text-muted {
    color: #6c757d !important;
    font-size: 0.875rem;
}

.d-flex {
    display: flex;
}

.gap-2 {
    gap: 0.5rem;
}

.mt-3 {
    margin-top: 1rem;
}
</style>
@endpush

@section('content')
<div class="profile-container">
    <!-- Header -->
    <div class="profile-header">
        <h1>Mon Profil</h1>
        <p>Gérez vos informations personnelles et votre compte</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
        </div>
    @endif

    <!-- Informations actuelles -->
    <div class="profile-card">
        <div class="profile-info">
            <div class="profile-avatar">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div class="profile-details">
                <h3>{{ $user->name }}</h3>
                <div class="profile-role 
                    @if($user->estAdmin()) role-admin
                    @elseif($user->estDirecteurPublication()) role-directeur
                    @elseif($user->estJournaliste()) role-journaliste
                    @endif
                ">
                    @if($user->estAdmin())
                        <i class="fas fa-crown"></i> Super Administrateur
                    @elseif($user->estDirecteurPublication())
                        <i class="fas fa-user-tie"></i> Directeur de Publication
                    @elseif($user->estJournaliste())
                        <i class="fas fa-pen-nib"></i> Journaliste
                    @endif
                </div>
                <div class="text-muted mt-1">
                    <i class="fas fa-envelope me-1"></i> {{ $user->email }}
                </div>
                @if($user->derniere_connexion)
                    <div class="text-muted">
                        <i class="fas fa-clock me-1"></i> 
                        Dernière connexion : {{ $user->derniere_connexion->diffForHumans() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Formulaire de mise à jour -->
    <div class="profile-card">
        <form method="POST" action="{{ route('dashboard.profile.update') }}">
            @csrf
            @method('PUT')

            <!-- Informations personnelles -->
            <div class="form-section">
                <h3 class="form-section-title">
                    <i class="fas fa-user me-2"></i>
                    Informations Personnelles
                </h3>

                <div class="form-group">
                    <label for="name" class="form-label required">Nom complet</label>
                    <input 
                        type="text" 
                        class="form-control @error('name') is-invalid @enderror" 
                        id="name" 
                        name="name" 
                        value="{{ old('name', $user->name) }}" 
                        required
                    >
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email" class="form-label required">Adresse email</label>
                    <input 
                        type="email" 
                        class="form-control @error('email') is-invalid @enderror" 
                        id="email" 
                        name="email" 
                        value="{{ old('email', $user->email) }}" 
                        required
                    >
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Sécurité -->
            <div class="form-section">
                <h3 class="form-section-title">
                    <i class="fas fa-lock me-2"></i>
                    Sécurité du Compte
                </h3>

                <div class="password-section">
                    <p class="text-muted mb-3">
                        <i class="fas fa-info-circle me-1"></i>
                        Laissez les champs vides si vous ne souhaitez pas modifier votre mot de passe
                    </p>

                    <div class="form-group">
                        <label for="password" class="form-label">Nouveau mot de passe</label>
                        <input 
                            type="password" 
                            class="form-control @error('password') is-invalid @enderror" 
                            id="password" 
                            name="password" 
                            minlength="8"
                        >
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Minimum 8 caractères</small>
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
                        <input 
                            type="password" 
                            class="form-control" 
                            id="password_confirmation" 
                            name="password_confirmation"
                        >
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="d-flex gap-2">
                <button type="submit" class="btn-primary">
                    <i class="fas fa-save"></i>
                    Enregistrer les modifications
                </button>
                <a href="{{ route('dashboard') }}" class="btn-secondary">
                    <i class="fas fa-times"></i>
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>
@endsection