@extends('layouts.app')

@section('title', 'Désabonnement Newsletter - Excellence Afrik')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow">
                <div class="card-body text-center p-5">
                    <div class="mb-4">
                        <div class="display-1 text-warning mb-3">
                            <i class="fas fa-envelope-open"></i>
                        </div>
                        <h2 class="h3 mb-3">Désabonnement effectué</h2>
                        <p class="text-muted mb-4">{{ $message }}</p>
                    </div>

                    @if($subscriber && !$subscriber->is_active)
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Vous ne recevrez plus nos newsletters à l'adresse <strong>{{ $subscriber->email }}</strong>
                        </div>
                        
                        <div class="mt-4">
                            <p class="text-muted small">
                                Vous changez d'avis ? Vous pouvez vous réabonner à tout moment sur notre site.
                            </p>
                        </div>
                    @endif

                    <div class="mt-4 pt-3 border-top">
                        <a href="{{ url('/') }}" class="btn btn-primary">
                            <i class="fas fa-home me-2"></i>Retour à l'accueil
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection