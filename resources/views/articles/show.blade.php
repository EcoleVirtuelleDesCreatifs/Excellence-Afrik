@extends('layouts.app')

@section('title', $article->seo_title ?: $article->title . ' - Excellence Afrik')
@section('meta_description', $article->seo_description ?: $article->excerpt)

@section('content')
@push('styles')
<style>
    .article-content p,
    .article-content p span {
        font-family: 'Poppins', sans-serif !important;
        font-size: 18px !important;
        color: #ffffff !important;
        background-color: transparent !important; /* Ensure no background color is applied from the editor */
        text-align: justify !important;
    }
    .article-content p {
        margin-bottom: 1.5em;
    }
</style>
@endpush

<main class="py-5">
    <div class="container">
        <div class="row">
            <!-- Colonne principale de l'article -->
            <div class="col-lg-8">
                <article>
                    <!-- En-tête de l'article -->
                    <header class="mb-4">
                        <h1 class="fw-bolder mb-1">{{ $article->title }}</h1>
                        <div class="text-muted fst-italic mb-2">Posté le {{ $article->created_at->translatedFormat('d F Y') }} par {{ $article->user->name ?? 'Admin' }}</div>
                        @if($article->category)
                            <a class="badge bg-secondary text-decoration-none link-light" href="{{ route('articles.category', $article->category->slug) }}">{{ $article->category->name }}</a>
                        @endif
                    </header>

                    <!-- Image à la une -->
                    <figure class="mb-4">
                        @if($article->featured_image_path)
                            <img class="img-fluid rounded" src="{{ $article->featured_image_path ? (app()->environment('production') ? asset('uploads/' . $article->featured_image_path) : asset('storage/' . $article->featured_image_path)) : asset('assets/images/default-article.jpg') }}" alt="{{ $article->title }}" />
                        @else
                            <img class="img-fluid rounded" src="{{ asset('assets/default/image_default.jpg') }}" alt="{{ $article->title }}" />
                        @endif
                    </figure>

                    <!-- Contenu de l'article -->
                    <section class="mb-5 article-content">
                        {!! $article->content !!}
                    </section>
                </article>

                <!-- Section de partage social redessinée -->
                <div class="share-section-wrapper my-5">
                    <h4 class="share-title">Partager cet article</h4>
                    <div class="share-buttons-grid">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank" class="share-button facebook">
                            <i class="fab fa-facebook-f"></i>
                            <span>Facebook</span>
                        </a>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($article->title) }}" target="_blank" class="share-button twitter">
                            <i class="fab fa-twitter"></i>
                            <span>Twitter</span>
                        </a>
                        <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(request()->url()) }}" target="_blank" class="share-button linkedin">
                            <i class="fab fa-linkedin-in"></i>
                            <span>LinkedIn</span>
                        </a>
                        <a href="https://wa.me/?text={{ urlencode($article->title . ' ' . request()->url()) }}" target="_blank" class="share-button whatsapp">
                            <i class="fab fa-whatsapp"></i>
                            <span>WhatsApp</span>
                        </a>
                    </div>
                    <div class="copy-link-wrapper mt-3">
                        <input type="text" id="shareableLink" class="form-control" value="{{ request()->url() }}" readonly>
                        <button class="btn btn-outline-secondary" id="copyLinkBtn" type="button">Copier</button>
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
                                <div class="flex-shrink-0 me-3" style="padding-right: 1rem">
                                     <a href="{{ route('articles.show', $related->slug) }}">
                                         <img src="{{ $related->featured_image_path ? (app()->environment('production') ? asset('uploads/' . $related->featured_image_path) : asset('storage/' . $related->featured_image_path)) : 'https://via.placeholder.com/80' }}" alt="{{ $related->title }}" class="img-fluid rounded" style="width: 80px; height: 80px; object-fit: cover;">
                                     </a>
                                 </div>
                                <div>
                                    <h5 class="mb-1" style="font-size: 1rem;"><a href="{{ route('articles.show', $related->slug) }}" class="text-dark text-decoration-none">{{ $related->title }}</a></h5>
                                    <div class="text-muted" style="font-size: 0.8rem;">{{ $related->created_at->translatedFormat('d F Y') }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Dynamic Sibling Categories Widget -->
                @if($sidebarCategories->count() > 0)
                    @foreach($sidebarCategories as $category)
                        @if($category->articles->count() > 0)
                            <div class="card mb-4">
                                <div class="card-header">{{ $category->name }}</div>
                                <div class="card-body">
                                    @foreach($category->articles as $articleItem)
                                        <div class="d-flex mb-3 sidebar-article-card">
                                            <div class="flex-shrink-0 me-3">
                                                <a href="{{ route('articles.show', $articleItem->slug) }}">
                                                    <img src="{{ $articleItem->featured_image_path ? (app()->environment('production') ? asset('uploads/' . $articleItem->featured_image_path) : asset('storage/' . $articleItem->featured_image_path)) : 'https://via.placeholder.com/80' }}" alt="{{ $articleItem->title }}" class="img-fluid rounded" style="width: 80px; height: 80px; object-fit: cover;">
                                                </a>
                                            </div>
                                            <div>
                                                <h5 class="mb-1" style="font-size: 1rem;"><a href="{{ route('articles.show', $articleItem->slug) }}" class="text-dark text-decoration-none">{{ $articleItem->title }}</a></h5>
                                                <div class="text-muted" style="font-size: 0.8rem;">{{ $articleItem->created_at->translatedFormat('d F Y') }}</div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endforeach
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
        color: #000000;
        line-height: 1.2;
        font-weight: 700;
        text-transform: uppercase;
    }

    @media (max-width: 768px) {
        /* Responsive Article Title */
        article header .fw-bolder {
            font-size: 1.5rem; /* Further reduce font size for mobile */
            line-height: 1.3; /* Adjust line height for wrapped text */
            text-align: center; /* Center the title */
        }

        /* Responsive Article Content */
        .article-content p,
        .article-content p span {
            font-size: 16px !important; /* Slightly smaller font for mobile readability */
        }

        /* Responsive Share Buttons */
        .share-buttons-grid {
            grid-template-columns: repeat(2, 1fr); /* 2 columns on mobile */
        }

        /* Responsive Sidebar */
        .sidebar-article-card h5 a {
            font-size: 0.9rem;
        }
    }
    article header .text-muted {
        color: #ffffff !important;
    }

    /* Nouvelle section de partage */
    .share-section-wrapper {
        background-color: #f1f1f1;
        border-radius: 12px;
        padding: 2rem;
        text-align: center;
        border: 1px solid #e0e0e0;
    }
    .share-title {
        font-weight: 700;
        color: #000;
        margin-bottom: 1.5rem;
    }
    .share-buttons-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
        gap: 1rem;
    }
    .share-button {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 1rem;
        border-radius: 8px;
        text-decoration: none;
        color: white;
        font-weight: 500;
        font-size: 0.9rem;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .share-button:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        color: white;
    }
    .share-button i {
        font-size: 1.5rem;
        margin-bottom: 0.5rem;
    }
    .share-button.facebook { background-color: #1877F2; }
    .share-button.twitter { background-color: #1DA1F2; }
    .share-button.linkedin { background-color: #0A66C2; }
    .share-button.whatsapp { background-color: #25D366; }

    .copy-link-wrapper {
        display: flex;
    }
    .copy-link-wrapper .form-control {
        border-right: 0;
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
        background-color: #fff;
    }
    .copy-link-wrapper .btn {
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const copyBtn = document.getElementById('copyLinkBtn');
    const linkInput = document.getElementById('shareableLink');

    if(copyBtn && linkInput) {
        copyBtn.addEventListener('click', function() {
            linkInput.select();
            document.execCommand('copy');
            this.textContent = 'Copié!';
            setTimeout(() => {
                this.textContent = 'Copier';
            }, 2000);
        });
    }
});
</script>
@endpush

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
    'image' => ($article->featured_image_path ? ($article->featured_image_path ? (app()->environment('production') ? asset('uploads/' . $article->featured_image_path) : asset('storage/' . $article->featured_image_path)) : asset('assets/images/default-article.jpg')) : ($article->featured_image_url ?: asset('assets/images/default-article.jpg'))),
    'mainEntityOfPage' => [
        '@type' => 'WebPage',
        '@id' => request()->url()
    ]
], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>
@endpush


@endsection
