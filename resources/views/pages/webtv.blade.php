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
        color: #000;
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
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
    }

    .video-status {
        font-size: 0.7rem;
        font-weight: bold;
        padding: 2px 8px;
        border-radius: 12px;
        text-transform: uppercase;
    }

    .status-live {
        background-color: #e74c3c;
        color: white;
        animation: blink-animation 1.5s infinite;
    }

    @keyframes blink-animation {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: 0.3;
        }
    
    }

    .status-scheduled {
        background-color: #f39c12;
        color: white;
    }

    .status-archived {
        background-color: #95a5a6;
        color: white;
    }

    .status-draft {
        background-color: #bdc3c7;
        color: #2c3e50;
    }

    /* Badge pour live programmé */
    .scheduled-badge {
        background-color: #f39c12;
        color: #fff;
        padding: 5px 15px;
        border-radius: 50px;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.9rem;
        animation: scheduled-glow 2s infinite;
    }

    @keyframes scheduled-glow {
        0% {
            box-shadow: 0 0 5px rgba(243, 156, 18, 0.7);
        }
        50% {
            box-shadow: 0 0 15px rgba(243, 156, 18, 0.9);
        }
        100% {
            box-shadow: 0 0 5px rgba(243, 156, 18, 0.7);
        }
    }

    /* Overlay pour live programmé */
    .scheduled-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(243, 156, 18, 0.15);
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
    }

    .scheduled-content {
        text-align: center;
        color: #2c3e50;
        background: rgba(255, 255, 255, 0.95);
        padding: 30px;
        border-radius: 15px;
        backdrop-filter: blur(10px);
    }

    .scheduled-content i {
        color: #f4c700;
    }

    .scheduled-content h4 {
        color: #2c3e50;
        font-weight: bold;
        margin-bottom: 8px;
    }

    .scheduled-content p {
        color: #555;
        font-weight: 500;
    }

    /* Overlay pour aucun live */
    .no-live-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
    }

    .no-live-content {
        text-align: center;
        color: #fff;
        background: rgba(0, 0, 0, 0.7);
        padding: 30px;
        border-radius: 15px;
        backdrop-filter: blur(5px);
    }

    /* Décompte */
    .countdown-container {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 10px;
        padding: 15px;
        backdrop-filter: blur(10px);
    }

    .countdown-display {
        font-family: 'Courier New', monospace;
        font-size: 1.5rem;
        font-weight: 700;
        color: #f39c12;
        text-align: center;
        background: rgba(0, 0, 0, 0.3);
        padding: 10px;
        border-radius: 8px;
    }

    .countdown-label {
        font-size: 0.9rem;
        text-align: center;
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
        $prochainLive = $webtvs->where('statut', 'programme')
            ->whereNotNull('date_programmee')
            ->where('date_programmee', '>', now())
            ->sortBy('date_programmee')
            ->first();
        $otherVideos = $webtvs->where('statut', '!=', 'en_direct');
    @endphp

    <!-- Section Live - Toujours affichée avec messages adaptatifs -->
    <section class="live-video-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="video-player-wrapper">
                        @if($liveVideo && !empty($liveVideo->code_embed_vimeo))
                            <!-- Live en cours avec code embed -->
                            {!! $liveVideo->code_embed_vimeo !!}
                        @elseif($liveVideo)
                            <!-- Live en cours sans code embed -->
                            <img src="{{ $liveVideo->image_path ? asset('storage/' . $liveVideo->image_path) : asset('assets/default/image_default.jpg') }}" alt="{{ $liveVideo->titre ?? 'Vidéo en direct' }}" style="width: 100%; height: 100%; object-fit: cover;">
                            <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: white; background: rgba(0,0,0,0.7); padding: 20px; border-radius: 10px; text-align: center;">
                                <p class="h5">Le direct est terminé ou le code d'intégration est manquant.</p>
                            </div>
                        @elseif($prochainLive)
                            <!-- Live programmé -->
                            <img src="{{ $prochainLive->image_path ? asset('storage/' . $prochainLive->image_path) : asset('assets/default/image_default.jpg') }}" alt="{{ $prochainLive->titre ?? 'Live programmé' }}" style="width: 100%; height: 100%; object-fit: cover;">
                            <div class="scheduled-overlay">
                                <div class="scheduled-content">
                                    <i class="fas fa-clock fa-3x mb-3"></i>
                                    <h4>Prochain Live</h4>
                                    <p class="mb-0">{{ \Carbon\Carbon::parse($prochainLive->date_programmee)->format('d/m/Y à H:i') }}</p>
                                </div>
                            </div>
                        @else
                            <!-- Aucun live -->
                            <img src="{{ asset('assets/default/image_default.jpg') }}" alt="WebTV Excellence Afrik" style="width: 100%; height: 100%; object-fit: cover;">
                            <div class="no-live-overlay">
                                <div class="no-live-content">
                                    <i class="fas fa-tv fa-3x mb-3"></i>
                                    <h4>Aucun Live En Cours</h4>
                                    <p class="mb-0">Découvrez nos programmes récents ci-dessous !</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-4 d-flex align-items-center">
                    <div class="live-video-info">
                        @if($liveVideo)
                            <!-- Live en cours -->
                            <span class="live-badge mb-3 d-inline-block">En Direct</span>
                            <h2 class="h3 fw-bold text-white mb-3">{{ $liveVideo->titre }}</h2>
                            <p class="text-white-50">{{ $liveVideo->description }}</p>
                        @elseif($prochainLive)
                            <!-- Live programmé avec décompte -->
                            <span class="scheduled-badge mb-3 d-inline-block">Programmé</span>
                            <h2 class="h3 fw-bold text-white mb-3">{{ $prochainLive->titre }}</h2>
                            <p class="text-white-50 mb-3">{{ Str::limit($prochainLive->description, 120) }}</p>
                            <div class="countdown-container">
                                <div class="countdown-label text-white-50 mb-2">Commence dans :</div>
                                <div class="countdown-timer" data-date="{{ $prochainLive->date_programmee->toISOString() }}">
                                    <div class="countdown-display">Calcul en cours...</div>
                                </div>
                            </div>
                        @else
                            <!-- Aucun live -->
                            <h2 class="h3 fw-bold text-white mb-3">WebTV Excellence Afrik</h2>
                            <p class="text-white-50 mb-3">Aucun live en cours pour le moment.</p>
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Restez connectés !</strong><br>
                                Nos prochains programmes seront bientôt annoncés.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Recent Programs Grid -->
    <section class="recent-programs-section py-5">
        <div class="container">
            <div class="webtv-grid">
                <div class="grid-header">
                    <h4 class="grid-title">NOS PROGRAMMES</h4>
                    <div class="grid-filters">
                        <button class="filter-pill-webtv active" data-filter="all">Tous</button>
                        @if($recentPrograms->isNotEmpty())
                            @foreach($recentPrograms->pluck('categorie')->unique()->filter() as $categorie)
                                <button class="filter-pill-webtv" data-filter="{{ \Illuminate\Support\Str::slug($categorie) }}">{{ ucfirst($categorie) }}</button>
                            @endforeach
                        @endif
                    </div>
                </div>

                @if(isset($recentPrograms) && $recentPrograms->count() > 0)
                <div class="videos-grid">
                    @foreach($recentPrograms as $program)
                    <div class="video-card" data-category="{{ \Illuminate\Support\Str::slug($program->categorie) }}">
                        <div class="video-thumbnail">
                            <a href="{{ route('webtv.show', $program) }}">
                                @if($program->image_path && file_exists(public_path('storage/' . $program->image_path)))
                                    <img src="{{ asset('storage/' . $program->image_path) }}" alt="{{ $program->titre }}">
                                @else
                                    <img src="{{ asset('assets/default/image_default.jpg') }}" alt="{{ $program->titre }}">
                                @endif
                            </a>
                            <div class="video-duration">{{ $program->duree_estimee_formatee ?? 'N/A' }}</div>
                            <div class="video-play-overlay">
                                <i class="fas fa-play"></i>
                            </div>
                        </div>
                        <div class="video-content">
                            <div class="video-category">{{ ucfirst($program->categorie ?? 'Programme') }}</div>
                            <h5 class="video-title">
                                <a href="{{ route('webtv.show', $program) }}" class="text-decoration-none text-dark">
                                    {{ $program->titre }}
                                </a>
                            </h5>
                            <div class="video-meta">
                                <span class="video-date">{{ $program->date_programmee_formatee ?? $program->created_at->diffForHumans() }}</span>
                                @if($program->statut)
                                    <span class="video-status status-{{ $program->statut_couleur }}">{{ $program->statut_formatte }}</span>
                                @endif
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
        // --- Countdown Timer ---
        function initCountdown() {
            const countdownTimer = document.querySelector('.countdown-timer');
            if (!countdownTimer) return;

            const targetDate = new Date(countdownTimer.dataset.date);

            function updateCountdown() {
                const now = new Date().getTime();
                const distance = targetDate.getTime() - now;

                if (distance < 0) {
                    countdownTimer.querySelector('.countdown-display').innerHTML =
                        '<span style="color: #f4c700; font-weight: bold; font-size: 1.1em; animation: pulse 1s infinite;">Le live commence maintenant !</span>';
                    // Recharger la page après 5 secondes pour mettre à jour le statut
                    setTimeout(() => location.reload(), 5000);
                    return;
                }

                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                let display = '';
                if (days > 0) {
                    display = `<span style="color: #f4c700; font-weight: bold; font-size: 1.2em;">${days}</span><span style="color: #ffffff;">j</span> <span style="color: #f4c700; font-weight: bold; font-size: 1.2em;">${hours}</span><span style="color: #ffffff;">h</span> <span style="color: #f4c700; font-weight: bold; font-size: 1.2em;">${minutes}</span><span style="color: #ffffff;">min</span>`;
                } else if (hours > 0) {
                    display = `<span style="color: #f4c700; font-weight: bold; font-size: 1.2em;">${hours}</span><span style="color: #ffffff;">h</span> <span style="color: #f4c700; font-weight: bold; font-size: 1.2em;">${minutes}</span><span style="color: #ffffff;">min</span> <span style="color: #f4c700; font-weight: bold; font-size: 1.2em;">${seconds}</span><span style="color: #ffffff;">s</span>`;
                } else if (minutes > 0) {
                    display = `<span style="color: #f4c700; font-weight: bold; font-size: 1.3em;">${minutes}</span><span style="color: #ffffff;">min</span> <span style="color: #f4c700; font-weight: bold; font-size: 1.3em;">${seconds}</span><span style="color: #ffffff;">s</span>`;
                } else {
                    display = `<span style="color: #e74c3c; font-weight: bold; font-size: 1.4em; animation: pulse 1s infinite;">${seconds}</span><span style="color: #ffffff;">s</span>`;
                }

                countdownTimer.querySelector('.countdown-display').innerHTML = display;
            }

            // Mise à jour initiale
            updateCountdown();

            // Mise à jour toutes les secondes
            setInterval(updateCountdown, 1000);
        }

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

        // Initialize countdown
        initCountdown();
    });
</script>
@endpush
</main>
@endsection
