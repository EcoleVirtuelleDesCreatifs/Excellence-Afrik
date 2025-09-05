@extends('layouts.auth')

@section('title', 'Connexion')
@section('meta_description', 'Connectez-vous à votre espace Excellence Afrik pour accéder à votre dashboard')

@section('content')
<div class="auth-header">
    <div class="auth-logo">
        <i class="fas fa-crown"></i>
    </div>
    <h1 class="auth-title">Bienvenue</h1>
    <p class="auth-subtitle">Connectez-vous à votre espace Excellence Afrik</p>
</div>

<div class="auth-body">
    @if ($errors->any())
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-circle me-2"></i>
            {{ $errors->first() }}
        </div>
    @endif

    @if (session('status'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="auth-form">
        @csrf
        
        <div class="form-group">
            <label for="email" class="form-label">Adresse email</label>
            <div class="input-group">
                <i class="fas fa-envelope input-group-icon"></i>
                <input type="email" 
                       id="email" 
                       name="email" 
                       class="form-control @error('email') is-invalid @enderror" 
                       value="{{ old('email') }}" 
                       placeholder="votre@email.com"
                       required 
                       autofocus>
            </div>
            @error('email')
                <div class="invalid-feedback d-block">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="form-group">
            <label for="password" class="form-label">Mot de passe</label>
            <div class="input-group">
                <i class="fas fa-lock input-group-icon"></i>
                <input type="password" 
                       id="password" 
                       name="password" 
                       class="form-control @error('password') is-invalid @enderror" 
                       placeholder="Votre mot de passe"
                       required>
                <button type="button" class="password-toggle">
                    <i class="fas fa-eye"></i>
                </button>
            </div>
            @error('password')
                <div class="invalid-feedback d-block">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="form-check">
            <input type="checkbox" 
                   class="form-check-input" 
                   id="remember" 
                   name="remember" 
                   {{ old('remember') ? 'checked' : '' }}>
            <label class="form-check-label" for="remember">
                Se souvenir de moi
            </label>
        </div>

        <button type="submit" class="btn btn-primary">
            <i class="fas fa-sign-in-alt me-2"></i>
            Se connecter
        </button>
    </form>
</div>

<div class="auth-footer">
    <p class="mb-0">
        <a href="#" onclick="showForgotPassword()">Mot de passe oublié ?</a>
    </p>
</div>
@endsection

@push('scripts')
<script>
function showForgotPassword() {
    alert('Fonctionnalité de récupération de mot de passe à venir. Contactez l\'administrateur.');
}

// Auto-focus on email field
document.addEventListener('DOMContentLoaded', function() {
    const emailInput = document.getElementById('email');
    if (emailInput && !emailInput.value) {
        emailInput.focus();
    }
});
</script>
@endpush
