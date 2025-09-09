@extends('layouts.app')

@section('title', 'Email Vérifié - Excellence Afrik')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow">
                <div class="card-body text-center p-5">
                    <div class="mb-4">
                        <div class="display-1 text-success mb-3">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <h2 class="h3 mb-3">Email vérifié avec succès !</h2>
                        <p class="text-muted mb-4">{{ $message }}</p>
                    </div>

                    @if($subscriber && $subscriber->isVerified())
                        <div class="alert alert-success">
                            <i class="fas fa-envelope-circle-check me-2"></i>
                            Votre adresse <strong>{{ $subscriber->email }}</strong> est maintenant vérifiée.
                            <br>
                            <small class="d-block mt-2">
                                Vous recevrez désormais nos newsletters et contenus exclusifs.
                            </small>
                        </div>

                        @if($subscriber->is_premium)
                            <div class="alert alert-warning">
                                <i class="fas fa-crown me-2"></i>
                                <strong>Abonnement Premium activé !</strong>
                                <br>
                                <small>Vous avez accès aux contenus premium et aux newsletters exclusives.</small>
                            </div>
                        @endif
                    @endif

                    <div class="mt-4 pt-3 border-top">
                        <div class="row g-2">
                            <div class="col-6">
                                <a href="{{ url('/') }}" class="btn btn-outline-primary w-100">
                                    <i class="fas fa-home me-1"></i>Accueil
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="{{ route('magazines.index') }}" class="btn btn-primary w-100">
                                    <i class="fas fa-book me-1"></i>Magazines
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="mt-3">
                        <p class="text-muted small mb-0">
                            Merci de faire confiance à Excellence Afrik pour votre veille économique africaine.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection