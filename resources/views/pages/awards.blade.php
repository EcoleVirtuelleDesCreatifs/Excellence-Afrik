@extends('layouts.app')

@section('title', 'Le Prix d\'Excellence - Excellence Afrik')
@section('meta_description', 'Découvrez le Prix d\'Excellence, une célébration des réussites et des innovations qui façonnent l\'avenir de l\'Afrique.')

@push('styles')
<style>
    .awards-header {
        background: linear-gradient(to right, #996633, #f7c807);
        padding: 4rem 2rem;
        border-radius: .75rem;
    }
    .awards-header .display-4 {
        color: #fff;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
    }
    .awards-header .lead {
        color: rgba(255, 255, 255, 0.9) !important; /* Override text-muted */
        text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
    }
    .award-card {
        border: 1px solid #e9ecef;
        transition: all 0.3s ease;
    }
    .award-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.12);
        border-color: #c1933e;
    }
    .award-card .card-body {
        padding: 2rem;
    }
    .award-card .card-title {
        font-weight: 700;
        color: #343a40;
    }
</style>
@endpush

@section('content')
<main class="py-5">
    <div class="container">
        <!-- En-tête de la page -->
        <div class="awards-header text-center mb-5">
            <h1 class="display-4 fw-bold">Nos Prix</h1>
            <p class="lead text-muted">Célébrer les réussites et les innovations qui façonnent l'avenir de l'Afrique.</p>
        </div>

        <!-- Section de présentation -->
        <div class="row justify-content-center mb-5">
            <div class="col-lg-8">
                <p class="text-center fs-5">
                    Le Prix d'Excellence est une initiative visant à honorer les entrepreneurs, les entreprises et les innovateurs qui, par leur travail acharné et leur vision, contribuent de manière significative au développement économique et social du continent. Chaque année, nous récompensons les parcours les plus inspirants et les projets les plus impactants.
                </p>
            </div>
        </div>

        <!-- Grille des trophées/catégories -->
        <div class="row">
            <!-- Catégorie 1 -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100 text-center award-card">
                    <div class="card-body">
                        <div class="mb-3">
                            <i class="fas fa-trophy fa-3x text-warning"></i>
                        </div>
                        <h5 class="card-title">Prix d'Excellence International</h5>
                        <p class="card-text">Récompense l'entreprise qui a introduit une technologie ou un modèle économique révolutionnaire.</p>
                        <a href="#" class="btn btn-primary-gold mt-3">Découvrez</a>
                    </div>
                </div>
            </div>

            <!-- Catégorie 2 -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100 text-center award-card">
                    <div class="card-body">
                        <div class="mb-3">
                            <i class="fas fa-leaf fa-3x text-success"></i>
                        </div>
                        <h5 class="card-title">Prix Impact Féminin</h5>
                        <p class="card-text">Dédié au projet ayant eu le plus grand impact positif sur sa communauté ou sur l'environnement.</p>
                        <a href="#" class="btn btn-primary-gold mt-3">Découvrez</a>
                    </div>
                </div>
            </div>

            <!-- Catégorie 3 -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100 text-center award-card">
                    <div class="card-body">
                        <div class="mb-3">
                            <i class="fas fa-rocket fa-3x text-info"></i>
                        </div>
                        <h5 class="card-title">Prix d'Excellence Entrepreneuriale</h5>
                        <p class="card-text">Célèbre la jeune entreprise la plus prometteuse, avec un fort potentiel de croissance et d'innovation.</p>
                        <a href="#" class="btn btn-primary-gold mt-3">Découvrez</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
