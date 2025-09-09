@extends('layouts.app')

@section('title', ($category->seo_title ?: $category->name) . ' - Excellence Afrik')
@section('meta_description', $category->seo_description ?: 'Découvrez nos articles sur ' . $category->name)

@php
    // Detect if this category contains video content
    $isVideoCategory = in_array($category->slug, ['grands-genres', 'webtv', 'documentaires', 'interviews', 'reportages']);
    $contentType = $isVideoCategory ? 'video' : 'text';
@endphp

@section('content')
    <!-- Main Content -->
    <main class="main-content">

        <div class="page-title-banner">
            <div class="container-fluid">
                <div class="row justify-content-center">

                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-10">

            @if($contentType === 'video')
            <!-- Video Hero Section -->
            <section class="video-hero-section fade-in">
                <div class="container">
                    <div class="video-hero-content">
                        <div class="row justify-content-center">
                            <div class="col-lg-8 text-center">
                                <div class="hero-badge-minimal">
                                    <span class="badge-text-minimal">
                                        <i class="fas fa-video"></i>
                                        {{ $category->name ?? ucfirst(str_replace('-', ' ', $slug)) }}
                                    </span>
                                </div>

                                <p class="video-hero-subtitle">
                                    Reportages exclusifs et témoignages authentiques des bâtisseurs africains
                                </p>
                                <div class="hero-description">
                                    <p class="lead-text">
                                        @if($category && $category->description)
                                            {{ $category->description }}
                                        @else
                                            Découvrez les histoires inspirantes des entrepreneurs qui transforment l'Afrique,
                                            racontées à travers nos reportages vidéo immersifs et nos interviews exclusives.
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>


            <section class="video-filter-section fade-in visible">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-10">
                            @if(!empty($isGrandsGenres) && $isGrandsGenres)
                                <div class="video-filter-tabs">
                                    @php $currentTheme = strtolower($theme ?? ''); @endphp
                                    <a class="video-filter-tab {{ $currentTheme === '' ? 'active' : '' }}" href="{{ route('articles.category', ['slug' => $category->slug]) }}" aria-current="{{ $currentTheme === '' ? 'true' : 'false' }}">
                                        <i class="fas fa-th-large"></i>
                                        <span>Tous les contenus</span>
                                    </a>
                                    <a class="video-filter-tab {{ $currentTheme === 'reportages' ? 'active' : '' }}" href="{{ route('articles.category', ['slug' => $category->slug, 'theme' => 'reportages']) }}" aria-current="{{ $currentTheme === 'reportages' ? 'true' : 'false' }}">
                                        <i class="fas fa-camera"></i>
                                        <span>Reportages</span>
                                    </a>
                                    <a class="video-filter-tab {{ $currentTheme === 'interviews' ? 'active' : '' }}" href="{{ route('articles.category', ['slug' => $category->slug, 'theme' => 'interviews']) }}" aria-current="{{ $currentTheme === 'interviews' ? 'true' : 'false' }}">
                                        <i class="fas fa-microphone"></i>
                                        <span>Interviews</span>
                                    </a>
                                    <a class="video-filter-tab {{ $currentTheme === 'documentaires' ? 'active' : '' }}" href="{{ route('articles.category', ['slug' => $category->slug, 'theme' => 'documentaires']) }}" aria-current="{{ $currentTheme === 'documentaires' ? 'true' : 'false' }}">
                                        <i class="fas fa-film"></i>
                                        <span>Documentaires</span>
                                    </a>
                                    <a class="video-filter-tab {{ $currentTheme === 'temoignages' ? 'active' : '' }}" href="{{ route('articles.category', ['slug' => $category->slug, 'theme' => 'temoignages']) }}" aria-current="{{ $currentTheme === 'temoignages' ? 'true' : 'false' }}">
                                        <i class="fas fa-quote-left"></i>
                                        <span>Témoignages</span>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </section>




            @else
            <!-- Text Articles Hero Section -->
            <section class="text-hero-section fade-in py-5">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-8 text-center">
                            <div class="hero-badge-minimal">
                                <span class="badge-text-minimal">
                                    <i class="fas fa-newspaper"></i>
                                    {{ $category->name ?? ucfirst(str_replace('-', ' ', $slug)) }}
                                </span>
                            </div>
                            <h1 class="display-4 fw-bold mb-4">{{ $category->name }}</h1>
                            <p class="lead text-muted mb-4">
                                @if($category && $category->description)
                                    {{ $category->description }}
                                @else
                                    Découvrez nos analyses approfondies et nos reportages sur {{ $category->name }}.
                                @endif
                            </p>

                        </div>
                    </div>
                </div>
            </section>
            @endif

            {{-- Sector nav for Figures de l'Économie and Entreprises & Impacts: always visible, even with 0 results --}}
            @if((isset($isEntreprisesImpacts) && $isEntreprisesImpacts) || ($category && $category->slug === 'entreprises-impacts') || (isset($isFigures) && $isFigures))
                <section class="categories-nav-section fade-in visible">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-10">
                                @php $currentSector = strtolower(($sector ?? '') !== '' ? $sector : request()->query('sector', '')); @endphp
                                <div class="categories-nav-tabs">
                                    <a class="category-nav-tab {{ $currentSector === '' ? 'active' : '' }}" href="{{ route('articles.category', ['slug' => $category->slug]) }}" aria-current="{{ $currentSector === '' ? 'true' : 'false' }}">
                                        <i class="fas fa-th-large"></i>
                                        <span>Tous les secteurs</span>
                                    </a>
                                    <a class="category-nav-tab {{ $currentSector === 'agriculture' ? 'active' : '' }}" href="{{ route('articles.category', ['slug' => $category->slug, 'sector' => 'agriculture']) }}" aria-current="{{ $currentSector === 'agriculture' ? 'true' : 'false' }}">
                                        <i class="fas fa-leaf"></i>
                                        <span>Agriculture</span>
                                    </a>
                                    <a class="category-nav-tab {{ $currentSector === 'technologie' ? 'active' : '' }}" href="{{ route('articles.category', ['slug' => $category->slug, 'sector' => 'technologie']) }}" aria-current="{{ $currentSector === 'technologie' ? 'true' : 'false' }}">
                                        <i class="fas fa-laptop-code"></i>
                                        <span>Technologie</span>
                                    </a>
                                    <a class="category-nav-tab {{ $currentSector === 'industrie' ? 'active' : '' }}" href="{{ route('articles.category', ['slug' => $category->slug, 'sector' => 'industrie']) }}" aria-current="{{ $currentSector === 'industrie' ? 'true' : 'false' }}">
                                        <i class="fas fa-cogs"></i>
                                        <span>Industrie</span>
                                    </a>
                                    <a class="category-nav-tab {{ $currentSector === 'services' ? 'active' : '' }}" href="{{ route('articles.category', ['slug' => $category->slug, 'sector' => 'services']) }}" aria-current="{{ $currentSector === 'services' ? 'true' : 'false' }}">
                                        <i class="fas fa-handshake"></i>
                                        <span>Services</span>
                                    </a>
                                    <a class="category-nav-tab {{ $currentSector === 'energie' ? 'active' : '' }}" href="{{ route('articles.category', ['slug' => $category->slug, 'sector' => 'energie']) }}" aria-current="{{ $currentSector === 'energie' ? 'true' : 'false' }}">
                                        <i class="fas fa-bolt"></i>
                                        <span>Énergie</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            @endif

                   @if($articles->count() > 0)
                <!-- Featured Article Section -->
                @if($contentType === 'video')
                <!-- Featured Video Section -->
                <section class="featured-video-section py-5">
                    <div class="container">
                        @php
                            // Entreprises & Impacts and Contributions & Analyses: show featured only if explicitly marked
                            // Other categories: fallback to first article
                            if ((!empty($isEntreprisesImpacts) && $isEntreprisesImpacts) || (!empty($isContributionsAnalyses) && $isContributionsAnalyses)) {
                                $featuredArticleResolved = isset($featuredArticle) && $featuredArticle ? $featuredArticle : null;
                            } else {
                                $featuredArticleResolved = $articles->first();
                            }
                        @endphp
                        @if($featuredArticleResolved)
                        <div class="row justify-content-center">
                            <div class="col-lg-10">


                                <div class="featured-video-card">
                                    <div class="row g-0">
                                        <div class="col-lg-6">
                                            <div class="featured-video-thumbnail">
                                                <a href="{{ route('articles.show', $featuredArticleResolved->slug) }}">
                                                @if($featuredArticleResolved->featured_image_path && file_exists(public_path('storage/' . $featuredArticleResolved->featured_image_path)))
                                                    <img src="{{ asset('storage/' . $featuredArticleResolved->featured_image_path) }}"
                                                         alt="{{ $featuredArticleResolved->title }}" class="img-fluid">
                                                @elseif($featuredArticleResolved->featured_image_url)
                                                    <img src="{{ $featuredArticleResolved->featured_image_url }}"
                                                         alt="{{ $featuredArticleResolved->title }}" class="img-fluid">
                                                @else
                                                    <div class="placeholder-image d-flex align-items-center justify-content-center">
                                                        <i class="fas fa-video fa-3x text-white"></i>
                                                    </div>
                                                @endif
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="featured-video-content">
                                                <div class="video-category-badge">
                                                    <h4> <span class="badge"> À LA UNE </span></h4>

                                                </div>
                                                <h3 class="featured-video-title">
                                                    <a href="{{ route('articles.show', $featuredArticleResolved->slug) }}" class="text-decoration-none text-dark">
                                                        {{ $featuredArticleResolved->title }}
                                                    </a>
                                                </h3>
                                                <p class="featured-video-description">
                                                    {{ Str::limit($featuredArticleResolved->excerpt ?: strip_tags($featuredArticleResolved->content), 150) }}
                                                </p>
                                                <div class="video-meta-info">
                                                    <div class="video-stats">

                                                        <div class="video-stat-item">
                                                            <i class="fas fa-calendar"></i>
                                                            <span>{{ $featuredArticleResolved->created_at->format('d M Y') }}</span>
                                                        </div>


                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </section>







                @else


                <!-- Featured Text Article Section -->
                <section class="featured-article-section py-5">
                    <div class="container">
                        @php
                            // Featured resolution rules:
                            // - Entreprises & Impacts: show explicit featured only (per secteur logic en amont)
                            // - Contributions & Analyses: show explicit featured only
                            // - Portrait d'Entrepreneur: show explicit featured if set, otherwise fallback to first article
                            // - Other categories: fallback to first article
                            if (!empty($isEntreprisesImpacts) && $isEntreprisesImpacts) {
                                $featuredArticleResolved = isset($featuredArticle) && $featuredArticle ? $featuredArticle : null;
                            } elseif (!empty($isContributionsAnalyses) && $isContributionsAnalyses) {
                                $featuredArticleResolved = isset($featuredArticle) && $featuredArticle ? $featuredArticle : null;
                            } elseif (!empty($isPortraitEntrepreneur) && $isPortraitEntrepreneur) {
                                $featuredArticleResolved = isset($featuredArticle) && $featuredArticle ? $featuredArticle : $articles->first();
                            } else {
                                $featuredArticleResolved = $articles->first();
                            }
                        @endphp
                        @if($featuredArticleResolved)
                        <div class="row justify-content-center">
                            <div class="col-lg-10">
                                <div class="featured-article-card shadow-lg">
                                    <div class="row g-0">
                                        <div class="col-lg-6">
                                            <div class="featured-article-image">
                                                <a href="{{ route('articles.show', $featuredArticleResolved->slug) }}" class="d-block h-100">
                                                    @if($featuredArticleResolved->featured_image_path && file_exists(public_path('storage/' . $featuredArticleResolved->featured_image_path)))
                                                        <img src="{{ asset('storage/' . $featuredArticleResolved->featured_image_path) }}"
                                                             alt="{{ $featuredArticleResolved->title }}" class="img-fluid h-100 w-100" style="object-fit: cover;">
                                                    @elseif($featuredArticleResolved->featured_image_url)
                                                        <img src="{{ $featuredArticleResolved->featured_image_url }}"
                                                             alt="{{ $featuredArticleResolved->title }}" class="img-fluid h-100 w-100" style="object-fit: cover;">
                                                    @else
                                                        <div class="placeholder-image bg-light d-flex align-items-center justify-content-center h-100">
                                                            <i class="fas fa-newspaper fa-3x text-muted"></i>
                                                        </div>
                                                    @endif
                                                </a>
                                            </div>
                                        </div>



                                        <div class="col-lg-6">
                                            <div class="featured-article-content p-4">
                                                <div class="article-category-badge mb-3">
                                                    <span class="badge bg-primary">{{ $featuredArticleResolved->category->name ?? 'Article' }}</span>
                                                </div>
                                                <h3 class="featured-article-title mb-3">
                                                    <a href="{{ route('articles.show', $featuredArticleResolved->slug) }}" class="text-decoration-none text-dark">
                                                        {{ $featuredArticleResolved->title }}
                                                    </a>
                                                </h3>
                                                <p class="featured-article-description text-muted mb-4">
                                                    {{ Str::limit($featuredArticleResolved->excerpt ?: strip_tags($featuredArticleResolved->content), 150) }}
                                                </p>
                                                <div class="article-meta-info">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div class="article-stats d-flex gap-3">

                                                            <small class="text-muted">
                                                                <i class="fas fa-calendar me-1"></i>{{ $featuredArticleResolved->created_at->format('d M Y') }}
                                                            </small>

                                                        </div>
                                                        <a href="{{ route('articles.show', $featuredArticleResolved->slug) }}" class="btn btn-outline-primary btn-sm">
                                                            Lire l'article
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </section>
                @endif

                <section class="articles-grid-section fade-in py-5">
                    <div class="container">

                        @php
                            // Determine how many items to skip in the grid to avoid duplicating the featured block
                            // - For Entreprises & Impacts: skip if an explicit featured exists (it's excluded from the list)
                            // - For Contributions & Analyses and Portrait d'Entrepreneur: DO NOT skip; we keep the featured in the list as well
                            // - For other categories: the first item is used as featured fallback -> skip one if list not empty
                            if (!empty($isEntreprisesImpacts) && $isEntreprisesImpacts) {
                                $skipCount = (!empty($featuredArticle) && $featuredArticle) ? 1 : 0;
                            } elseif ((!empty($isContributionsAnalyses) && $isContributionsAnalyses) || (!empty($isPortraitEntrepreneur) && $isPortraitEntrepreneur)) {
                                $skipCount = 0;
                            } else {
                                $skipCount = ($articles->count() > 0) ? 1 : 0;
                            }
                        @endphp

                        <div class="row">
                            <div class="col-12">
                                <div class="text-center mb-5">
                                    <h2 class="h3 mb-3">Tous les articles</h2>
                                    <p class="text-muted">
                                        Découvrez notre collection d'articles sur {{ $category->name }}.
                                    </p>
                                </div>
                            </div>
                        </div>

                         <div class="row g-4">
                            @foreach($articles->skip($skipCount) as $article)
                                @php $articleSector = strtolower(Str::slug($article->sector ?? 'all')); @endphp
                                <div class="col-lg-4 col-md-6" data-article-sector="{{ $articleSector }}">
                                    <article class="card h-100 shadow-sm border-0 article-card {{ $contentType === 'video' ? 'video-card' : 'text-card' }}">
                                        <div class="card-image-container position-relative">
                                            @if($contentType === 'video')
                                                @if($article->featured_image_path && file_exists(public_path('storage/' . $article->featured_image_path)))
                                                    <img src="{{ asset('storage/' . $article->featured_image_path) }}"
                                                         class="card-img-top" alt="{{ $article->title }}" style="width: 100%; height: 500px; object-fit: cover;">
                                                @elseif($article->featured_image_url)
                                                    <img src="{{ $article->featured_image_url }}"
                                                         class="card-img-top" alt="{{ $article->title }}" style="width: 100%; height: 500px; object-fit: cover;">
                                                @else
                                                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 500px;">
                                                        <i class="fas fa-video fa-2x text-muted"></i>
                                                    </div>
                                                @endif
                                                <div class="video-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center">
                                                    <a href="{{ route('articles.show', $article->slug) }}" class="video-play-btn btn btn-light rounded-circle p-3 shadow">
                                                        <i class="fas fa-play text-primary"></i>
                                                    </a>
                                                </div>
                                                {{-- Duration removed as requested --}}
                                            @else
                                                <a href="{{ route('articles.show', $article->slug) }}" class="d-block">
                                                    @if($article->featured_image_path && file_exists(public_path('storage/' . $article->featured_image_path)))
                                                        <img src="{{ asset('storage/' . $article->featured_image_path) }}"
                                                             class="card-img-top" alt="{{ $article->title }}" style="width: 100%; height: 500px; object-fit: cover;">
                                                    @elseif($article->featured_image_url)
                                                        <img src="{{ $article->featured_image_url }}"
                                                             class="card-img-top" alt="{{ $article->title }}" style="width: 100%; height: 500px; object-fit: cover;">
                                                    @else
                                                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 500px;">
                                                            <i class="fas fa-newspaper fa-2x text-muted"></i>
                                                        </div>
                                                    @endif
                                                </a>
                                            @endif
                                        </div>

                                        <div class="card-body d-flex flex-column">
                                            <div class="mb-2 d-flex flex-wrap align-items-center">
                                                <span class="badge {{ $contentType === 'video' ? 'bg-danger' : 'bg-primary' }}">
                                                    <i class="fas fa-{{ $contentType === 'video' ? 'video' : 'newspaper' }} me-1"></i>
                                                    {{ $article->category->name ?? 'Non classé' }}
                                                </span>
                                                @if(!empty($article->sector))
                                                    <span class="badge bg-secondary ms-2">
                                                        <i class="fas fa-tags me-1"></i>{{ ucfirst($article->sector) }}
                                                    </span>
                                                @endif
                                                {{-- Reading time removed as requested --}}
                                            </div>

                                            <h5 class="card-title">
                                                <a href="{{ route('articles.show', $article->slug) }}" class="text-decoration-none text-dark stretched-link">
                                                    {{ Str::limit($article->title, 60) }}
                                                </a>
                                            </h5>

                                            <p class="card-text text-muted flex-grow-1">
                                                {{ Str::limit($article->excerpt ?: strip_tags($article->content), 100) }}
                                            </p>

                                            <div class="mt-auto">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <small class="text-muted">
                                                        <i class="fas fa-calendar me-1"></i>{{ $article->created_at->format('d M Y') }}
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    </article>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        @if($articles->hasPages())
                            <div class="mt-5">
                                {{ $articles->links('vendor.pagination.excellence-pagination') }}
                            </div>
                        @endif
                    </div>
                </section>
            @else
                <!-- Empty State -->
                <section class="video-grid-section fade-in">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 text-center py-5">
                                <i class="fas fa-video fa-5x text-muted mb-4"></i>
                                <h3 class="text-muted">Aucun contenu trouvé</h3>
                                <p class="text-muted mb-4">
                                    Il n'y a pas encore d'articles dans la catégorie "{{ $category->name ?? ucfirst(str_replace('-', ' ', $slug)) }}".
                                </p>

                            </div>
                        </div>
                    </div>
                </section>
            @endif





            <!-- Video Newsletter CTA -->
            <section class="video-newsletter-section fade-in">
                <div class="container">
                    <div class="video-newsletter-card">
                        <div class="row align-items-center">
                            <div class="col-lg-8">
                                <div class="newsletter-content-video">
                                    <div class="newsletter-icon-video">
                                        <i class="fas fa-video"></i>
                                    </div>
                                    <div class="newsletter-text-video">
                                        <h3 class="newsletter-title-video text-white">Ne ratez aucun de nos contenus</h3>
                                        <p class="newsletter-description-video">
                                            Recevez une notification dès qu'un nouvel article, reportage ou interview est publié.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="newsletter-form-video">
                                    <form class="newsletter-form-articles" action="{{ route('newsletter.subscribe') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="source" value="articles">
                                        <div class="input-group-video">
                                            <input type="email" name="email" class="form-control-video" placeholder="Votre email" required>
                                            <button type="submit" class="btn-subscribe-video">
                                                <i class="fas fa-bell"></i>
                                                <span>S'abonner</span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

                </div>
            </div>
        </div>
    </main>
@endsection
