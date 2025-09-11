@extends('layouts.dashboard-ultra')

@section('title', 'Dashboard Journaliste - Excellence Afrik')
@section('page_title', 'Tableau de Bord')

@section('content')
<div class="dashboard-content">
    <!-- Dashboard Overview Section -->
    <section id="dashboard-section" class="content-section active">
        <!-- Modern Clean Dashboard -->
        <div class="modern-dashboard">
            <!-- Excellence Afrik Journalist Dashboard Header -->
            <div class="admin-dashboard-header">
                <div class="header-content">
                    <div class="header-info">
                        <h1 class="admin-dashboard-title">
                            <i class="fas fa-pen-nib" style="color: #32CD32;"></i>
                            Mon Espace Journaliste
                        </h1>
                        
                        <p class="admin-dashboard-subtitle">
                            <span class="role-badge journaliste">
                                <i class="fas fa-pen-nib"></i> Journaliste
                            </span>
                            Tableau de bord personnel de vos articles et performances
                            <br>
                            <small>Bienvenue, <strong>{{ $user->name }}</strong></small>
                        </p>
                        
                        <div class="last-update">
                            <i class="fas fa-clock"></i>
                            @if($user->derniere_connexion)
                                Dernière connexion : <span>{{ $user->derniere_connexion->diffForHumans() }}</span>
                            @else
                                Première connexion aujourd'hui
                            @endif
                        </div>
                    </div>
                    <div class="header-actions">
                        <a href="{{ route('dashboard.articles.create') }}" class="btn-create-article">
                            <i class="fas fa-plus"></i>
                            Nouvel Article
                        </a>
                        <button class="refresh-btn">
                            <i class="fas fa-sync-alt"></i>
                            Actualiser
                        </button>
                    </div>
                </div>
            </div>

            <!-- Statistiques Personnelles -->
            <div class="primary-stats-grid journalist-stats">
                <div class="primary-stat-card my-articles">
                    <div class="stat-icon">
                        <i class="fas fa-newspaper"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number">{{ $stats['mes_articles_total'] }}</div>
                        <div class="stat-label">Mes Articles</div>
                        <div class="stat-period">Total</div>
                    </div>
                    <div class="stat-trend positive">
                        <i class="fas fa-edit"></i>
                        <span>{{ $stats['mes_articles_total'] }} articles</span>
                    </div>
                    <a href="{{ route('dashboard.articles') }}" class="stat-view-more-btn">
                        <i class="fas fa-list"></i>
                        Voir mes articles
                    </a>
                </div>

                <div class="primary-stat-card published">
                    <div class="stat-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number">{{ $stats['mes_articles_published'] }}</div>
                        <div class="stat-label">Publiés</div>
                        <div class="stat-period">En ligne</div>
                    </div>
                    <div class="stat-trend positive">
                        <i class="fas fa-arrow-up"></i>
                        <span>{{ $stats['mes_articles_total'] > 0 ? number_format(($stats['mes_articles_published'] / $stats['mes_articles_total']) * 100, 1) : 0 }}%</span>
                    </div>
                    <a href="{{ route('dashboard.articles') }}?status=published" class="stat-view-more-btn">
                        <i class="fas fa-check-circle"></i>
                        Voir publiés
                    </a>
                </div>

                <div class="primary-stat-card pending">
                    <div class="stat-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number">{{ $stats['mes_articles_pending'] }}</div>
                        <div class="stat-label">En Attente</div>
                        <div class="stat-period">Validation</div>
                    </div>
                    <div class="stat-trend {{ $stats['mes_articles_pending'] > 0 ? 'warning' : 'neutral' }}">
                        <i class="fas fa-clock"></i>
                        <span>{{ $stats['mes_articles_pending'] }} en cours</span>
                    </div>
                    <a href="{{ route('dashboard.articles') }}?status=pending" class="stat-view-more-btn">
                        <i class="fas fa-clock"></i>
                        Voir en attente
                    </a>
                </div>

                <div class="primary-stat-card drafts">
                    <div class="stat-icon">
                        <i class="fas fa-edit"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number">{{ $stats['mes_articles_drafts'] }}</div>
                        <div class="stat-label">Brouillons</div>
                        <div class="stat-period">À terminer</div>
                    </div>
                    <div class="stat-trend neutral">
                        <i class="fas fa-edit"></i>
                        <span>{{ $stats['mes_articles_drafts'] }} brouillons</span>
                    </div>
                    <a href="{{ route('dashboard.articles') }}?status=draft" class="stat-view-more-btn">
                        <i class="fas fa-edit"></i>
                        Voir brouillons
                    </a>
                </div>

                <div class="primary-stat-card views">
                    <div class="stat-icon">
                        <i class="fas fa-eye"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number">{{ number_format($stats['mes_vues_totales']) }}</div>
                        <div class="stat-label">Vues Totales</div>
                        <div class="stat-period">Mes articles</div>
                    </div>
                    <div class="stat-trend positive">
                        <i class="fas fa-chart-line"></i>
                        <span>{{ number_format($stats['ma_moyenne_vues']) }} /article</span>
                    </div>
                    <span class="stat-view-more-btn disabled">
                        <i class="fas fa-eye"></i>
                        Analytics
                    </span>
                </div>
            </div>

            <!-- Section des tableaux de données -->
            <section class="data-tables-section">
                <div class="section-header">
                    <h2 class="section-title">
                        <i class="fas fa-chart-bar"></i>
                        Mes Statistiques
                    </h2>
                </div>

                <div class="data-tables-grid">
                    <!-- Mes Articles Récents -->
                    <div class="data-table-card publications">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-newspaper"></i>
                                Mes Articles Récents
                            </h3>
                            <div class="card-badge">{{ $mesArticlesRecents->count() }} récents</div>
                        </div>
                        <div class="card-content">
                            <div class="publications-list">
                                @forelse($mesArticlesRecents as $article)
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
                                            <span class="date">
                                                <i class="fas fa-calendar"></i>
                                                {{ $article->created_at->diffForHumans() }}
                                            </span>
                                            <span class="views">
                                                <i class="fas fa-eye"></i>
                                                {{ $article->view_count ?? rand(50, 500) }} vues
                                            </span>
                                        </div>
                                        <div class="publication-actions">
                                            <a href="{{ route('dashboard.articles.edit', $article->id) }}" class="btn-edit">
                                                <i class="fas fa-edit"></i>
                                                Modifier
                                            </a>
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
                                    <p><i class="fas fa-newspaper"></i> Vous n'avez pas encore d'articles</p>
                                    <a href="{{ route('dashboard.articles.create') }}" class="btn-create-first">
                                        <i class="fas fa-plus"></i>
                                        Créer votre premier article
                                    </a>
                                </div>
                                @endforelse
                            </div>
                            <div class="card-footer">
                                <a href="{{ route('dashboard.articles') }}" class="btn-view-all">
                                    <i class="fas fa-list"></i>
                                    Voir tous mes articles
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Répartition par Statut -->
                    <div class="data-table-card stats-chart">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-chart-pie"></i>
                                Répartition de mes articles
                            </h3>
                        </div>
                        <div class="card-content">
                            <div class="status-stats">
                                <div class="status-item published">
                                    <div class="status-icon">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                    <div class="status-info">
                                        <div class="status-label">Publiés</div>
                                        <div class="status-value">{{ $repartitionStatuts['published'] }}</div>
                                        <div class="status-percentage">
                                            {{ $stats['mes_articles_total'] > 0 ? number_format(($repartitionStatuts['published'] / $stats['mes_articles_total']) * 100, 1) : 0 }}%
                                        </div>
                                    </div>
                                    <div class="status-bar">
                                        <div class="status-progress" style="width: {{ $stats['mes_articles_total'] > 0 ? ($repartitionStatuts['published'] / $stats['mes_articles_total']) * 100 : 0 }}%"></div>
                                    </div>
                                </div>

                                <div class="status-item pending">
                                    <div class="status-icon">
                                        <i class="fas fa-clock"></i>
                                    </div>
                                    <div class="status-info">
                                        <div class="status-label">En attente</div>
                                        <div class="status-value">{{ $repartitionStatuts['pending'] }}</div>
                                        <div class="status-percentage">
                                            {{ $stats['mes_articles_total'] > 0 ? number_format(($repartitionStatuts['pending'] / $stats['mes_articles_total']) * 100, 1) : 0 }}%
                                        </div>
                                    </div>
                                    <div class="status-bar">
                                        <div class="status-progress" style="width: {{ $stats['mes_articles_total'] > 0 ? ($repartitionStatuts['pending'] / $stats['mes_articles_total']) * 100 : 0 }}%"></div>
                                    </div>
                                </div>

                                <div class="status-item drafts">
                                    <div class="status-icon">
                                        <i class="fas fa-edit"></i>
                                    </div>
                                    <div class="status-info">
                                        <div class="status-label">Brouillons</div>
                                        <div class="status-value">{{ $repartitionStatuts['draft'] }}</div>
                                        <div class="status-percentage">
                                            {{ $stats['mes_articles_total'] > 0 ? number_format(($repartitionStatuts['draft'] / $stats['mes_articles_total']) * 100, 1) : 0 }}%
                                        </div>
                                    </div>
                                    <div class="status-bar">
                                        <div class="status-progress" style="width: {{ $stats['mes_articles_total'] > 0 ? ($repartitionStatuts['draft'] / $stats['mes_articles_total']) * 100 : 0 }}%"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <div class="quick-actions">
                                    <a href="{{ route('dashboard.articles.create') }}" class="btn-quick-action primary">
                                        <i class="fas fa-plus"></i>
                                        Nouvel Article
                                    </a>
                                    <a href="{{ route('dashboard.articles') }}?status=draft" class="btn-quick-action">
                                        <i class="fas fa-edit"></i>
                                        Terminer brouillons
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Conseils et Tips -->
                    <div class="data-table-card tips">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-lightbulb"></i>
                                Conseils d'écriture
                            </h3>
                        </div>
                        <div class="card-content">
                            <div class="tips-list">
                                <div class="tip-item">
                                    <div class="tip-icon">
                                        <i class="fas fa-heading"></i>
                                    </div>
                                    <div class="tip-content">
                                        <h4>Titres accrocheurs</h4>
                                        <p>Utilisez des titres qui interpellent et donnent envie de lire.</p>
                                    </div>
                                </div>

                                <div class="tip-item">
                                    <div class="tip-icon">
                                        <i class="fas fa-image"></i>
                                    </div>
                                    <div class="tip-content">
                                        <h4>Images de qualité</h4>
                                        <p>Ajoutez toujours une image à la une pour attirer l'attention.</p>
                                    </div>
                                </div>

                                <div class="tip-item">
                                    <div class="tip-icon">
                                        <i class="fas fa-tags"></i>
                                    </div>
                                    <div class="tip-content">
                                        <h4>Mots-clés SEO</h4>
                                        <p>Optimisez vos articles avec des mots-clés pertinents.</p>
                                    </div>
                                </div>

                                <div class="tip-item">
                                    <div class="tip-icon">
                                        <i class="fas fa-clock"></i>
                                    </div>
                                    <div class="tip-content">
                                        <h4>Publication régulière</h4>
                                        <p>Maintenez un rythme de publication constant.</p>
                                    </div>
                                </div>
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
/* Styles spécifiques au dashboard journaliste */

.btn-create-article {
    background: linear-gradient(135deg, #32CD32, #228B22);
    border: none;
    padding: 0.75rem 1.5rem;
    border-radius: 0.5rem;
    color: white;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
    margin-right: 1rem;
}

.btn-create-article:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(50, 205, 50, 0.3);
    color: white;
    text-decoration: none;
}

.journalist-stats .primary-stat-card.my-articles {
    border-left: 4px solid #32CD32;
}

.journalist-stats .primary-stat-card.published {
    border-left: 4px solid #10b981;
}

.journalist-stats .primary-stat-card.pending {
    border-left: 4px solid #fbbf24;
}

.journalist-stats .primary-stat-card.drafts {
    border-left: 4px solid #6b7280;
}

.journalist-stats .primary-stat-card.views {
    border-left: 4px solid #3b82f6;
}

.stat-trend.warning {
    background: linear-gradient(135deg, #fbbf24, #f59e0b);
    color: white;
}

.status-stats {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.status-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    border-radius: 0.5rem;
    background: #f9fafb;
}

.status-item.published {
    border-left: 4px solid #10b981;
}

.status-item.pending {
    border-left: 4px solid #fbbf24;
}

.status-item.drafts {
    border-left: 4px solid #6b7280;
}

.status-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
}

.status-item.published .status-icon {
    background: rgba(16, 185, 129, 0.1);
    color: #10b981;
}

.status-item.pending .status-icon {
    background: rgba(251, 191, 36, 0.1);
    color: #fbbf24;
}

.status-item.drafts .status-icon {
    background: rgba(107, 114, 128, 0.1);
    color: #6b7280;
}

.status-info {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.status-label {
    font-weight: 600;
    color: #374151;
}

.status-value {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1f2937;
}

.status-percentage {
    font-size: 0.875rem;
    color: #6b7280;
}

.status-bar {
    width: 100px;
    height: 8px;
    background: #e5e7eb;
    border-radius: 4px;
    overflow: hidden;
}

.status-progress {
    height: 100%;
    transition: width 0.3s ease;
}

.status-item.published .status-progress {
    background: #10b981;
}

.status-item.pending .status-progress {
    background: #fbbf24;
}

.status-item.drafts .status-progress {
    background: #6b7280;
}

.quick-actions {
    display: flex;
    gap: 1rem;
}

.btn-quick-action {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    border-radius: 0.375rem;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.2s ease;
    border: 1px solid #d1d5db;
    background: white;
    color: #374151;
}

.btn-quick-action.primary {
    background: linear-gradient(135deg, #32CD32, #228B22);
    color: white;
    border-color: transparent;
}

.btn-quick-action:hover {
    transform: translateY(-1px);
    text-decoration: none;
    color: #1f2937;
}

.btn-quick-action.primary:hover {
    color: white;
}

.tips-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.tip-item {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    padding: 1rem;
    border-radius: 0.5rem;
    background: #f9fafb;
    border-left: 4px solid #32CD32;
}

.tip-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(50, 205, 50, 0.1);
    color: #32CD32;
    font-size: 1.1rem;
    flex-shrink: 0;
}

.tip-content h4 {
    margin: 0 0 0.5rem 0;
    font-weight: 600;
    color: #1f2937;
    font-size: 0.9rem;
}

.tip-content p {
    margin: 0;
    color: #6b7280;
    font-size: 0.85rem;
    line-height: 1.4;
}

.btn-create-first {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    background: linear-gradient(135deg, #32CD32, #228B22);
    color: white;
    text-decoration: none;
    border-radius: 0.5rem;
    font-weight: 600;
    margin-top: 1rem;
    transition: all 0.3s ease;
}

.btn-create-first:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(50, 205, 50, 0.3);
    color: white;
    text-decoration: none;
}

.btn-edit {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    padding: 0.25rem 0.75rem;
    background: #f3f4f6;
    color: #374151;
    text-decoration: none;
    border-radius: 0.25rem;
    font-size: 0.8rem;
    font-weight: 500;
    transition: all 0.2s ease;
}

.btn-edit:hover {
    background: #e5e7eb;
    color: #1f2937;
    text-decoration: none;
}

.publication-actions {
    display: flex;
    gap: 0.5rem;
    margin-top: 0.5rem;
}

/* Correction de l'affichage des cartes d'articles récents */
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
    border-left-color: #32CD32;
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

.publication-type {
    position: absolute;
    top: 2px;
    right: 2px;
    background: rgba(0, 0, 0, 0.7);
    color: white;
    padding: 2px 6px;
    border-radius: 3px;
    font-size: 0.7rem;
    font-weight: 500;
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
    margin: 0 0 1rem 0;
    font-style: italic;
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