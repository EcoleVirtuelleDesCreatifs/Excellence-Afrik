@extends('layouts.app')

@section('title', $article->seo_title ?: $article->title . ' - Excellence Afrik')
@section('meta_description', $article->seo_description ?: $article->excerpt)

@section('content')
<main class="py-5">
    <div class="container">
        <div class="row">
            <!-- Colonne principale de l'article -->
            <div class="col-lg-8">
                <article>
                    <!-- En-tête de l'article -->
                    <header class="mb-4">
                        <h1 class="fw-bolder mb-1">{{ $article->title }}</h1>
                        <div class="text-muted fst-italic mb-2">Posté le {{ $article->created_at->format('d F Y') }} par {{ $article->user->name ?? 'Admin' }}</div>
                        @if($article->category)
                            <a class="badge bg-secondary text-decoration-none link-light" href="{{ route('articles.category', $article->category->slug) }}">{{ $article->category->name }}</a>
                        @endif
                    </header>

                    <!-- Image à la une -->
                    <figure class="mb-4">
                        @if($article->featured_image_path)
                            <img class="img-fluid rounded" src="{{ asset('storage/' . $article->featured_image_path) }}" alt="{{ $article->title }}" />
                        @endif
                    </figure>

                    <!-- Contenu de l'article -->
                    <section class="mb-5 article-content">
                        {!! $article->content !!}
                    </section>
                </article>

                <!-- Section de partage social -->
                <div class="text-center my-5">
                    <h4 class="mb-3">Partager cet article</h4>
                    <div class="social-share">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank" class="btn btn-primary btn-lg mx-2"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($article->title) }}" target="_blank" class="btn btn-info btn-lg mx-2 text-white"><i class="fab fa-twitter"></i></a>
                        <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(request()->url()) }}" target="_blank" class="btn btn-secondary btn-lg mx-2"><i class="fab fa-linkedin-in"></i></a>
                        <a href="https://wa.me/?text={{ urlencode($article->title . ' ' . request()->url()) }}" target="_blank" class="btn btn-success btn-lg mx-2"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>

            </div>

            <!-- Barre latérale -->
            <div class="col-lg-4">
                <!-- Widget de recherche -->
                <div class="card mb-4">
                    <div class="card-header">Recherche</div>
                    <div class="card-body">
                        <div class="input-group">
                            <input class="form-control" type="text" placeholder="Entrez un terme..." aria-label="Entrez un terme..." aria-describedby="button-search" />
                            <button class="btn btn-primary" id="button-search" type="button">Go!</button>
                        </div>
                    </div>
                </div>

                <!-- Widget d'articles similaires -->
                @if($relatedArticles->count() > 0)
                <div class="card mb-4">
                    <div class="card-header">À lire aussi</div>
                    <div class="card-body">
                        @foreach($relatedArticles as $related)
                            <div class="d-flex mb-3 sidebar-article-card">
                                <div class="flex-shrink-0">
                                    <a href="{{ route('articles.show', $related->slug) }}">
                                        <img src="{{ $related->featured_image_path ? asset('storage/' . $related->featured_image_path) : 'https://via.placeholder.com/80' }}" alt="{{ $related->title }}" class="img-fluid rounded" style="width: 80px; height: 80px; object-fit: cover;">
                                    </a>
                                </div>
                                <div class="ms-3">
                                    <h5 class="mb-1" style="font-size: 1rem;"><a href="{{ route('articles.show', $related->slug) }}" class="text-dark text-decoration-none">{{ $related->title }}</a></h5>
                                    <div class="text-muted" style="font-size: 0.8rem;">{{ $related->created_at->format('d M Y') }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

            </div>
        </div>
    </div>
</main>

@push('styles')
<style>
    /* Style général de la page */
    body {
        background-color: #f8f9fa;
    }

    /* Contenu de l'article */
    .article-content {
        font-family: 'Georgia', serif;
        font-size: 1.15rem;
        line-height: 1.8;
        color: #333;
    }
    .article-content p {
        margin-bottom: 1.75rem;
    }
    .article-content h2, .article-content h3, .article-content h4 {
        font-family: 'Montserrat', sans-serif;
        font-weight: 700;
        margin-top: 2.5rem;
        margin-bottom: 1.5rem;
        color: #222;
    }
    .article-content a {
        color: #c1933e;
        text-decoration: none;
        border-bottom: 1px dotted #c1933e;
        transition: all 0.3s ease;
    }
    .article-content a:hover {
        color: #fff;
        background-color: #c1933e;
        border-bottom-color: #c1933e;
    }
    .article-content blockquote {
        border-left: 3px solid #c1933e;
        padding-left: 1.5rem;
        margin: 2rem 0;
        font-style: italic;
        color: #666;
        background-color: #fdfdfd;
        padding-top: 1rem;
        padding-bottom: 1rem;
    }

    /* Barre latérale */
    .card {
        border: none;
        box-shadow: 0 5px 25px rgba(0,0,0,0.05);
    }
    .card-header {
        background-color: #1a1a1a;
        color: #fff;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-size: 0.9rem;
        border-bottom: 2px solid #c1933e;
    }
    .sidebar-article-card:hover h5 a {
        color: #c1933e;
    }

    /* Boutons de partage */
    .social-share .btn {
        border-radius: 50%;
        width: 50px;
        height: 50px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }
    .social-share .btn:hover {
        transform: translateY(-3px) scale(1.1);
        box-shadow: 0 10px 20px rgba(0,0,0,0.15);
    }

    /* Titre de l'article */
    article header .fw-bolder {
        color: #c1933e;
    }
</style>
@endpush
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
