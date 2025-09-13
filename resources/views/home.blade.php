@extends('layouts.app')

@push('styles')
<style>
    .page-banner-area .page-title-bar {
        background: #000000;
    }
    .page-banner-area .page-title-bar h1 {
        color: #fff;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
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
        transform: translateY(-100px);
        padding: 0 1rem;
        font-size: 0.9rem;
        color: #333;
        font-weight: 500;
        white-space: nowrap;
        opacity: 0;
        animation: tickerVertical 15s infinite;
        z-index: 1;
    }
    .ticker__content ul li:nth-child(1) { animation-delay: 0s; }
    .ticker__content ul li:nth-child(2) { animation-delay: 3s; }
    .ticker__content ul li:nth-child(3) { animation-delay: 6s; }
    .ticker__content ul li:nth-child(4) { animation-delay: 9s; }
    .ticker__content ul li:nth-child(5) { animation-delay: 12s; }
    @keyframes tickerVertical {
        0% {
            opacity: 0;
            transform: translateY(-100px);
        }
        6.67% {
            opacity: 1;
            transform: translateY(-50%);
        }
        13.33% {
            opacity: 1;
            transform: translateY(-50%);
        }
        20% {
            opacity: 0;
            transform: translateY(100px);
        }
        100% {
            opacity: 0;
            transform: translateY(100px);
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
        }
        .breaking__static-info {
            order: 2;
            justify-content: space-between;
            padding: 10px 15px;
            background: #fff;
            border-radius: 4px;
            flex-wrap: wrap;
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
                                        <li>La BRVM enregistre une hausse de 2.3% aujourd'hui</li>
                                        <li>Le Président reçoit une délégation de la Banque Mondiale</li>
                                        <li>Sommet de l'UA : La Côte d'Ivoire présente ses projets</li>
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
                        <div class="page-title-bar text-center pt-60 pb-60">
                            <h1>WebTV</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if($featuredWebtv)
        <section class="live-video-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="video-player-wrapper">
                            @if(!empty($featuredWebtv->code_embed_vimeo))
                                {!! $featuredWebtv->code_embed_vimeo !!}
                            @else
                                <img src="{{ $featuredWebtv->image_path ? asset('storage/' . $featuredWebtv->image_path) : asset('styles/img/hero/part1/hero1.jpg') }}" alt="{{ $featuredWebtv->titre ?? '' }}" style="width: 100%; height: 100%; object-fit: cover;">
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-4 d-flex align-items-center">
                        <div class="live-video-info">
                            @if($featuredWebtv->statut == 'en_direct')
                                <span class="live-badge mb-3 d-inline-block">En Direct</span>
                            @endif
                            <h2 class="h3 fw-bold text-white mb-3">{{ $featuredWebtv->titre }}</h2>
                            <p class="text-white-50">{{ Str::limit($featuredWebtv->description, 150) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @endif

        <br/>
        <br/>

        <!-- ============================================================== -->
        <!-- Section Principale (Hero Area) -->
        <!-- ============================================================== -->

        <section class="hero-area">
            <div class="container">

                <div class="row">
                    <div class="col-12">
                        <div class="section-title mb-30">
                            <h2>TOPS 3 DE L'ARTICLE DU JOUR</h2>
                        </div>
                    </div>
                @if(isset($dailyNews) && $dailyNews->count() > 0)
                    @php
                        $topArticle = $dailyNews->first();
                        $sideArticles = $dailyNews->slice(1, 2);
                    @endphp
                    <div class="row">
                        {{-- Main Article --}}
                        @if($topArticle)
                            <div class="col-lg-6 col-md-12">
                                <div class="hero pos-relative mb-30">
                                    <div class="hero__thumb" data-overlay="dark-gradient">
                                        <a href="{{ route('articles.show', $topArticle->slug) }}">
                                            @if($topArticle->featured_image_path && file_exists(public_path('storage/' . $topArticle->featured_image_path)))
                                                <img src="{{ asset('storage/' . $topArticle->featured_image_path) }}" alt="{{ $topArticle->title }}">
                                            @elseif($topArticle->featured_image_url)
                                                <img src="{{ $topArticle->featured_image_url }}" alt="{{ $topArticle->title }}">
                                            @else
                                                <img src="{{ asset('styles/img/hero/part1/hero1.jpg') }}" alt="{{ $topArticle->title }}">
                                            @endif
                                        </a>
                                    </div>
                                    <div class="hero__text">
                                        <span class="post-cat mb-10"><a href="{{ route('articles.category', $topArticle->category->slug) }}">{{ $topArticle->category->name }}</a></span>
                                        <h3 class="pr-100"><a href="{{ route('articles.show', $topArticle->slug) }}">{{ $topArticle->title }}</a></h3>
                                        <small>{{ $topArticle->created_at->format('d M Y') }} | {{ $topArticle->user->name ?? 'Admin' }}</small>
                                    </div>
                                </div>
                            </div>
                        @endif

                        {{-- Side Articles --}}
                        <div class="col-lg-6">
                            <div class="row">
                                @if($sideArticles->count() > 0)
                                    @foreach($sideArticles as $article)
                                        <div class="col-lg-6 col-md-6">
                                            <div class="hero pos-relative mb-30">
                                                <div class="hero__thumb" data-overlay="dark-gradient">
                                                    <a href="{{ route('articles.show', $article->slug) }}">
                                                        @if($article->featured_image_path && file_exists(public_path('storage/' . $article->featured_image_path)))
                                                            <img src="{{ asset('storage/' . $article->featured_image_path) }}" alt="{{ $article->title }}">
                                                        @elseif($article->featured_image_url)
                                                            <img src="{{ $article->featured_image_url }}" alt="{{ $article->title }}">
                                                        @else
                                                            <img src="{{ asset('styles/img/hero/part1/hero2.jpg') }}" alt="{{ $article->title }}">
                                                        @endif
                                                    </a>
                                                </div>
                                                <div class="hero__text hero__text-small">
                                                    <span class="post-cat mb-10">
                                                        <a href="{{ route('articles.category', $article->category->slug) }}">{{ $article->category->name }}</a>
                                                    </span>
                                                    <h3 class="pr-0">
                                                        <a href="{{ route('articles.show', $article->slug) }}">{{ Str::limit($article->title, 50) }}</a>
                                                    </h3>
                                                    <small>{{ $article->created_at->format('d M Y') }}</small>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </section>
        <!-- hero-area end -->

        <!-- ============================================================== -->
        <!-- Section des Actualités du Jour -->
        <!-- ============================================================== -->
        <section class="news-area pt-30 pb-30">
            <br />
            <br />
            <!-- trendy news -->
            <div class="container">
                <div class="row ">
                    <div class="col-12">
                        <div class="section-title mb-30">
                            <h2 style="color: #fff;">ACTUALITÉ DU JOUR</h2>
                        </div>
                    </div>
                </div>
                <br />
            </div>
            <div class="container">
                <div class="row row-10">
                    <div class="col-20 wow fadeInUp" data-wow-delay=".3s">
                        <div class="hero pos-relative mb-30">
                            <div class="hero__thumb" data-overlay="dark-gradient">
                                <a href="#"><img src="{{ asset('styles/img/trendy/sm1.jpg') }}" alt="hero image"></a>
                            </div>
                            <div class="hero__text hero__text-small">
                                <h3 class="pr-0"><a href="#">Paul Manafort’s Accountant Testifies She Helped Alter Financial Documents</a></h3>
                                <small>01 Sep 2018 | Nom de la Catégorie</small>
                            </div>
                        </div>
                        <div class="hero pos-relative mb-30">
                            <div class="hero__thumb" data-overlay="dark-gradient">
                                <a href="#"><img src="{{ asset('styles/img/trendy/sm2.jpg') }}" alt="hero image"></a>
                            </div>
                            <div class="hero__text hero__text-small">
                                <h3 class="pr-0"><a href="#">Rina Sawayama Is Not the Asian Britney Spears</a></h3>
                                <small>01 Sep 2018 | Nom de la Catégorie</small>
                            </div>
                        </div>
                        <div class="hero pos-relative mb-30">
                            <div class="hero__thumb" data-overlay="dark-gradient">
                                <a href="#"><img src="{{ asset('styles/img/trendy/sm3.jpg') }}" alt="hero image"></a>
                            </div>
                            <div class="hero__text hero__text-small">
                                <h3 class="pr-0"><a href="#">Receiving the Summer Sols tice the Swedish Way</a></h3>
                                <small>01 Sep 2018 | Nom de la Catégorie</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-40 wow fadeInUp" data-wow-delay=".5s">
                        <div class="hero pos-relative mb-30">
                            <div class="hero__thumb" data-overlay="dark-gradient">
                                <a href="#"><img src="{{ asset('styles/img/trendy/lg1.jpg') }}" alt="hero image"></a>
                            </div>
                            <div class="hero__text">
                                <h3 class="pr-100"><a href="#">Trump’s Inaccurate Claims About High ways the world, Immigration and Beyoncé.</a></h3>
                                <small>01 Sep 2018 | Nom de la Catégorie</small>
                            </div>
                        </div>

                        <div class="hero pos-relative mb-30">
                            <div class="hero__thumb" data-overlay="dark-gradient">
                                <a href="#"><img src="{{ asset('styles/img/trendy/lg2.jpg') }}" alt="hero image"></a>
                            </div>
                            <div class="hero__text">
                                <h3 class="pr-100"><a href="#">Moving From Buyer to Seller, Major League Soccer Revenue In The World Wide Claims About.</a></h3>
                                <small>01 Sep 2018 | Nom de la Catégorie</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-20 d-md-none d-xl-block wow fadeInUp" data-wow-delay=".7s">
                        <div class="hero pos-relative mb-30">
                            <div class="hero__thumb" data-overlay="dark-gradient">
                                <a href="#"><img src="{{ asset('styles/img/trendy/xs/xs-1.jpg') }}" alt="hero image"></a>
                            </div>
                            <div class="hero__text hero__text-small">
                                <span class="post-cat mb-10"><a href="#">Fashion</a></span>
                                <h3 class="pr-0"><a href="#">Storm in aw ame home away.</a></h3>
                            </div>
                        </div>
                        <div class="hero pos-relative mb-30">
                            <div class="hero__thumb" data-overlay="dark-gradient">
                                <a href="#"><img src="{{ asset('styles/img/trendy/xs/xs-2.jpg') }}" alt="hero image"></a>
                            </div>
                            <div class="hero__text hero__text-small">
                                <span class="post-cat mb-10"><a href="#">Fashion</a></span>
                                <h3 class="pr-0"><a href="#">Good ridre urants bid farewell.</a></h3>
                            </div>
                        </div>
                        <div class="hero pos-relative mb-30">
                            <div class="hero__thumb" data-overlay="dark-gradient">
                                <a href="#"><img src="{{ asset('styles/img/trendy/xs/xs-3.jpg') }}" alt="hero image"></a>
                            </div>
                            <div class="hero__text hero__text-small">
                                <span class="post-cat mb-10"><a href="#">Fashion</a></span>
                                <h3 class="pr-0"><a href="#">Nahan dow plays Lieral lership..</a></h3>
                            </div>
                        </div>

                    </div>
                    <div class="col-20 wow fadeInUp" data-wow-delay=".9s">
                        <div class="hero pos-relative mb-30">
                            <div class="hero__thumb" data-overlay="dark-gradient">
                                <a href="#"><img src="{{ asset('styles/img/trendy/sm4.jpg') }}" alt="hero image"></a>
                            </div>
                            <div class="hero__text hero__text-small">
                                <h3 class="pr-0"><a href="#">Paul Manafort’s Accountant Testifies She Helped Alter Financial Documents</a></h3>
                                <small>01 Sep 2018 | Nom de la Catégorie</small>
                            </div>
                        </div>
                        <div class="hero pos-relative mb-30">
                            <div class="hero__thumb" data-overlay="dark-gradient">
                                <a href="#"><img src="{{ asset('styles/img/trendy/sm5.jpg') }}" alt="hero image"></a>
                            </div>
                            <div class="hero__text hero__text-small">
                                <h3 class="pr-0"><a href="#">Rina Sawayama Is Not the Asian Britney Spears</a></h3>
                                <small>01 Sep 2018 | Nom de la Catégorie</small>
                            </div>
                        </div>
                        <div class="hero pos-relative mb-30">
                            <div class="hero__thumb" data-overlay="dark-gradient">
                                <a href="#"><img src="{{ asset('styles/img/trendy/sm6.jpg') }}" alt="hero image"></a>
                            </div>
                            <div class="hero__text hero__text-small">
                                <h3 class="pr-0"><a href="#">Receiving the Summer Sols tice the Swedish Way</a></h3>
                                <small>01 Sep 2018 | Nom de la Catégorie</small>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
            <br />
            <br />
            <br />
            <div class="post-btn mb-50">
                <a href="#" class="btn btn-border">Voir plus </a>
            </div>
            <!-- trendy news end -->
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
                                            <img src="{{ $article->featured_image_path ? asset('storage/' . $article->featured_image_path) : asset('styles/img/video/video-2.jpg') }}" alt="{{ $article->title }}">
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
                                            <img src="{{ $article->featured_image_path ? asset('storage/' . $article->featured_image_path) : asset('styles/img/video/video-2.jpg') }}" alt="{{ $article->title }}">
                                        </a>
                                    </div>
                                    <div class="portrait-card__content portrait-card__content--small">
                                        <h4 class="portrait-card__title portrait-card__title--small">
                                            <a href="{{ route('articles.show', $article->slug) }}">{{ Str::limit($article->title, 50) }}</a>
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
                                            <div class="hero__thumb" data-overlay="dark-gradient">
                                                <a href="{{ route('magazines.show', $magazine->slug) }}">
                                                    <img src="{{ $magazine->cover_image_path ? Storage::url($magazine->cover_image_path) : asset('styles/img/hero/part1/hero2.jpg') }}" alt="{{ $magazine->title }}">
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
        <section class="app-area pb-60">
            <div class="container">
                <div class="grey-bg pt-55 pb-55 pl-60 pr-60 wow fadeInUp" data-wow-delay=".3s">
                    <div class="row">
                        <div class="col-xl-6 col-lg-12">
                            <div class="app-text text-center text-xl-left">
                                <h2>Download our apps now</h2>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-12">
                            <div class="app-store text-center text-xl-right">
                                <a href="#"><img src="{{ asset('styles/img/store/apple.png') }}" alt=""></a>
                                <a href="#"><img src="{{ asset('styles/img/store/google.png') }}" alt=""></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>



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
            const listContent = tickerList.innerHTML;
            tickerList.innerHTML += listContent; // Duplicate content for seamless loop
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

        // Fetch all data
        fetchWeather();
        displayBrvm();
    });
</script>
@endpush
