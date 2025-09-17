@extends('layouts.app')

@push('styles')
<style>
    /* New WebTV Hero Banner Styles */
    .webtv-hero-banner {
        background: #000;
        padding: 80px 0;
        border-top: 5px solid var(--ea-gold);
        border-bottom: 5px solid var(--ea-gold);
    }
    .webtv-hero-title {
        font-size: 4rem;
        font-weight: 700;
        color: #fff;
        text-transform: uppercase;
        letter-spacing: 3px;
        margin-bottom: 1rem;
        text-shadow: 2px 2px 8px rgba(0,0,0,0.5);
    }
    .webtv-hero-subtitle {
        font-size: 1.25rem;
        color: #ccc;
        margin-bottom: 2rem;
    }
    .btn-webtv {
        background: var(--ea-gold);
        color: #000;
        font-weight: 700;
        padding: 1rem 2.5rem;
        border-radius: 50px;
        text-transform: uppercase;
        transition: all 0.3s ease;
    }
    .btn-webtv:hover {
        background: #fff;
        color: #000;
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.2);
    }
    .live-video-section {
        background-color: #1a1a1a;
        padding: 60px 0;
    }
    .video-player-wrapper {
        position: relative;
        padding-bottom: 56.25%; /* 16:9 aspect ratio */
        height: 0;
        overflow: hidden;
        background: #000;
        border-radius: 10px;
    }
    .video-player-wrapper iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }
    .live-video-info {
        color: #fff;
    }
    .live-badge {
        background-color: #e53e3e;
        color: #fff;
        padding: 5px 15px;
        border-radius: 50px;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.9rem;
        animation: pulse 1.5s infinite;
    }

    @keyframes pulse {
        0% {
            transform: scale(1);
            box-shadow: 0 0 0 0 rgba(229, 62, 62, 0.7);
        }
        70% {
            transform: scale(1.05);
            box-shadow: 0 0 10px 15px rgba(229, 62, 62, 0);
        }
        100% {
            transform: scale(1);
            box-shadow: 0 0 0 0 rgba(229, 62, 62, 0);
        }
    }

    /* Badge pour live programmé */
    .scheduled-badge {
        background-color: #f39c12;
        color: #fff;
        padding: 5px 15px;
        border-radius: 50px;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.9rem;
        animation: scheduled-glow 2s infinite;
    }

    @keyframes scheduled-glow {
        0% {
            box-shadow: 0 0 5px rgba(243, 156, 18, 0.7);
        }
        50% {
            box-shadow: 0 0 15px rgba(243, 156, 18, 0.9);
        }
        100% {
            box-shadow: 0 0 5px rgba(243, 156, 18, 0.7);
        }
    }

    /* Overlay pour live programmé */
    .scheduled-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(243, 156, 18, 0.15);
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
    }

    .scheduled-content {
        text-align: center;
        color: #2c3e50;
        background: rgba(255, 255, 255, 0.95);
        padding: 30px;
        border-radius: 15px;
        backdrop-filter: blur(10px);
    }

    .scheduled-content i {
        color: #f4c700;
    }

    .scheduled-content h4 {
        color: #2c3e50;
        font-weight: bold;
        margin-bottom: 8px;
    }

    .scheduled-content p {
        color: #555;
        font-weight: 500;
    }

    /* Overlay pour aucun live */
    .no-live-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
    }

    .no-live-content {
        text-align: center;
        color: #fff;
        background: rgba(0, 0, 0, 0.7);
        padding: 30px;
        border-radius: 15px;
        backdrop-filter: blur(5px);
    }

    /* Décompte */
    .countdown-container {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 10px;
        padding: 15px;
        backdrop-filter: blur(10px);
    }

    .countdown-display {
        font-family: 'Courier New', monospace;
        font-size: 1.5rem;
        font-weight: 700;
        color: #f39c12;
        text-align: center;
        background: rgba(0, 0, 0, 0.3);
        padding: 10px;
        border-radius: 8px;
    }

    .countdown-label {
        font-size: 0.9rem;
        text-align: center;
    }
    .news-area {
        background: linear-gradient(to right, #996633, #f7c807);
    }

    .portrait-card {
        background: #fff;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
    }
    .portrait-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.12);
    }
    .portrait-card__image img {
        width: 100%;
        height: 350px;
        object-fit: cover;
        object-position: top; /* Prioritise le haut de l'image */
    }
    .portrait-card__content {
        padding: 25px 30px;
    }
    .portrait-card__title {
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 15px;
    }
    .portrait-card__title a {
        color: #222;
        text-decoration: none;
        transition: color 0.3s;
    }
    .portrait-card__title a:hover {
        color: #c1933e;
    }
    .portrait-card__content, .portrait-card__content p, .portrait-card__content a {
        color: #666; /* Assurer la lisibilité sur fond blanc */
    }
    .portrait-card__title a {
        color: #222;
    }
    .portrait-card__excerpt {
        font-size: 0.95rem;
        color: #666;
        line-height: 1.6;
    }
    .portrait-card .btn-link {
        font-weight: 600;
        color: #c1933e;
        text-decoration: none;
        transition: all 0.3s ease;
    }
    .portrait-card .btn-link i {
        transition: transform 0.3s ease;
    }
    .portrait-card .btn-link:hover {
        color: #996633;
    }
    .portrait-card .btn-link:hover i {
        transform: translateX(5px);
    }

    /* Decorated Section Title */
    .section-title--decorated {
        text-align: center;
        position: relative;
    }
    .section-title--decorated h2 {
        color: #fff;
        text-transform: uppercase;
        font-weight: 700;
        font-size: 2.2rem;
        display: inline-block;
        padding: 0 25px;
        background: linear-gradient(to right, #996633, #f7c807); /* Match the main background */
        position: relative;
        z-index: 1;
    }
    .section-title--decorated::before {
        content: '';
        position: absolute;
        left: 0;
        right: 0;
        top: 50%;
        height: 2px;
        background: rgba(255, 255, 255, 0.3);
        z-index: 0;
    }

    /* Gradient overlay for hero images to improve text readability */
    .hero::after {
        content: '';
        position: absolute;
        left: 0;
        right: 0;
        bottom: 0;
        height: 70%;
        background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0) 100%);
        border-radius: 15px; /* Match the image border-radius */
    }
    .bg-light {
        background-color: #f8f9fa !important;
    }

    .portrait-card__image--small img {
        height: 200px;
        object-fit: cover;
        object-position: top;
    }
    .portrait-card__content--small {
        padding: 15px 20px;
    }
    .portrait-card__title--small {
        font-size: 1rem;
        margin-bottom: 0;
        white-space: normal; /* Allow text to wrap */
        word-wrap: break-word; /* Break long words if necessary */
    }

    .breaking__meta .positive {
        color: #28a745;
        font-weight: 600;
    }
    .breaking__meta .negative {
        color: #dc3545;
        font-weight: 600;
    }

    /* Style horizontal comme l'exemple */
    .breaking__horizontal {
        display: flex;
        align-items: center;
        background: #f8f9fa;
        border-radius: 6px;
        padding: 8px 0;
        border: 1px solid #e9ecef;
    }

    /* Section ticker "En continu" */
    .breaking__ticker-section {
        display: flex;
        align-items: center;
        flex: 1;
        min-width: 0;
        width: 65%;
        border-radius: 4px;
        overflow: hidden;
    }
    .ticker__label {
        background: #f1c40f;
        color: #000;
        padding: 8px 16px;
        font-weight: 700;
        font-size: 0.85rem;
        text-transform: uppercase;
        white-space: nowrap;
        border-radius: 4px;
        margin-right: 15px;
        position: relative;
        z-index: 10;
    }
    .ticker__content {
        overflow: hidden;
        position: relative;
        flex: 1;
        height: 40px;
        display: flex;
        align-items: center;
    }
    .ticker__content ul {
        margin: 0;
        list-style: none;
        position: relative;
        height: 100%;
        width: 100%;
    }
    .ticker__content ul li {
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        transform: translateY(-50%);
        padding: 0 1rem;
        font-size: 0.9rem;
        color: #333;
        font-weight: 500;
        white-space: nowrap;
        opacity: 0;
        z-index: 1;
    }

    /* Animation dynamique générée par JavaScript */
    @keyframes flashInfoFadeIn {
        0% {
            opacity: 0;
            transform: translateY(-100%);
        }
        5% {
            opacity: 1;
            transform: translateY(-50%);
        }
        20% {
            opacity: 1;
            transform: translateY(-50%);
        }
        25% {
            opacity: 0;
            transform: translateY(100%);
        }
        100% {
            opacity: 0;
            transform: translateY(100%);
        }
    }

    /* Informations statiques à droite */
    .breaking__static-info {
        display: flex;
        align-items: center;
        gap: 12px;
        padding-right: 15px;
        flex-shrink: 0;
        width: 35%;
        justify-content: space-evenly;
    }
    .breaking__static-info .info__item {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 0.75rem;
        color: #333;
        white-space: nowrap;
        background: rgba(255, 255, 255, 0.9);
        padding: 8px 12px;
        border-radius: 18px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        border-left: 3px solid #f1c40f;
        transition: all 0.3s ease;
        flex: 1;
        justify-content: center;
    }
    .breaking__static-info .info__item:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
    .breaking__static-info .info__item i {
        font-size: 0.85rem;
        color: #f1c40f;
        width: 14px;
        text-align: center;
    }
    .breaking__static-info .info__item span {
        font-weight: 500;
    }


    /* Responsive */
    @media (max-width: 1200px) {
        .breaking__static-info {
            gap: 10px;
        }
        .breaking__static-info .info__item {
            padding: 6px 10px;
            font-size: 0.8rem;
        }
    }
    @media (max-width: 992px) {
        .breaking__horizontal {
            flex-direction: column;
            align-items: stretch;
            gap: 10px;
        }
        .breaking__ticker-section {
            order: 1;
            width: 100%;
        }
        .breaking__static-info {
            order: 2;
            width: 100%;
            justify-content: space-between;
            padding: 10px 15px;
            background: #fff;
            border-radius: 4px;
            flex-wrap: wrap;
        }

        /* Flash Info optimisations pour tablette */
        .ticker__label {
            font-size: 0.8rem;
            padding: 6px 12px;
        }
        .ticker__content ul li {
            font-size: 0.85rem;
            padding: 0 0.8rem;
        }
    }
    @media (max-width: 768px) {
        .breaking__static-info {
            gap: 8px;
        }
        .breaking__static-info .info__item {
            padding: 5px 8px;
            font-size: 0.75rem;
        }
        .breaking__static-info .info__item i {
            font-size: 0.9rem;
        }

        /* Flash Info mobile - Défilement horizontal */
        .breaking__horizontal {
            padding: 8px;
            margin-bottom: 15px;
        }
        .breaking__ticker-section {
            flex-direction: column;
            align-items: stretch;
            width: 100%;
        }
        .ticker__label {
            font-size: 0.75rem;
            padding: 6px 10px;
            margin-right: 0;
            margin-bottom: 8px;
            text-align: center;
            width: 100%;
        }
        .ticker__content {
            height: 35px;
            overflow: hidden;
        }
        .ticker__content ul {
            display: flex;
            list-style: none;
            margin: 0;
            padding: 0;
            animation: scrollHorizontal 15s linear infinite;
            white-space: nowrap;
        }
        .ticker__content ul li {
            display: inline-block !important;
            position: relative !important;
            opacity: 1 !important;
            animation: none !important;
            padding: 0 1rem !important;
            font-size: 0.95rem !important;
            line-height: 35px !important;
            white-space: nowrap !important;
            color: #333 !important;
            font-weight: 600 !important;
        }
        .ticker__content ul li::after {
            content: " • ";
            color: #f1c40f;
            margin-left: 0.5rem;
        }
        .ticker__content ul li:last-child::after {
            content: "";
        }

        /* Animation de défilement horizontal pour mobile */
        @keyframes scrollHorizontal {
            0% {
                transform: translateX(100%);
            }
            100% {
                transform: translateX(-100%);
            }
        }
    }
    @media (max-width: 480px) {
        /* Très petit mobile */
        .breaking__horizontal {
            padding: 6px;
            margin-bottom: 10px;
        }
        .ticker__content ul li {
            font-size: 0.85rem !important;
            padding: 0 0.8rem !important;
        }
        .breaking__static-info {
            flex-direction: column;
            gap: 6px;
            width: 100%;
        }
        .breaking__static-info .info__item {
            padding: 4px 6px;
            font-size: 0.7rem;
            justify-content: center;
        }
    }
</style>
@endpush

@section('content')
    <!-- ============================================================== -->
    <!-- DEBUT DU CONTENU PRINCIPAL -->
    <!-- ============================================================== -->
    <main>
        <!-- Section 'Breaking News' (Informations Météo/Date) -->
        <section class="breaking pt-25 pb-25">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="breaking__horizontal mb-30">
                            <!-- Section "Flash Info" avec ticker -->
                            <div class="breaking__ticker-section">
                                <div class="ticker__label">
                                    <i class="fas fa-bolt"></i> FLASH INFO
                                </div>
                                <div class="ticker__content">
                                    <ul>
                                        @forelse($flashInfos as $flashInfo)
                                            <li><strong>{{ $flashInfo->titre }}</strong></li>
                                        @empty
                                            <li>Aucune Flash Info disponible pour le moment</li>
                                        @endforelse
                                    </ul>
                                </div>
                            </div>

                            <!-- Informations statiques à droite -->
                            <div class="breaking__static-info">
                                <div class="info__item">
                                    <i class="fas fa-cloud-sun"></i>
                                    <span>Abidjan <span id="weather-display">26°C</span></span>
                                </div>
                                <div class="info__item">
                                    <i class="fas fa-chart-line"></i>
                                    <span>BRVM10 <span id="brvm-display">162.29</span></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
        <!-- breaking end -->

<div class="page-banner-area">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="webtv-hero-banner">
                            <div class="container text-center">
                                <h1 class="webtv-hero-title">WebTV</h1>
                                <p class="webtv-hero-subtitle">Plongez au cœur de l'actualité avec nos émissions et reportages.</p>
                                <a href="{{ route('webtv.index') }}" class="btn btn-lg btn-webtv">Accéder à la WebTV</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Section WebTV - Toujours affichée avec messages adaptatifs -->
        <section class="live-video-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="video-player-wrapper">
                            @if($featuredWebtv && $featuredWebtv->statut == 'en_direct' && !empty($featuredWebtv->code_embed_vimeo))
                                <!-- Live en cours avec code embed -->
                                {!! $featuredWebtv->code_embed_vimeo !!}
                            @elseif($featuredWebtv && $featuredWebtv->statut == 'en_direct')
                                <!-- Live en cours sans code embed -->
                                <img src="{{ $featuredWebtv->image_path ? asset('storage/' . $featuredWebtv->image_path) : asset('assets/default/image_default.jpg') }}" alt="{{ $featuredWebtv->titre ?? '' }}" style="width: 100%; height: 100%; object-fit: cover;">
                            @elseif($prochainLive)
                                <!-- Live programmé -->
                                <img src="{{ $prochainLive->image_path ? asset('storage/' . $prochainLive->image_path) : asset('assets/default/image_default.jpg') }}" alt="{{ $prochainLive->titre ?? '' }}" style="width: 100%; height: 100%; object-fit: cover;">
                                <div class="scheduled-overlay">
                                    <div class="scheduled-content">
                                        <i class="fas fa-clock fa-3x mb-3"></i>
                                        <h4>Prochain Live</h4>
                                        <p class="mb-0">Programmé</p>
                                    </div>
                                </div>
                            @else
                                <!-- Aucun live -->
                                <img src="{{ asset('assets/default/image_default.jpg') }}" alt="WebTV Excellence Afrik" style="width: 100%; height: 100%; object-fit: cover;">
                                <div class="no-live-overlay">
                                    <div class="no-live-content">
                                        <i class="fas fa-tv fa-3x mb-3"></i>
                                        <h4>Aucun Live En Cours</h4>
                                        <p class="mb-0">Restez connectés pour nos prochains programmes !</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-4 d-flex align-items-center">
                        <div class="live-video-info">
                            @if($featuredWebtv && $featuredWebtv->statut == 'en_direct')
                                <!-- Live en cours -->
                                <span class="live-badge mb-3 d-inline-block">En Direct</span>
                                <h2 class="h3 fw-bold text-white mb-3">{{ $featuredWebtv->titre }}</h2>
                                <p class="text-white-50 mb-3">{{ Str::limit($featuredWebtv->description, 150) }}</p>
                                <a href="{{ route('webtv.show', $featuredWebtv) }}" class="btn btn-warning">
                                    <i class="fas fa-play me-2"></i>Regarder maintenant
                                </a>
                            @elseif($prochainLive)
                                <!-- Live programmé avec décompte -->
                                <span class="scheduled-badge mb-3 d-inline-block">Programmé</span>
                                <h2 class="h3 fw-bold text-white mb-3">{{ $prochainLive->titre }}</h2>
                                <p class="text-white-50 mb-3">{{ Str::limit($prochainLive->description, 120) }}</p>
                                <div class="countdown-container mb-3">
                                    <div class="countdown-label text-white-50 mb-2">Commence dans :</div>
                                    <div class="countdown-timer" data-date="{{ $prochainLive->date_programmee->toISOString() }}">
                                        <div class="countdown-display">Calcul en cours...</div>
                                    </div>
                                </div>
                                <a href="{{ route('webtv.show', $prochainLive) }}" class="btn btn-outline-light">
                                    <i class="fas fa-info-circle me-2"></i>Voir les détails
                                </a>
                            @else
                                <!-- Aucun live -->
                                <h2 class="h3 fw-bold text-white mb-3">WebTV Excellence Afrik</h2>
                                <p class="text-white-50 mb-3">Découvrez nos émissions, interviews et reportages exclusifs.</p>
                                <a href="{{ route('webtv.index') }}" class="btn btn-outline-light">
                                    <i class="fas fa-play me-2"></i>Voir nos programmes
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <br/>
        <br/>

        <!-- ============================================================== -->
        <!-- Section Principale (Hero Area) -->
        <!-- ============================================================== -->

        <section class="unified-a-la-une-area pt-30 pb-30">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="section-title section-title--decorated mb-50">
                            <h2>À LA UNE</h2>
                        </div>
                    </div>
                </div>

                @if(isset($homepageAlaUneArticles) && $homepageAlaUneArticles->count() > 0)
                    @php
                        $largeArticles = $homepageAlaUneArticles->take(3);
                        $smallArticles = $homepageAlaUneArticles->slice(3);
                    @endphp

                    <!-- 3 Large Articles -->
                    <div class="row mb-30">
                        @foreach($largeArticles as $article)
                            <div class="col-lg-4 col-md-6 mb-30">
                                <div class="hero pos-relative h-100">
                                    <div class="hero__thumb" style="aspect-ratio: 5 / 3;">
                                        <a href="{{ route('articles.show', $article->slug) }}">
                                            @php
                                                $thumb_path = $article->featured_image_path ? preg_replace('/(\.[^.]+)$/', '_thumb$1', $article->featured_image_path) : null;
                                            @endphp
                                            <img src="{{ ($thumb_path && file_exists(public_path('storage/' . $thumb_path))) ? asset('storage/' . $thumb_path) : asset('assets/default/image_default.jpg') }}" alt="{{ $article->title }}" style="height: 100%; width: 100%; object-fit: cover;">
                                        </a>
                                    </div>
                                    <div class="hero__text">
                                        @if($article->category)
                                            <span class="post-cat mb-10"><a href="{{ route('articles.category', $article->category->slug) }}">{{ $article->category->name }}</a></span>
                                        @endif
                                        <h3 class="pr-0"><a href="{{ route('articles.show', $article->slug) }}">{{ $article->title }}</a></h3>
                                        @if($article->published_at)
                                            <small>{{ $article->published_at->translatedFormat('d F Y') }}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- 12 Small Articles -->
                    <div class="row">
                        @foreach($smallArticles as $article)
                            <div class="col-lg-3 col-md-4 col-sm-6 mb-30">
                                <div class="hero pos-relative h-100 hero-small">
                                    <div class="hero__thumb" style="aspect-ratio: 5 / 3;">
                                        <a href="{{ route('articles.show', $article->slug) }}">
                                             @php
                                                $thumb_path = $article->featured_image_path ? preg_replace('/(\.[^.]+)$/', '_thumb$1', $article->featured_image_path) : null;
                                            @endphp
                                            <img src="{{ ($thumb_path && file_exists(public_path('storage/' . $thumb_path))) ? asset('storage/' . $thumb_path) : asset('assets/default/image_default.jpg') }}" alt="{{ $article->title }}" style="height: 100%; width: 100%; object-fit: cover;">
                                        </a>
                                    </div>
                                    <div class="hero__text hero__text-small">
                                         @if($article->category)
                                            <span class="post-cat mb-10"><a href="{{ route('articles.category', $article->category->slug) }}">{{ $article->category->name }}</a></span>
                                        @endif
                                        <h6><a href="{{ route('articles.show', $article->slug) }}">{{ $article->title }}</a></h6>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                @else
                    <div class="row">
                        <div class="col-12 text-center">
                            <p style="color: #fff; font-size: 1.2rem;">Aucune actualité à afficher pour le moment.</p>
                        </div>
                    </div>
                @endif
            </div>
        </section>
        <!-- news area end -->





        <!-- ============================================================== -->
        <!-- Section 'Portrait d'Entrepreneurs' -->
        <!-- ============================================================== -->
        <section class="portrait-area pb-30 pt-60">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="section-title mb-50 text-center">
                            <h2>Portraits d'Entrepreneurs</h2>
                            <p>Découvrez les parcours inspirants de ceux qui façonnent l'économie.</p>
                        </div>
                    </div>
                </div>

                @if(isset($entrepreneurArticles) && $entrepreneurArticles->count() > 0)
                    @php
                        $mainArticles = $entrepreneurArticles->slice(0, 3);
                        $secondaryArticles = $entrepreneurArticles->slice(3, 4);
                    @endphp

                    <!-- Grands Blocs -->
                    <div class="row">
                        @foreach($mainArticles as $article)
                            <div class="col-lg-4 mb-4">
                                <div class="portrait-card h-100 wow fadeInUp">
                                    <div class="portrait-card__image">
                                        <a href="{{ route('articles.show', $article->slug) }}">
                                            <img src="{{ $article->featured_image_path ? (app()->environment('production') ? asset('uploads/' . $article->featured_image_path) : asset('storage/' . $article->featured_image_path)) : asset('assets/default/image_default.jpg') }}" alt="{{ $article->title }}">
                                        </a>
                                    </div>
                                    <div class="portrait-card__content">
                                        <h3 class="portrait-card__title">
                                            <a href="{{ route('articles.show', $article->slug) }}">{{ $article->title }}</a>
                                        </h3>

                                        <a href="{{ route('articles.show', $article->slug) }}" class="btn btn-link p-0">Lire le portrait <i class="fas fa-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Petits Blocs -->
                    @if($secondaryArticles->count() > 0)
                    <div class="row mt-4">
                        @foreach($secondaryArticles as $article)
                            <div class="col-lg-3 col-md-6 mb-4">
                                <div class="portrait-card portrait-card--small h-100 wow fadeInUp">
                                    <div class="portrait-card__image portrait-card__image--small">
                                        <a href="{{ route('articles.show', $article->slug) }}">
                                            <img src="{{ $article->featured_image_path ? (app()->environment('production') ? asset('uploads/' . $article->featured_image_path) : asset('storage/' . $article->featured_image_path)) : asset('assets/default/image_default.jpg') }}" alt="{{ $article->title }}">
                                        </a>
                                    </div>
                                    <div class="portrait-card__content portrait-card__content--small">
                                        <h4 class="portrait-card__title portrait-card__title--small">
                                            <a href="{{ route('articles.show', $article->slug) }}">{{ $article->title }}</a>
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @endif
                @else
                    <div class="col-12 text-center">
                        <p>Aucun portrait d'entrepreneur à afficher pour le moment.</p>
                    </div>
                @endif
            </div>
        </section>


        <br />
        <br />
        <!-- ============================================================== -->
        <!-- Section des Magazines -->
        <!-- ============================================================== -->
        <section class="add-area pb-30">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12">
                        <div class="section-title mb-30">
                            <h2>Magazines</h2>
                        </div>

                        @if(isset($latestMagazines) && $latestMagazines->count() > 0)
                            <div class="row">
                                @foreach($latestMagazines as $magazine)
                                    <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="{{ $loop->index * 0.1 }}s">
                                        <div class="hero pos-relative mb-30">
                                            <div class="hero__thumb">
                                                <a href="{{ route('magazines.show', $magazine->slug) }}">
                                                    @if($magazine->cover_path)
                                                        <img src="{{ Storage::url($magazine->cover_path) }}" alt="{{ $magazine->title }}">
                                                    @else
                                                        <img src="{{ asset('assets/default/image_default.jpg') }}" alt="{{ $magazine->title }}">
                                                    @endif
                                                </a>
                                            </div>
                                            <div class="hero__text hero__text-small">
                                                <span class="post-cat mb-10">
                                                    <a href="{{ route('magazines.index') }}">Magazine</a>
                                                </span>
                                                <h3 class="pr-0">
                                                    <a href="{{ route('magazines.show', $magazine->slug) }}">{{ $magazine->title }}</a>
                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p>Aucun magazine à afficher pour le moment.</p>
                        @endif
                    </div>
                </div>
            </div>
        </section>
        <!-- add-area end -->



        <!-- ============================================================== -->
        <!-- Section de Téléchargement des Applications -->
        <!-- ============================================================== -->
        @if(isset($bottomBannerAd))
        <section class="app-area pb-60">
            <div class="container">
                <div class="wow fadeInUp" data-wow-delay=".3s">
                    <a href="{{ $bottomBannerAd->getTrackableUrl() }}" target="_blank" rel="noopener noreferrer">
                        <img src="{{ asset('storage/' . $bottomBannerAd->image) }}" alt="{{ $bottomBannerAd->title }}" style="width: 100%; height: auto;">
                    </a>
                </div>
            </div>
        </section>
        @endif



    </main>
    <!-- ============================================================== -->
    <!-- FIN DU CONTENU PRINCIPAL -->
    <!-- ============================================================== -->


@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- Ticker Animation ---
        const tickerList = document.querySelector('.ticker__content ul');
        if (tickerList) {
            const flashInfoItems = tickerList.querySelectorAll('li');
            const totalItems = flashInfoItems.length;
            const isMobile = window.innerWidth <= 768;

            console.log(`Flash Info: ${totalItems} éléments détectés, Mobile: ${isMobile}`);

            if (totalItems > 0) {
                if (!isMobile) {
                    // Animation verticale pour desktop
                    const displayTime = 4; // Temps d'affichage par Flash Info (secondes)
                    const totalCycleTime = totalItems * displayTime; // Durée totale du cycle complet

                    flashInfoItems.forEach((item, index) => {
                        // Chaque Flash Info a une animation qui dure le cycle complet
                        item.style.animation = `flashInfoFadeIn ${totalCycleTime}s infinite`;
                        item.style.animationDelay = `${index * displayTime}s`;

                        // Positionnement pour desktop
                        item.style.position = 'absolute';
                        item.style.top = '50%';
                        item.style.left = '0';
                        item.style.right = '0';
                        item.style.transform = 'translateY(-50%)';
                        item.style.textAlign = 'left';
                        item.style.paddingLeft = '1rem';
                        item.style.paddingRight = '1rem';

                        console.log(`Flash Info ${index + 1}: délai de ${index * displayTime}s, durée totale: ${totalCycleTime}s`);
                    });

                    console.log(`Animation configurée: cycle complet de ${totalCycleTime}s pour ${totalItems} éléments`);
                }
                // En mobile, laisser le CSS gérer le défilement horizontal
            }
        }

        // --- Weather Data ---
        function fetchWeather() {
            const lat = 5.34; // Abidjan Latitude
            const lon = -4.04; // Abidjan Longitude
            const url = `https://api.open-meteo.com/v1/forecast?latitude=${lat}&longitude=${lon}&current_weather=true`;

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    const temp = data.current_weather.temperature;
                    const weatherElement = document.querySelector('#weather-display');
                    if (weatherElement) {
                        weatherElement.textContent = `${temp}°C`;
                    }
                })
                .catch(error => {
                    console.error('Error fetching weather:', error);
                    const weatherElement = document.querySelector('#weather-display');
                    if (weatherElement) weatherElement.textContent = 'Indisponible';
                });
        }


        // --- BRVM Data (Static) ---
        function displayBrvm() {
            const brvmElement = document.querySelector('#brvm-display');
            if (brvmElement) {
                // Valeur statique en attendant une API
                brvmElement.innerHTML = '162.29 <span class="positive">(+0.49%)</span>';
            }
        }

        // --- Countdown Timer ---
        function initCountdown() {
            const countdownTimer = document.querySelector('.countdown-timer');
            if (!countdownTimer) return;

            const targetDate = new Date(countdownTimer.dataset.date);

            function updateCountdown() {
                const now = new Date().getTime();
                const distance = targetDate.getTime() - now;

                if (distance < 0) {
                    countdownTimer.querySelector('.countdown-display').innerHTML =
                        '<span style="color: #f4c700; font-weight: bold; font-size: 1.1em; animation: pulse 1s infinite;">Le live commence maintenant !</span>';
                    // Recharger la page après 5 secondes pour mettre à jour le statut
                    setTimeout(() => location.reload(), 5000);
                    return;
                }

                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                let display = '';
                if (days > 0) {
                    display = `<span style="color: #f4c700; font-weight: bold; font-size: 1.2em;">${days}</span><span style="color: #ffffff;">j</span> <span style="color: #f4c700; font-weight: bold; font-size: 1.2em;">${hours}</span><span style="color: #ffffff;">h</span> <span style="color: #f4c700; font-weight: bold; font-size: 1.2em;">${minutes}</span><span style="color: #ffffff;">min</span>`;
                } else if (hours > 0) {
                    display = `<span style="color: #f4c700; font-weight: bold; font-size: 1.2em;">${hours}</span><span style="color: #ffffff;">h</span> <span style="color: #f4c700; font-weight: bold; font-size: 1.2em;">${minutes}</span><span style="color: #ffffff;">min</span> <span style="color: #f4c700; font-weight: bold; font-size: 1.2em;">${seconds}</span><span style="color: #ffffff;">s</span>`;
                } else if (minutes > 0) {
                    display = `<span style="color: #f4c700; font-weight: bold; font-size: 1.3em;">${minutes}</span><span style="color: #ffffff;">min</span> <span style="color: #f4c700; font-weight: bold; font-size: 1.3em;">${seconds}</span><span style="color: #ffffff;">s</span>`;
                } else {
                    display = `<span style="color: #e74c3c; font-weight: bold; font-size: 1.4em; animation: pulse 1s infinite;">${seconds}</span><span style="color: #ffffff;">s</span>`;
                }

                countdownTimer.querySelector('.countdown-display').innerHTML = display;
            }

            // Mise à jour initiale
            updateCountdown();

            // Mise à jour toutes les secondes
            setInterval(updateCountdown, 1000);
        }

        // Fetch all data
        fetchWeather();
        displayBrvm();
        initCountdown();
    });
</script>
@endpush
