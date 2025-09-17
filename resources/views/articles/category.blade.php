@extends('layouts.app')

@section('title', ($category->name ?? 'Catégorie') . ' - Excellence Afrik')
@section('meta_description', $category->description ?? 'Articles de la catégorie ' . ($category->name ?? ''))

@php
    $isVideoCategory = in_array($category->slug, ['grands-genres', 'webtv', 'documentaires', 'interviews', 'reportages']);
@endphp

@push('styles')
<style>
    .page-title-bar {
        background: linear-gradient(to right, #996633, #f7c807);
    }
    .page-title-bar h1 {
        color: #fff;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
    }
    .category-description {
        font-size: 1.2rem;
        color: #666;
        max-width: 800px;
        margin: 0 auto 50px auto;
        text-align: center;
    }
    .filter-tabs {
        display: flex;
        justify-content: center;
        gap: 15px;
        margin-bottom: 50px;
        flex-wrap: wrap;
    }
    .filter-tab {
        padding: 10px 25px;
        border: 2px solid #ddd;
        border-radius: 50px;
        color: #333;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .filter-tab:hover {
        background-color: #f0f0f0 !important;
        border-color: #ccc !important;
        color: #333 !important; /* Assurer que le texte reste lisible */
    }
    .filter-tab.active {
        background-color: #D4AF37;
        border-color: #D4AF37;
        color: #fff;
    }
    .article-card-v2 {
        background: #fff;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0,0,0,0.07);
        transition: transform 0.3s, box-shadow 0.3s;
        height: 100%;
    }
    .article-card-v2:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1);
    }
    .article-card-v2__thumb {
        position: relative;
    }
    .article-card-v2__thumb img {
        width: 100%;
        height: 320px;
        object-fit: cover;
    }
    .article-card-v2__thumb .play-icon {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 60px;
        height: 60px;
        background: rgba(255,255,255,0.8);
        color: #D4AF37;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        transition: all 0.3s ease;
    }
    .article-card-v2:hover .play-icon {
        background: #D4AF37;
        color: #fff;
    }
    .article-card-v2__content {
        padding: 20px;
    }
    .article-card-v2__category {
        display: inline-block;
        background: #f8f9fa;
        color: #666;
        padding: 3px 12px;
        border-radius: 50px;
        font-size: 0.8rem;
        font-weight: 600;
        margin-bottom: 10px;
        text-transform: uppercase;
    }
    .article-card-v2__title {
        font-size: 1.2rem;
        font-weight: 600;
        margin-bottom: 15px;
        line-height: 1.4;
    }
    .article-card-v2__title a {
        color: #333;
        text-decoration: none;
    }
    .article-card-v2__meta {
        font-size: 0.9rem;
        color: #888;
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
                        <h1>{{ $category->name ?? 'Catégorie' }}</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="py-5">
        <div class="container">
            @php
                $categoriesWithFilters = ['grands-genres', 'entreprises-impacts', 'figures-de-leconomie'];
            @endphp

            @if($category->slug === 'grands-genres')
                 <div class="row justify-content-center">
                    <div class="col-lg-8 text-center">
                      <h2 class="fw-bold" style="font-weight: 700 !important; margin-bottom: 2rem;">THÉMATIQUES</h2>
                    </div>
                </div>
            @elseif($category->slug === 'entreprises-impacts' || $category->slug === 'figures-de-leconomie')
                 <div class="row justify-content-center">
                    <div class="col-lg-8 text-center">
                      <h2 class="fw-bold" style="font-weight: 700 !important; margin-bottom: 2rem;">SECTEURS</h2>
                    </div>
                </div>

            @endif

            <!-- Filters -->
            @if($isVideoCategory && $category->slug === 'grands-genres')
                <div class="filter-tabs">
                    @php $currentTheme = strtolower($theme ?? ''); @endphp
                    <a class="filter-tab {{ $currentTheme === '' ? 'active' : '' }}" href="{{ route('articles.category', ['slug' => $category->slug]) }}">
                        <i class="fas fa-th-large"></i>
                        <span>Tous</span>
                    </a>
                    <a class="filter-tab {{ $currentTheme === 'reportages' ? 'active' : '' }}" href="{{ route('articles.category', ['slug' => $category->slug, 'theme' => 'reportages']) }}">
                        <i class="fas fa-camera"></i>
                        <span>Reportages</span>
                    </a>
                    <a class="filter-tab {{ $currentTheme === 'interviews' ? 'active' : '' }}" href="{{ route('articles.category', ['slug' => $category->slug, 'theme' => 'interviews']) }}">
                        <i class="fas fa-microphone"></i>
                        <span>Interviews</span>
                    </a>
                    <a class="filter-tab {{ $currentTheme === 'documentaires' ? 'active' : '' }}" href="{{ route('articles.category', ['slug' => $category->slug, 'theme' => 'documentaires']) }}">
                        <i class="fas fa-film"></i>
                        <span>Documentaires</span>
                    </a>
                    <a class="filter-tab {{ $currentTheme === 'temoignages' ? 'active' : '' }}" href="{{ route('articles.category', ['slug' => $category->slug, 'theme' => 'temoignages']) }}">
                        <i class="fas fa-quote-left"></i>
                        <span>Témoignages</span>
                    </a>
                </div>
            @elseif(($category->slug === 'entreprises-impacts' || $category->slug === 'figures-de-leconomie') && $category->slug !== 'contributions-analyses')
                <div class="filter-tabs">
                     @php $currentSector = strtolower($sector ?? ''); @endphp
                    <a href="{{ route('articles.category', $category->slug) }}" class="filter-tab {{ $currentSector === '' ? 'active' : '' }}">
                        <i class="fas fa-th-large"></i>
                        <span>Tous les secteurs</span>
                    </a>
                    <a href="{{ route('articles.category', ['slug' => $category->slug, 'sector' => 'agriculture']) }}" class="filter-tab {{ $currentSector === 'agriculture' ? 'active' : '' }}">
                        <i class="fas fa-leaf"></i>
                        <span>Agriculture</span>
                    </a>
                    <a href="{{ route('articles.category', ['slug' => $category->slug, 'sector' => 'technologie']) }}" class="filter-tab {{ $currentSector === 'technologie' ? 'active' : '' }}">
                        <i class="fas fa-microchip"></i>
                        <span>Technologie</span>
                    </a>
                    <a href="{{ route('articles.category', ['slug' => $category->slug, 'sector' => 'industrie']) }}" class="filter-tab {{ $currentSector === 'industrie' ? 'active' : '' }}">
                        <i class="fas fa-industry"></i>
                        <span>Industrie</span>
                    </a>
                    <a href="{{ route('articles.category', ['slug' => $category->slug, 'sector' => 'services']) }}" class="filter-tab {{ $currentSector === 'services' ? 'active' : '' }}">
                        <i class="fas fa-concierge-bell"></i>
                        <span>Services</span>
                    </a>
                    <a href="{{ route('articles.category', ['slug' => $category->slug, 'sector' => 'energie']) }}" class="filter-tab {{ $currentSector === 'energie' ? 'active' : '' }}">
                        <i class="fas fa-bolt"></i>
                        <span>Énergie</span>
                    </a>
                </div>
            @endif

            <!-- Articles Grid -->
            <div class="row">
                @forelse($articles as $article)
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="article-card-v2">
                            <div class="article-card-v2__thumb">
                                <a href="{{ route('articles.show', $article->slug) }}">
                                    @if($article->featured_image_path)
                                        <img src="{{ app()->environment('production') ? asset('uploads/' . $article->featured_image_path) : asset('storage/' . $article->featured_image_path) }}" alt="{{ $article->title }}">
                                    @elseif($article->featured_image_url)
                                        <img src="{{ $article->featured_image_url }}" alt="{{ $article->title }}">
                                    @else
                                        <img src="{{ asset('assets/default/image_default.jpg') }}" alt="Image par défaut">
                                    @endif
                                </a>
                                @if($isVideoCategory)
                                    <a href="{{ route('articles.show', $article->slug) }}" class="play-icon">
                                        <i class="fas fa-play"></i>
                                    </a>
                                @endif
                            </div>
                            <div class="article-card-v2__content">
                                <a href="{{ route('articles.category', $article->category->slug) }}" class="article-card-v2__category">{{ $article->category->name }}</a>
                                <h3 class="article-card-v2__title">
                                    <a href="{{ route('articles.show', $article->slug) }}">{{ $article->title }}</a>
                                </h3>
                                <div class="article-card-v2__meta">
                                    <span>Par {{ $article->author->name ?? 'Admin' }}</span> |
                                    <span>{{ $article->created_at->translatedFormat('d F Y') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <i class="fas fa-newspaper fa-4x text-white mb-4"></i>
                        <h3 class="text-white">Aucun article trouvé</h3>
                        <p class="text-white">Il n'y a pas encore de contenu dans cette catégorie.</p>
                    </div>
                @endforelse
            </div>

            <!-- DEBUG: Total articles -->
            <p class="text-center fw-bold">Total des articles trouvés : {{ $articles->total() }}</p>

            <!-- Pagination -->
            @if($articles->hasPages())
                <div class="mt-5">
                    {{ $articles->links('vendor.pagination.excellence-pagination') }}
                </div>
            @endif
        </div>
    </section>
</main>
@endsection
