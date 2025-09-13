@extends('layouts.app')

@section('title', 'WebTV')

@section('content')

<section class="webtv-ultra-section fade-in visible">
    <style>
        /* Scoped UI/UX enhancements */
        .webtv-ultra-section .featured-video-wrapper,
        .webtv-ultra-section .video-thumbnail { position: relative; overflow: hidden; border-radius: 14px; }
        .webtv-ultra-section .video-thumbnail img,
        .webtv-ultra-section .featured-video-thumbnail { transition: transform .2s ease, filter .2s ease; display:block; width:100%; height:auto; }
        .webtv-ultra-section .video-thumbnail:hover img { transform: scale(1.02); }
        /* Ensure video previews keep 16:9 and fill */
        .webtv-ultra-section .video-thumbnail,
        .webtv-ultra-section .featured-video-wrapper { aspect-ratio: 16/9; background:#000; }
        .webtv-ultra-section .video-thumbnail img,
        .webtv-ultra-section .featured-video-wrapper img { position:relative; width:100%; height:100%; object-fit:cover; transition: transform .25s ease; }
        .webtv-ultra-section .video-thumbnail iframe,
        .webtv-ultra-section .featured-video-wrapper iframe { position:absolute; inset:0; width:100%; height:100%; border:0; transition: transform .25s ease; }
        /* Allow interaction on featured video (click to unmute if needed) */
        .webtv-ultra-section .featured-video-wrapper iframe { pointer-events:auto; }
        /* Featured sound CTA */
        .webtv-ultra-section .featured-sound-cta { position:absolute; left:50%; top:50%; transform:translate(-50%,-50%); z-index:3; background:rgba(15,23,42,.8); color:#fff; border:1px solid rgba(255,255,255,.25); padding:10px 14px; border-radius:12px; backdrop-filter: blur(4px); display:none; align-items:center; gap:8px; font-weight:700; }
        .webtv-ultra-section .featured-sound-cta i { font-size:18px; }
        .webtv-ultra-section .video-card:hover .video-thumbnail img,
        .webtv-ultra-section .video-card:hover .video-thumbnail iframe { transform: scale(1.03); }
        /* Remove shadows per request (cards + featured container) */
        .webtv-ultra-section .video-card,
        .webtv-ultra-section .webtv-featured-block,
        .webtv-ultra-section .featured-video-container,
        .webtv-ultra-section .video-content { padding: 14px 12px 16px; }
        .webtv-ultra-section .video-category { color:#cbd5e1; font-size:.78rem; text-transform:uppercase; letter-spacing:.08em; margin-bottom:6px; }
        .webtv-ultra-section .video-meta { display:flex; gap:10px; align-items:center; color:#9aa4b2; font-size:.9rem; margin-top:8px; }
        .webtv-ultra-section .video-meta .video-views { display:none; }
        .webtv-ultra-section .video-card { transition: transform .18s ease, border-color .18s ease; }
        .webtv-ultra-section .video-card:hover { transform: translateY(-2px); border-color: rgba(148,163,184,.3); }

        /* Title clamp */
        .webtv-ultra-section .video-title { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; font-size: 1.25rem; font-weight: 800; letter-spacing: -0.01em; line-height: 1.3; }
        @media (min-width: 576px) { .webtv-ultra-section .video-title { font-size: 1.3rem; } }
        @media (min-width: 992px) { .webtv-ultra-section .video-title { font-size: 1.5rem; } }
        .webtv-ultra-section .featured-video-title { font-size: 1.6rem; font-weight: 900; letter-spacing: -0.015em; line-height: 1.25; }
        @media (min-width: 576px) { .webtv-ultra-section .featured-video-title { font-size: 1.8rem; } }
        @media (min-width: 992px) { .webtv-ultra-section .featured-video-title { font-size: 2rem; } }

        /* Sticky filters on large screens */
        @media (min-width: 992px) {
            .webtv-ultra-section .grid-filters { position: sticky; top: 10px; z-index: 5; backdrop-filter: blur(4px); }
        }
        .webtv-ultra-section .filter-pill-webtv { transition: all .18s ease; }
        .webtv-ultra-section .filter-pill-webtv.active { box-shadow: 0 0 0 2px rgba(212,175,55,.25), inset 0 0 0 1px rgba(212,175,55,.55); }
        .webtv-ultra-section .filter-pill-webtv:focus-visible { outline: 3px solid rgba(37,99,235,.45); outline-offset: 2px; }

        /* Pagination polish (works with default Laravel links markup) */
        .webtv-ultra-section .pagination { display:flex; gap:6px; justify-content:center; }
        .webtv-ultra-section .pagination .page-item .page-link { border-radius:10px; padding:8px 12px; border:1px solid rgba(148,163,184,.2); background:rgba(255,255,255,.02); color:#e2e8f0; }
        .webtv-ultra-section .pagination .page-item.active .page-link { border-color: rgba(212,175,55,.55); background: rgba(212,175,55,.12); color:#fff; }
        .webtv-ultra-section .pagination .page-item .page-link:hover { transform: translateY(-1px); border-color: rgba(148,163,184,.35); }
        .webtv-ultra-section .pagination .page-item.disabled .page-link { opacity:.6; cursor:not-allowed; }

        /* Focus ring for interactive elements */
        .webtv-ultra-section .watch-btn { outline: none; }
        .webtv-ultra-section .watch-btn:focus-visible { outline: 3px solid rgba(37,99,235,.45); outline-offset: 2px; border-radius: 10px; }

        /* Center the play overlay (grid & featured) */
        .webtv-ultra-section .video-play-overlay,
        .webtv-ultra-section .video-play-button { position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%); display:flex; align-items:center; justify-content:center; width:64px; height:64px; border-radius:50%; background: rgba(15,23,42,0.55); color:#fff; box-shadow:none; }
        .webtv-ultra-section .video-play-overlay i,
        .webtv-ultra-section .video-play-button i { font-size: 20px; }
        @media (min-width: 992px){ .webtv-ultra-section .video-play-overlay, .webtv-ultra-section .video-play-button { width:72px; height:72px; } }

        /* Live badges — more visible + blinking */
        .webtv-ultra-section .video-live-indicator {
            position: absolute; top: 12px; left: 12px;
            display: inline-flex; align-items: center; gap: 8px;
            padding: 6px 12px; border-radius: 999px;
            background: linear-gradient(135deg, #dc3545 0%, #ff5a5f 100%);
            color: #fff; font-weight: 900; letter-spacing: .05em; font-size: .8rem;
            box-shadow: 0 6px 18px rgba(220, 53, 69, .35), 0 0 0 2px rgba(255,255,255,.1) inset;
            animation: webtv-blink 1.4s infinite steps(2, jump-none);
        }
        .webtv-ultra-section .video-live-indicator .live-dot {
            width: 10px; height: 10px; border-radius: 50%; background: #fff;
            box-shadow: 0 0 0 3px rgba(255,255,255,.25);
            animation: webtv-pulse 1.2s ease-in-out infinite;
        }
        /* Hero top-left live badge */
        .webtv-ultra-section .hero-badge-webtv {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 6px 12px; border-radius: 999px;
            background: linear-gradient(135deg, #dc3545 0%, #ff5a5f 100%);
            color: #fff; font-weight: 900; letter-spacing: .05em; font-size: .85rem;
            box-shadow: 0 10px 24px rgba(220, 53, 69, .35);
            animation: webtv-blink 1.6s infinite steps(2, jump-none);
        }
        .webtv-ultra-section .hero-badge-webtv .badge-dot-webtv {
            width: 10px; height: 10px; border-radius: 50%; background: #fff;
            box-shadow: 0 0 0 3px rgba(255,255,255,.25);
            animation: webtv-pulse 1.2s ease-in-out infinite;
        }
        .webtv-ultra-section .hero-badge-webtv .badge-text-webtv { color: #fff; }

        @keyframes webtv-blink {
            0% { opacity: 1; }
            49% { opacity: 1; }
            50% { opacity: .55; }
            100% { opacity: .55; }
        }
        @keyframes webtv-pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.35); }
            100% { transform: scale(1); }
        }

        /* Minimal list layout (YouTube-like) */
        .webtv-ultra-section .videos-list { display: grid; gap: 18px; }
        .webtv-ultra-section .video-row { display: grid; grid-template-columns: 5fr 7fr; gap: 0; align-items: stretch; border:1px solid rgba(148,163,184,.15); border-radius: 14px; overflow:hidden; background: transparent; transition: transform .18s ease, border-color .18s ease; }
        .webtv-ultra-section .video-row:hover { transform: translateY(-2px); border-color: rgba(148,163,184,.3); }
        @media (max-width: 991.98px) { .webtv-ultra-section .video-row { grid-template-columns: 1fr; } }
        /* Thumbnail column */
        .webtv-ultra-section .video-row .thumb { position: relative; aspect-ratio: 16/9; background: #000; }
        .webtv-ultra-section .video-row .thumb img,
        .webtv-ultra-section .video-row .thumb iframe { position:absolute; inset:0; width:100%; height:100%; object-fit:cover; border:0; transition: transform .25s ease; }
        /* Loading shimmer for dynamic thumbnails */
        .webtv-ultra-section .thumb img.vimeo-loading { background: linear-gradient(90deg, rgba(30,41,59,.6) 25%, rgba(51,65,85,.6) 37%, rgba(30,41,59,.6) 63%); background-size: 400% 100%; animation: shimmer 1.2s ease-in-out infinite; }
        @keyframes shimmer { 0% { background-position: 200% 0; } 100% { background-position: -200% 0; } }
        .webtv-ultra-section .video-row:hover .thumb img,
        .webtv-ultra-section .video-row:hover .thumb iframe { transform: scale(1.03); }
        /* Details column */
        .webtv-ultra-section .video-row .details { padding: 16px; display:flex; flex-direction:column; justify-content:center; }
        .webtv-ultra-section .video-row .details .category { color:#cbd5e1; font-size:.78rem; text-transform:uppercase; letter-spacing:.08em; margin-bottom:6px; }
        .webtv-ultra-section .video-row .details .title { font-size:1.35rem; font-weight:800; line-height:1.25; margin:0; }
        @media (min-width: 992px) { .webtv-ultra-section .video-row .details .title { font-size:1.5rem; } }
        .webtv-ultra-section .video-row .details .meta { color:#9aa4b2; font-size:.95rem; margin-top:8px; }
        .webtv-ultra-section .video-row .details .desc { color:#cbd5e1; font-size:.98rem; margin-top:8px; display:-webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow:hidden; }
        /* Reuse shared thumbnail helpers */
        .webtv-ultra-section .video-thumbnail,
        .webtv-ultra-section .featured-video-wrapper { aspect-ratio: 16/9; background:#000; }
        .webtv-ultra-section .video-thumbnail img,
        .webtv-ultra-section .featured-video-wrapper img { position:relative; width:100%; height:100%; object-fit:cover; transition: transform .25s ease; }
        .webtv-ultra-section .video-thumbnail iframe,
        .webtv-ultra-section .featured-video-wrapper iframe { position:absolute; inset:0; width:100%; height:100%; border:0; pointer-events:none; transition: transform .25s ease; }
        .webtv-ultra-section .video-card:hover .video-thumbnail img,
        .webtv-ultra-section .video-card:hover .video-thumbnail iframe { transform: scale(1.03); }

        /* Clean grid & cards */
        .webtv-ultra-section .videos-grid { display:grid; grid-template-columns: repeat(12, 1fr); gap: 20px; }
        @media (max-width: 1199.98px) { .webtv-ultra-section .videos-grid { grid-template-columns: repeat(8, 1fr); } }
        @media (max-width: 991.98px) { .webtv-ultra-section .videos-grid { grid-template-columns: repeat(6, 1fr); } }
        @media (max-width: 767.98px) { .webtv-ultra-section .videos-grid { grid-template-columns: repeat(4, 1fr); gap: 14px; } }
        .webtv-ultra-section .video-card { position: relative; border:1px solid rgba(148,163,184,.15); border-radius: 14px; overflow:hidden; background:transparent; grid-column: span 4; }
        @media (max-width: 1199.98px) { .webtv-ultra-section .video-card { grid-column: span 4; } }
        @media (max-width: 991.98px) { .webtv-ultra-section .video-card { grid-column: span 3; } }
        @media (max-width: 767.98px) { .webtv-ultra-section .video-card { grid-column: span 4; } }
        /* Thumbnails */
        .webtv-ultra-section .video-thumbnail,
        .webtv-ultra-section .featured-video-wrapper { aspect-ratio: 16/9; background:#000; }
        .webtv-ultra-section .video-thumbnail img,
        .webtv-ultra-section .featured-video-wrapper img { position:relative; width:100%; height:100%; object-fit:cover; }
        .webtv-ultra-section .video-thumbnail iframe,
        .webtv-ultra-section .featured-video-wrapper iframe { position:absolute; inset:0; width:100%; height:100%; border:0; pointer-events:none; }

        /* Style pour les badges de catégorie dans les programmes */
        .webtv-ultra-section .category-badge {
            position: absolute; top: 12px; right: 12px;
            background: rgba(139, 92, 246, 0.9);
            color: #fff; padding: 4px 10px; border-radius: 12px;
            font-size: .7rem; font-weight: 600; text-transform: uppercase;
        }
    </style>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-10">

                <!-- Hero Header -->
                <div class="webtv-hero-header text-center">
                    @php
                        // Chercher un live en cours ou programmé pour afficher le badge
                        $items = $webtvs instanceof \Illuminate\Pagination\AbstractPaginator ? $webtvs->getCollection() : $webtvs;
                        $hasActiveLive = $items->where('type_programme', 'live')
                                              ->whereIn('statut', ['en_direct', 'programme'])
                                              ->where('est_actif', true)
                                              ->isNotEmpty();
                    @endphp

                    @if($hasActiveLive)
                    <div class="hero-badge-webtv">
                        <div class="badge-dot-webtv"></div>
                        <span class="badge-text-webtv">En Direct</span>
                    </div>
                    @endif

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

                <!-- Featured Video Block - UNIQUEMENT POUR LES LIVES -->
                <div class="webtv-featured-block">
                    <div class="featured-video-container">
                        <div class="featured-video-wrapper">
                            @php
                                // Prioriser les lives : d'abord 'en_direct', puis 'programme' de type 'live'
                                $lives = $items->where('type_programme', 'live')
                                              ->whereIn('statut', ['en_direct', 'programme'])
                                              ->where('est_actif', true);

                                $featured = $lives->where('statut', 'en_direct')->first() ?: $lives->first();

                                if($featured) {
                                    $featuredCategorie = 'Live WebTV';
                                    $featuredTitre = $featured->titre;
                                    $featuredDesc = $featured->description ? \Illuminate\Support\Str::limit(strip_tags($featured->description), 140) : "Suivez notre émission en direct.";
                                    $featuredDuration = $featured->duree_estimee_formatee;
                                    $featuredDate = $featured->date_programmee_formatee ?? "Maintenant";
                                    $isLive = $featured->statut === 'en_direct';
                                    $featuredVid = !empty($featured->vimeo_event_id) ? $featured->vimeo_event_id : (!empty($featured->video_id) ? $featured->video_id : null);
                                } else {
                                    // Pas de live actuel, on peut afficher un placeholder ou rien
                                    $featured = null;
                                    $featuredCategorie = 'WebTV';
                                    $featuredTitre = "Aucun live en cours";
                                    $featuredDesc = "Revenez bientôt pour découvrir nos prochaines émissions en direct.";
                                    $featuredDuration = null;
                                    $featuredDate = "Bientôt";
                                    $isLive = false;
                                    $featuredVid = null;
                                }
                            @endphp

                            @if($featured)
                                @if($featured->type_programme === 'live' && !empty($featured->code_embed_vimeo))
                                    {!! $featured->code_embed_vimeo !!}
                                @elseif(!empty($featured->vimeo_event_id))
                                    <iframe src="https://player.vimeo.com/video/{{ $featured->vimeo_event_id }}?autoplay=1&muted=1&loop=1&controls=0&playsinline=1"
                                            allow="autoplay; fullscreen; picture-in-picture" loading="eager"></iframe>
                                @elseif(!empty($featured->video_id))
                                    <iframe src="https://player.vimeo.com/video/{{ $featured->video_id }}?autoplay=1&muted=1&loop=1&controls=0&playsinline=1"
                                            allow="autoplay; fullscreen; picture-in-picture" loading="eager"></iframe>
                                @endif
                            @else
                                <!-- Placeholder quand pas de live -->
                                <div style="display:flex;align-items:center;justify-content:center;height:100%;background:#1e293b;color:#94a3b8;flex-direction:column;gap:1rem;">
                                    <i class="fas fa-broadcast-tower" style="font-size:3rem;opacity:0.5;"></i>
                                    <p style="margin:0;font-size:1.1rem;">Aucun live en cours</p>
                                </div>
                            @endif

                            <button type="button" class="featured-sound-cta" aria-label="Activer le son"><i class="fas fa-volume-up"></i><span>Activer le son</span></button>
                            <div class="video-overlay">
                                @if($featured)
                                <div class="video-play-button watch-btn" role="button" tabindex="0" aria-label="Lire" data-embed-container-id="embed-src-{{ $featured->id }}">
                                    <i class="fas fa-play"></i>
                                </div>
                                @endif

                                @if($isLive)
                                <div class="video-live-indicator">
                                    <div class="live-dot"></div>
                                    <span>EN DIRECT</span>
                                </div>
                                @endif
                            </div>
                        </div>

                        @if($featured)
                        <div id="embed-src-{{ $featured->id }}" class="embed-source" style="display:none">
                            @if($featured->type_programme === 'live' && !empty($featured->code_embed_vimeo))
                                {!! $featured->code_embed_vimeo !!}
                            @elseif(!empty($featured->vimeo_event_id))
                                <iframe src="https://player.vimeo.com/video/{{ $featured->vimeo_event_id }}" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                            @elseif(!empty($featured->video_id))
                                <iframe src="https://player.vimeo.com/video/{{ $featured->video_id }}" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                            @endif
                        </div>
                        @endif

                        <div class="featured-video-info">
                            <div class="video-category-badge">{{ $featuredCategorie }}</div>
                            <h3 class="featured-video-title">{{ $featuredTitre }}</h3>
                            <p class="featured-video-description">{{ $featuredDesc }}</p>
                            <div class="video-metadata">
                                <div class="video-stats">
                                    <span class="stat-item">
                                        <i class="fas fa-eye"></i>
                                        <span>— vues</span>
                                    </span>
                                    @if($featuredDuration)
                                    <span class="stat-item">
                                        <i class="fas fa-clock"></i>
                                        <span>{{ $featuredDuration }}</span>
                                    </span>
                                    @endif
                                    <span class="stat-item">
                                        <i class="fas fa-calendar"></i>
                                        <span>{{ $featuredDate }}</span>
                                    </span>
                                </div>
                                <div class="video-actions">
                                    @if($featured)
                                    <button class="action-btn-webtv watch-btn" data-embed-container-id="embed-src-{{ $featured->id }}">
                                        <i class="fas fa-play"></i>
                                        <span>Regarder</span>
                                    </button>
                                    @endif
                                    <button class="action-btn-webtv share-btn">
                                        <i class="fas fa-share-alt"></i>
                                        <span>Partager</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section Programmes par Rubriques -->
                <div class="webtv-grid">
                    <div class="grid-header">
                        <h4 class="grid-title">Programmes par Rubriques</h4>
                    </div>

                    @php
                        // Filtrer uniquement les programmes (type_programme = 'programme')
                        $programmes = $items->where('type_programme', 'programme')
                                           ->where('est_actif', true)
                                           ->where('statut', 'programme'); // Statut "programme" = publié pour les programmes

                        // Grouper par catégorie
                        $programmesByCategory = $programmes->groupBy('categorie');
                        $categories = ['debates' => 'Débats', 'interviews' => 'Interviews', 'reportages' => 'Reportages', 'documentaires' => 'Documentaires', 'general' => 'Général'];
                    @endphp

                    @if($programmesByCategory->count() > 0)
                        @foreach($categories as $catKey => $catName)
                            @if($programmesByCategory->has($catKey))
                                <div class="category-section" style="margin-bottom: 3rem;">
                                    <h5 class="category-title" style="font-size: 1.4rem; font-weight: 700; margin-bottom: 1.5rem; color: #e2e8f0; border-bottom: 2px solid rgba(139, 92, 246, 0.3); padding-bottom: 0.5rem;">
                                        {{ $catName }}
                                        <span style="font-size: 0.8rem; font-weight: 400; color: #94a3b8; margin-left: 1rem;">
                                            ({{ $programmesByCategory[$catKey]->count() }} programme{{ $programmesByCategory[$catKey]->count() > 1 ? 's' : '' }})
                                        </span>
                                    </h5>

                                    <div class="videos-list">
                                        @foreach($programmesByCategory[$catKey] as $program)
                                            @php
                                                $thumb = null;
                                                $vid = !empty($program->video_id) ? $program->video_id : null;
                                                // Build preferred embed src
                                                $embedSrc = null;
                                                if($program->type_programme === 'programme' && !empty($program->code_integration_vimeo)){
                                                    if(preg_match('/src=("|\')([^"\']+)\\1/i', $program->code_integration_vimeo, $m)) {
                                                        $embedSrc = $m[2];
                                                    }
                                                }
                                                if(!$embedSrc && $vid) {
                                                    $embedSrc = 'https://player.vimeo.com/video/' . $vid;
                                                }
                                            @endphp
                                            <div class="video-row">
                                                <div class="thumb">
                                                    @if($embedSrc && $vid)
                                                        <img src="data:image/gif;base64,R0lGODlhAQABAAAAACw="
                                                             class="vimeo-loading"
                                                             alt="{{ $program->titre }}"
                                                             loading="lazy"
                                                             decoding="async"
                                                             data-embed-src="{{ $embedSrc }}"
                                                             data-vimeo-id="{{ $vid }}">
                                                    @endif
                                                    @if(!empty($program->duree_estimee_formatee))
                                                        <div class="video-duration">{{ $program->duree_estimee_formatee }}</div>
                                                    @endif
                                                    <div class="video-play-overlay watch-btn" role="button" tabindex="0" aria-label="Lire" data-embed-container-id="embed-src-{{ $program->id }}">
                                                        <i class="fas fa-play"></i>
                                                    </div>
                                                    <div class="category-badge">{{ $catName }}</div>
                                                </div>
                                                <div class="details">
                                                    <h5 class="title">{{ $program->titre }}</h5>
                                                    <div class="meta">{{ $program->created_at->diffForHumans() }}</div>
                                                    @if(!empty($program->description))
                                                        <p class="desc">{{ \Illuminate\Support\Str::limit(strip_tags($program->description), 140) }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                            <div id="embed-src-{{ $program->id }}" class="embed-source" style="display:none">
                                                @if($program->type_programme === 'programme' && !empty($program->code_integration_vimeo))
                                                    {!! $program->code_integration_vimeo !!}
                                                @elseif(!empty($program->video_id))
                                                    <iframe src="https://player.vimeo.com/video/{{ $program->video_id }}" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @else
                        <div class="col-12" style="grid-column: 1 / -1; text-align:center; color:#94a3b8; padding:24px 0;">
                            <i class="fas fa-video" style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.5;"></i>
                            <h3>Aucun programme disponible</h3>
                            <p>Les programmes seront bientôt disponibles dans différentes rubriques.</p>
                        </div>
                    @endif
                </div>

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
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function(){
    // Ensure Vimeo API is loaded once
    function ensureVimeoApi() {
        if (window.Vimeo && window.Vimeo.Player) return Promise.resolve();
        return new Promise((resolve) => {
            const existing = document.querySelector('script[src*="player.vimeo.com/api/player.js"]');
            if (existing) {
                existing.addEventListener('load', () => resolve());
                if (existing.dataset.loaded === '1' || window.Vimeo) setTimeout(resolve, 0);
                return;
            }
            const s = document.createElement('script');
            s.src = 'https://player.vimeo.com/api/player.js';
            s.async = true;
            s.onload = () => { s.dataset.loaded = '1'; resolve(); };
            document.head.appendChild(s);
        });
    }

    const modal = (() => {
        let backdrop, box, closeBtn, content, unmuteBtn;
        function ensure() {
            if (backdrop) return;
            backdrop = document.createElement('div');
            backdrop.style.cssText = 'position:fixed;inset:0;background:rgba(0,0,0,.6);z-index:1050;display:none';
            box = document.createElement('div');
            box.style.cssText = 'position:fixed;inset:0;display:none;align-items:center;justify-content:center;z-index:1060;padding:20px';
            const wrap = document.createElement('div');
            wrap.style.cssText = 'background:#0b1220;border:1px solid rgba(148,163,184,.2);border-radius:12px;max-width:960px;width:100%;max-height:80vh;overflow:hidden;box-shadow:0 20px 60px rgba(0,0,0,.45)';
            const head = document.createElement('div');
            head.style.cssText = 'display:flex;justify-content:flex-end;padding:8px;background:rgba(255,255,255,.02)';
            closeBtn = document.createElement('button');
            closeBtn.innerHTML = '&times;';
            closeBtn.style.cssText = 'border:none;background:transparent;color:#e2e8f0;font-size:28px;line-height:1;cursor:pointer;padding:4px 8px;border-radius:8px';
            content = document.createElement('div');
            content.style.cssText = 'position:relative;width:100%;height:0;padding-bottom:56.25%';
            const inner = document.createElement('div');
            inner.style.cssText = 'position:absolute;inset:0';
            content.appendChild(inner);
            // Unmute button overlay
            unmuteBtn = document.createElement('button');
            unmuteBtn.type = 'button';
            unmuteBtn.textContent = 'Activer le son';
            unmuteBtn.setAttribute('aria-label', 'Activer le son');
            unmuteBtn.style.cssText = 'position:absolute;right:12px;bottom:12px;z-index:2;background:rgba(15,23,42,.8);color:#fff;border:1px solid rgba(255,255,255,.25);padding:8px 12px;border-radius:10px;backdrop-filter:blur(4px);display:none;cursor:pointer;font-weight:600';
            content.appendChild(unmuteBtn);
            head.appendChild(closeBtn);
            wrap.appendChild(head);
            wrap.appendChild(content);
            box.appendChild(wrap);
            document.body.appendChild(backdrop);
            document.body.appendChild(box);
            backdrop.addEventListener('click', hide);
            closeBtn.addEventListener('click', hide);
        }
        function show(html) {
            ensure();
            const inner = content.firstElementChild;
            inner.innerHTML = html || '<div style="display:flex;align-items:center;justify-content:center;height:100%;color:#94a3b8">Aucune vidéo</div>';
            backdrop.style.display = 'block';
            box.style.display = 'flex';
            // ensure iframes stretch
            inner.querySelectorAll('iframe, object, embed').forEach(el => {
                el.style.width = '100%'; el.style.height = '100%'; el.style.border = '0';
            });
            // Force autoplay for Vimeo iframes
            const iframe = inner.querySelector('iframe');
            if (iframe) {
                try {
                    const url = new URL(iframe.src, window.location.origin);
                    url.searchParams.set('autoplay', '1');
                    url.searchParams.set('muted', '0');
                    url.searchParams.set('playsinline', '1');
                    iframe.src = url.toString();
                    const allow = iframe.getAttribute('allow') || '';
                    let newAllow = allow;
                    if (!/autoplay/i.test(newAllow)) newAllow = (newAllow + '; autoplay').trim();
                    if (!/fullscreen/i.test(newAllow)) newAllow = (newAllow + '; fullscreen').trim();
                    if (!/picture-in-picture/i.test(newAllow)) newAllow = (newAllow + '; picture-in-picture').trim();
                    iframe.setAttribute('allow', newAllow);
                } catch(e) { /* noop */ }

                ensureVimeoApi().then(() => {
                    try {
                        const player = new window.Vimeo.Player(iframe);
                        player.setVolume(1).then(() => player.play()).catch(() => {
                            unmuteBtn.style.display = 'inline-flex';
                            const tryUnmute = () => {
                                unmuteBtn.style.display = 'none';
                                player.setVolume(1).then(() => player.play()).catch(() => {});
                            };
                            unmuteBtn.onclick = tryUnmute;
                            inner.addEventListener('click', tryUnmute, { once: true });
                        });
                    } catch(e) { /* ignore */ }
                });
            }
        }
        function hide() {
            if (!box) return;
            box.style.display = 'none';
            backdrop.style.display = 'none';
            const inner = content.firstElementChild;
            inner.innerHTML = '';
            if (unmuteBtn) unmuteBtn.style.display = 'none';
        }
        return { show };
    })();

    // Make thumbnails clickable to open modal with correct source
    (function thumbsOpenModal(){
        document.querySelectorAll('.videos-list .thumb img[data-embed-src], .videos-grid .video-thumbnail img[data-embed-src]')
            .forEach(img => {
                const open = (e) => {
                    e.preventDefault();
                    const src = img.getAttribute('data-embed-src');
                    if (!src) return;
                    const html = buildIframeFromSrc(src);
                    if (html) modal.show(html);
                };
                img.style.cursor = 'pointer';
                img.addEventListener('click', open);
                img.addEventListener('keydown', (e) => { if (e.key==='Enter' || e.key===' ') { e.preventDefault(); open(e); } });
            });
    })();

    // Propagate embed src to play buttons in list/grid
    (function propagateEmbedSrc(){
        try {
            document.querySelectorAll('.videos-list .video-row, .videos-grid .video-card').forEach(row => {
                const img = row.querySelector('img[data-embed-src]');
                const src = img ? img.getAttribute('data-embed-src') : null;
                if (!src) return;
                const btns = row.querySelectorAll('.watch-btn');
                btns.forEach(btn => {
                    if (!btn.getAttribute('data-embed-src')) btn.setAttribute('data-embed-src', src);
                    if (!btn.getAttribute('href')) btn.setAttribute('href', src);
                    btn.setAttribute('target', '_blank');
                    btn.setAttribute('rel', 'noopener');
                    if (!btn.hasAttribute('role')) btn.setAttribute('role', 'button');
                    if (!btn.hasAttribute('tabindex')) btn.setAttribute('tabindex', '0');
                });
            });
        } catch(e) { console.warn('[WebTV] propagateEmbedSrc error', e); }
    })();

    // Load real Vimeo preview images (oEmbed) for any <img data-vimeo-id>
    (function loadVimeoThumbs(){
        const imgs = document.querySelectorAll('.webtv-ultra-section img[data-vimeo-id], .webtv-ultra-section img[data-embed-src]');
        if (!imgs.length) return;
        const oembedById = (id) => `https://vimeo.com/api/oembed.json?url=${encodeURIComponent('https://vimeo.com/' + id)}`;
        const oembedByUrl = (u) => `https://vimeo.com/api/oembed.json?url=${encodeURIComponent(u)}`;
        imgs.forEach(img => {
            const id = img.getAttribute('data-vimeo-id');
            const embedSrc = img.getAttribute('data-embed-src');
            let reqUrl = null;
            if (id) {
                reqUrl = oembedById(id);
            } else if (embedSrc) {
                let pageUrl = embedSrc.replace('player.vimeo.com/video/', 'vimeo.com/');
                reqUrl = oembedByUrl(pageUrl);
            } else {
                return;
            }
            fetch(reqUrl)
                .then(r => r.ok ? r.json() : Promise.reject())
                .then(data => {
                    if (!data || !data.thumbnail_url) return;
                    let url = data.thumbnail_url.replace(/_[0-9x]+\.jpg$/i, '_1280.jpg');
                    img.src = url;
                    img.classList.remove('vimeo-loading');
                    img.loading = img.loading || 'lazy';
                    img.decoding = 'async';
                    img.style.objectFit = 'cover';
                    img.style.width = '100%';
                    img.style.height = '100%';
                })
                .catch(() => { /* keep existing placeholder */ });
        });
    })();

    // Featured inline autoplay with sound + fallback unmute
    (function featuredAutoplaySound(){
        const wrap = document.querySelector('.featured-video-wrapper');
        if (!wrap) return;
        const iframe = wrap.querySelector('iframe');
        if (!iframe) return;
        const setIframeParam = (key, val) => {
            try {
                const url = new URL(iframe.src, window.location.origin);
                url.searchParams.set(key, String(val));
                iframe.src = url.toString();
            } catch(e) { /* ignore */ }
        };
        const showUnmute = () => {
            let btn = wrap.querySelector('.featured-unmute-btn');
            if (!btn) {
                btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'featured-unmute-btn';
                btn.textContent = 'Activer le son';
                btn.setAttribute('aria-label', 'Activer le son');
                btn.style.cssText = 'position:absolute;right:12px;bottom:12px;z-index:3;background:rgba(15,23,42,.8);color:#fff;border:1px solid rgba(255,255,255,.25);padding:8px 12px;border-radius:10px;backdrop-filter:blur(4px);display:inline-flex;align-items:center;gap:8px;cursor:pointer;font-weight:600';
                const ico = document.createElement('i');
                ico.className = 'fas fa-volume-up';
                btn.prepend(ico);
                wrap.appendChild(btn);
            }
            return btn;
        };
        ensureVimeoApi().then(() => {
            let player;
            const startWithSound = () => {
                try {
                    player = new window.Vimeo.Player(iframe);
                    player.setVolume(1).then(() => player.play()).then(() => {
                        const cta = wrap.querySelector('.featured-sound-cta');
                        if (cta) cta.style.display = 'none';
                    }).catch(startMuted);
                } catch(e) { startMuted(); }
            };
            const startMuted = () => {
                setIframeParam('muted', '1');
                setTimeout(() => {
                    try {
                        player = new window.Vimeo.Player(iframe);
                        player.play().catch(() => {});
                    } catch(e) { /* ignore */ }
                }, 50);
                const btn = showUnmute();
                btn.style.display = 'inline-flex';
                const tryUnmute = () => {
                    btn.style.display = 'none';
                    try {
                        setIframeParam('muted', '0');
                        setTimeout(() => {
                            try {
                                player = new window.Vimeo.Player(iframe);
                                player.setVolume(1).then(() => player.play()).then(() => {
                                    const c = wrap.querySelector('.featured-sound-cta');
                                    if (c) c.style.display = 'none';
                                }).catch(() => {});
                            } catch(e) { /* ignore */ }
                        }, 50);
                    } catch(e) { /* ignore */ }
                };
                btn.onclick = tryUnmute;
                wrap.addEventListener('click', tryUnmute, { once: true });
            };
            startWithSound();
        });
    })();

    function buildIframeFromSrc(src) {
        try {
            let url = new URL(src, window.location.origin);
            url.searchParams.set('autoplay', '1');
            url.searchParams.set('muted', '0');
            url.searchParams.set('playsinline', '1');
            return `<div class="ratio ratio-16x9"><iframe src="${url.toString()}" allow="autoplay; fullscreen; picture-in-picture" loading="eager" frameborder="0"></iframe></div>`;
        } catch(e) {
            console.warn('[WebTV] invalid embed src', src, e);
            return '';
        }
    }

    function wire(el) {
        const containerId = el.getAttribute('data-embed-container-id');
        const directSrc = el.getAttribute('data-embed-src');
        const open = () => {
            if (directSrc) {
                const html = buildIframeFromSrc(directSrc);
                if (html) { modal.show(html); return; }
            }
            if (containerId) {
                const src = document.getElementById(containerId);
                if (src) {
                    const html = src.innerHTML.trim();
                    if (html) { modal.show(html); return; }
                }
            }
            console.warn('[WebTV] No embed source for modal', { el, containerId, directSrc });
        };
        el.addEventListener('click', open);
        el.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); open(); }
        });
    }

    document.querySelectorAll('.watch-btn[data-embed-container-id], .video-play-overlay.watch-btn[data-embed-container-id], .video-play-button.watch-btn[data-embed-container-id], .watch-btn[data-embed-src]')
        .forEach(wire);

    // One-time global unlock: first user gesture attempts to unmute featured
    (function oneTimeUnlock(){
        let done = false;
        const unlock = () => {
            if (done) return; done = true;
            try {
                const wrap = document.querySelector('.featured-video-wrapper');
                const iframe = wrap ? wrap.querySelector('iframe') : null;
                if (!iframe || !window.Vimeo) return;
                const p = new window.Vimeo.Player(iframe);
                p.setVolume(1).then(() => p.play()).catch(()=>{});
                const cta = wrap && wrap.querySelector('.featured-sound-cta');
                if (cta) cta.style.display = 'none';
            } catch(e) { /* ignore */ }
            window.removeEventListener('click', unlock);
            window.removeEventListener('keydown', unlock);
            window.removeEventListener('touchstart', unlock);
        };
        window.addEventListener('click', unlock, { once:true, passive:true });
        window.addEventListener('keydown', unlock, { once:true });
        window.addEventListener('touchstart', unlock, { once:true, passive:true });
    })();
});
</script>
@endpush