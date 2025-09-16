@extends('layouts.app')

@section('title', 'Ligne Éditoriale - Excellence Afrik')
@section('meta_description', 'Découvrez la ligne éditoriale d\'Excellence Afrik, notre vision et notre approche unique du journalisme économique africain.')

@push('styles')
<style>
    .page-title-bar {
        background: linear-gradient(to right, #996633, #f7c807);
    }
    .page-title-bar h1 {
        color: #fff;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
    }
    .editorial-section {
        padding: 80px 0;
    }
    .editorial-section.bg-light {
        background-color: #f8f9fa;
    }
    .editorial-section.bg-gradient {
        background: linear-gradient(to right, #996633, #f7c807);
    }
    .editorial-section.bg-gradient h2,
    .editorial-section.bg-gradient h3,
    .editorial-section.bg-gradient p {
        color: #fff;
    }
    .section-title h2 {
        font-size: 2.8rem;
        font-weight: 700;
        margin-bottom: 20px;
    }
    .section-title p {
        font-size: 1.2rem;
        color: #4a4a4a;
        max-width: 800px;
        margin: 0 auto;
    }
    .mission-image {
        border-radius: 10px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    .info-card {
        background: #fff;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.07);
        height: 100%;
    }
    .info-card h3 {
        font-size: 1.8rem;
        font-weight: 600;
        color: #D4AF37; /* Gold color */
        margin-bottom: 20px;
    }
        .styled-list ul {
        list-style: none;
        padding-left: 0;
    }
    .styled-list ul li {
        padding-left: 30px;
        position: relative;
        margin-bottom: 15px;
        font-size: 1.1rem;
        line-height: 1.6;
        color: #000 !important; /* Forcer le texte en noir */
    }
    .styled-list ul li::before {
        content: '\f058'; /* Font Awesome check-circle */
        font-family: 'Font Awesome 5 Free';
        font-weight: 900;
        color: #D4AF37;
        position: absolute;
        left: 0;
        top: 4px;
        font-size: 1.2rem;
    }
    .editorial-section.bg-gradient .styled-list ul li::before {
        color: #fff;
    }
    .criteria-card {
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        padding: 30px;
        border-radius: 10px;
        text-align: center;
        height: 100%;
        transition: background 0.3s;
    }
    .criteria-card:hover {
        background: rgba(255, 255, 255, 0.2);
    }
    .criteria-card .icon {
        font-size: 2.5rem;
        margin-bottom: 15px;
        color: #fff;
    }
    .criteria-card h4 {
        font-size: 1.3rem;
        font-weight: 600;
        color: #fff;
        margin-bottom: 10px;
    }
    .criteria-card p {
        color: rgba(255, 255, 255, 0.9);
        font-size: 0.95rem;
    }
    .signature {
        font-style: italic;
        font-weight: bold;
        font-size: 1.5rem;
        color: #333;
        margin-top: 30px;
        display: block;
    }
    .diffusion-text {
        color: #D4AF37; /* Gold color */
        font-weight: 500;
    }
    .diffusion-title {
        color: #D4AF37;
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
                        <h1>Ligne Éditoriale</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mission Section -->
    <section class="editorial-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <img src="{{ asset('assets/about/about.jpg') }}" alt="Notre Mission" class="img-fluid mission-image">
                </div>
                <div class="col-lg-6">
                    <div class="section-title">
                        <span class="post-cat mb-10">Notre Mission</span>
                        <h2 class="mt-3">Valoriser les bâtisseurs de l’économie réelle Africaine.</h2>
                        <p class="mt-3" style="margin-left: 0; text-align: left;">
                            Excellence AFRIK est le premier magazine panafricain exclusivement dédié aux dirigeants des entreprises non cotées. Nous mettons en lumière des parcours de dirigeants inspirants, des entreprises performantes, et des initiatives économiques structurantes, en privilégiant un traitement de l’information sérieux, constructif et orienté vers les solutions.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Objectifs & Cible Section -->
    <section class="editorial-section bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <div class="info-card styled-list">
                        <h3>Objectifs Éditoriaux</h3>
                        <ul>
                            <li>Donner une tribune aux dirigeants africains : vision, stratégie, engagements.</li>
                            <li>Promouvoir les succès stories africaines hors des circuits boursiers.</li>
                            <li>Offrir une analyse économique de proximité, tournée vers les réalités du terrain.</li>
                            <li>Contribuer à la création de références crédibles dans le paysage entrepreneurial africain.</li>
                            <li>Soutenir la visibilité des PME, ETI et groupes familiaux performants.</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="info-card styled-list">
                        <h3>Public Cible</h3>
                        <ul>
                            <li>Dirigeants d’entreprises africaines (PME, ETI, groupes familiaux).</li>
                            <li>Cadres dirigeants et décideurs économiques.</li>
                            <li>Organisations patronales, chambres de commerce, bailleurs, investisseurs.</li>
                            <li>Institutions publiques en charge du développement économique.</li>
                            <li>Médias économiques, influenceurs du secteur business.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Critères Section -->
    <section class="editorial-section bg-gradient">
        <div class="container">
            <div class="row justify-content-center text-center mb-5">
                <div class="col-lg-8">
                    <h2 class="mb-4">Nos Critères de Sélection</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="criteria-card">
                        <div class="icon"><i class="fas fa-chart-line"></i></div>
                        <h4>Pertinence Économique</h4>
                        <p>Impact réel sur l’emploi, la production ou l’innovation.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="criteria-card">
                        <div class="icon"><i class="fas fa-star"></i></div>
                        <h4>Exemplarité</h4>
                        <p>Caractère exemplaire du parcours ou du projet.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="criteria-card">
                        <div class="icon"><i class="fas fa-expand-arrows-alt"></i></div>
                        <h4>Scalabilité</h4>
                        <p>Dimension panafricaine et potentiel de croissance.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="criteria-card">
                        <div class="icon"><i class="fas fa-shield-alt"></i></div>
                        <h4>Éthique & Impact</h4>
                        <p>Valeurs de gouvernance et d'engagement social ou environnemental.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Déontologie Section -->
    <section class="editorial-section">
        <div class="container">
            <div class="row justify-content-center text-center mb-5">
                <div class="col-lg-8">
                    <div class="section-title">
                        <h2>Déontologie et Vérification</h2>
                        <p>Notre engagement pour un journalisme crédible et éthique.</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <div class="info-card styled-list">
                        <h3>Déontologie</h3>
                        <ul>
                            <li>Respecter les principes d’indépendance éditoriale.</li>
                            <li>Vérifier les informations et garantir leur exactitude.</li>
                            <li>Refuser tout contenu publicitaire déguisé non signalé.</li>
                            <li>Promouvoir des modèles entrepreneuriaux crédibles, inclusifs et éthiques.</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="info-card styled-list">
                        <h3>Vérification des Sources</h3>
                        <ul>
                            <li><strong>Source institutionnelle ou officielle</strong> (gouvernement, banques centrales, etc.).</li>
                            <li><strong>Source académique ou scientifique</strong> (universités, centres de recherche).</li>
                            <li><strong>Médias reconnus et crédibles</strong> avec un historique sérieux.</li>
                            <li><strong>Témoignage direct vérifié</strong> (interview, citation enregistrée ou signée).</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Diffusion & Signature Section -->
    <section class="editorial-section text-center bg-light">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <h3 class="mb-4 diffusion-title">Supports et Canaux de Diffusion</h3>
                    <p class="diffusion-text">Édition numérique interactive (PDF & web), site web et réseaux sociaux (interviews vidéo, teasers), et une newsletter professionnelle pour nos abonnés.</p>
                    <hr class="my-5">
                    <p class="signature">Excellence AFRIK – La voix des bâtisseurs de l’économie réelle.</p>
                </div>
            </div>
        </div>
    </section>

</main>
@endsection
