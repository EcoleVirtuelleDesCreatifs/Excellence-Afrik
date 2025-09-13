@extends('layouts.app')

@section('title', 'WebTV - Excellence Afrik')
@section('meta_description', 'Regardez nos émissions en direct, nos reportages et interviews exclusives sur Excellence Afrik WebTV.')

@push('styles')
<style>
    .page-title-bar {
        background: linear-gradient(to right, #996633, #f7c807);
    }
    .page-title-bar h1 {
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
    .webtv-card {
        background: #fff;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0,0,0,0.07);
        transition: transform 0.3s, box-shadow 0.3s;
        height: 100%;
    }
    .webtv-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1);
    }
    .webtv-card__thumb img {
        width: 100%;
        height: 220px;
        object-fit: cover;
    }

    /* New WebTV Grid Styles */
    .webtv-grid .grid-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        border-bottom: 1px solid #e0e0e0;
        padding-bottom: 15px;
    }
    .webtv-grid .grid-title {
        font-size: 1.5rem;
        font-weight: 700;
        margin: 0;
    }
    .grid-filters .filter-pill-webtv {
        background-color: #f0f0f0;
        border: none;
        border-radius: 50px;
        padding: 8px 20px;
        margin-left: 10px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .grid-filters .filter-pill-webtv:hover {
        background-color: #ddd;
    }
    .grid-filters .filter-pill-webtv.active {
        background-color: #c1933e;
        color: #fff;
    }
    .videos-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 30px;
    }
    .video-card {
        background: #fff;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
    }
    .video-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    }
    .video-thumbnail {
        position: relative;
    }
    .video-thumbnail img {
        width: 100%;
        height: 180px;
        object-fit: cover;
    }
    .video-duration {
        position: absolute;
        bottom: 8px;
        right: 8px;
        background-color: rgba(0,0,0,0.75);
        color: #fff;
        padding: 2px 8px;
        border-radius: 4px;
        font-size: 0.8rem;
    }
    .video-play-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.3);
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 2.5rem;
        color: #fff;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    .video-card:hover .video-play-overlay {
        opacity: 1;
    }
    .video-content {
        padding: 15px;
    }
    .video-category {
        font-size: 0.8rem;
        font-weight: 700;
        color: #c1933e;
        text-transform: uppercase;
        margin-bottom: 5px;
    }
    .video-title {
        font-size: 1rem;
        font-weight: 600;
        margin: 0 0 10px 0;
        line-height: 1.4;
    }
    .video-meta {
        font-size: 0.8rem;
        color: #6c757d;
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
                        <h1>WebTV</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Live Video Section -->
    @php
        $liveVideo = $webtvs->where('statut', 'en_direct')->first();
        $otherVideos = $webtvs->where('statut', '!=', 'en_direct');
    @endphp

    @if($liveVideo)
    <section class="live-video-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="video-player-wrapper">
                        @if(isset($liveVideo) && !empty($liveVideo->code_embed_vimeo))
                            {!! $liveVideo->code_embed_vimeo !!}
                        @else
                            <img src="{{ isset($liveVideo) && $liveVideo->image_path ? asset('storage/' . $liveVideo->image_path) : asset('styles/img/hero/part1/hero1.jpg') }}" alt="{{ $liveVideo->titre ?? 'Vidéo en direct' }}" style="width: 100%; height: 100%; object-fit: cover;">
                            <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: white; background: rgba(0,0,0,0.7); padding: 20px; border-radius: 10px; text-align: center;">
                                <p class="h5">Le direct est terminé ou le code d'intégration est manquant.</p>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-4 d-flex align-items-center">
                    <div class="live-video-info">
                        <span class="live-badge mb-3 d-inline-block">En Direct</span>
                        <h2 class="h3 fw-bold text-white mb-3">{{ $liveVideo->titre }}</h2>
                        <p class="text-white-50">{{ $liveVideo->description }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- Recent Programs Grid -->
    <section class="recent-programs-section py-5">
        <div class="container">
            <div class="webtv-grid">
                <div class="grid-header">
                    <h4 class="grid-title">NOS PROGRAMMES</h4>
                    <div class="grid-filters">
                        <button class="filter-pill-webtv active" data-filter="all">Tous</button>
                        <button class="filter-pill-webtv" data-filter="debates">Débats</button>
                        <button class="filter-pill-webtv" data-filter="interviews">Interviews</button>
                        <button class="filter-pill-webtv" data-filter="reportages">Reportages</button>
                    </div>
                </div>

                @if(isset($recentPrograms) && $recentPrograms->count() > 0)
                <div class="videos-grid">
                    @foreach($recentPrograms as $program)
                    <div class="video-card" data-category="{{ $program->categorie }}">
                        <div class="video-thumbnail">
                            <a href="#">
                                <img src="{{ $program->image_path ? asset('storage/' . $program->image_path) : 'https://via.placeholder.com/400x225' }}" alt="{{ $program->titre }}">
                            </a>
                            <div class="video-duration">{{ $program->duree_estimee ? gmdate('i:s', $program->duree_estimee * 60) : 'N/A' }}</div>
                            <div class="video-play-overlay">
                                <i class="fas fa-play"></i>
                            </div>
                        </div>
                        <div class="video-content">
                            <div class="video-category">{{ ucfirst($program->categorie) }}</div>
                            <h5 class="video-title">{{ $program->titre }}</h5>
                            <div class="video-meta">
                                <span class="video-date">{{ $program->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-5">
                    <p class="text-muted">Aucun programme récent à afficher pour le moment.</p>
                </div>
                @endif
            </div>
        </div>
    </section>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Filter functionality for the new grid
        const filterButtons = document.querySelectorAll('.filter-pill-webtv');
        const videoCards = document.querySelectorAll('.videos-grid .video-card');

        filterButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Handle active state for buttons
                filterButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');

                const filter = this.getAttribute('data-filter');

                // Filter video cards
                videoCards.forEach(card => {
                    if (filter === 'all' || card.getAttribute('data-category') === filter) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });
    });
</script>
@endpush
</main>
@endsection
