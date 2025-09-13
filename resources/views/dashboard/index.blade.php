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
                        <div class="stat-number">{{ number_format($stats['articles_total'] ?? 0) }}</div>
                        <div class="stat-label">Articles Publiés</div>
                        <div class="stat-value">{{ number_format($stats['articles_total'] ?? 0) }}</div>
                        <div class="stat-label">Total Articles</div>
                    </div>
                    <div class="stat-trend positive">
                        <i class="fas fa-arrow-up"></i>
                        <span>{{ number_format($stats['articles_published'] ?? 0) }} publiés</span>
                    </div>
                    <div class="stat-sparkline">
                        <div class="sparkline-bar" style="height: 40%"></div>
                        <div class="sparkline-bar" style="height: 65%"></div>
                        <div class="sparkline-bar" style="height: 45%"></div>
                        <div class="sparkline-bar" style="height: 80%"></div>
                        <div class="sparkline-bar" style="height: 100%"></div>
                    </div>
                    <button class="stat-view-more-btn" data-stat="articles">
                        <i class="fas fa-chart-line"></i>
                        Voir plus
                    </button>
                </div>

                <div class="primary-stat-card views">
                    <div class="stat-icon">
                        <i class="fas fa-eye"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number">{{ number_format($stats['views_total'] ?? 0) }}</div>
                        <div class="stat-label">Vues Totales</div>
                        <div class="stat-period">Ce mois</div>
                    </div>
                    <div class="stat-trend positive">
                        <i class="fas fa-arrow-up"></i>
                        <span>{{ number_format($stats['views_published'] ?? 0) }} vues</span>
                    </div>
                    <div class="stat-sparkline">
                        <div class="sparkline-bar" style="height: 60%"></div>
                        <div class="sparkline-bar" style="height: 75%"></div>
                        <div class="sparkline-bar" style="height: 85%"></div>
                        <div class="sparkline-bar" style="height: 90%"></div>
                        <div class="sparkline-bar" style="height: 100%"></div>
                    </div>
                    <button class="stat-view-more-btn" data-stat="views">
                        <i class="fas fa-eye"></i>
                        Voir plus
                    </button>
                </div>

                <div class="primary-stat-card visitors">
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number">{{ number_format($stats['visitors_total'] ?? 0) }}</div>
                        <div class="stat-label">Visiteurs Uniques</div>
                        <div class="stat-period">Ce mois</div>
                    </div>
                    <div class="stat-trend positive">
                        <i class="fas fa-arrow-up"></i>
                        <span>{{ number_format($stats['visitors_published'] ?? 0) }} visiteurs</span>
                    </div>
                    <div class="stat-sparkline">
                        <div class="sparkline-bar" style="height: 50%"></div>
                        <div class="sparkline-bar" style="height: 70%"></div>
                        <div class="sparkline-bar" style="height: 65%"></div>
                        <div class="sparkline-bar" style="height: 85%"></div>
                        <div class="sparkline-bar" style="height: 100%"></div>
                    </div>
                    <button class="stat-view-more-btn" data-stat="visitors">
                        <i class="fas fa-users"></i>
                        Voir plus
                    </button>
                </div>

                <div class="primary-stat-card newsletter">
                    <div class="stat-icon">
                        <i class="fas fa-envelope-open"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number">{{ number_format($stats['newsletter_total'] ?? 0) }}</div>
                        <div class="stat-label">Abonnés Newsletter</div>
                        <div class="stat-period">Total</div>
                    </div>
                    <div class="stat-trend positive">
                        <i class="fas fa-arrow-up"></i>
                        <span>{{ number_format($stats['newsletter_published'] ?? 0) }} abonnés</span>
                    </div>
                    <div class="stat-sparkline">
                        <div class="sparkline-bar" style="height: 70%"></div>
                        <div class="sparkline-bar" style="height: 75%"></div>
                        <div class="sparkline-bar" style="height: 80%"></div>
                        <div class="sparkline-bar" style="height: 90%"></div>
                        <div class="sparkline-bar" style="height: 100%"></div>
                    </div>
                    <button class="stat-view-more-btn" data-stat="newsletter">
                        <i class="fas fa-envelope-open"></i>
                        Voir plus
                    </button>
                </div>

                <div class="primary-stat-card users">
                    <div class="stat-icon">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number">{{ number_format($stats['users_total'] ?? 0) }}</div>
                        <div class="stat-label">Utilisateurs Inscrits</div>
                        <div class="stat-period">Total</div>
                    </div>
                    <div class="stat-trend positive">
                        <i class="fas fa-arrow-up"></i>
                        <span>{{ number_format($stats['users_published'] ?? 0) }} utilisateurs</span>
                    </div>
                    <div class="stat-sparkline">
                        <div class="sparkline-bar" style="height: 55%"></div>
                        <div class="sparkline-bar" style="height: 65%"></div>
                        <div class="sparkline-bar" style="height: 75%"></div>
                        <div class="sparkline-bar" style="height: 85%"></div>
                        <div class="sparkline-bar" style="height: 100%"></div>
                    </div>
                    <button class="stat-view-more-btn" data-stat="users">
                        <i class="fas fa-user-plus"></i>
                        Voir plus
                    </button>
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
                            <div class="card-badge">4 récents</div>
                        </div>
                        <div class="card-content">
                            <div class="publications-list">
                                @forelse($recentArticles as $article)
                                    <div class="publication-item">
                                        <div class="publication-thumbnail">
                                            <img src="{{ $article->image_url ?? 'https://images.unsplash.com/photo-1557804506-669a67965ba0?w=80&h=60&fit=crop&crop=faces' }}" alt="Article thumbnail">
                                            <div class="publication-type">{{ $article->category->name ?? 'N/A' }}</div>
                                        </div>
                                        <div class="publication-info">
                                            <h4 class="publication-title">{{ Str::limit($article->title, 40) }}</h4>
                                            <div class="publication-meta">
                                                <span class="author">
                                                    <i class="fas fa-user"></i>
                                                    {{ $article->user->name ?? 'N/A' }}
                                                </span>
                                                <span class="date">
                                                    <i class="fas fa-calendar"></i>
                                                    {{ $article->created_at->diffForHumans() }}
                                                </span>
                                            </div>
                                            <div class="publication-stats">
                                                <span class="views">
                                                    <i class="fas fa-eye"></i>
                                                    {{ number_format($article->view_count) }} vues
                                                </span>
                                            </div>
                                        </div>
                                        <div class="publication-status {{ $article->status }}">
                                            <i class="fas fa-check-circle"></i>
                                            {{ ucfirst($article->status) }}
                                        </div>
                                    </div>
                                @empty
                                    <p>Aucune publication récente.</p>
                                @endforelse
                            </div>
                            <div class="card-footer">
                                <button class="btn-view-all">
                                    <i class="fas fa-list"></i>
                                    Voir toutes les publications
                                </button>
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
                            <div class="card-badge trending">Top 6 semaine</div>
                        </div>
                        <div class="card-content">
                            <div class="top-articles-list">
                                @forelse($topArticles as $article)
                                    <div class="top-article-item rank-{{ $loop->iteration }}">
                                        <div class="article-rank">
                                            <span class="rank-number">{{ $loop->iteration }}</span>
                                            @if($loop->first)<i class="fas fa-crown"></i>@endif
                                        </div>
                                        <div class="article-details">
                                            <h4 class="article-title">{{ Str::limit($article->title, 35) }}</h4>
                                            <div class="article-metrics">
                                                <span class="views">
                                                    <i class="fas fa-eye"></i>
                                                    {{ number_format($article->view_count) }} vues
                                                </span>
                                            </div>
                                        </div>
                                        <div class="article-growth positive">
                                            <i class="fas fa-arrow-up"></i>
                                        </div>
                                    </div>
                                @empty
                                    <p>Aucun article à afficher.</p>
                                @endforelse
                            </div>
                            <div class="card-footer">
                                <button class="btn-view-all">
                                    <i class="fas fa-chart-line"></i>
                                    Voir les analytics détaillés
                                </button>
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
                                        <div class="stat-value">{{ number_format($stats['users_online'] ?? 0) }}</div>
                                        <div class="stat-label">Utilisateurs en ligne</div>
                                    </div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-icon reading">
                                        <i class="fas fa-book-open"></i>
                                    </div>
                                    <div class="stat-info">
                                        <div class="stat-value">{{ number_format($stats['reading_count'] ?? 0) }}</div>
                                        <div class="stat-label">Lectures actives</div>
                                    </div>
                                </div>
                            </div>

                            <div class="activity-feed">
                                @forelse($activities as $activity)
                                    <div class="activity-item">
                                        <i class="fas {{ $activity['icon'] }} activity-icon {{ $activity['color'] }}"></i>
                                        <div class="activity-content">
                                            <div class="activity-text">{!! $activity['description'] !!}</div>
                                            <div class="activity-time">{{ $activity['time']->diffForHumans() }}</div>
                                        </div>
                                    </div>
                                @empty
                                    <p>Aucune activité récente.</p>
                                @endforelse
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

            <!-- Analytics Grid -->
            <div class="analytics-grid">
                <div class="analytics-card large" style="animation: 0.6s cubic-bezier(0.4, 0, 0.2, 1) 0s 1 normal none running fadeInUp;">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-chart-bar"></i>
                            Performance Globale
                        </h3>
                    </div>
                    <div class="card-content">
                        <div class="performance-chart">
                            <canvas id="performanceChart" width="400" height="200"></canvas>
                        </div>
                    </div>
                </div>

                <div class="analytics-card medium" style="animation: 0.6s cubic-bezier(0.4, 0, 0.2, 1) 0s 1 normal none running fadeInUp;">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-fire"></i>
                            Top Articles
                        </h3>
                    </div>
                    <div class="card-content">
                        <div class="article-list">
                            @forelse($topArticles as $article)
                                <div class="article-item">
                                    <div class="article-rank">{{ $loop->iteration }}</div>
                                    <div class="article-info">
                                        <div class="article-title">{{ Str::limit($article->title, 25) }}</div>
                                        <div class="article-stats">{{ number_format($article->view_count) }} vues</div>
                                    </div>
                                    <div class="article-trend positive">
                                        <i class="fas fa-arrow-up"></i>
                                    </div>
                                </div>
                            @empty
                                <p>Aucun article à afficher.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="analytics-card small" style="animation: 0.6s cubic-bezier(0.4, 0, 0.2, 1) 0s 1 normal none running fadeInUp;">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-globe-africa"></i>
                            Audience
                        </h3>
                    </div>
                    <div class="card-content">
                        <div class="audience-stats">
                            <div class="audience-item">
                                <span class="country">🇨🇮 Côte d'Ivoire</span>
                                <span class="percentage">28%</span>
                            </div>
                            <div class="audience-item">
                                <span class="country">🇫🇷 France</span>
                                <span class="percentage">22%</span>
                            </div>
                            <div class="audience-item">
                                <span class="country">🇸🇳 Sénégal</span>
                                <span class="percentage">19%</span>
                            </div>
                            <div class="audience-item">
                                <span class="country">🇨🇦 Canada</span>
                                <span class="percentage">15%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
</style>
@endpush

@endsection
