@extends('layouts.app')

@section('title', $magazine->title . ' - Excellence Afrik')
@section('meta_description', $magazine->description)

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-10">

            <!-- Magazine Header -->
            <section class="magazine-header mb-5">
                <div class="row align-items-center">
                    <div class="col-lg-4">
                        <div class="magazine-cover-large">
                            <img src="{{ asset('storage/' . $magazine->cover_path) }}" 
                                 alt="{{ $magazine->title }}" class="img-fluid rounded-3 shadow-lg">
                            <div class="cover-badge">Édition Spéciale</div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="magazine-details">
                            <div class="magazine-meta-large">
                                <span class="issue-date-large">{{ $magazine->published_at->translatedFormat('F Y') }}</span>
                            </div>
                            <h1 class="magazine-title-large">{{ $magazine->title }}</h1>
                            <p class="magazine-description-large">
                                {{ $magazine->description }}
                            </p>
                            
                            <div class="magazine-stats-large">
                                <div class="stat-item-large">
                                    <i class="fas fa-file-alt text-primary"></i>
                                    <span class="stat-number">68</span>
                                    <span class="stat-label">Pages</span>
                                </div>
                                <div class="stat-item-large">
                                    <i class="fas fa-users text-primary"></i>
                                    <span class="stat-number">15</span>
                                    <span class="stat-label">Experts</span>
                                </div>
                                <div class="stat-item-large">
                                    <i class="fas fa-building text-primary"></i>
                                    <span class="stat-number">25</span>
                                    <span class="stat-label">Entreprises</span>
                                </div>
                                <div class="stat-item-large">
                                    <i class="fas fa-globe-africa text-primary"></i>
                                    <span class="stat-number">12</span>
                                    <span class="stat-label">Pays</span>
                                </div>
                            </div>

                            <div class="magazine-actions-large">
                                <button class="btn btn-primary btn-lg me-3" onclick="openReader()">
                                    <i class="fas fa-book-open me-2"></i>Lire en ligne
                                </button>
                                <a href="{{ asset('storage/' . $magazine->pdf_path) }}" class="btn btn-outline-primary btn-lg me-3" download>
                                    <i class="fas fa-download me-2"></i>Télécharger PDF
                                </a>
                                <button class="btn btn-outline-secondary btn-lg" onclick="shareMagazine()">
                                    <i class="fas fa-share-alt me-2"></i>Partager
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Table of Contents -->
            <section class="magazine-toc mb-5">
                <div class="toc-header">
                    <h2 class="toc-title">Sommaire</h2>
                    <p class="toc-subtitle">Découvrez le contenu de ce numéro exceptionnel</p>
                </div>
                
                <div class="toc-content">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="toc-section">
                                <h4 class="toc-section-title">
                                    <i class="fas fa-brain text-primary me-2"></i>Dossier Principal
                                </h4>
                                <div class="toc-items">
                                    <div class="toc-item">
                                        <span class="toc-page">p. 8</span>
                                        <div class="toc-content-item">
                                            <h5>L'IA en Afrique : État des lieux et perspectives</h5>
                                            <p>Analyse complète du marché africain de l'intelligence artificielle</p>
                                        </div>
                                    </div>
                                    <div class="toc-item">
                                        <span class="toc-page">p. 16</span>
                                        <div class="toc-content-item">
                                            <h5>Les géants technologiques investissent en Afrique</h5>
                                            <p>Google, Microsoft et Meta misent sur le potentiel africain</p>
                                        </div>
                                    </div>
                                    <div class="toc-item">
                                        <span class="toc-page">p. 24</span>
                                        <div class="toc-content-item">
                                            <h5>IA et agriculture : révolution dans les champs</h5>
                                            <p>Comment l'intelligence artificielle transforme l'agriculture africaine</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-6">
                            <div class="toc-section">
                                <h4 class="toc-section-title">
                                    <i class="fas fa-user-tie text-success me-2"></i>Interviews Exclusives
                                </h4>
                                <div class="toc-items">
                                    <div class="toc-item">
                                        <span class="toc-page">p. 32</span>
                                        <div class="toc-content-item">
                                            <h5>Dr. Amina Hassan, CEO d'AI4Africa</h5>
                                            <p>"L'Afrique peut devenir le laboratoire mondial de l'IA éthique"</p>
                                        </div>
                                    </div>
                                    <div class="toc-item">
                                        <span class="toc-page">p. 38</span>
                                        <div class="toc-content-item">
                                            <h5>Kwame Osei, Fondateur de GhanaAI</h5>
                                            <p>Développer des solutions IA adaptées aux défis africains</p>
                                        </div>
                                    </div>
                                    <div class="toc-item">
                                        <span class="toc-page">p. 44</span>
                                        <div class="toc-content-item">
                                            <h5>Table ronde : L'avenir de l'IA en Afrique</h5>
                                            <p>Débat avec 5 experts internationaux</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-lg-6">
                            <div class="toc-section">
                                <h4 class="toc-section-title">
                                    <i class="fas fa-rocket text-warning me-2"></i>Startups à Suivre
                                </h4>
                                <div class="toc-items">
                                    <div class="toc-item">
                                        <span class="toc-page">p. 50</span>
                                        <div class="toc-content-item">
                                            <h5>10 startups IA qui révolutionnent l'Afrique</h5>
                                            <p>Portrait des entreprises les plus prometteuses du continent</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-6">
                            <div class="toc-section">
                                <h4 class="toc-section-title">
                                    <i class="fas fa-chart-line text-info me-2"></i>Analyses & Données
                                </h4>
                                <div class="toc-items">
                                    <div class="toc-item">
                                        <span class="toc-page">p. 58</span>
                                        <div class="toc-content-item">
                                            <h5>Investissements IA en Afrique : Les chiffres clés</h5>
                                            <p>Infographies et analyses des tendances d'investissement</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Featured Articles Preview -->
            <section class="featured-articles mb-5">
                <h2 class="section-title">Extraits exclusifs</h2>
                <div class="row g-4">
                    <div class="col-lg-4">
                        <div class="article-preview-card">
                            <div class="article-preview-image">
                                <img src="https://images.unsplash.com/photo-1677442136019-21780ecad995?w=400&h=250&fit=crop" 
                                     alt="IA Agriculture" class="img-fluid">
                            </div>
                            <div class="article-preview-content">
                                <span class="article-category">Agriculture</span>
                                <h4>L'IA révolutionne l'agriculture africaine</h4>
                                <p>Des drones intelligents aux systèmes de prédiction météorologique, découvrez comment l'intelligence artificielle transforme...</p>
                                <a href="#" class="read-more-link">Lire l'extrait <i class="fas fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-4">
                        <div class="article-preview-card">
                            <div class="article-preview-image">
                                <img src="https://images.unsplash.com/photo-1559526324-4b87b5e36e44?w=400&h=250&fit=crop" 
                                     alt="Fintech IA" class="img-fluid">
                            </div>
                            <div class="article-preview-content">
                                <span class="article-category">Fintech</span>
                                <h4>IA et services financiers</h4>
                                <p>Comment l'intelligence artificielle révolutionne les services bancaires et améliore l'inclusion financière...</p>
                                <a href="#" class="read-more-link">Lire l'extrait <i class="fas fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-4">
                        <div class="article-preview-card">
                            <div class="article-preview-image">
                                <img src="https://images.unsplash.com/photo-1576091160399-112ba8d25d1f?w=400&h=250&fit=crop" 
                                     alt="Santé IA" class="img-fluid">
                            </div>
                            <div class="article-preview-content">
                                <span class="article-category">Santé</span>
                                <h4>IA et télémédecine en Afrique</h4>
                                <p>Les applications d'intelligence artificielle qui améliorent l'accès aux soins de santé dans les zones rurales...</p>
                                <a href="#" class="read-more-link">Lire l'extrait <i class="fas fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Navigation -->
            <section class="magazine-navigation">
                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('magazines.show', 23) }}" class="nav-magazine-btn prev">
                        <i class="fas fa-chevron-left"></i>
                        <div class="nav-content">
                            <span class="nav-label">Numéro précédent</span>
                            <span class="nav-title">N° 23 - Fintech Revolution</span>
                        </div>
                    </a>
                    
                    <a href="{{ route('magazines.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-grid-3x3 me-2"></i>Tous les numéros
                    </a>
                    
                    <div class="nav-magazine-btn next disabled">
                        <div class="nav-content">
                            <span class="nav-label">Numéro suivant</span>
                            <span class="nav-title">Bientôt disponible</span>
                        </div>
                        <i class="fas fa-chevron-right"></i>
                    </div>
                </div>
            </section>

        </div>
    </div>
</div>

<!-- Reader Modal -->
<div class="modal fade" id="readerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Magazine N° 24 - Lecture en ligne</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0">
                <div class="magazine-reader">
                    <div class="reader-toolbar">
                        <div class="reader-controls">
                            <button class="btn btn-sm btn-outline-secondary" onclick="zoomOut()">
                                <i class="fas fa-search-minus"></i>
                            </button>
                            <span class="zoom-level">100%</span>
                            <button class="btn btn-sm btn-outline-secondary" onclick="zoomIn()">
                                <i class="fas fa-search-plus"></i>
                            </button>
                        </div>
                        <div class="page-navigation">
                            <button class="btn btn-sm btn-outline-secondary" onclick="prevPage()">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            <span class="page-info">Page <span id="currentPage">1</span> sur 68</span>
                            <button class="btn btn-sm btn-outline-secondary" onclick="nextPage()">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        </div>
                    </div>
                    <div class="reader-content">
                        <div class="magazine-page">
                            <img src="https://via.placeholder.com/800x1000/f8f9fa/6c757d?text=Page+1" 
                                 alt="Page 1" class="img-fluid" id="magazinePage">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.magazine-cover-large {
    position: relative;
}

.cover-badge {
    position: absolute;
    top: 1rem;
    left: 1rem;
    background: #ffd700;
    color: #000;
    padding: 0.5rem 1rem;
    border-radius: 1rem;
    font-size: 0.8rem;
    font-weight: 700;
    text-transform: uppercase;
}

.magazine-meta-large {
    display: flex;
    gap: 1rem;
    margin-bottom: 1.5rem;
    flex-wrap: wrap;
}

.issue-number-large {
    background: var(--bs-primary);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 1rem;
    font-weight: 600;
}

.issue-date-large {
    background: #f8f9fa;
    color: var(--bs-gray-700);
    padding: 0.5rem 1rem;
    border-radius: 1rem;
    font-weight: 500;
}

.issue-type-large {
    background: #ffd700;
    color: #000;
    padding: 0.5rem 1rem;
    border-radius: 1rem;
    font-weight: 600;
    text-transform: uppercase;
}

.magazine-title-large {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 1.5rem;
    line-height: 1.2;
}

.magazine-description-large {
    font-size: 1.1rem;
    line-height: 1.6;
    color: var(--bs-gray-600);
    margin-bottom: 2rem;
}

.magazine-stats-large {
    display: flex;
    gap: 2rem;
    margin-bottom: 2rem;
    flex-wrap: wrap;
}

.stat-item-large {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
}

.stat-item-large i {
    font-size: 1.5rem;
    margin-bottom: 0.5rem;
}

.stat-item-large .stat-number {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--bs-dark);
}

.stat-item-large .stat-label {
    font-size: 0.9rem;
    color: var(--bs-gray-600);
}

.magazine-actions-large {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
}

.magazine-toc {
    background: #f8f9fa;
    border-radius: 1rem;
    padding: 2rem;
}

.toc-header {
    text-align: center;
    margin-bottom: 2rem;
}

.toc-title {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.toc-subtitle {
    color: var(--bs-gray-600);
}

.toc-section {
    margin-bottom: 2rem;
}

.toc-section-title {
    font-size: 1.3rem;
    font-weight: 600;
    margin-bottom: 1rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid #dee2e6;
}

.toc-item {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    padding: 1rem;
    background: white;
    border-radius: 0.5rem;
    margin-bottom: 1rem;
    box-shadow: 0 2px 5px rgba(0,0,0,0.05);
}

.toc-page {
    background: var(--bs-primary);
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 1rem;
    font-size: 0.8rem;
    font-weight: 600;
    flex-shrink: 0;
}

.toc-content-item h5 {
    font-size: 1rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.toc-content-item p {
    font-size: 0.9rem;
    color: var(--bs-gray-600);
    margin: 0;
}

.article-preview-card {
    background: white;
    border-radius: 1rem;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    transition: transform 0.3s ease;
}

.article-preview-card:hover {
    transform: translateY(-5px);
}

.article-preview-image img {
    width: 100%;
    height: 200px;
    object-fit: cover;
}

.article-preview-content {
    padding: 1.5rem;
}

.article-category {
    background: var(--bs-primary);
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 1rem;
    font-size: 0.8rem;
    font-weight: 600;
}

.article-preview-content h4 {
    font-size: 1.1rem;
    font-weight: 600;
    margin: 1rem 0 0.5rem 0;
}

.read-more-link {
    color: var(--bs-primary);
    text-decoration: none;
    font-weight: 500;
    font-size: 0.9rem;
}

.read-more-link:hover {
    text-decoration: underline;
}

.magazine-navigation {
    margin-top: 3rem;
    padding: 2rem;
    background: #f8f9fa;
    border-radius: 1rem;
}

.nav-magazine-btn {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: white;
    border: 1px solid #dee2e6;
    border-radius: 0.5rem;
    text-decoration: none;
    color: var(--bs-dark);
    transition: all 0.3s ease;
}

.nav-magazine-btn:hover:not(.disabled) {
    background: var(--bs-primary);
    color: white;
    text-decoration: none;
}

.nav-magazine-btn.disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.nav-content {
    display: flex;
    flex-direction: column;
}

.nav-label {
    font-size: 0.8rem;
    color: var(--bs-gray-600);
}

.nav-title {
    font-weight: 600;
}

.magazine-reader {
    height: 100vh;
    display: flex;
    flex-direction: column;
}

.reader-toolbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem;
    background: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
}

.reader-controls {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.zoom-level {
    font-weight: 600;
    min-width: 50px;
    text-align: center;
}

.page-navigation {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.reader-content {
    flex: 1;
    overflow: auto;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 2rem;
    background: #e9ecef;
}

.magazine-page {
    max-width: 100%;
    max-height: 100%;
}

@media (max-width: 768px) {
    .magazine-title-large {
        font-size: 2rem;
    }
    
    .magazine-stats-large {
        justify-content: center;
    }
    
    .magazine-actions-large {
        justify-content: center;
    }
    
    .nav-magazine-btn {
        flex-direction: column;
        text-align: center;
    }
}
</style>
@endpush

@push('scripts')
<script>
function openReader() {
    const modal = new bootstrap.Modal(document.getElementById('readerModal'));
    modal.show();
}

function shareMagazine() {
    if (navigator.share) {
        navigator.share({
            title: 'Magazine Excellence Afrik N° 24',
            text: 'L\'Afrique à l\'ère de l\'Intelligence Artificielle',
            url: window.location.href
        });
    } else {
        // Fallback: copy to clipboard
        navigator.clipboard.writeText(window.location.href);
        alert('Lien copié dans le presse-papiers !');
    }
}

let currentPage = 1;
let zoomLevel = 100;

function nextPage() {
    if (currentPage < 68) {
        currentPage++;
        updatePage();
    }
}

function prevPage() {
    if (currentPage > 1) {
        currentPage--;
        updatePage();
    }
}

function zoomIn() {
    if (zoomLevel < 200) {
        zoomLevel += 25;
        updateZoom();
    }
}

function zoomOut() {
    if (zoomLevel > 50) {
        zoomLevel -= 25;
        updateZoom();
    }
}

function updatePage() {
    document.getElementById('currentPage').textContent = currentPage;
    // Here you would load the actual page image
    document.getElementById('magazinePage').src = `https://via.placeholder.com/800x1000/f8f9fa/6c757d?text=Page+${currentPage}`;
}

function updateZoom() {
    document.querySelector('.zoom-level').textContent = zoomLevel + '%';
    document.getElementById('magazinePage').style.transform = `scale(${zoomLevel / 100})`;
}
</script>
@endpush
