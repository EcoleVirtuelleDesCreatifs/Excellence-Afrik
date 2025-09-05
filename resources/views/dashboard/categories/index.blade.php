@extends('layouts.dashboard-ultra')

@section('title', 'Gestion des Catégories - Excellence Afrik')
@section('page_title', 'Gestion des Catégories')

@push('styles')
<style>
.categories-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem;
}

.categories-header {
    background: linear-gradient(135deg, #1a1a1a 0%, #000000 100%);
    border-radius: 1rem;
    padding: 2rem;
    margin-bottom: 2rem;
    color: #D4AF37;
    position: relative;
    overflow: hidden;
}

.categories-header::before {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    width: 200px;
    height: 200px;
    background: rgba(212, 175, 55, 0.1);
    border-radius: 50%;
    transform: translate(50%, -50%);
}

.categories-header h1 {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    position: relative;
    z-index: 1;
}

.categories-header p {
    font-size: 1.1rem;
    opacity: 0.9;
    margin: 0;
    position: relative;
    z-index: 1;
}

.categories-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    gap: 1rem;
}

.btn {
    padding: 0.75rem 1.5rem;
    border-radius: 0.5rem;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
    cursor: pointer;
    border: none;
    font-size: 0.9rem;
}

.btn-primary {
    background: linear-gradient(135deg, #D4AF37 0%, #B8941F 100%);
    color: white;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #B8941F 0%, #9A7B1A 100%);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(212, 175, 55, 0.3);
}

.categories-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 1.5rem;
}

.category-card {
    background: white;
    border-radius: 1rem;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    transition: all 0.3s ease;
}

.category-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.category-header {
    padding: 1.5rem;
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    border-bottom: 1px solid #e5e7eb;
}

.category-name {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 0.5rem;
}

.category-slug {
    font-size: 0.8rem;
    color: #6b7280;
    font-family: monospace;
    background: #f3f4f6;
    padding: 0.25rem 0.5rem;
    border-radius: 0.25rem;
    display: inline-block;
}

.category-body {
    padding: 1.5rem;
}

.category-description {
    color: #6b7280;
    margin-bottom: 1rem;
    line-height: 1.5;
}

.category-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
    font-size: 0.8rem;
    color: #9ca3af;
}

.category-status {
    padding: 0.25rem 0.75rem;
    border-radius: 9999px;
    font-size: 0.7rem;
    font-weight: 600;
    text-transform: uppercase;
}

.status-active {
    background: #dcfce7;
    color: #16a34a;
}

.status-inactive {
    background: #fee2e2;
    color: #dc2626;
}

.category-actions {
    display: flex;
    gap: 0.5rem;
}

.btn-sm {
    padding: 0.5rem 1rem;
    font-size: 0.8rem;
}

.btn-secondary {
    background: #6b7280;
    color: white;
}

.btn-secondary:hover {
    background: #4b5563;
}

.btn-danger {
    background: #ef4444;
    color: white;
}

.btn-danger:hover {
    background: #dc2626;
}

.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    background: white;
    border-radius: 1rem;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.empty-state i {
    font-size: 4rem;
    color: #d1d5db;
    margin-bottom: 1rem;
}

.empty-state h3 {
    font-size: 1.5rem;
    color: #374151;
    margin-bottom: 0.5rem;
}

.empty-state p {
    color: #6b7280;
    margin-bottom: 2rem;
}

.alert {
    padding: 1rem 1.5rem;
    border-radius: 0.5rem;
    margin-bottom: 2rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.alert-success {
    background: #dcfce7;
    color: #16a34a;
    border: 1px solid #bbf7d0;
}

@media (max-width: 768px) {
    .categories-container {
        padding: 1rem;
    }
    
    .categories-header {
        padding: 1.5rem;
    }
    
    .categories-actions {
        flex-direction: column;
        align-items: stretch;
    }
    
    .categories-grid {
        grid-template-columns: 1fr;
    }
}
</style>
@endpush

@section('content')
<div class="categories-container">
    <!-- Header -->
    <div class="categories-header">
        <h1><i class="fas fa-folder-open"></i> Gestion des Catégories</h1>
        <p>Organisez et gérez les catégories de vos articles</p>
    </div>

    <!-- Messages de succès -->
    @if(session('success'))
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i>
        {{ session('success') }}
    </div>
    @endif

    <!-- Actions -->
    <div class="categories-actions">
        <div>
            <h2 style="margin: 0; color: #374151; font-size: 1.25rem;">
                <i class="fas fa-list"></i> Liste des Catégories
            </h2>
        </div>
        <a href="{{ route('dashboard.categories.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i>
            Créer une Catégorie
        </a>
    </div>

    <!-- Liste des catégories -->
    @if($categories->count() > 0)
        <div class="categories-grid">
            @foreach($categories as $category)
            <div class="category-card">
                <div class="category-header">
                    <div class="category-name">{{ $category->name }}</div>
                    <div class="category-slug">/categories/{{ $category->slug }}</div>
                </div>
                <div class="category-body">
                    <div class="category-description">
                        {{ $category->description ?: 'Aucune description disponible.' }}
                    </div>
                    <div class="category-meta">
                        <span>{{ $category->articles_count ?? 0 }} articles</span>
                        <span class="category-status status-{{ $category->status }}">
                            {{ $category->status === 'active' ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                    <div class="category-actions">
                        <a href="{{ route('dashboard.categories.edit', $category->id) }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-edit"></i>
                            Modifier
                        </a>
                        <form action="{{ route('dashboard.categories.delete', $category->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ? Cette action est irréversible.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i>
                                Supprimer
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <!-- État vide -->
        <div class="empty-state">
            <i class="fas fa-folder-open"></i>
            <h3>Aucune catégorie trouvée</h3>
            <p>Vous n'avez pas encore créé de catégories. Commencez par créer votre première catégorie pour organiser vos articles.</p>
            <a href="{{ route('dashboard.categories.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i>
                Créer votre première catégorie
            </a>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<!-- Aucun script requis pour la suppression désormais; utilisation d'un formulaire natif -->
@endpush
