@extends('layouts.app')

@section('title', 'Archives du Magazine - Excellence Afrik')
@section('meta_description', 'Consultez tous les numéros archivés du magazine Excellence Afrik depuis sa création')

@section('page_title', 'Archives du Magazine')
@section('page_subtitle', 'Retrouvez tous nos numéros depuis la création du magazine')

@push('styles')
<style>
    .magazine-card {
        transition: all 0.3s ease;
        border: 1px solid #eee;
    }
    .magazine-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        border-color: transparent;
    }
    .magazine-card .card-img-top {
        height: 350px;
        object-fit: cover;
    }
</style>
@endpush

@section('content')
<div class="container my-5">
    <div class="row">
        @forelse($magazines as $magazine)
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="card h-100 magazine-card">
                    <a href="{{ route('magazines.show', $magazine->slug) }}">
                        <img src="{{ $magazine->cover_image_path ? Storage::url($magazine->cover_image_path) : 'https://via.placeholder.com/300x400' }}" class="card-img-top" alt="{{ $magazine->title }}">
                    </a>
                    <div class="card-body">
                        <h5 class="card-title"><a href="{{ route('magazines.show', $magazine->slug) }}" class="text-dark text-decoration-none">{{ $magazine->title }}</a></h5>
                        <p class="card-text text-muted">{{ $magazine->created_at->format('F Y') }}</p>
                    </div>
                    <div class="card-footer bg-white border-0">
                         <a href="{{ route('magazines.show', $magazine->slug) }}" class="btn btn-primary btn-sm">Lire</a>
                         @if($magazine->pdf_path)
                            <a href="{{ route('magazines.download', $magazine->id) }}" class="btn btn-outline-secondary btn-sm">Télécharger</a>
                         @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <p class="text-muted">Aucun magazine n'a été publié pour le moment.</p>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($magazines->hasPages())
        <div class="mt-5">
            {{ $magazines->links('vendor.pagination.excellence-pagination') }}
        </div>
    @endif
</div>
                    <div class="row g-3">
                        @for($i = 12; $i >= 1; $i--)
                        <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                            <div class="archive-item">
                                <div class="archive-cover">
                                    <img src="https://images.unsplash.com/photo-{{ 1611224923853 + $i + 50 }}?w=200&h=250&fit=crop" 
                                         alt="Numéro {{ $i }}" class="img-fluid">
                                    @if(in_array($i, [6, 12]))
                                    <div class="archive-badge special">Spécial</div>
                                    @endif
                                </div>
                                <div class="archive-info">
                                    <div class="archive-number">N° {{ $i }}</div>
                                    <div class="archive-date">
                                        {{ ['Déc', 'Nov', 'Oct', 'Sep', 'Août', 'Juil', 'Juin', 'Mai', 'Avr', 'Mar', 'Fév', 'Jan'][12 - $i] }} 2023
                                    </div>
                                    <div class="archive-actions">
                                        <a href="{{ route('magazines.show', $i) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('magazines.download', $i) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-download"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endfor
                    </div>
                </div>

                <!-- Special Editions Highlight -->
                <div class="special-editions mb-5">
                    <h2 class="section-title">Éditions Spéciales</h2>
                    <div class="row g-4">
                        <div class="col-lg-4">
                            <div class="special-edition-card">
                                <div class="special-cover">
                                    <img src="https://images.unsplash.com/photo-1611224923853-80b023f02d71?w=300&h=400&fit=crop" 
                                         alt="IA Edition" class="img-fluid">
                                    <div class="special-overlay">
                                        <div class="special-badge">Édition Spéciale</div>
                                    </div>
                                </div>
                                <div class="special-content">
                                    <h4>L'Afrique à l'ère de l'IA</h4>
                                    <p>N° 24 - Décembre 2024</p>
                                    <p>Notre dossier le plus complet sur l'intelligence artificielle en Afrique.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="special-edition-card">
                                <div class="special-cover">
                                    <img src="https://images.unsplash.com/photo-1590283603385-17ffb3a7f29f?w=300&h=400&fit=crop" 
                                         alt="Agriculture Edition" class="img-fluid">
                                    <div class="special-overlay">
                                        <div class="special-badge">Édition Spéciale</div>
                                    </div>
                                </div>
                                <div class="special-content">
                                    <h4>Agriculture 4.0</h4>
                                    <p>N° 21 - Septembre 2024</p>
                                    <p>L'avenir de l'alimentation et les technologies agricoles innovantes.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="special-edition-card">
                                <div class="special-cover">
                                    <img src="https://images.unsplash.com/photo-1554224155-6726b3ff858f?w=300&h=400&fit=crop" 
                                         alt="Energy Edition" class="img-fluid">
                                    <div class="special-overlay">
                                        <div class="special-badge">Édition Spéciale</div>
                                    </div>
                                </div>
                                <div class="special-content">
                                    <h4>Révolution Énergétique</h4>
                                    <p>N° 18 - Juin 2024</p>
                                    <p>Les énergies renouvelables et l'indépendance énergétique africaine.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Archive Search -->
                <div class="archive-search">
                    <div class="search-card">
                        <h3>Rechercher dans les archives</h3>
                        <form class="search-form">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <input type="text" class="form-control" placeholder="Mot-clé, titre, sujet...">
                                </div>
                                <div class="col-md-3">
                                    <select class="form-select">
                                        <option value="">Toutes les années</option>
                                        <option value="2024">2024</option>
                                        <option value="2023">2023</option>
                                        <option value="2022">2022</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select class="form-select">
                                        <option value="">Tous les types</option>
                                        <option value="regular">Numéros réguliers</option>
                                        <option value="special">Éditions spéciales</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="fas fa-search"></i> Rechercher
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </section>

        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.archive-stats {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 1.5rem;
    padding: 3rem 2rem;
    color: white;
}

.stat-card {
    background: rgba(255,255,255,0.15);
    backdrop-filter: blur(10px);
    border-radius: 1rem;
    padding: 2rem 1rem;
    border: 1px solid rgba(255,255,255,0.2);
}

.stat-icon i {
    font-size: 2.5rem;
    margin-bottom: 1rem;
}

.stat-number {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.stat-label {
    font-size: 0.9rem;
    opacity: 0.9;
}

.year-section {
    border-bottom: 1px solid #dee2e6;
    padding-bottom: 2rem;
}

.year-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
}

.year-title {
    font-size: 2rem;
    font-weight: 700;
    color: var(--bs-primary);
}

.year-count {
    background: #f8f9fa;
    padding: 0.5rem 1rem;
    border-radius: 1rem;
    font-weight: 600;
    color: var(--bs-gray-700);
}

.archive-item {
    background: white;
    border-radius: 0.5rem;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
}

.archive-item:hover {
    transform: translateY(-3px);
}

.archive-cover {
    position: relative;
}

.archive-cover img {
    width: 100%;
    height: 150px;
    object-fit: cover;
}

.archive-badge {
    position: absolute;
    top: 0.5rem;
    right: 0.5rem;
    background: var(--bs-success);
    color: white;
    padding: 0.25rem 0.5rem;
    border-radius: 0.25rem;
    font-size: 0.7rem;
    font-weight: 600;
}

.archive-badge.special {
    background: #ffd700;
    color: #000;
}

.archive-info {
    padding: 1rem 0.75rem;
}

.archive-number {
    font-weight: 600;
    margin-bottom: 0.25rem;
}

.archive-date {
    font-size: 0.8rem;
    color: var(--bs-gray-600);
    margin-bottom: 0.75rem;
}

.archive-actions {
    display: flex;
    gap: 0.25rem;
}

.special-editions {
    background: #f8f9fa;
    border-radius: 1rem;
    padding: 2rem;
}

.special-edition-card {
    background: white;
    border-radius: 1rem;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
}

.special-edition-card:hover {
    transform: translateY(-5px);
}

.special-cover {
    position: relative;
}

.special-cover img {
    width: 100%;
    height: 250px;
    object-fit: cover;
}

.special-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(to bottom, rgba(0,0,0,0.3), transparent);
}

.special-badge {
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

.special-content {
    padding: 1.5rem;
}

.special-content h4 {
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.special-content p:nth-child(2) {
    color: var(--bs-primary);
    font-weight: 600;
    margin-bottom: 0.75rem;
}

.archive-search {
    margin-top: 3rem;
}

.search-card {
    background: white;
    border-radius: 1rem;
    padding: 2rem;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.search-card h3 {
    margin-bottom: 1.5rem;
    text-align: center;
}

@media (max-width: 768px) {
    .year-header {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }
    
    .archive-stats {
        padding: 2rem 1rem;
    }
    
    .stat-card {
        margin-bottom: 1rem;
    }
}
</style>
@endpush
