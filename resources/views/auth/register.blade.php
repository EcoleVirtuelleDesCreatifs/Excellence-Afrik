@extends('layouts.auth')

@section('title', 'Créer un compte')
@section('meta_description', 'Créez votre compte Excellence Afrik pour accéder à votre espace personnel')

@section('content')
<div class="auth-header">
    <div class="auth-logo">
        <i class="fas fa-user-plus"></i>
    </div>
    <h1 class="auth-title">Créer un compte</h1>
    <p class="auth-subtitle">Rejoignez la communauté Excellence Afrik</p>
</div>

<div class="auth-body">
    @if ($errors->any())
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-circle me-2"></i>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}" class="auth-form">
        @csrf
        
        <div class="form-group">
            <label for="name" class="form-label">Nom complet</label>
            <div class="input-group">
                <i class="fas fa-user input-group-icon"></i>
                <input type="text" 
                       id="name" 
                       name="name" 
                       class="form-control @error('name') is-invalid @enderror" 
                       value="{{ old('name') }}" 
                       placeholder="Votre nom complet"
                       required 
                       autofocus>
            </div>
            @error('name')
                <div class="invalid-feedback d-block">
                    {{ $message }}
                </div>
            @enderror
        </div>

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
                       required>
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
                       placeholder="Minimum 8 caractères"
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

        <div class="form-group">
            <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
            <div class="input-group">
                <i class="fas fa-lock input-group-icon"></i>
                <input type="password" 
                       id="password_confirmation" 
                       name="password_confirmation" 
                       class="form-control" 
                       placeholder="Confirmez votre mot de passe"
                       required>
                <button type="button" class="password-toggle">
                    <i class="fas fa-eye"></i>
                </button>
            </div>
        </div>

        <div class="form-check">
            <input type="checkbox" 
                   class="form-check-input" 
                   id="terms" 
                   name="terms" 
                   required>
            <label class="form-check-label" for="terms">
                J'accepte les <a href="#" onclick="showTerms()">conditions d'utilisation</a> 
                et la <a href="#" onclick="showPrivacy()">politique de confidentialité</a>
            </label>
        </div>

        <button type="submit" class="btn btn-primary">
            <i class="fas fa-user-plus me-2"></i>
            Créer mon compte
        </button>
    </form>
</div>

<div class="auth-footer">
    <p class="mb-0">
        Vous avez déjà un compte ? 
        <a href="{{ route('login') }}">Se connecter</a>
    </p>
</div>
@endsection

@push('scripts')
<script>
function showTerms() {
    alert('Conditions d\'utilisation à venir. Contactez l\'administrateur pour plus d\'informations.');
}

function showPrivacy() {
    alert('Politique de confidentialité à venir. Contactez l\'administrateur pour plus d\'informations.');
}

// Password strength indicator
document.addEventListener('DOMContentLoaded', function() {
    const passwordInput = document.getElementById('password');
    const confirmInput = document.getElementById('password_confirmation');
    
    passwordInput.addEventListener('input', function() {
        const password = this.value;
        const strength = getPasswordStrength(password);
        
        // You can add visual feedback here
        console.log('Password strength:', strength);
    });
    
    confirmInput.addEventListener('input', function() {
        const password = passwordInput.value;
        const confirm = this.value;
        
        if (password !== confirm && confirm.length > 0) {
            this.setCustomValidity('Les mots de passe ne correspondent pas');
        } else {
            this.setCustomValidity('');
        }
    });
});

function getPasswordStrength(password) {
    let strength = 0;
    
    if (password.length >= 8) strength++;
    if (/[a-z]/.test(password)) strength++;
    if (/[A-Z]/.test(password)) strength++;
    if (/[0-9]/.test(password)) strength++;
    if (/[^A-Za-z0-9]/.test(password)) strength++;
    
    return strength;
}
</script>
@endpush
