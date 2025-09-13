@props(['position' => 'sidebar', 'class' => ''])

@php
    $ad = \App\Helpers\AdvertisementHelper::getCurrentAd($position);
    $dimensions = [
        'top_banner' => '730x90px',
        'sidebar' => '300x250px', 
        'middle' => '728x90px',
        'bottom' => '970x250px'
    ];
    $size = $dimensions[$position] ?? '300x250px';
@endphp

<div class="advertisement-{{ $position }} {{ $class }}">
    @if($ad)
        <div class="ad-container">
            <a href="{{ $ad->getTrackableUrl() }}" target="_blank" rel="noopener" class="ad-link">
                <img src="{{ asset('storage/' . $ad->image) }}" 
                     alt="{{ $ad->title }}" 
                     class="ad-image img-fluid"
                     style="width: 100%; height: auto; object-fit: cover; border-radius: 8px;">
            </a>
            <small class="ad-label text-muted d-block text-center mt-1" style="font-size: 10px;">
                Publicité
            </small>
        </div>
    @else
        <div class="ad-placeholder-{{ $position }}">
            <div class="ad-fallback" style="background: #f8f9fa; padding: 15px; text-align: center; border: 1px dashed #dee2e6; border-radius: 8px;">
                <i class="fas fa-bullhorn text-muted mb-2"></i>
                <p class="text-muted mb-1 small">Espace publicitaire</p>
                <small class="text-muted">{{ $size }}</small>
            </div>
        </div>
    @endif
</div>

<style>
.ad-link {
    text-decoration: none;
    display: block;
    transition: transform 0.2s ease;
}

.ad-link:hover {
    transform: translateY(-2px);
}

.ad-container {
    margin-bottom: 20px;
}

.advertisement-top-banner {
    margin: 15px auto;
    text-align: center;
    max-width: 730px;
}

.advertisement-top-banner .ad-image {
    max-width: 730px;
    max-height: 90px;
}

.advertisement-sidebar {
    margin: 20px 0;
}

.advertisement-middle {
    margin: 30px auto;
    text-align: center;
}

.advertisement-bottom {
    margin: 40px auto 20px;
    text-align: center;
}

.ad-fallback {
    opacity: 0.7;
}
</style>