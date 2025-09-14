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

.article-detail-section {
    background: #f8f9fa;
    min-height: 100vh;
    padding: 1rem;
}

.article-header-card {
    background: white;
    border-radius: 12px;
    box-shadow: var(--shadow-light);
    padding: 2rem;
    margin-bottom: 2rem;
}

.article-content-card {
    background: white;
    border-radius: 12px;
    box-shadow: var(--shadow-light);
    padding: 2rem;
    margin-bottom: 2rem;
}

.article-meta-card {
    background: white;
    border-radius: 12px;
    box-shadow: var(--shadow-light);
    padding: 1.5rem;
}

.page-header-modern {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.header-actions {
    display: flex;
    gap: 0.5rem;
}

.btn {
    padding: 0.5rem 1rem;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-primary {
    background: linear-gradient(135deg, var(--ea-gold), #e6b800);
    color: #000;
    border: none;
}

.btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: var(--shadow-hover);
    color: #000;
    text-decoration: none;
}

.btn-secondary {
    background: #6c757d;
    color: white;
    border: none;
}

.btn-secondary:hover {
    background: #5a6268;
    color: white;
    text-decoration: none;
}

.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    border-radius: 50px;
    font-size: 0.875rem;
    font-weight: 500;
}

.status-badge.published {
    background: #d1fae5;
    color: #065f46;
}

.status-badge.draft {
    background: #f3f4f6;
    color: #374151;
}

.status-badge.pending {
    background: #fef3c7;
    color: #92400e;
}

.status-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
}

.status-dot.online {
    background-color: #10b981;
}

.status-dot.offline {
    background-color: #6b7280;
}

.status-dot.pending {
    background-color: #f59e0b;
}

.article-image {
    width: 100%;
    max-height: 400px;
    object-fit: cover;
    border-radius: 8px;
    margin-bottom: 1.5rem;
}

.article-title {
    font-size: 2rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 1rem;
    line-height: 1.3;
}

.article-excerpt {
    font-size: 1.1rem;
    color: var(--text-secondary);
    font-style: italic;
    margin-bottom: 1.5rem;
    line-height: 1.6;
}

.article-content {
    font-size: 1rem;
    line-height: 1.7;
    color: var(--text-primary);
}

.article-content h1, .article-content h2, .article-content h3 {
    margin-top: 2rem;
    margin-bottom: 1rem;
}

.article-content p {
    margin-bottom: 1rem;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 1rem;
}

.meta-label {
    font-weight: 600;
    color: var(--text-primary);
}

.meta-value {
    color: var(--text-secondary);
}

.author-avatar {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--ea-gold), var(--ea-blue));
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 600;
    font-size: 0.875rem;
}

@media (max-width: 768px) {
    .article-detail-section {
        padding: 0.5rem;
    }

    .article-header-card,
    .article-content-card,
    .article-meta-card {
        padding: 1rem;
    }

    .article-title {
        font-size: 1.5rem;
    }

    .page-header-modern {
        flex-direction: column;
        gap: 1rem;
    }
}
</style>
@endpush

@section('title', 'Détails de l\'article')

@section('content')
<div class="article-detail-section">
    <!-- Header -->
    <div class="article-header-card">
        <div class="page-header-modern">
            <div class="d-flex align-items-center gap-3">
                <div class="header-icon" style="width: 50px; height: 50px; background: linear-gradient(135deg, var(--ea-gold), var(--ea-blue)); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white;">
                    <i class="fas fa-newspaper"></i>
                </div>
                <div>
                    <h1 style="margin: 0; font-size: 1.5rem; color: var(--text-primary);">Détails de l'article</h1>
                    <div class="breadcrumb-modern" style="font-size: 0.875rem; color: var(--text-secondary); margin-top: 0.25rem;">
                        <a href="{{ url('/dashboard') }}" style="color: var(--text-secondary); text-decoration: none;">
                            <i class="fas fa-home"></i> Dashboard
                        </a>
                        <i class="fas fa-chevron-right mx-2"></i>
                        <a href="{{ route('dashboard.articles') }}" style="color: var(--text-secondary); text-decoration: none;">
                            Articles
                        </a>
                        <i class="fas fa-chevron-right mx-2"></i>
                        <span style="color: var(--ea-gold); font-weight: 500;">Détails</span>
                    </div>
                </div>
            </div>

            <div class="header-actions">
                @if(auth()->check() && auth()->user()->peutModifierArticle($article))
                    <a href="{{ route('dashboard.articles.edit', $article->id) }}" class="btn btn-primary">
                        <i class="fas fa-edit me-2"></i>Modifier
                    </a>
                @endif
                <a href="{{ route('dashboard.articles') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Retour
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Contenu principal -->
        <div class="col-lg-8">
            <div class="article-content-card">
                <!-- Image de l'article -->
                @if($article->featured_image_path && file_exists(public_path('storage/' . $article->featured_image_path)))
                    <img src="{{ asset('storage/' . $article->featured_image_path) }}"
                         class="article-image" alt="{{ $article->title }}">
                @elseif($article->featured_image_url)
                    <img src="{{ $article->featured_image_url }}"
                         class="article-image" alt="{{ $article->title }}">
                @endif

                <!-- Titre -->
                <h1 class="article-title">{{ $article->title }}</h1>

                <!-- Extrait -->
                @if($article->excerpt)
                    <div class="article-excerpt">
                        {{ $article->excerpt }}
                    </div>
                @endif

                <!-- Contenu -->
                <div class="article-content">
                    {!! nl2br(e($article->content)) !!}
                </div>
            </div>
        </div>

        <!-- Métadonnées -->
        <div class="col-lg-4">
            <div class="article-meta-card">
                <h3 style="margin-bottom: 1.5rem; color: var(--text-primary);">Informations</h3>

                <!-- Statut -->
                <div class="meta-item">
                    <span class="meta-label">Statut :</span>
                    @if($article->status === 'published')
                        <span class="status-badge published">
                            <span class="status-dot online"></span>
                            Publié
                        </span>
                    @elseif($article->status === 'draft')
                        <span class="status-badge draft">
                            <span class="status-dot offline"></span>
                            Brouillon
                        </span>
                    @elseif($article->status === 'pending')
                        <span class="status-badge pending">
                            <span class="status-dot pending"></span>
                            En attente
                        </span>
                    @else
                        <span class="status-badge">
                            <span class="status-dot offline"></span>
                            {{ ucfirst($article->status) }}
                        </span>
                    @endif
                </div>

                <!-- Auteur -->
                <div class="meta-item">
                    <span class="meta-label">Auteur :</span>
                    <div class="d-flex align-items-center gap-2">
                        <div class="author-avatar">
                            {{ strtoupper(substr($article->user->name ?? 'U', 0, 1)) }}
                        </div>
                        <span class="meta-value">{{ $article->user->name ?? 'Utilisateur inconnu' }}</span>
                    </div>
                </div>

                <!-- Catégorie -->
                <div class="meta-item">
                    <span class="meta-label">Catégorie :</span>
                    <span class="badge bg-primary">{{ $article->category->name ?? 'Sans catégorie' }}</span>
                </div>

                <!-- Date de création -->
                <div class="meta-item">
                    <span class="meta-label">Créé le :</span>
                    <span class="meta-value">{{ $article->created_at->format('d M Y à H:i') }}</span>
                </div>

                <!-- Date de mise à jour -->
                @if($article->updated_at != $article->created_at)
                    <div class="meta-item">
                        <span class="meta-label">Modifié le :</span>
                        <span class="meta-value">{{ $article->updated_at->format('d M Y à H:i') }}</span>
                    </div>
                @endif

                <!-- Nombre de vues -->
                <div class="meta-item">
                    <span class="meta-label">Vues :</span>
                    <span class="meta-value">{{ number_format($article->view_count ?? 0) }}</span>
                </div>

                <!-- Date de publication -->
                @if($article->published_at)
                    <div class="meta-item">
                        <span class="meta-label">Publié le :</span>
                        <span class="meta-value">{{ $article->published_at->format('d M Y à H:i') }}</span>
                    </div>
                @endif

                <!-- Lien public -->
                @if($article->status === 'published')
                    <div class="meta-item" style="margin-top: 1.5rem; padding-top: 1rem; border-top: 1px solid var(--card-border);">
                        <a href="{{ route('articles.show', $article->slug) }}" target="_blank"
                           class="btn btn-outline-primary btn-sm w-100">
                            <i class="fas fa-external-link-alt me-2"></i>
                            Voir sur le site
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection