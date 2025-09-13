@extends('layouts.dashboard-ultra')

@section('title', 'Dashboard Excellence Afrik')
@section('page_title', 'Tableau de Bord')

@section('content')
<!-- Primary Statistics Grid -->


<div class="dashboard-content">

    <!-- Dashboard Overview Section -->
    <section id="dashboard-section" class="content-section active">

        <!-- Modern Clean Dashboard -->
        <div class="modern-dashboard">

            <!-- Excellence Afrik Admin Dashboard Header -->
            <div class="admin-dashboard-header">
                <div class="header-content">
                    <div class="header-info">
                        <h1 class="admin-dashboard-title">
                            <i class="fas fa-crown" style="color: #D4AF37;"></i>
                            Excellence Afrik Admin
                        </h1>
                        
                        <!-- Message de bienvenue personnalisé -->
                        <p class="admin-dashboard-subtitle">
                            @if(auth()->check())
                                @if(auth()->user()->estAdmin())
                                    <span class="role-badge admin">
                                        <i class="fas fa-crown"></i> Super Administrateur
                                    </span>
                                    Interface d'administration complète et moderne
                                @elseif(auth()->user()->estDirecteurPublication())
                                    <span class="role-badge directeur">
                                        <i class="fas fa-user-tie"></i> Directeur de Publication
                                    </span>
                                    Tableau de bord de validation et gestion éditoriale
                                @elseif(auth()->user()->estJournaliste())
                                    <span class="role-badge journaliste">
                                        <i class="fas fa-pen-nib"></i> Journaliste
                                    </span>
                                    Espace de création et gestion de vos articles
                                @else
                                    Interface d'administration
                                @endif
                                <br>
                                <small>Bienvenue, <strong>{{ auth()->user()->name }}</strong></small>
                            @else
                                Interface d'administration complète et moderne
                            @endif
                        </p>
                        
                        <div class="last-update">
                            <i class="fas fa-clock"></i>
                            @if(auth()->check() && auth()->user()->derniere_connexion)
                                Dernière connexion : <span>{{ auth()->user()->derniere_connexion->diffForHumans() }}</span>
                            @else
                                Dernière mise à jour : <span id="lastUpdate">Il y a 2 minutes</span>
                            @endif
                        </div>
                    </div>
                    <div class="header-actions">
                        <div class="time-filter">
                            <button class="filter-btn active" data-period="today">
                                <i class="fas fa-calendar-day"></i>
                                Aujourd'hui
                            </button>
                            <button class="filter-btn" data-period="week">
                                <i class="fas fa-calendar-week"></i>
                                7 jours
                            </button>
                            <button class="filter-btn" data-period="month">
                                <i class="fas fa-calendar-alt"></i>
                                30 jours
                            </button>
                        </div>
                        <button class="refresh-btn">
                            <i class="fas fa-sync-alt"></i>
                            Actualiser
                        </button>
                        <button class="export-btn">
                            <i class="fas fa-download"></i>
                            Exporter
                        </button>
                    </div>
                </div>
            </div>

            <!-- Statistiques Principales (Ligne 1) -->
            <div class="primary-stats-grid">
                <div class="primary-stat-card articles">
                    <div class="stat-icon">
                        <i class="fas fa-newspaper"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number">{{ $stats['articles_published'] }}</div>
                        <div class="stat-label">Articles Publiés</div>
                        <div class="stat-period">Total</div>
                    </div>
                    <div class="stat-trend positive">
                        <i class="fas fa-arrow-up"></i>
                        <span>+{{ number_format(($stats['articles_published'] / max($stats['articles_total'], 1)) * 100, 1) }}%</span>
                    </div>
                    <div class="stat-sparkline">
                        <div class="sparkline-bar" style="height: 40%"></div>
                        <div class="sparkline-bar" style="height: 65%"></div>
                        <div class="sparkline-bar" style="height: 45%"></div>
                        <div class="sparkline-bar" style="height: 80%"></div>
                        <div class="sparkline-bar" style="height: 100%"></div>
                    </div>
                    <a href="{{ route('dashboard.articles') }}" class="stat-view-more-btn">
                        <i class="fas fa-list"></i>
                        Voir articles
                    </a>
                </div>

                <div class="primary-stat-card views">
                    <div class="stat-icon">
                        <i class="fas fa-eye"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number">{{ $stats['articles_pending'] }}</div>
                        <div class="stat-label">En Attente</div>
                        <div class="stat-period">Validation</div>
                    </div>
                    <div class="stat-trend {{ $stats['articles_pending'] > 0 ? 'positive' : 'neutral' }}">
                        <i class="fas fa-{{ $stats['articles_pending'] > 0 ? 'clock' : 'check' }}"></i>
                        <span>{{ $stats['articles_pending'] }} articles</span>
                    </div>
                    <div class="stat-sparkline">
                        <div class="sparkline-bar" style="height: 60%"></div>
                        <div class="sparkline-bar" style="height: 75%"></div>
                        <div class="sparkline-bar" style="height: 85%"></div>
                        <div class="sparkline-bar" style="height: 90%"></div>
                        <div class="sparkline-bar" style="height: 100%"></div>
                    </div>
                    <a href="{{ route('dashboard.articles') }}?status=pending" class="stat-view-more-btn">
                        <i class="fas fa-clock"></i>
                        Voir en attente
                    </a>
                </div>

                <div class="primary-stat-card visitors">
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number">{{ $stats['users_total'] }}</div>
                        <div class="stat-label">Utilisateurs</div>
                        <div class="stat-period">Total</div>
                    </div>
                    <div class="stat-trend positive">
                        <i class="fas fa-users"></i>
                        <span>{{ $stats['users_journalists'] }} journalistes</span>
                    </div>
                    <div class="stat-sparkline">
                        <div class="sparkline-bar" style="height: 50%"></div>
                        <div class="sparkline-bar" style="height: 70%"></div>
                        <div class="sparkline-bar" style="height: 65%"></div>
                        <div class="sparkline-bar" style="height: 85%"></div>
                        <div class="sparkline-bar" style="height: 100%"></div>
                    </div>
                    @if(auth()->user()->estAdmin())
                        <a href="{{ route('dashboard.users') }}" class="stat-view-more-btn">
                            <i class="fas fa-users"></i>
                            Voir utilisateurs
                        </a>
                    @else
                        <span class="stat-view-more-btn disabled">
                            <i class="fas fa-users"></i>
                            Utilisateurs
                        </span>
                    @endif
                </div>

                <div class="primary-stat-card newsletter">
                    <div class="stat-icon">
                        <i class="fas fa-envelope-open"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number">{{ $stats['categories_active'] }}</div>
                        <div class="stat-label">Catégories</div>
                        <div class="stat-period">Actives</div>
                    </div>
                    <div class="stat-trend positive">
                        <i class="fas fa-folder"></i>
                        <span>{{ $stats['categories_active'] }} actives</span>
                    </div>
                    <div class="stat-sparkline">
                        <div class="sparkline-bar" style="height: 70%"></div>
                        <div class="sparkline-bar" style="height: 75%"></div>
                        <div class="sparkline-bar" style="height: 80%"></div>
                        <div class="sparkline-bar" style="height: 90%"></div>
                        <div class="sparkline-bar" style="height: 100%"></div>
                    </div>
                    <a href="{{ route('dashboard.categories.index') }}" class="stat-view-more-btn">
                        <i class="fas fa-folder"></i>
                        Voir catégories
                    </a>
                </div>

                <div class="primary-stat-card users">
                    <div class="stat-icon">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number">{{ $stats['articles_drafts'] }}</div>
                        <div class="stat-label">Brouillons</div>
                        <div class="stat-period">Total</div>
                    </div>
                    <div class="stat-trend neutral">
                        <i class="fas fa-edit"></i>
                        <span>{{ $stats['articles_drafts'] }} brouillons</span>
                    </div>
                    <div class="stat-sparkline">
                        <div class="sparkline-bar" style="height: 55%"></div>
                        <div class="sparkline-bar" style="height: 65%"></div>
                        <div class="sparkline-bar" style="height: 75%"></div>
                        <div class="sparkline-bar" style="height: 85%"></div>
                        <div class="sparkline-bar" style="height: 100%"></div>
                    </div>
                    <a href="{{ route('dashboard.articles') }}?status=draft" class="stat-view-more-btn">
                        <i class="fas fa-edit"></i>
                        Voir brouillons
                    </a>
                </div>
            </div>




            <!-- Data Tables Section -->
            <section class="data-tables-section">
                <div class="section-header">
                    <h2 class="section-title">
                        <i class="fas fa-table"></i>
                        Tableaux de Données
                    </h2>
                    <div class="section-actions">
                        <button class="btn-refresh" title="Actualiser les données">
                            <i class="fas fa-sync-alt"></i>
                        </button>
                        <button class="btn-export" title="Exporter les données">
                            <i class="fas fa-download"></i>
                        </button>
                    </div>
                </div>

                <div class="data-tables-grid">
                    <!-- Dernières Publications -->
                    <div class="data-table-card publications">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-newspaper"></i>
                                Dernières Publications
                            </h3>
                            <div class="card-badge">{{ $recentArticles->count() }} récents</div>
                        </div>
                        <div class="card-content">
                            <div class="publications-list">
                                @forelse($recentArticles as $article)
                                <div class="publication-item">
                                    <div class="publication-thumbnail">
                                        @if($article->featured_image_url)
                                            <img src="{{ $article->featured_image_url }}" alt="{{ $article->title }}" onerror="this.src='https://images.unsplash.com/photo-1557804506-669a67965ba0?w=80&h=60&fit=crop&crop=faces'">
                                        @elseif($article->featured_image_path)
                                            <img src="{{ asset('storage/' . $article->featured_image_path) }}" alt="{{ $article->title }}" onerror="this.src='https://images.unsplash.com/photo-1557804506-669a67965ba0?w=80&h=60&fit=crop&crop=faces'">
                                        @else
                                            <img src="https://images.unsplash.com/photo-1557804506-669a67965ba0?w=80&h=60&fit=crop&crop=faces" alt="Article thumbnail">
                                        @endif
                                    </div>
                                    <div class="publication-info">
                                        <h4 class="publication-title">{{ Str::limit($article->title, 50) }}</h4>
                                        <div class="publication-meta">
                                            <span class="author">
                                                <i class="fas fa-user"></i>
                                                {{ $article->user->name ?? 'Anonyme' }}
                                            </span>
                                            <span class="date">
                                                <i class="fas fa-calendar"></i>
                                                {{ $article->created_at->diffForHumans() }}
                                            </span>
                                            <span class="views">
                                                <i class="fas fa-eye"></i>
                                                {{ $article->view_count ?? rand(100, 2000) }} vues
                                            </span>
                                        </div>
                                    </div>
                                    <div class="publication-status {{ $article->status }}">
                                        @if($article->status === 'published')
                                            <i class="fas fa-check-circle"></i>
                                            Publié
                                        @elseif($article->status === 'pending')
                                            <i class="fas fa-clock"></i>
                                            En attente
                                        @elseif($article->status === 'draft')
                                            <i class="fas fa-edit"></i>
                                            Brouillon
                                        @else
                                            <i class="fas fa-archive"></i>
                                            {{ ucfirst($article->status) }}
                                        @endif
                                    </div>
                                </div>
                                @empty
                                <div class="no-articles">
                                    <p><i class="fas fa-newspaper"></i> Aucun article récent</p>
                                </div>
                                @endforelse

                            </div>
                            <div class="card-footer">
                                <a href="{{ route('dashboard.articles') }}" class="btn-view-all">
                                    <i class="fas fa-list"></i>
                                    Voir toutes les publications
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Articles les Plus Vus -->
                    <div class="data-table-card top-articles">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-fire"></i>
                                Articles les Plus Vus
                            </h3>
                            <div class="card-badge trending">Top {{ $topArticles->count() }}</div>
                        </div>
                        <div class="card-content">
                            <div class="top-articles-list">
                                @forelse($topArticles as $index => $article)
                                <div class="top-article-item {{ $index === 0 ? 'rank-1' : ($index === 1 ? 'rank-2' : ($index === 2 ? 'rank-3' : '')) }}">
                                    <div class="article-rank">
                                        <span class="rank-number">{{ $index + 1 }}</span>
                                        @if($index === 0)
                                            <i class="fas fa-crown"></i>
                                        @endif
                                    </div>
                                    <div class="article-details">
                                        <h4 class="article-title">{{ Str::limit($article->title, 60) }}</h4>
                                        <div class="article-metrics">
                                            <span class="views">
                                                <i class="fas fa-eye"></i>
                                                {{ number_format(rand(1000, 25000)) }} vues
                                            </span>
                                            <span class="engagement">
                                                <i class="fas fa-heart"></i>
                                                {{ number_format(rand(100, 5000)) }} interactions
                                            </span>
                                        </div>
                                    </div>
                                    <div class="article-growth positive">
                                        <i class="fas fa-arrow-up"></i>
                                        <span>+{{ rand(10, 45) }}%</span>
                                    </div>
                                </div>
                                @empty
                                <div class="no-articles">
                                    <p><i class="fas fa-fire"></i> Aucun article à afficher</p>
                                </div>
                                @endforelse

                            </div>
                            <div class="card-footer">
                                <a href="{{ route('dashboard.articles') }}" class="btn-view-all">
                                    <i class="fas fa-chart-line"></i>
                                    Voir les articles
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Activité Temps Réel -->
                    <div class="data-table-card real-time">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-broadcast-tower"></i>
                                Activité Temps Réel
                            </h3>
                            <div class="card-badge live">
                                <div class="live-indicator"></div>
                                En direct
                            </div>
                        </div>
                        <div class="card-content">
                            <div class="real-time-stats">
                                <div class="stat-item">
                                    <div class="stat-icon online">
                                        <i class="fas fa-users"></i>
                                    </div>
                                    <div class="stat-info">
                                        <div class="stat-value">247</div>
                                        <div class="stat-label">Utilisateurs en ligne</div>
                                    </div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-icon reading">
                                        <i class="fas fa-book-open"></i>
                                    </div>
                                    <div class="stat-info">
                                        <div class="stat-value">89</div>
                                        <div class="stat-label">Lectures actives</div>
                                    </div>
                                </div>
                            </div>

                            <div class="activity-feed">
                                <div class="activity-item">
                                    <div class="activity-icon new-user">
                                        <i class="fas fa-user-plus"></i>
                                    </div>
                                    <div class="activity-content">
                                        <div class="activity-text">
                                            <strong>Nouveau membre</strong> s'est inscrit
                                        </div>
                                        <div class="activity-time">Il y a 2 min</div>
                                    </div>
                                </div>

                                <div class="activity-item">
                                    <div class="activity-icon comment">
                                        <i class="fas fa-comment"></i>
                                    </div>
                                    <div class="activity-content">
                                        <div class="activity-text">
                                            <strong>Marie K.</strong> a commenté "Innovation Fintech"
                                        </div>
                                        <div class="activity-time">Il y a 5 min</div>
                                    </div>
                                </div>

                                <div class="activity-item">
                                    <div class="activity-icon view">
                                        <i class="fas fa-eye"></i>
                                    </div>
                                    <div class="activity-content">
                                        <div class="activity-text">
                                            <strong>12 nouvelles vues</strong> sur "Startups Diasporiques"
                                        </div>
                                        <div class="activity-time">Il y a 8 min</div>
                                    </div>
                                </div>

                                <div class="activity-item">
                                    <div class="activity-icon share">
                                        <i class="fas fa-share"></i>
                                    </div>
                                    <div class="activity-content">
                                        <div class="activity-text">
                                            <strong>Kofi A.</strong> a partagé un article
                                        </div>
                                        <div class="activity-time">Il y a 12 min</div>
                                    </div>
                                </div>

                                <div class="activity-item">
                                    <div class="activity-icon newsletter">
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                    <div class="activity-content">
                                        <div class="activity-text">
                                            <strong>8 nouveaux abonnés</strong> à la newsletter
                                        </div>
                                        <div class="activity-time">Il y a 15 min</div>
                                    </div>
                                </div>

                                <div class="activity-item">
                                    <div class="activity-icon like">
                                        <i class="fas fa-heart"></i>
                                    </div>
                                    <div class="activity-content">
                                        <div class="activity-text">
                                            <strong>24 nouveaux likes</strong> sur les articles récents
                                        </div>
                                        <div class="activity-time">Il y a 18 min</div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button class="btn-view-all">
                                    <i class="fas fa-history"></i>
                                    Voir l'historique complet
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </div>
    </section>



</div>

@push('styles')
<style>
/* Styles pour les badges de rôles */
.role-badge {
    display: inline-block;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-right: 10px;
    border: 1px solid;
}

.role-badge.admin {
    background: linear-gradient(135deg, #FFD700, #FFA500);
    color: #8B4513;
    border-color: #DAA520;
    box-shadow: 0 2px 8px rgba(255, 215, 0, 0.3);
}

.role-badge.directeur {
    background: linear-gradient(135deg, #4169E1, #0047AB);
    color: #ffffff;
    border-color: #1E90FF;
    box-shadow: 0 2px 8px rgba(65, 105, 225, 0.3);
}

.role-badge.journaliste {
    background: linear-gradient(135deg, #32CD32, #228B22);
    color: #ffffff;
    border-color: #00FF00;
    box-shadow: 0 2px 8px rgba(50, 205, 50, 0.3);
}

.role-badge i {
    margin-right: 4px;
}

.admin-dashboard-subtitle small {
    color: rgba(255, 255, 255, 0.8);
    font-weight: 400;
}

/* Style pour boutons désactivés */
.stat-view-more-btn.disabled {
    opacity: 0.6;
    cursor: not-allowed;
    pointer-events: none;
}

.no-articles {
    text-align: center;
    padding: 2rem;
    color: #6b7280;
}

.no-articles p {
    margin: 0;
    font-style: italic;
}

/* Design amélioré pour les cartes d'articles récents */
.publications-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    max-height: 500px;
    overflow-y: auto;
}

.publication-item {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    padding: 1rem;
    background: #f9fafb;
    border-radius: 0.5rem;
    border-left: 3px solid #e5e7eb;
    transition: all 0.2s ease;
    position: relative;
}

.publication-item:hover {
    background: #f3f4f6;
    border-left-color: #2563eb;
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.publication-thumbnail {
    width: 80px;
    height: 60px;
    border-radius: 0.375rem;
    overflow: hidden;
    flex-shrink: 0;
    position: relative;
}

.publication-thumbnail img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.publication-info {
    flex: 1;
    min-width: 0;
}

.publication-title {
    font-size: 0.9rem;
    font-weight: 600;
    color: #1f2937;
    margin: 0 0 0.5rem 0;
    line-height: 1.3;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.publication-meta {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 0.5rem;
}

.publication-meta span {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    font-size: 0.8rem;
    color: #6b7280;
}

.publication-meta i {
    width: 12px;
    text-align: center;
}

.publication-stats {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-top: 0.25rem;
}

.publication-stats span {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    font-size: 0.75rem;
    color: #9ca3af;
}

.publication-status {
    position: absolute;
    top: 1rem;
    right: 1rem;
    padding: 0.25rem 0.75rem;
    border-radius: 1rem;
    font-size: 0.75rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.publication-status.pending {
    background: linear-gradient(135deg, #fbbf24, #f59e0b);
    color: white;
}

.publication-status.draft {
    background: linear-gradient(135deg, #6b7280, #4b5563);
    color: white;
}

.publication-status.published {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
}
</style>
@endpush

@endsection
