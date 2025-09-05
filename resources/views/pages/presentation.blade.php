@extends('layouts.app')

@section('title', 'Présentation - Excellence Afrik')
@section('meta_description', 'Découvrez Excellence Afrik, le premier magazine panafricain dédié aux entreprises non cotées, TPE, PME et startups africaines')

@section('content')


<!-- Main Content -->
<main class="container my-5">
    <div class="row justify-content-center">
        <div class="col-10">

            <!-- Hero Section - Histoire du Positionnement Éditorial -->
            <section class="editorial-hero-section fade-in">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-10">
                            <div class="editorial-hero-content text-center">
                                <div class="hero-badge-minimal">
                                    <span class="badge-text-minimal">Histoire du Positionnement Éditorial</span>
                                </div>
                                <h1 class="editorial-hero-title">
                                    Excellence <span class="title-accent-gold">AFRIK</span>
                                </h1>
                                <p class="editorial-hero-subtitle">
                                    La voix des bâtisseurs silencieux
                                </p>
                                <div class="hero-description">
                                    <p class="lead-text">
                                        Excellence AFRIK est né d'un constat simple mais puissant : la majorité des entreprises africaines
                                        qui transforment le continent opèrent dans l'ombre, loin des projecteurs, des marchés financiers,
                                        et des grandes tribunes médiatiques.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Positioning Section -->
            <section class="positioning-section fade-in">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="positioning-content">
                                <div class="section-badge">
                                    <i class="fas fa-search"></i>
                                    <span>Un média pionnier dédié aux non-cotées</span>
                                </div>
                                <h2 class="section-title-minimal">Premier magazine panafricain</h2>
                                <p class="section-description">
                                    <strong>Fondé en 2021</strong> mais obtient les accréditations légales 2025, Excellence AFRIK se positionne
                                    comme le premier magazine panafricain entièrement consacré aux <strong>entreprises non cotées</strong>,
                                    en particulier les TPE, PME et startups opérant sur le terrain.
                                </p>
                                <p class="section-description">
                                    Contrairement aux médias économiques traditionnels centrés sur les grandes firmes, nous faisons le choix
                                    éditorial audacieux de mettre en lumière les <strong>bâtisseurs invisibles</strong> : artisans, commerçants
                                    innovants, entrepreneurs locaux, dirigeants de PME familiales, incubateurs, agri-preneurs.
                                </p>
                                <div class="key-stats-minimal">
                                    <div class="stat-item-minimal">
                                        <span class="stat-number">2021</span>
                                        <span class="stat-label">Fondation</span>
                                    </div>
                                    <div class="stat-item-minimal">
                                        <span class="stat-number">2025</span>
                                        <span class="stat-label">Accréditation</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="positioning-visual">
                                <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=600&h=400&fit=crop"
                                    alt="Entrepreneurs africains" class="positioning-image">
                                <div class="visual-overlay">
                                    <div class="overlay-badge">TPE • PME • Startups</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Editorial Line Section -->
            <section class="editorial-line-section fade-in">
                <div class="container">
                    <div class="section-header-minimal">
                        <div class="section-badge">
                            <i class="fas fa-microphone-alt"></i>
                            <span>Une ligne éditoriale incarnée</span>
                        </div>
                        <h2 class="section-title-minimal">La voix et le visage des entrepreneurs</h2>
                        <p class="section-subtitle-minimal">
                            Notre ligne éditoriale repose sur le portrait humain et narratif, un format qui capte l'essence
                            de l'entrepreneuriat africain : le courage, les échecs, les recommencements, les réussites silencieuses.
                        </p>
                    </div>

                    <div class="editorial-formats">
                        <div class="row g-4">
                            <div class="col-lg-6">
                                <div class="format-card">
                                    <div class="format-icon">
                                        <i class="fas fa-pen-fancy"></i>
                                    </div>
                                    <h3 class="format-title">Le Portrait écrit</h3>
                                    <p class="format-description">
                                        Un récit journalistique vivant, incarné, inspirant, illustré de photos originales.
                                    </p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="format-card">
                                    <div class="format-icon">
                                        <i class="fas fa-podcast"></i>
                                    </div>
                                    <h3 class="format-title">Le Podcast</h3>
                                    <p class="format-description">
                                        Un entretien authentique qui donne la parole aux entrepreneurs, dans leur voix,
                                        leur ton, leur vérité.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Mission Section -->
            <section class="mission-section-minimal fade-in">
                <div class="container">
                    <div class="mission-content-wrapper">
                        <div class="row align-items-center">
                            <div class="col-lg-8">
                                <div class="mission-content">
                                    <div class="section-badge">
                                        <i class="fas fa-globe-africa"></i>
                                        <span>Une ambition panafricaine et inclusive</span>
                                    </div>
                                    <h2 class="mission-title">Notre Mission</h2>
                                    <p class="mission-description">
                                        Excellence AFRIK ne se limite pas à un pays ou une capitale : notre rédaction couvre
                                        toute l'Afrique francophone (et bientôt anglophone), avec une attention particulière
                                        aux zones rurales, aux initiatives féminines, aux diasporas créatrices de valeur
                                        et aux modèles hybrides.
                                    </p>
                                    <div class="mission-statement">
                                        <h3 class="statement-title">Documenter, inspirer et connecter l'Afrique qui construit dans le silence</h3>
                                        <div class="mission-details">
                                            <div class="detail-item">
                                                <strong>Slogan :</strong> Révéler l'excellence silencieuse
                                            </div>
                                            <div class="detail-item">
                                                <strong>Cible :</strong> TPE, PME, startups, entrepreneurs africains hors marchés cotés,
                                                investisseurs et bailleurs nationaux et internationaux
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="mission-visual">
                                    <div class="value-card-highlight">
                                        <div class="value-icon">
                                            <i class="fas fa-gem"></i>
                                        </div>
                                        <h4 class="value-title">Valeur Fondamentale</h4>
                                        <p class="value-description">
                                            « La voix des bâtisseurs silencieux »
                                        </p>
                                        <p class="value-text">
                                            Excellence AFRIK est bien plus qu'un média. C'est une tribune d'honneur
                                            offerte à celles et ceux qui bâtissent l'Afrique loin des projecteurs.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Founder Section -->
            <section class="founder-section fade-in">
                <div class="container">
                    <div class="founder-content-wrapper">
                        <div class="row align-items-center">
                            <div class="col-lg-4">
                                <div class="founder-image-wrapper">
                                    <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=400&h=400&fit=crop&crop=face"
                                        alt="Deza Auguste César" class="founder-image">
                                    <div class="founder-badge">
                                        <span>Fondateur</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="founder-content">
                                    <div class="section-badge">
                                        <i class="fas fa-user-tie"></i>
                                        <span>Fondateur</span>
                                    </div>
                                    <h2 class="founder-name">Deza Auguste César</h2>
                                    <p class="founder-title">Communicant panafricain & Expert en marketing stratégique</p>

                                    <div class="founder-description">
                                        <p>
                                            Deza Auguste César est un communicant panafricain, expert en marketing stratégique
                                            et en communication d'influence. Fort de plus de <strong>8 années d'expérience</strong>
                                            dans le développement de marques, la mise en réseau d'entreprises et la connexion
                                            de projets africains avec des investisseurs et bailleurs internationaux, notamment
                                            basés aux Émirats arabes unis.
                                        </p>
                                        <p>
                                            Il s'impose comme un acteur engagé de l'écosystème entrepreneurial africain.
                                            En fondant Excellence AFRIK, il répond à un besoin fondamental :
                                            <strong>Donner une voix aux bâtisseurs silencieux de l'Afrique</strong>.
                                        </p>
                                    </div>

                                    <div class="founder-vision-mission">
                                        <div class="vision-mission-item">
                                            <div class="vm-icon">
                                                <i class="fas fa-eye"></i>
                                            </div>
                                            <div class="vm-content">
                                                <h4 class="vm-title">Sa vision</h4>
                                                <p class="vm-description">
                                                    Créer un média de référence entièrement dédié aux entreprises africaines non cotées,
                                                    trop souvent ignorées des grands circuits médiatiques, mais pourtant essentielles
                                                    à la transformation économique, sociale et culturelle de l'Afrique.
                                                </p>
                                            </div>
                                        </div>

                                        <div class="vision-mission-item">
                                            <div class="vm-icon">
                                                <i class="fas fa-bullseye"></i>
                                            </div>
                                            <div class="vm-content">
                                                <h4 class="vm-title">Son objectif</h4>
                                                <p class="vm-description">
                                                    « Valoriser les bâtisseurs silencieux africains. »
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="founder-stats">
                                        <div class="stat-item-founder">
                                            <span class="stat-number">8+</span>
                                            <span class="stat-label">Années d'expérience</span>
                                        </div>
                                        <div class="stat-item-founder">
                                            <span class="stat-number">UAE</span>
                                            <span class="stat-label">Réseau international</span>
                                        </div>
                                        <div class="stat-item-founder">
                                            <span class="stat-number">2021</span>
                                            <span class="stat-label">Création Excellence AFRIK</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Call to Action Section -->
            <section class="cta-section-minimal fade-in">
                <div class="container">
                    <div class="cta-content-minimal">
                        <div class="row justify-content-center">
                            <div class="col-lg-8 text-center">
                                <div class="cta-header">
                                    <h2 class="cta-title-minimal">Rejoignez la révolution de l'information économique africaine</h2>
                                    <p class="cta-subtitle-minimal">
                                        Découvrez les histoires inspirantes des entrepreneurs qui transforment l'Afrique dans l'ombre
                                    </p>
                                </div>
                                <div class="cta-actions-minimal">
                                    <a href="#" class="btn-minimal btn-primary-minimal">
                                        <i class="fas fa-newspaper"></i>
                                        <span>Lire nos articles</span>
                                    </a>
                                    <a href="#" class="btn-minimal btn-secondary-minimal">
                                        <i class="fas fa-podcast"></i>
                                        <span>Écouter nos podcasts</span>
                                    </a>
                                    <a href="#" class="btn-minimal btn-outline-minimal">
                                        <i class="fas fa-envelope"></i>
                                        <span>Newsletter</span>
                                    </a>
                                </div>
                                <div class="cta-note">
                                    <p class="note-text">
                                        <i class="fas fa-quote-left"></i>
                                        Ils n'ont ni visibilité, ni accès aux marchés côtés, ni équipes de communication.
                                        Mais ils ont des idées, du courage et un impact. Nous leur donnons une voix.
                                        Nous racontons leur excellence.
                                        <i class="fas fa-quote-right"></i>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>


        </div>
    </div>
</main>


@endsection
