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
                        <div class="stat-number">127</div>
                        <div class="stat-label">Articles Publiés</div>
                        <div class="stat-period">Ce mois</div>
                    </div>
                    <div class="stat-trend positive">
                        <i class="fas fa-arrow-up"></i>
                        <span>+18.2%</span>
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
                        <div class="stat-number">2.8M</div>
                        <div class="stat-label">Vues Totales</div>
                        <div class="stat-period">Ce mois</div>
                    </div>
                    <div class="stat-trend positive">
                        <i class="fas fa-arrow-up"></i>
                        <span>+24.7%</span>
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
                        <div class="stat-number">189K</div>
                        <div class="stat-label">Visiteurs Uniques</div>
                        <div class="stat-period">Ce mois</div>
                    </div>
                    <div class="stat-trend positive">
                        <i class="fas fa-arrow-up"></i>
                        <span>+15.3%</span>
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
                        <div class="stat-number">47.2K</div>
                        <div class="stat-label">Abonnés Newsletter</div>
                        <div class="stat-period">Total</div>
                    </div>
                    <div class="stat-trend positive">
                        <i class="fas fa-arrow-up"></i>
                        <span>+9.8%</span>
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
                        <div class="stat-number">12.4K</div>
                        <div class="stat-label">Utilisateurs Inscrits</div>
                        <div class="stat-period">Total</div>
                    </div>
                    <div class="stat-trend positive">
                        <i class="fas fa-arrow-up"></i>
                        <span>+12.1%</span>
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
                                <div class="publication-item">
                                    <div class="publication-thumbnail">
                                        <img src="https://images.unsplash.com/photo-1557804506-669a67965ba0?w=80&amp;h=60&amp;fit=crop&amp;crop=faces" alt="Article thumbnail">
                                        <div class="publication-type">Article</div>
                                    </div>
                                    <div class="publication-info">
                                        <h4 class="publication-title">Innovation Fintech en Afrique de l'Ouest</h4>
                                        <div class="publication-meta">
                                            <span class="author">
                                                <i class="fas fa-user"></i>
                                                Deza Auguste César
                                            </span>
                                            <span class="date">
                                                <i class="fas fa-calendar"></i>
                                                Il y a 2h
                                            </span>
                                        </div>
                                        <div class="publication-stats">
                                            <span class="views">
                                                <i class="fas fa-eye"></i>
                                                1.2K vues
                                            </span>
                                            <span class="comments">
                                                <i class="fas fa-comment"></i>
                                                24 commentaires
                                            </span>
                                        </div>
                                    </div>
                                    <div class="publication-status published">
                                        <i class="fas fa-check-circle"></i>
                                        Publié
                                    </div>
                                </div>

                                <div class="publication-item">
                                    <div class="publication-thumbnail">
                                        <img src="https://images.unsplash.com/photo-1559526324-4b87b5e36e44?w=80&amp;h=60&amp;fit=crop&amp;crop=faces" alt="Article thumbnail">
                                        <div class="publication-type">Analyse</div>
                                    </div>
                                    <div class="publication-info">
                                        <h4 class="publication-title">Économie Numérique : Défis et Opportunités</h4>
                                        <div class="publication-meta">
                                            <span class="author">
                                                <i class="fas fa-user"></i>
                                                Marie Kouassi
                                            </span>
                                            <span class="date">
                                                <i class="fas fa-calendar"></i>
                                                Il y a 5h
                                            </span>
                                        </div>
                                        <div class="publication-stats">
                                            <span class="views">
                                                <i class="fas fa-eye"></i>
                                                890 vues
                                            </span>
                                            <span class="comments">
                                                <i class="fas fa-comment"></i>
                                                18 commentaires
                                            </span>
                                        </div>
                                    </div>
                                    <div class="publication-status draft">
                                        <i class="fas fa-edit"></i>
                                        Brouillon
                                    </div>
                                </div>

                                <div class="publication-item">
                                    <div class="publication-thumbnail">
                                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=80&amp;h=60&amp;fit=crop&amp;crop=faces" alt="Article thumbnail">
                                        <div class="publication-type">Interview</div>
                                    </div>
                                    <div class="publication-info">
                                        <h4 class="publication-title">Startups Diasporiques : Retour aux Sources</h4>
                                        <div class="publication-meta">
                                            <span class="author">
                                                <i class="fas fa-user"></i>
                                                Kofi Asante
                                            </span>
                                            <span class="date">
                                                <i class="fas fa-calendar"></i>
                                                Il y a 1j
                                            </span>
                                        </div>
                                        <div class="publication-stats">
                                            <span class="views">
                                                <i class="fas fa-eye"></i>
                                                2.1K vues
                                            </span>
                                            <span class="comments">
                                                <i class="fas fa-comment"></i>
                                                31 commentaires
                                            </span>
                                        </div>
                                    </div>
                                    <div class="publication-status review">
                                        <i class="fas fa-clock"></i>
                                        En révision
                                    </div>
                                </div>

                                <div class="publication-item">
                                    <div class="publication-thumbnail">
                                        <img src="https://images.unsplash.com/photo-1573164713714-d95e436ab8d6?w=80&amp;h=60&amp;fit=crop&amp;crop=faces" alt="Article thumbnail">
                                        <div class="publication-type">Podcast</div>
                                    </div>
                                    <div class="publication-info">
                                        <h4 class="publication-title">Leadership Féminin en Entreprise</h4>
                                        <div class="publication-meta">
                                            <span class="author">
                                                <i class="fas fa-user"></i>
                                                Fatou Diallo
                                            </span>
                                            <span class="date">
                                                <i class="fas fa-calendar"></i>
                                                Il y a 2j
                                            </span>
                                        </div>
                                        <div class="publication-stats">
                                            <span class="views">
                                                <i class="fas fa-headphones"></i>
                                                1.8K écoutes
                                            </span>
                                            <span class="comments">
                                                <i class="fas fa-comment"></i>
                                                42 commentaires
                                            </span>
                                        </div>
                                    </div>
                                    <div class="publication-status published">
                                        <i class="fas fa-check-circle"></i>
                                        Publié
                                    </div>
                                </div>
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
                                <div class="top-article-item rank-1">
                                    <div class="article-rank">
                                        <span class="rank-number">1</span>
                                        <i class="fas fa-crown"></i>
                                    </div>
                                    <div class="article-details">
                                        <h4 class="article-title">Innovation Fintech : L'Afrique en Première Ligne</h4>
                                        <div class="article-metrics">
                                            <span class="views">
                                                <i class="fas fa-eye"></i>
                                                24.7K vues
                                            </span>
                                            <span class="engagement">
                                                <i class="fas fa-heart"></i>
                                                4.2K interactions
                                            </span>
                                        </div>
                                    </div>
                                    <div class="article-growth positive">
                                        <i class="fas fa-arrow-up"></i>
                                        <span>+18%</span>
                                    </div>
                                </div>

                                <div class="top-article-item rank-2">
                                    <div class="article-rank">
                                        <span class="rank-number">2</span>
                                    </div>
                                    <div class="article-details">
                                        <h4 class="article-title">Startups Diasporiques : Retour aux Sources</h4>
                                        <div class="article-metrics">
                                            <span class="views">
                                                <i class="fas fa-eye"></i>
                                                18.3K vues
                                            </span>
                                            <span class="engagement">
                                                <i class="fas fa-heart"></i>
                                                3.1K interactions
                                            </span>
                                        </div>
                                    </div>
                                    <div class="article-growth positive">
                                        <i class="fas fa-arrow-up"></i>
                                        <span>+24%</span>
                                    </div>
                                </div>

                                <div class="top-article-item rank-3">
                                    <div class="article-rank">
                                        <span class="rank-number">3</span>
                                    </div>
                                    <div class="article-details">
                                        <h4 class="article-title">Économie Circulaire en Afrique de l'Ouest</h4>
                                        <div class="article-metrics">
                                            <span class="views">
                                                <i class="fas fa-eye"></i>
                                                15.9K vues
                                            </span>
                                            <span class="engagement">
                                                <i class="fas fa-heart"></i>
                                                2.8K interactions
                                            </span>
                                        </div>
                                    </div>
                                    <div class="article-growth positive">
                                        <i class="fas fa-arrow-up"></i>
                                        <span>+31%</span>
                                    </div>
                                </div>

                                <div class="top-article-item">
                                    <div class="article-rank">
                                        <span class="rank-number">4</span>
                                    </div>
                                    <div class="article-details">
                                        <h4 class="article-title">Leadership Féminin : Nouvelles Perspectives</h4>
                                        <div class="article-metrics">
                                            <span class="views">
                                                <i class="fas fa-eye"></i>
                                                12.4K vues
                                            </span>
                                            <span class="engagement">
                                                <i class="fas fa-heart"></i>
                                                2.3K interactions
                                            </span>
                                        </div>
                                    </div>
                                    <div class="article-growth positive">
                                        <i class="fas fa-arrow-up"></i>
                                        <span>+15%</span>
                                    </div>
                                </div>

                                <div class="top-article-item">
                                    <div class="article-rank">
                                        <span class="rank-number">5</span>
                                    </div>
                                    <div class="article-details">
                                        <h4 class="article-title">Tech Africaine : Révolution Silencieuse</h4>
                                        <div class="article-metrics">
                                            <span class="views">
                                                <i class="fas fa-eye"></i>
                                                9.8K vues
                                            </span>
                                            <span class="engagement">
                                                <i class="fas fa-heart"></i>
                                                1.9K interactions
                                            </span>
                                        </div>
                                    </div>
                                    <div class="article-growth positive">
                                        <i class="fas fa-arrow-up"></i>
                                        <span>+22%</span>
                                    </div>
                                </div>

                                <div class="top-article-item">
                                    <div class="article-rank">
                                        <span class="rank-number">6</span>
                                    </div>
                                    <div class="article-details">
                                        <h4 class="article-title">Investissements Durables : Tendances 2024</h4>
                                        <div class="article-metrics">
                                            <span class="views">
                                                <i class="fas fa-eye"></i>
                                                8.2K vues
                                            </span>
                                            <span class="engagement">
                                                <i class="fas fa-heart"></i>
                                                1.5K interactions
                                            </span>
                                        </div>
                                    </div>
                                    <div class="article-growth neutral">
                                        <i class="fas fa-minus"></i>
                                        <span>+3%</span>
                                    </div>
                                </div>
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
                        <div class="top-articles">
                            <div class="article-item">
                                <div class="article-rank">1</div>
                                <div class="article-info">
                                    <div class="article-title">Économie Africaine 2025</div>
                                    <div class="article-stats">24.7K vues</div>
                                </div>
                                <div class="article-trend positive">
                                    <i class="fas fa-arrow-up"></i>
                                    <span>+45%</span>
                                </div>
                            </div>
                            <div class="article-item">
                                <div class="article-rank">2</div>
                                <div class="article-info">
                                    <div class="article-title">Tech Startups Afrique</div>
                                    <div class="article-stats">18.3K vues</div>
                                </div>
                                <div class="article-trend positive">
                                    <i class="fas fa-arrow-up"></i>
                                    <span>+32%</span>
                                </div>
                            </div>
                            <div class="article-item">
                                <div class="article-rank">3</div>
                                <div class="article-info">
                                    <div class="article-title">Diaspora Investissements</div>
                                    <div class="article-stats">15.9K vues</div>
                                </div>
                                <div class="article-trend positive">
                                    <i class="fas fa-arrow-up"></i>
                                    <span>+28%</span>
                                </div>
                            </div>
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
