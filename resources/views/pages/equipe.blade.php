@extends('layouts.app')

@section('title', 'Notre Équipe - Excellence Afrik')
@section('meta_description', 'Découvrez les leaders passionnés qui animent la mission d\'Excellence Afrik.')

@push('styles')
<style>
    .page-banner-area {
        background-color: #f8f9fa;
    }
    .page-title-bar {
        background: linear-gradient(to right, #996633, #f7c807);
    }
    .page-title-bar h1 {
        color: #fff;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
    }
    .team-section {
        padding: 80px 0;
        background-color: #f8f9fa;
    }
    .section-title-center {
        text-align: center;
        margin-bottom: 50px;
    }
    .section-title-center h2 {
        font-size: 2.8rem;
        font-weight: 700;
        color: #333;
    }
    .section-title-center p {
        font-size: 1.1rem;
        color: #666;
        max-width: 700px;
        margin: 0 auto;
    }
    .team-card {
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        padding: 20px;
        transition: all 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: row; /* Horizontal layout */
        align-items: flex-start; /* Align items to the top */
        gap: 20px;
    }
    .team-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.12);
    }
    .team-card__image {
        width: 180px;
        height: 180px;
        border-radius: 50%; /* Make it a circle */
        overflow: hidden;
        flex-shrink: 0;
        border: 5px solid #D4AF37;
        background-color: #f0f0f0;
    }
    .team-card__image img {
        width: 100%;
        height: 100%;
        object-fit: cover; /* Fill the circle */
        object-position: center; /* Center the image */
    }
    .team-card__name {
        font-size: 1.5rem;
        font-weight: 700;
        color: #000;
        margin-bottom: 5px;
    }
    .team-card__title {
        font-size: 1rem;
        font-weight: 500;
        color: #D4AF37;
        margin-bottom: 15px;
        text-transform: uppercase;
    }
    .team-card__description {
        font-size: 0.95rem;
        color: #333;
        flex-grow: 1;
        text-align: left;
    }
</style>
@endpush

@section('content')
<main>
    <!-- Hero Banner -->
    <div class="page-banner-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-bar text-center pt-60 pb-60">
                        <h1>NOTRE ÉQUIPE</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Team Section -->
    <section class="team-section" id="equipe">
        <div class="container">
            <div class="section-title-center">
                <p>Les leaders passionnés qui animent notre mission.</p>
            </div>
            <div class="row justify-content-center">
                <!-- Team Member: Venance Kokora -->
                <div class="col-lg-12 mb-4">
                    <div class="team-card">
                        <div class="team-card__image">
                            <img src="{{ asset('assets/about/kokora.jpg') }}" alt="Venance Kokora">
                        </div>
                        <div class="team-card__content">
                            <h3 class="team-card__name">Venance Kokora</h3>
                            <p class="team-card__title">Directeur de publication</p>
                            <p class="team-card__description">Journaliste chevronné avec plus de vingt ans d’expérience, Venance a travaillé pour des journaux de référence et dirigé des radios de proximité, lui conférant une vision globale et stratégique des métiers de l’information.</p>
                        </div>
                    </div>
                </div>

                <!-- Team Member: Deza Auguste César -->
                <div class="col-lg-12 mb-4">
                    <div class="team-card">
                        <div class="team-card__image">
                            <img src="{{ asset('assets/about/deza.jpg') }}" alt="Deza Auguste César">
                        </div>
                        <div class="team-card__content">
                            <h3 class="team-card__name">Deza Auguste César</h3>
                            <p class="team-card__title">Fondateur</p>
                            <p class="team-card__description">Communicant panafricain et expert en marketing stratégique, Deza connecte des projets africains avec des investisseurs internationaux, s'imposant comme un acteur engagé de l’écosystème entrepreneurial africain.</p>
                        </div>
                    </div>
                </div>

                <!-- Team Member: Bossombra BILE -->
                <div class="col-lg-12 mb-4">
                    <div class="team-card">
                        <div class="team-card__image">
                            <img src="{{ asset('assets/about/bile.jpg') }}" alt="Bossombra BILE">
                        </div>
                        <div class="team-card__content">
                            <h3 class="team-card__name">Bossombra BILE</h3>
                            <p class="team-card__title">Chef de projet digital</p>
                            <p class="team-card__description">Chef de projet digital expérimenté avec plus de dix ans d’expertise, Bilé Bossombra a piloté des projets d’envergure pour des entreprises et marques panafricaines et internationales. Son parcours, marqué par des réussites dans le développement web, le design et la stratégie numérique, lui confère une vision globale et stratégique de la transformation digitale.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
