@extends('layouts.app')

@section('title', 'Excellence Afrik — Actualités Économiques & Entrepreneuriat')
@section('meta_description', 'Excellence Afrik - Votre source d\'information sur l\'économie, l\'entrepreneuriat et l\'investissement en Afrique')

@section('content')
<!-- Main Content -->
<main class="container my-5">
    <div class="row justify-content-center">
        <div class="col-10">

            <!-- WEB TV - Ultra Modern Revolutionary Design -->
            <section class="webtv-ultra-section fade-in">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-10">

                            <!-- Hero Header -->
                            <div class="webtv-hero-header text-center">
                                <div class="hero-badge-webtv">
                                    <div class="badge-dot-webtv"></div>
                                    <span class="badge-text-webtv">En Direct</span>
                                </div>
                                <h2 class="webtv-hero-title">
                                    <span class="title-line-webtv">WEB</span>
                                    <span class="title-separator-webtv">•</span>
                                    <span class="title-line-webtv title-accent-webtv">TV</span>
                                </h2>
                                <div class="hero-subtitle-webtv">
                                    <span class="subtitle-item-webtv">Actualités Live</span>
                                    <span class="subtitle-separator-webtv">•</span>
                                    <span class="subtitle-item-webtv">Débats Exclusifs</span>
                                    <span class="subtitle-separator-webtv">•</span>
                                    <span class="subtitle-item-webtv">Interviews</span>
                                </div>
                            </div>

                            <!-- Featured Video Block (dynamic) -->
                            @php
                                $fw = $featuredWebtv ?? null;
                                $fwTitre = $fw?->titre ?? "Programme à l'affiche";
                                $fwCategorie = $fw?->categorie ? ucfirst($fw->categorie) : 'WebTV';
                                $fwDesc = $fw?->description ? Str::limit(strip_tags($fw->description), 140) : "Découvrez nos programmes exclusifs en direct et en replay.";
                                $fwDate = $fw?->date_programmee_formatee ?? "Aujourd'hui";
                                $fwIsLive = $fw?->statut === 'en_direct';
                                $fwVid = $fw && !empty($fw->vimeo_event_id) ? $fw->vimeo_event_id : ($fw && !empty($fw->video_id) ? $fw->video_id : null);
                                $fwPlaceholder = 'https://images.unsplash.com/photo-1611224923853-80b023f02d71?w=800&h=450&fit=crop';
                            @endphp
                            @if($fw)
                            <div class="webtv-featured-block">
                                <div class="featured-video-container">
                                    <div class="featured-video-wrapper" style="position:relative; overflow:hidden; border-radius:14px; aspect-ratio:16/9; background:#000;">
                                        <img src="{{ $fwPlaceholder }}" alt="{{ $fwTitre }}" class="featured-video-thumbnail" @if($fwVid) data-vimeo-id="{{ $fwVid }}" @endif style="width:100%; height:100%; object-fit:cover; display:block;">
                                        <div class="video-overlay">
                                            <div class="video-play-button watch-btn" role="button" tabindex="0" aria-label="Lire" data-embed-container-id="embed-src-{{ $fw->id }}">
                                                <i class="fas fa-play"></i>
                                            </div>
                                            @if($fwIsLive)
                                            <div class="video-live-indicator">
                                                <div class="live-dot"></div>
                                                <span>EN DIRECT</span>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="featured-video-info">
                                        <div class="video-category-badge">{{ $fwCategorie }}</div>
                                        <h3 class="featured-video-title">{{ $fwTitre }}</h3>
                                        <p class="featured-video-description">{{ $fwDesc }}</p>
                                        <div class="video-metadata">
                                            <div class="video-stats">
                                                <span class="stat-item"><i class="fas fa-calendar"></i><span>{{ $fwDate }}</span></span>
                                            </div>
                                            <div class="video-actions">
                                                <button class="action-btn-webtv watch-btn" data-embed-container-id="embed-src-{{ $fw->id }}">
                                                    <i class="fas fa-play"></i>
                                                    <span>Regarder</span>
                                                </button>
                                                <a class="action-btn-webtv share-btn" href="{{ route('webtv.index') }}">
                                                    <i class="fas fa-share-alt"></i>
                                                    <span>Voir la WebTV</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- Newsletter CTA -->
                            <div class="webtv-newsletter-cta">
                                <div class="newsletter-content-webtv">
                                    <div class="newsletter-icon-webtv">
                                        <i class="fas fa-bell"></i>
                                    </div>
                                    <div class="newsletter-text-webtv">
                                        <h5>Ne manquez aucune émission</h5>
                                        <p>Recevez les notifications de nos programmes en direct</p>
                                    </div>
                                    <button class="newsletter-btn-webtv">
                                        <i class="fas fa-plus"></i>
                                        <span>S'abonner</span>
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </section>

            {{-- Modal lecteur vidéo (réutilise Bootstrap) --}}
            <div class="modal fade" id="webtvPlayerModalHome" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-xl">
                    <div class="modal-content bg-black">
                        <div class="modal-body p-0 position-relative">
                            <button type="button" class="btn-close btn-close-white position-absolute" style="right:12px; top:12px; z-index:3;" data-bs-dismiss="modal" aria-label="Fermer"></button>
                            <div class="ratio ratio-16x9">
                                <iframe id="webtvPlayerIframeHome" src="" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen frameborder="0"></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @push('scripts')
            <script>
            document.addEventListener('DOMContentLoaded', function(){
              // Load Vimeo thumbnail for featured
              const img = document.querySelector('.webtv-featured-block img[data-vimeo-id]');
              if (img) {
                const id = img.getAttribute('data-vimeo-id');
                fetch(`https://vimeo.com/api/oembed.json?url=${encodeURIComponent('https://vimeo.com/' + id)}`)
                  .then(r => r.ok ? r.json() : Promise.reject())
                  .then(d => { if(d.thumbnail_url){ img.src = d.thumbnail_url.replace(/_[0-9x]+\.jpg$/i,'_1280.jpg'); } })
                  .catch(()=>{});
              }
              // Wire play buttons
              const modalEl = document.getElementById('webtvPlayerModalHome');
              const iframe = document.getElementById('webtvPlayerIframeHome');
              document.querySelectorAll('.webtv-featured-block .watch-btn[data-embed-container-id]').forEach(btn => {
                btn.addEventListener('click', () => {
                  const containerId = btn.getAttribute('data-embed-container-id');
                  const id = containerId?.replace('embed-src-','');
                  if (!id) return;
                  // We don't have the Vimeo numeric id here reliably; fallback to using data attribute on image if present
                  const vimeoId = img?.getAttribute('data-vimeo-id');
                  if (!vimeoId) return;
                  iframe.src = `https://player.vimeo.com/video/${vimeoId}?autoplay=1&muted=0`;
                  const modal = new bootstrap.Modal(modalEl);
                  modal.show();
                });
              });
              modalEl?.addEventListener('hidden.bs.modal', () => { iframe.src = ''; });
            });
            </script>
            @endpush

            <!-- Actualité du jour - Modern Revolutionary Design -->
            <section class="daily-modern mb-5 fade-in">
                <!-- Modern Header -->
                <div class="daily-header mb-4">
                    <div class="daily-title-wrapper">
                        <h2 class="daily-title">Actualité du Jour</h2>
                        <div class="daily-accent-line"></div>
                    </div>
                    <p class="daily-subtitle">Les dernières nouvelles qui façonnent l'Afrique</p>
                </div>

                @if($dailyNews->count() > 0)
                    <!-- Featured News Layout -->
                    <div class="daily-featured mb-4">
                        <div class="row g-0">
                            <div class="col-lg-7">
                                @php $mainArticle = $dailyNews->first(); @endphp
                                <div class="daily-main-story">
                                    <div class="daily-main-image">
                                        @if($mainArticle->featured_image_path && file_exists(public_path('storage/' . $mainArticle->featured_image_path)))
                                            <img src="{{ asset('storage/' . $mainArticle->featured_image_path) }}"
                                                alt="{{ $mainArticle->featured_image_alt ?: $mainArticle->title }}">
                                        @elseif($mainArticle->featured_image_url)
                                            <img src="{{ $mainArticle->featured_image_url }}"
                                                alt="{{ $mainArticle->featured_image_alt ?: $mainArticle->title }}">
                                        @else
                                            <img src="{{ asset('assets/images/default-article.jpg') }}"
                                                alt="{{ $mainArticle->featured_image_alt ?: $mainArticle->title }}">
                                        @endif
                                        <div class="daily-main-category">{{ $mainArticle->category->name }}</div>
                                    </div>
                                    <div class="daily-main-content">
                                        <h3 class="daily-main-title">
                                            <a href="{{ route('articles.show', $mainArticle->slug) }}" class="text-decoration-none text-dark">
                                                {{ $mainArticle->title }}
                                            </a>
                                        </h3>
                                        <p class="daily-main-excerpt">{{ $mainArticle->excerpt ?: Str::limit(strip_tags($mainArticle->content), 150) }}</p>
                                        <div class="daily-main-meta">
                                            <span class="daily-main-time">{{ $mainArticle->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <div class="daily-side-stories">
                                    @foreach($dailyNews->skip(1)->take(2) as $article)
                                    <div class="daily-side-story">
                                        <div class="daily-side-image">
                                            @if($article->featured_image_path && file_exists(public_path('storage/' . $article->featured_image_path)))
                                                <img src="{{ asset('storage/' . $article->featured_image_path) }}"
                                                    alt="{{ $article->featured_image_alt ?: $article->title }}">
                                            @elseif($article->featured_image_url)
                                                <img src="{{ $article->featured_image_url }}"
                                                    alt="{{ $article->featured_image_alt ?: $article->title }}">
                                            @else
                                                <img src="{{ asset('assets/images/default-article.jpg') }}"
                                                    alt="{{ $article->featured_image_alt ?: $article->title }}">
                                            @endif
                                        </div>
                                        <div class="daily-side-content">
                                            <div class="daily-side-category daily-category-agriculture">{{ $article->category->name }}</div>
                                            <h4 class="daily-side-title">
                                                <a href="{{ route('articles.show', $article->slug) }}" class="text-decoration-none text-dark">
                                                    {{ Str::limit($article->title, 60) }}
                                                </a>
                                            </h4>
                                            <div class="daily-side-time">{{ $article->created_at->diffForHumans() }}</div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Latest News Grid -->
                    <div class="daily-grid">
                        @foreach($dailyNews->skip(3) as $article)
                        <div class="daily-grid-item">
                            <div class="daily-grid-image">
                                @if($article->featured_image_path && file_exists(public_path('storage/' . $article->featured_image_path)))
                                    <img src="{{ asset('storage/' . $article->featured_image_path) }}"
                                        alt="{{ $article->featured_image_alt ?: $article->title }}">
                                @elseif($article->featured_image_url)
                                    <img src="{{ $article->featured_image_url }}"
                                        alt="{{ $article->featured_image_alt ?: $article->title }}">
                                @else
                                    <img src="{{ asset('assets/images/default-article.jpg') }}"
                                        alt="{{ $article->featured_image_alt ?: $article->title }}">
                                @endif
                            </div>
                            <div class="daily-grid-content">
                                <div class="daily-grid-category daily-category-education">{{ $article->category->name }}</div>
                                <h4 class="daily-grid-title">
                                    <a href="{{ route('articles.show', $article->slug) }}" class="text-decoration-none text-dark">
                                        {{ Str::limit($article->title, 80) }}
                                    </a>
                                </h4>
                                <p class="daily-grid-excerpt">{{ $article->excerpt ?: Str::limit(strip_tags($article->content), 100) }}</p>
                                <div class="daily-grid-time">{{ $article->created_at->diffForHumans() }}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <!-- Message si aucun article -->
                    <div class="alert alert-info text-center">
                        <h4>Aucun article disponible</h4>
                        <p>Les articles de la catégorie "Actualité du jour" seront bientôt disponibles.</p>
                    </div>
                @endif
            </section>




            <!-- Portrait d'Entrepreneurs - Modern Revolutionary Design -->
            <section class="entrepreneurs-modern">
                <div class="container-fluid px-0">
                    <div class="row g-0">
                        <div class="col-12 entrepreneurs-background">
                            <div class="container">
                                <div class="row justify-content-center">
                                    <div class="col-10">
                                        <!-- Modern Header -->
                                        <div class="entrepreneurs-header">
                                            <div class="entrepreneurs-title-wrapper">
                                                <h2 class="entrepreneurs-title">Portrait d'Entrepreneurs</h2>
                                                <div class="entrepreneurs-accent-line"></div>
                                            </div>
                                            <p class="entrepreneurs-subtitle">Visages de l'excellence entrepreneuriale africaine</p>
                                        </div>

                                        @if($figuresArticles->count() > 0)
                            <!-- Featured Entrepreneur -->
                            <div class="entrepreneurs-featured">
                                <div class="row g-0">
                                    @php $mainFigure = $figuresArticles->first(); @endphp
                                    <div class="col-lg-6">
                                        <div class="entrepreneurs-main-image">
                                            @if($mainFigure->featured_image_path && file_exists(public_path('storage/' . $mainFigure->featured_image_path)))
                                                <img src="{{ asset('storage/' . $mainFigure->featured_image_path) }}"
                                                     alt="{{ $mainFigure->featured_image_alt ?: $mainFigure->title }}">
                                            @elseif($mainFigure->featured_image_url)
                                                <img src="{{ $mainFigure->featured_image_url }}"
                                                     alt="{{ $mainFigure->featured_image_alt ?: $mainFigure->title }}">
                                            @else
                                                <img src="{{ asset('assets/images/default-article.jpg') }}"
                                                     alt="{{ $mainFigure->featured_image_alt ?: $mainFigure->title }}">
                                            @endif
                                            <div class="entrepreneurs-overlay">
                                                <div class="entrepreneurs-badge">{{ $mainFigure->category->name }}</div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="entrepreneurs-main-content">
                                            <div class="entrepreneurs-category">{{ $mainFigure->category->name }}</div>
                                            <h3 class="entrepreneurs-main-title">
                                                <a href="{{ route('articles.show', $mainFigure->slug) }}" class="text-decoration-none text-dark">
                                                    {{ $mainFigure->title }}
                                                </a>
                                            </h3>
                                            <p class="entrepreneurs-main-excerpt">
                                                {{ $mainFigure->excerpt ?: Str::limit(strip_tags($mainFigure->content), 200) }}
                                            </p>
                                            <div class="entrepreneurs-stats">


                                                <div class="entrepreneurs-stat">
                                                    <span class="entrepreneurs-stat-number">{{ $mainFigure->created_at->locale('fr')->isoFormat('D MMMM YYYY [à] HH:mm') }}</span>
                                                    <span class="entrepreneurs-stat-label">Publication</span>
                                                </div>
                                            </div>
                                            <div class="entrepreneurs-actions">
                                                <a href="{{ route('articles.show', $mainFigure->slug) }}" class="entrepreneurs-btn-primary">
                                                    <span>Lire le portrait</span>
                                                    <i class="fas fa-arrow-right"></i>
                                                </a>
                                                <a href="{{ route('articles.category', $mainFigure->category->slug) }}" class="entrepreneurs-btn-secondary">
                                                    <i class="fas fa-users"></i>
                                                    <span>Voir tous les portraits</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Secondary Entrepreneurs Grid -->
                            <div class="entrepreneurs-grid">
                                @foreach($figuresArticles->skip(1) as $figure)
                                <div class="entrepreneurs-grid-item">
                                    <div class="entrepreneurs-card">
                                        <div class="entrepreneurs-card-image">
                                            @if($figure->featured_image_path && file_exists(public_path('storage/' . $figure->featured_image_path)))
                                                <img src="{{ asset('storage/' . $figure->featured_image_path) }}"
                                                     alt="{{ $figure->featured_image_alt ?: $figure->title }}">
                                            @elseif($figure->featured_image_url)
                                                <img src="{{ $figure->featured_image_url }}"
                                                     alt="{{ $figure->featured_image_alt ?: $figure->title }}">
                                            @else
                                                <img src="{{ asset('assets/images/default-article.jpg') }}"
                                                     alt="{{ $figure->featured_image_alt ?: $figure->title }}">
                                            @endif
                                            <div class="entrepreneurs-card-overlay">
                                                <div class="entrepreneurs-card-badge">{{ $figure->category->name }}</div>
                                            </div>
                                        </div>
                                        <div class="entrepreneurs-card-content">
                                            <h4 class="entrepreneurs-card-title">
                                                <a href="{{ route('articles.show', $figure->slug) }}" class="text-decoration-none text-dark">
                                                    {{ Str::limit($figure->title, 50) }}
                                                </a>
                                            </h4>
                                            <p class="entrepreneurs-card-role">{{ $figure->subtitle ?: 'Figure de l\'Économie' }}</p>
                                            <p class="entrepreneurs-card-excerpt">
                                                {{ $figure->excerpt ?: Str::limit(strip_tags($figure->content), 120) }}
                                            </p>
                                            <div class="entrepreneurs-card-impact">
                                                <span class="entrepreneurs-impact-number">{{ $figure->created_at->diffForHumans() }}</span>
                                                <span class="entrepreneurs-impact-label">Publié</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <!-- Message si aucun article -->
                            <div class="alert alert-info text-center">
                                <h4>Aucun portrait disponible</h4>
                                <p>Les portraits des figures de l'économie seront bientôt disponibles.</p>
                            </div>
                        @endif
                                        <!-- Call to Action -->
                                        <div class="entrepreneurs-cta">
                                            <div class="entrepreneurs-cta-content">
                                                <h3 class="entrepreneurs-cta-title">Vous êtes entrepreneur ?</h3>
                                                <p class="entrepreneurs-cta-text">
                                                    Partagez votre histoire et inspirez la prochaine génération d'entrepreneurs africains.
                                                </p>
                                                <a href="#" class="entrepreneurs-cta-btn">
                                                    <span>Proposer votre portrait</span>
                                                    <i class="fas fa-plus"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <div class="ad" aria-label="Bandeau publicitaire">Bandeau publicitaire</div>

            <!-- Newsletter Section -->
            <section class="newsletter-section-black fade-in">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-8 col-xl-6">
                            <div class="newsletter-content text-center">
                                <div class="newsletter-icon mb-4">
                                    <i class="fas fa-envelope fa-4x text-primary"></i>
                                </div>
                                <h3 class="font-display mb-3 text-white">Restez informé avec notre newsletter</h3>
                                <p class="mb-4 text-light">Recevez chaque semaine les meilleures actualités économiques et entrepreneuriales d'Afrique directement dans votre boîte mail.</p>
                                <form class="newsletter-form-centered" action="{{ route('newsletter.subscribe') }}" method="POST">
                                    @csrf
                                    <div class="input-group input-group-lg">
                                        <input type="email" class="form-control newsletter-input" name="email" placeholder="Votre adresse e-mail" required>
                                        <button type="submit" class="btn btn-primary newsletter-btn">
                                            <i class="fas fa-paper-plane me-2"></i>S'abonner
                                        </button>
                                    </div>
                                </form>
                                <small class="text-muted d-block mt-3">
                                    <i class="fas fa-shield-alt me-1"></i>
                                    Vos données sont protégées et ne seront jamais partagées
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Partenaires -->
            <section class="mb-5 fade-in">
                <div class="section-header">
                    <h2 class="section-title">Nos Partenaires</h2>
                    <p class="text-muted">Ils nous font confiance et soutiennent notre mission</p>
                </div>
                <div class="row g-4">
                    <div class="col-lg-2 col-md-4 col-6">
                        <div class="partner-logo">
                            <img src="https://via.placeholder.com/120x60/f8f9fa/6c757d?text=Partner+1" alt="Partenaire 1" class="img-fluid">
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 col-6">
                        <div class="partner-logo">
                            <img src="https://via.placeholder.com/120x60/f8f9fa/6c757d?text=Partner+2" alt="Partenaire 2" class="img-fluid">
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 col-6">
                        <div class="partner-logo">
                            <img src="https://via.placeholder.com/120x60/f8f9fa/6c757d?text=Partner+3" alt="Partenaire 3" class="img-fluid">
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 col-6">
                        <div class="partner-logo">
                            <img src="https://via.placeholder.com/120x60/f8f9fa/6c757d?text=Partner+4" alt="Partenaire 4" class="img-fluid">
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 col-6">
                        <div class="partner-logo">
                            <img src="https://via.placeholder.com/120x60/f8f9fa/6c757d?text=Partner+5" alt="Partenaire 5" class="img-fluid">
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 col-6">
                        <div class="partner-logo">
                            <img src="https://via.placeholder.com/120x60/f8f9fa/6c757d?text=Partner+6" alt="Partenaire 6" class="img-fluid">
                        </div>
                    </div>
                </div>
            </section>

        </div>
    </div>
</main>
@endsection
