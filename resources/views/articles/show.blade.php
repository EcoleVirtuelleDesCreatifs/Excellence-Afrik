@extends('layouts.app')

@section('title', $article->seo_title ?: $article->title . ' - Excellence Afrik')
@section('meta_description', $article->seo_description ?: $article->excerpt)

@section('content')
<div class="container-fluid px-0">
    <!-- Article Header -->
    <section class="article-header bg-dark text-white py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <!-- Breadcrumb -->
                    <nav aria-label="breadcrumb" class="mb-4">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-warning">Accueil</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('articles.index') }}" class="text-warning">Articles</a></li>
                            @if($article->category)
                                <li class="breadcrumb-item">
                                    <a href="{{ route('articles.category', $article->category->slug) }}" class="text-warning">
                                        {{ $article->category->name }}
                                    </a>
                                </li>
                            @endif
                            <li class="breadcrumb-item active text-light" aria-current="page">{{ Str::limit($article->title, 50) }}</li>
                        </ol>
                    </nav>

                    <!-- Article Meta -->
                    <div class="article-meta mb-4">
                        @if($article->category)
                            <span class="badge bg-warning text-dark me-3">{{ $article->category->name }}</span>
                        @endif


                        <span class="text-muted-white">
                            <i class="fas fa-calendar text-muted-white"></i> {{ $article->created_at->format('d M Y') }}
                        </span>
                    </div>

                    <!-- Article Title -->
                    <h1 class="display-4 fw-bold text-warning mb-3">{{ $article->title }}</h1>

                    @if($article->subtitle)
                        <p class="lead text-light mb-4">{{ $article->subtitle }}</p>
                    @endif


                </div>
            </div>
        </div>
    </section>




    <!-- Main Content -->
<main class="container">
    <div class="row justify-content-center">
        <div class="col-10">

            <!-- Positioning Section -->
            <section class="positioning-section fade-in">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="positioning-content">


                                <p class="section-description">
                                    {!! $article->content !!}
                                </p>

                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="positioning-visual">
                                <!-- Featured Image -->
                                @if($article->featured_image_path && file_exists(public_path('storage/' . $article->featured_image_path)))


                                    <div class="featured-image">
                                        <img src="{{ asset('storage/' . $article->featured_image_path) }}"
                                             class="img-fluid rounded"
                                             alt="{{ $article->featured_image_alt ?: $article->title }}"
                                             style="width: 100%; height: auto;">
                                    </div>
                                @elseif($article->featured_image_url)
                                    <div class="featured-image">
                                        <img src="{{ $article->featured_image_url }}"
                                             class="img-fluid rounded"
                                             alt="{{ $article->featured_image_alt ?: $article->title }}"
                                             style="width: 100%; height: auto;">
                                    </div>
                                @endif


                            </div>
                        </div>


                    </div>
                </div>
            </section>

        </div>
    </div>
</main>





























<style>
.article-header {
    background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
}

.breadcrumb-item + .breadcrumb-item::before {
    color: #ffc107;
}

.article-body {
    font-size: 1.1rem;
    line-height: 1.8;
    color: #333;
}

.article-body h2,
.article-body h3,
.article-body h4 {
    color: #D4AF37;
    margin-top: 2rem;
    margin-bottom: 1rem;
}

.article-body p {
    margin-bottom: 1.5rem;
}

.article-body blockquote {
    border-left: 4px solid #D4AF37;
    padding-left: 1.5rem;
    margin: 2rem 0;
    font-style: italic;
    color: #666;
}

.article-body img {
    max-width: 100%;
    height: auto;
    border-radius: 0.5rem;
    margin: 1.5rem 0;
}

.related-article-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.related-article-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
}

.social-share .btn {
    transition: all 0.3s ease;
}

.social-share .btn:hover {
    transform: translateY(-2px);
}
</style>
@endsection

@push('head')
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'Article',
    'headline' => $article->title,
    'description' => $article->excerpt ?: 'Article publié sur Excellence Afrik',
    'author' => [
        '@type' => 'Person',
        'name' => $article->user->name ?? 'Excellence Afrik'
    ],
    'publisher' => [
        '@type' => 'Organization',
        'name' => 'Excellence Afrik',
        'logo' => [
            '@type' => 'ImageObject',
            'url' => asset('assets/images/logo.png')
        ]
    ],
    'datePublished' => $article->created_at->toISOString(),
    'dateModified' => $article->updated_at->toISOString(),
    'image' => ($article->featured_image_path ? asset('storage/' . $article->featured_image_path) : ($article->featured_image_url ?: asset('assets/images/default-article.jpg'))),
    'mainEntityOfPage' => [
        '@type' => 'WebPage',
        '@id' => request()->url()
    ]
], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>
@endpush
