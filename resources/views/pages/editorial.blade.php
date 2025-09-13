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
    .styled-list h3 {
        font-size: 1.8rem;
        font-weight: 600;
        color: #333;
    }
    .styled-list ul {
        list-style: none;
        padding-left: 0;
    }
    .styled-list ul li {
        padding-left: 25px;
        position: relative;
        margin-bottom: 12px;
        font-size: 1.1rem;
        line-height: 1.6;
    }
    .styled-list ul li::before {
        content: '\f058'; /* Font Awesome check-circle */
        font-family: 'Font Awesome 5 Free';
        font-weight: 900;
        color: #D4AF37;
        position: absolute;
        left: 0;
        top: 5px;
    }
    .signature {
        font-style: italic;
        font-weight: bold;
        font-size: 1.5rem;
        color: #333;
        margin-top: 30px;
        display: block;
    }
    .editorial-section.bg-light {
        background: linear-gradient(to right, #996633, #f7c807);
    }
    .editorial-section.bg-light .styled-list h3,
    .editorial-section.bg-light .styled-list ul li {
        color: #fff;
    }
    .editorial-section.bg-light .styled-list ul li::before {
        color: #fff;
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

    <!-- Objectif Fondamental Section -->
    <section class="editorial-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10 text-center">
                    <div class="section-title">
                        <span class="post-cat mb-10">Notre Mission</span>
                        <h2>Valoriser les femmes et hommes d’affaires qui bâtissent l’économie réelle Africaine.</h2>
                        <p>
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
                <div class="col-lg-6 mb-4 mb-lg-0 styled-list">
                    <h3 class="mb-4">Objectifs Éditoriaux</h3>
                    <ul>
                        <li>Donner une tribune aux dirigeants africains : vision, stratégie, engagements.</li>
                        <li>Promouvoir les succès stories africaines hors des circuits boursiers.</li>
                        <li>Offrir une analyse économique de proximité, tournée vers les réalités du terrain.</li>
                        <li>Contribuer à la création de références crédibles dans le paysage entrepreneurial africain.</li>
                        <li>Soutenir la visibilité des PME, ETI et groupes familiaux performants.</li>
                    </ul>
                </div>
                <div class="col-lg-6 styled-list">
                    <h3 class="mb-4">Public Cible</h3>
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
    </section>

    <!-- Ton & Critères Section -->
    <section class="editorial-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 mb-4 mb-lg-0 styled-list">
                    <h3 class="mb-4">Ton et Style Rédactionnel</h3>
                    <ul>
                        <li><strong>Professionnel, sobre, affirmé.</strong></li>
                        <li><strong>Positif mais rigoureux :</strong> mettre en valeur sans tomber dans l’éloge gratuit.</li>
                        <li><strong>Ancré dans la réalité africaine :</strong> proximité avec les réalités du terrain.</li>
                        <li><strong>Orienté solutions :</strong> axé sur les enjeux, défis, réponses et perspectives.</li>
                    </ul>
                </div>
                <div class="col-lg-6 styled-list">
                    <h3 class="mb-4">Critères de Sélection</h3>
                    <ul>
                        <li><strong>Pertinence économique :</strong> impact réel sur l’emploi, la production où l’innovation.</li>
                        <li><strong>Exemplarité</strong> du parcours ou du projet.</li>
                        <li>Dimension panafricaine ou <strong>potentielle scalabilité</strong>.</li>
                        <li>Valeurs d’éthique, de gouvernance, d’engagement social ou environnemental.</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Déontologie Section -->
    <section class="editorial-section bg-light">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10 text-center">
                    <div class="section-title">
                        <h2>Déontologie et Vérification</h2>
                        <p>Notre engagement pour un journalisme crédible et éthique.</p>
                    </div>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-lg-6 mb-4 mb-lg-0 styled-list">
                    <h3 class="mb-4">Déontologie</h3>
                    <ul>
                        <li>Respecter les principes d’indépendance éditoriale.</li>
                        <li>Vérifier les informations et garantir leur exactitude.</li>
                        <li>Refuser tout contenu publicitaire déguisé non signalé.</li>
                        <li>Promouvoir des modèles entrepreneuriaux crédibles, inclusifs et éthiques.</li>
                    </ul>
                </div>
                <div class="col-lg-6 styled-list">
                    <h3 class="mb-4">Vérification des Sources</h3>
                    <ul>
                        <li><strong>Source institutionnelle ou officielle</strong> (gouvernement, banques centrales, etc.).</li>
                        <li><strong>Source académique ou scientifique</strong> (universités, centres de recherche).</li>
                        <li><strong>Médias reconnus et crédibles</strong> avec un historique sérieux.</li>
                        <li><strong>Témoignage direct vérifié</strong> (interview, citation enregistrée ou signée).</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Diffusion & Signature Section -->
    <section class="editorial-section text-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <h3 class="mb-4">Supports et Canaux de Diffusion</h3>
                    <p>Édition numérique interactive (PDF & web), site web et réseaux sociaux (interviews vidéo, teasers), et une newsletter professionnelle pour nos abonnés.</p>
                    <hr class="my-5">
                    <p class="signature">Excellence AFRIK – La voix des bâtisseurs de l’économie réelle.</p>
                </div>
            </div>
        </div>
    </section>

</main>
@endsection
