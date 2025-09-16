@extends('layouts.dashboard-ultra')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/dashboard-ultra.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/dashboard-pages.css') }}">
<style>
/* Variables CSS pour la cohérence */
:root {
    --ea-gold: #F2CB05;
    --ea-blue: #2563eb;
    --ea-green: #10b981;
    --ea-danger: #dc3545;
    --card-bg: #ffffff;
    --card-border: #e9ecef;
    --text-primary: #2c3e50;
    --text-secondary: #6c757d;
    --shadow-light: 0 2px 10px rgba(0,0,0,0.08);
    --shadow-hover: 0 4px 20px rgba(0,0,0,0.12);
}

.articles-management-section {
    background: #f8f9fa;
    min-height: 100vh;
}

.page-header-modern {
    background: white;
    border-radius: 12px;
    box-shadow: var(--shadow-light);
    padding: 2rem;
    margin-bottom: 2rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1rem;
}

.header-actions {
    display: flex;
    gap: 1rem;
    align-items: center;
}

.btn-primary-modern {
    background: linear-gradient(135deg, var(--ea-gold), #e6b800);
    color: #000;
    padding: 0.75rem 1.5rem;
    border-radius: 10px;
    text-decoration: none;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    border: none;
    transition: all 0.3s ease;
    cursor: pointer;
}

.btn-primary-modern:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-hover);
    color: #000;
    text-decoration: none;
}
</style>
@endpush

@section('title', 'Gestion des Articles À la une')

@section('content')
<div class="articles-management-section">
    <div class="page-header-modern">
        <div class="header-content">
            <div class="header-main">
                <div class="header-icon">
                    <i class="fas fa-star"></i>
                </div>
                <div class="header-info">
                    <h1 class="page-title">Gestion des Articles "À la une"</h1>
                    <p class="page-subtitle">Créez, modifiez et gérez les articles "À la une"</p>
                </div>
            </div>
        </div>
        <div class="header-actions">
            <a href="{{ route('dashboard.a_la_une.create') }}" class="btn-primary-modern">
                <i class="fas fa-plus"></i>
                <span>Nouvel article "À la une"</span>
            </a>
        </div>
    </div>

    <div class="dashboard-card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">Liste des Articles "À la une" ({{ $articles->count() }})</h3>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Article</th>
                            <th>Auteur</th>
                            <th>Catégorie</th>
                            <th>Statut</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($articles as $article)
                        <tr>
                            <td>{{ $article->title }}</td>
                            <td>{{ $article->user->name ?? 'N/A' }}</td>
                            <td>{{ $article->category->name ?? 'N/A' }}</td>
                            <td><span class="badge bg-{{ $article->status == 'published' ? 'success' : 'secondary' }}">{{ $article->status }}</span></td>
                            <td>{{ $article->created_at->translatedFormat('d F Y') }}</td>
                            <td>
                                <a href="{{ route('dashboard.a_la_une.edit', $article->id) }}" class="btn btn-sm btn-primary">Modifier</a>
                                <form action="{{ route('dashboard.a_la_une.destroy', $article->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet article ?')">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Aucun article "À la une" pour le moment.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
