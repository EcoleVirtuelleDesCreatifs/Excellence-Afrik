@extends('layouts.app')

@section('title', 'Présentation - Excellence Afrik')
@section('meta_description', 'Découvrez Excellence Afrik, le premier magazine panafricain dédié aux entreprises non cotées, TPE, PME et startups africaines.')

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
    .about-section {
        padding: 80px 0;
        background-color: #fff;
    }
    .about-content h2 {
        font-size: 2.5rem;
        font-weight: 700;
        color: #333;
        margin-bottom: 20px;
    }
    .about-content .lead {
        font-size: 1.25rem;
        color: #555;
    }
    .post-cat {
        background-color: #D4AF37;
        color: #fff;
        padding: 5px 15px;
        border-radius: 50px;
        font-size: 0.9rem;
        font-weight: 600;
        text-transform: uppercase;
        display: inline-block;
        letter-spacing: 0.5px;
    }
    .about-image {
        border-radius: 10px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    .mission-vision-section {
        padding: 80px 0;
        background: linear-gradient(to right, #996633, #f7c807);
    }
    .mission-vision-section .section-title-center h2,
    .mission-vision-section .section-title-center p {
        color: #fff;
    }
    .section-title-center {
        text-align: center;
        margin-bottom: 50px;
    }
    .section-title-center h2 {
        font-size: 2.8rem;
        font-weight: 700;
    }
    .section-title-center p {
        font-size: 1.1rem;
        color: #666;
        max-width: 700px;
        margin: 0 auto;
    }
    .value-card {
        background: #fff;
        padding: 30px;
        border-radius: 10px;
        text-align: center;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        transition: transform 0.3s, box-shadow 0.3s;
        height: 100%;
    }
    .value-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1);
    }
    .value-card .icon {
        font-size: 3rem;
        color: #D4AF37; /* Gold color from your theme */
        margin-bottom: 20px;
    }
    .value-card h3 {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 15px;
    }
    .founder-section {
        padding: 80px 0;
        background-color: #fff;
    }
    .founder-image {
        width: 300px;

        object-fit: cover; /* Assure que l'image remplit le carré sans être déformée */
        border-radius: 15px; /* Applique les coins arrondis */
        margin: 0 auto;
        display: block;
        border: 5px solid #D4AF37;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    .founder-content h2 {
        font-size: 2.2rem;
    }
    .founder-content .founder-title {
        font-size: 1.2rem;
        font-weight: 500;
        color: #D4AF37;
        margin-bottom: 20px;
    }
</style>
@endpush

@section('content')

<main>
    <!-- Hero Banner -->
    <div class="page-banner-area mt-60">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-bar text-center pt-60 pb-60">
                        <h1>QUI SOMMES-NOUS ?</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- About Section -->
    <section class="about-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <div class="about-content">
                        <span class="post-cat mb-10">Un média pionnier</span>
                        <h2>
                            <span style="display: block;">PREMIER MAGAZINE PANAFRICAIN</span>
                            <span style="display: block;">DÉDIÉ AUX BÂTISSEURS</span>
                            <span style="display: block;">DE L'ÉCONOMIE RÉELLE.</span>
                        </h2>
                        <p class="lead">
                            Fondé en 2021, Excellence AFRIK est le premier média panafricain entièrement consacré aux entreprises non cotées : TPE, PME, et startups qui forment le cœur de l'économie africaine.
                        </p>
                        <p>
                            Nous faisons le choix éditorial audacieux de mettre en lumière les <strong>bâtisseurs invisibles</strong> : artisans, commerçants innovants, entrepreneurs locaux, et dirigeants de PME familiales. Notre mission est de raconter leurs histoires, de célébrer leurs succès et d'inspirer la prochaine génération d'entrepreneurs.
                        </p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <img src="{{ asset('assets/about/about.jpg') }}" alt="Équipe Excellence Afrik" class="img-fluid about-image">
                </div>
            </div>
        </div>
    </section>

    <!-- Mission, Vision, Values Section -->
    <section class="mission-vision-section">
        <div class="container">
            <div class="section-title-center">
                <h2>Notre Engagement</h2>
                <p>Documenter, inspirer et connecter l'Afrique qui construit dans le silence.</p>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="value-card">
                        <div class="icon"><i class="fas fa-bullseye"></i></div>
                        <h3>Notre Mission</h3>
                        <p>Révéler l'excellence silencieuse en offrant une tribune d'honneur aux entrepreneurs qui bâtissent l'Afrique loin des projecteurs, avec un focus sur l'Afrique francophone, les zones rurales et les initiatives féminines.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="value-card">
                        <div class="icon"><i class="fas fa-eye"></i></div>
                        <h3>Notre Vision</h3>
                        <p>Devenir la plateforme de référence pour l'écosystème des entreprises non cotées en Afrique, en connectant les entrepreneurs, les investisseurs et les diasporas pour catalyser une croissance durable et inclusive.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="value-card">
                        <div class="icon"><i class="fas fa-pen-fancy"></i></div>
                        <h3>Notre Ligne Éditoriale</h3>
                        <p>Nous privilégions le portrait humain et narratif, à travers des articles de fond et des podcasts authentiques, pour capturer l'essence de l'entrepreneuriat : le courage, les échecs et les réussites.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Founder Section -->
    <section class="founder-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-4 text-center mb-4 mb-lg-0">
                    <img src="{{ asset('assets/about/deza.jpg') }}" alt="Deza Auguste César" class="founder-image">
                </div>
                <div class="col-lg-8">
                    <div class="founder-content">
                        <span class="post-cat mb-10">Le Fondateur</span>
                        <h2>Deza Auguste César</h2>
                        <p class="founder-title">Communicant Panafricain & Expert en Marketing Stratégique</p>
                        <p>Passionné par l'émergence du continent et convaincu que l'avenir de l'Afrique se construit par ses entrepreneurs, Deza Auguste César a fondé Excellence Afrik pour donner une voix et une visibilité à ceux qui sont au cœur de la transformation économique africaine. Son ambition est de créer un écosystème médiatique qui non seulement informe, mais aussi inspire et connecte les forces vives du continent.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
                            </div>
                        </div>
                    </div>
                </div>
            </section>



        </div>
    </div>
</main>


@endsection
