@extends('layouts.app')

@section('title', $webtv->titre . ' - Excellence Afrik WebTV')

@section('meta')
    <meta name="description" content="{{ Str::limit(strip_tags($webtv->description), 160) }}">
    <meta property="og:title" content="{{ $webtv->titre }}">
    <meta property="og:description" content="{{ Str::limit(strip_tags($webtv->description), 160) }}">
    <meta property="og:type" content="video.other">
    @if($webtv->image_path)
        <meta property="og:image" content="{{ asset('storage/' . $webtv->image_path) }}">
    @endif
@endsection

@push('styles')
<style>
    .webtv-detail-hero {
        background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
        padding: 80px 0 40px;
        min-height: 60vh;
    }

    .video-container {
        position: relative;
        background: #000;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 20px 40px rgba(0,0,0,0.3);
    }

    .video-embed {
        position: relative;
        width: 100%;
        height: 0;
        padding-bottom: 56.25%; /* 16:9 aspect ratio */
    }

    .video-embed iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border: none;
    }

    .video-info {
        background: white;
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        margin-top: 30px;
    }

    .video-title {
        font-size: 2rem;
        font-weight: bold;
        color: #2c3e50;
        margin-bottom: 15px;
        line-height: 1.3;
    }

    .video-meta-row {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        margin-bottom: 20px;
        font-size: 0.9rem;
        color: #6c757d;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .meta-item i {
        color: #f4c700;
    }

    .video-description {
        line-height: 1.8;
        color: #555;
        margin-top: 20px;
    }

    .status-badge {
        padding: 6px 15px;
        border-radius: 25px;
        font-size: 0.8rem;
        font-weight: bold;
        text-transform: uppercase;
    }

    .status-live {
        background-color: #e74c3c;
        color: white;
    }

    .status-scheduled {
        background-color: #f39c12;
        color: white;
    }

    .status-archived {
        background-color: #95a5a6;
        color: white;
    }

    .related-programs {
        margin-top: 60px;
    }

    .related-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    }

    .related-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    }

    .related-thumb {
        position: relative;
        height: 160px;
        overflow: hidden;
    }

    .related-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .related-card:hover .related-thumb img {
        transform: scale(1.05);
    }

    .play-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.4);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .related-card:hover .play-overlay {
        opacity: 1;
    }

    .play-overlay i {
        font-size: 2rem;
        color: #f4c700;
    }

    .related-content {
        padding: 15px;
    }

    .related-title {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 8px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .related-meta {
        font-size: 0.8rem;
        color: #6c757d;
    }

    @media (max-width: 768px) {
        .webtv-detail-hero {
            padding: 60px 0 30px;
        }

        .video-title {
            font-size: 1.5rem;
        }

        .video-info {
            padding: 20px;
            margin-top: 20px;
        }

        .video-meta-row {
            flex-direction: column;
            gap: 10px;
        }
    }
</style>
@endpush

@section('content')
    <div class="webtv-detail-hero">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="video-container">
                        @if($webtv->code_embed_vimeo)
                            <div class="video-embed">
                                {!! $webtv->code_embed_vimeo !!}
                            </div>
                        @elseif($webtv->code_integration_vimeo)
                            <div class="video-embed">
                                {!! $webtv->code_integration_vimeo !!}
                            </div>
                        @else
                            <!-- Fallback si pas de code Vimeo -->
                            <div class="hero__thumb" style="background: #f8f9fa; display: flex; align-items: center; justify-content: center; padding-bottom: 56.25%;">
                                <div style="position: absolute; text-align: center; color: #6c757d;">
                                    <i class="fas fa-video fa-3x mb-3"></i>
                                    <p>Vidéo non disponible</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="video-info">
                        <h1 class="video-title">{{ $webtv->titre }}</h1>

                        <div class="video-meta-row">
                            @if($webtv->categorie)
                                <div class="meta-item">
                                    <i class="fas fa-tag"></i>
                                    <span>{{ ucfirst($webtv->categorie) }}</span>
                                </div>
                            @endif

                            @if($webtv->duree_estimee_formatee)
                                <div class="meta-item">
                                    <i class="fas fa-clock"></i>
                                    <span>{{ $webtv->duree_estimee_formatee }}</span>
                                </div>
                            @endif

                            <div class="meta-item">
                                <i class="fas fa-calendar"></i>
                                <span>{{ $webtv->date_programmee_formatee ?? $webtv->created_at->translatedFormat('d F Y') }}</span>
                            </div>
                        </div>

                        @if($webtv->statut)
                            <div class="mb-3">
                                <span class="status-badge status-{{ $webtv->statut_couleur }}">
                                    {{ $webtv->statut_formatte }}
                                </span>
                            </div>
                        @endif

                        @if($webtv->description)
                            <div class="video-description">
                                {{ $webtv->description }}
                            </div>
                        @endif

                        <div class="mt-4">
                            <a href="{{ route('webtv.index') }}" class="btn btn-outline-primary">
                                <i class="fas fa-arrow-left me-2"></i>
                                Retour aux programmes
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($programmesLies->count() > 0)
    <section class="related-programs py-5">
        <div class="container">
            <h3 class="text-center mb-5">Programmes similaires</h3>
            <div class="row">
                @foreach($programmesLies as $programme)
                <div class="col-lg-3 col-md-6 mb-4">
                    <a href="{{ route('webtv.show', $programme) }}" class="text-decoration-none">
                        <div class="related-card">
                            <div class="related-thumb">
                                @if($programme->image_path && file_exists(public_path('storage/' . $programme->image_path)))
                                    <img src="{{ asset('storage/' . $programme->image_path) }}" alt="{{ $programme->titre }}">
                                @else
                                    <img src="{{ asset('assets/default/image_default.jpg') }}" alt="{{ $programme->titre }}">
                                @endif
                                <div class="play-overlay">
                                    <i class="fas fa-play"></i>
                                </div>
                            </div>
                            <div class="related-content">
                                <h6 class="related-title">{{ $programme->titre }}</h6>
                                <div class="related-meta">
                                    {{ $programme->date_programmee_formatee ?? $programme->created_at->diffForHumans() }}
                                    @if($programme->duree_estimee_formatee)
                                        • {{ $programme->duree_estimee_formatee }}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif
@endsection