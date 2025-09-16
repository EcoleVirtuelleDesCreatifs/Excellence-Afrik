<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard Excellence Afrik - Plateforme Éditoriale Africaine')</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Playfair+Display:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard-ultra.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard-pages.css') }}">

    @stack('styles')
</head>

<body class="dashboard-body">
    @php
        // Charger les catégories actives pour le sous-menu (sidebar)
        try {
            $sidebarCategories = \App\Models\Category::where('status', 'active')
                ->where('is_active', 1)
                ->orderBy('name')
                ->get();
        } catch (\Throwable $e) {
            $sidebarCategories = collect();
        }
    @endphp

    <!-- Dashboard Container -->
    <div class="dashboard-ultra-container">

        <!-- Sidebar Navigation -->
        <aside class="dashboard-sidebar" id="dashboardSidebar">
            <div class="sidebar-header">
                <div class="sidebar-logo">
                    <i class="fas fa-crown" style="color: #D4AF37; font-size: 1.5rem;"></i>
                    <span class="sidebar-logo-text">Excellence Afrik</span>
                </div>
                <button class="sidebar-toggle" id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>
            </div>

            <nav class="sidebar-nav">
                <div class="nav-section">
                    <div class="nav-section-title">Principal</div>
                    <ul class="nav-menu">
                        <!-- Tableau de Bord - Accessible à tous -->
                        <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <a href="{{ route('dashboard') }}" class="nav-link" data-section="dashboard">
                                <i class="nav-icon fas fa-chart-pie"></i>
                                <span class="nav-text">Tableau de Bord</span>
                            </a>
                        </li>
                        
                    </ul>
                </div>

                <div class="nav-section">
                    <div class="nav-section-title">Gestion</div>
                    <ul class="nav-menu">
                        <!-- Gestion des Articles -->
                        <li class="nav-item has-submenu {{ request()->routeIs('dashboard.articles') ? 'active' : '' }}">
                            <a href="#" class="nav-link submenu-toggle">
                                <i class="nav-icon fas fa-newspaper"></i>
                                <span class="nav-text">Gestion des Articles</span>
                                <i class="submenu-arrow fas fa-chevron-down"></i>
                            </a>
                            <ul class="nav-submenu">
                                <!-- Créer article - Accessible à tous -->
                                <li class="nav-subitem">
                                    <a href="{{ route('dashboard.articles.create') }}" class="nav-sublink" data-section="add-article">
                                        <i class="nav-subicon fas fa-plus"></i>
                                        <span class="nav-subtext">Ajouter un article</span>
                                    </a>
                                </li>
                                
                                <!-- Liste des articles - Accessible à tous -->
                                <li class="nav-subitem">
                                    <a href="{{ route('dashboard.articles') }}" class="nav-sublink" data-section="list-articles">
                                        <i class="nav-subicon fas fa-list"></i>
                                        <span class="nav-subtext">Liste des articles</span>
                                    </a>
                                </li>
                                
                                <!-- Mes articles - Seulement pour journalistes -->
                                @if(auth()->check() && auth()->user()->estJournaliste())
                                    <li class="nav-subitem">
                                        <a href="{{ route('dashboard.mes-articles') }}" class="nav-sublink" data-section="mes-articles">
                                            <i class="nav-subicon fas fa-user-edit"></i>
                                            <span class="nav-subtext">Mes articles</span>
                                        </a>
                                    </li>
                                @endif
                                
                                <!-- Catégories - Lecture pour tous -->
                                <li class="nav-subitem">
                                    <a href="{{ route('dashboard.categories.index') }}" class="nav-sublink" data-section="list-categories">
                                        <i class="nav-subicon fas fa-folder-tree"></i>
                                        <span class="nav-subtext">Catégories</span>
                                    </a>
                                </li>
                                
                                <!-- Créer catégorie - Seulement Admin et Directeur -->
                                @if(auth()->check() && (auth()->user()->estAdmin() || auth()->user()->estDirecteurPublication()))
                                    <li class="nav-subitem">
                                        <a href="{{ route('dashboard.categories.create') }}" class="nav-sublink" data-section="add-article-category">
                                            <i class="nav-subicon fas fa-folder-plus"></i>
                                            <span class="nav-subtext">Ajouter une catégorie</span>
                                        </a>
                                    </li>
                                @endif
                                @if(isset($sidebarCategories) && $sidebarCategories->count())
                                    @foreach($sidebarCategories as $cat)
                                        <li class="nav-subitem">
                                            <a href="{{ route('dashboard.categories.edit', $cat->id) }}" class="nav-sublink" title="Éditer {{ $cat->name }}">
                                                <i class="nav-subicon fas fa-folder"></i>
                                                <span class="nav-subtext">{{ $cat->name }}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                @endif
                                <li class="nav-subitem">
                                    <a href="#article-drafts" class="nav-sublink" data-section="article-drafts">
                                        <i class="nav-subicon fas fa-edit"></i>
                                        <span class="nav-subtext">Brouillons</span>
                                    </a>
                                </li>
                                <li class="nav-subitem">
                                    <a href="#article-comments" class="nav-sublink" data-section="article-comments">
                                        <i class="nav-subicon fas fa-comments"></i>
                                        <span class="nav-subtext">Commentaires</span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- Gestion des Articles À la une -->
                        <li class="nav-item {{ request()->routeIs('dashboard.a_la_une.*') ? 'active' : '' }}">
                            <a href="{{ route('dashboard.a_la_une.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-star"></i>
                                <span class="nav-text">Articles À la une</span>
                            </a>
                        </li>

                        <!-- Gestion WebTV - Accessible à tous les utilisateurs authentifiés -->
                        @if(auth()->check())
                            <li class="nav-item has-submenu {{ request()->routeIs('dashboard.webtv.*') ? 'active' : '' }}">
                                <a href="#" class="nav-link submenu-toggle">
                                    <i class="nav-icon fas fa-video"></i>
                                    <span class="nav-text">Gestion WebTV</span>
                                    <i class="submenu-arrow fas fa-chevron-down"></i>
                                </a>
                            <ul class="nav-submenu">
                                <li class="nav-subitem">
                                    <a href="{{ route('dashboard.webtv.media.create') }}" class="nav-sublink" data-section="add-webtv-media">
                                        <i class="nav-subicon fas fa-plus"></i>
                                        <span class="nav-subtext">Créer un Live</span>
                                    </a>
                                </li>
                                <li class="nav-subitem">
                                    <a href="{{ route('dashboard.webtv.programs.create') }}" class="nav-sublink" data-section="add-webtv-program">
                                        <i class="nav-subicon fas fa-tv"></i>
                                        <span class="nav-subtext">Créer un Programme</span>
                                    </a>
                                </li>
                                <li class="nav-subitem">
                                    <a href="{{ route('dashboard.webtv.index') }}" class="nav-sublink" data-section="list-webtv">
                                        <i class="nav-subicon fas fa-list"></i>
                                        <span class="nav-subtext">
                                            @if(auth()->user()->estJournaliste())
                                                Mes Événements WebTV
                                            @else
                                                Tous les Événements WebTV
                                            @endif
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @endif

                        <!-- Gestion des Magazines - Seulement Admin et Directeur -->
                        @if(auth()->check() && (auth()->user()->estAdmin() || auth()->user()->estDirecteurPublication()))
                            <li class="nav-item has-submenu {{ request()->routeIs('dashboard.magazines.*') ? 'active' : '' }}">
                                <a href="#" class="nav-link submenu-toggle">
                                    <i class="nav-icon fas fa-book-open"></i>
                                    <span class="nav-text">Gestion des Magazines</span>
                                    <i class="submenu-arrow fas fa-chevron-down"></i>
                                </a>
                            <ul class="nav-submenu">
                                <li class="nav-subitem">
                                    <a href="{{ route('dashboard.magazines.index') }}" class="nav-sublink" data-section="list-magazines">
                                        <i class="nav-subicon fas fa-list"></i>
                                        <span class="nav-subtext">Liste des magazines</span>
                                    </a>
                                </li>
                                <li class="nav-subitem">
                                    <a href="{{ route('dashboard.magazines.create') }}" class="nav-sublink" data-section="add-magazine">
                                        <i class="nav-subicon fas fa-plus"></i>
                                        <span class="nav-subtext">Nouveau magazine</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @endif

                        <!-- Gestion des Publicités - Seulement Admin et Directeur -->
                        @if(auth()->check() && (auth()->user()->estAdmin() || auth()->user()->estDirecteurPublication()))
                            <li class="nav-item has-submenu {{ request()->routeIs('dashboard.advertisements.*') ? 'active' : '' }}">
                                <a href="#" class="nav-link submenu-toggle">
                                    <i class="nav-icon fas fa-bullhorn"></i>
                                    <span class="nav-text">Gestion des Publicités</span>
                                    <i class="submenu-arrow fas fa-chevron-down"></i>
                                </a>
                            <ul class="nav-submenu">
                                <li class="nav-subitem">
                                    <a href="{{ route('dashboard.advertisements.index') }}" class="nav-sublink" data-section="list-advertisements">
                                        <i class="nav-subicon fas fa-list"></i>
                                        <span class="nav-subtext">Liste des publicités</span>
                                    </a>
                                </li>
                                <li class="nav-subitem">
                                    <a href="{{ route('dashboard.advertisements.create') }}" class="nav-sublink" data-section="add-advertisement">
                                        <i class="nav-subicon fas fa-plus"></i>
                                        <span class="nav-subtext">Nouvelle publicité</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @endif

                        <!-- Gestion des Utilisateurs - Seulement Admin et Directeur -->
                        @if(auth()->check() && (auth()->user()->estAdmin() || auth()->user()->estDirecteurPublication()))
                            <li class="nav-item has-submenu {{ request()->routeIs('dashboard.users') ? 'active' : '' }}">
                                <a href="#" class="nav-link submenu-toggle">
                                    <i class="nav-icon fas fa-users"></i>
                                    <span class="nav-text">Gestion des Utilisateurs</span>
                                    <i class="submenu-arrow fas fa-chevron-down"></i>
                                </a>
                            <ul class="nav-submenu">
                                <li class="nav-subitem">
                                    <a href="{{ route('dashboard.users') }}" class="nav-sublink" data-section="list-users">
                                        <i class="nav-subicon fas fa-list"></i>
                                        <span class="nav-subtext">Liste des utilisateurs</span>
                                    </a>
                                </li>
                                <li class="nav-subitem">
                                    <a href="#add-user" class="nav-sublink" data-section="add-user">
                                        <i class="nav-subicon fas fa-user-plus"></i>
                                        <span class="nav-subtext">Ajouter un utilisateur</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @endif

                        <!-- Gestion des Flash Info - Seulement Admin et Directeur -->
                        @if(auth()->check() && (auth()->user()->estAdmin() || auth()->user()->estDirecteurPublication()))
                            <li class="nav-item has-submenu {{ request()->routeIs('dashboard.flash-infos.*') ? 'active' : '' }}">
                                <a href="#" class="nav-link submenu-toggle">
                                    <i class="nav-icon fas fa-bolt text-warning"></i>
                                    <span class="nav-text">Flash Info</span>
                                    <i class="submenu-arrow fas fa-chevron-down"></i>
                                </a>
                                <ul class="nav-submenu">
                                    <li class="nav-subitem">
                                        <a href="{{ route('dashboard.flash-infos.index') }}" class="nav-sublink" data-section="list-flash-infos">
                                            <i class="nav-subicon fas fa-list"></i>
                                            <span class="nav-subtext">Liste des Flash Info</span>
                                        </a>
                                    </li>
                                    <li class="nav-subitem">
                                        <a href="{{ route('dashboard.flash-infos.create') }}" class="nav-sublink" data-section="add-flash-info">
                                            <i class="nav-subicon fas fa-plus"></i>
                                            <span class="nav-subtext">Nouvelle Flash Info</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif

                        <!-- Gestion Newsletters - Masqué pour les journalistes -->
                        @if(auth()->check() && !auth()->user()->estJournaliste())
                            <li class="nav-item has-submenu">
                                <a href="#" class="nav-link submenu-toggle">
                                    <i class="nav-icon fas fa-envelope"></i>
                                    <span class="nav-text">Gestion Newsletters</span>
                                    <i class="submenu-arrow fas fa-chevron-down"></i>
                                </a>
                                <ul class="nav-submenu">
                                    <li class="nav-subitem">
                                        <a href="{{ route('dashboard.newsletter.index') }}" class="nav-sublink">
                                            <i class="nav-subicon fas fa-users"></i>
                                            <span class="nav-subtext">Abonnés</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <!-- Gestion des Contacts -->
                            <li class="nav-item {{ request()->routeIs('dashboard.contacts.*') ? 'active' : '' }}">
                                <a href="{{ route('dashboard.contacts.index') }}" class="nav-link" data-section="contacts">
                                    <i class="nav-icon fas fa-message"></i>
                                    <span class="nav-text">Messages de Contact</span>
                                    @php
                                        $nouveauxContacts = \App\Models\Contact::nouveaux()->count();
                                    @endphp
                                    @if($nouveauxContacts > 0)
                                        <span class="nav-badge">{{ $nouveauxContacts }}</span>
                                    @endif
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>

                <div class="nav-section">
                    <div class="nav-section-title">Configuration</div>
                    <ul class="nav-menu">
                        <!-- Paramètres système - Seulement Super Admin -->
                        @if(auth()->check() && auth()->user()->estAdmin())
                            <li class="nav-item {{ request()->routeIs('dashboard.settings') ? 'active' : '' }}">
                                <a href="{{ route('dashboard.settings') }}" class="nav-link" data-section="settings">
                                    <i class="nav-icon fas fa-cog"></i>
                                    <span class="nav-text">Paramètres</span>
                                </a>
                            </li>
                        @endif
                        
                        <!-- Profil - Accessible à tous -->
                        <li class="nav-item {{ request()->routeIs('dashboard.profile') ? 'active' : '' }}">
                            <a href="{{ route('dashboard.profile') }}" class="nav-link" data-section="profile">
                                <i class="nav-icon fas fa-user-circle"></i>
                                <span class="nav-text">Profil</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

           
        </aside>

        <!-- Main Content -->
        <main class="dashboard-main">
            <!-- Top Header -->
            <header class="dashboard-header">
                <div class="header-left">
                    <button class="mobile-menu-toggle" id="mobileMenuToggle">
                        <i class="fas fa-bars"></i>
                    </button>
                    <div class="breadcrumb-nav">
                        <span class="breadcrumb-item active">@yield('page_title', 'Tableau de Bord')</span>
                        <span class="breadcrumb-separator">•</span>
                        <span class="breadcrumb-subtitle">Excellence Afrik - Plateforme Éditoriale</span>
                    </div>
                </div>

                <div class="header-right">
                    <div class="header-search">
                        <input type="text" class="search-input" placeholder="Rechercher articles, auteurs, statistiques...">
                        <i class="fas fa-search search-icon"></i>
                        <div class="search-suggestions" id="searchSuggestions" style="display: none;">
                            <div class="suggestion-item">
                                <i class="fas fa-newspaper"></i>
                                <span>Articles récents</span>
                            </div>
                            <div class="suggestion-item">
                                <i class="fas fa-chart-line"></i>
                                <span>Statistiques</span>
                            </div>
                            <div class="suggestion-item">
                                <i class="fas fa-users"></i>
                                <span>Auteurs</span>
                            </div>
                        </div>
                    </div>

                    <div class="header-actions">
                        <button class="action-btn notification-btn">
                            <i class="fas fa-bell"></i>
                            <span class="notification-badge">3</span>
                        </button>

                        <button class="action-btn message-btn">
                            <i class="fas fa-envelope"></i>
                            <span class="message-badge">7</span>
                        </button>

                        <div class="dropdown">
                            <button class="user-dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="user-avatar-small">
                                    {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                                </div>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="{{ route('dashboard.settings') }}">
                                        <i class="fas fa-user me-2"></i>Mon profil
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('dashboard.settings') }}">
                                        <i class="fas fa-cog me-2"></i>Paramètres
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('home') }}" target="_blank">
                                        <i class="fas fa-external-link-alt me-2"></i>Voir le site
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="fas fa-sign-out-alt me-2"></i>Se déconnecter
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Dashboard Content -->
            <div class="dashboard-content">
                <!-- Flash Messages -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert" style="border-radius: 12px; border: none; background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white;">
                        <i class="fas fa-check-circle me-2"></i>
                        <strong>Succès !</strong> {{ session('success') }}
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert" style="border-radius: 12px; border: none; background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white;">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Erreur !</strong> {{ session('error') }}
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('warning'))
                    <div class="alert alert-warning alert-dismissible fade show mb-4" role="alert" style="border-radius: 12px; border: none; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: white;">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <strong>Attention !</strong> {{ session('warning') }}
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('info'))
                    <div class="alert alert-info alert-dismissible fade show mb-4" role="alert" style="border-radius: 12px; border: none; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: white;">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Information !</strong> {{ session('info') }}
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JavaScript -->
    <script src="{{ asset('assets/js/dashboard-ultra.js') }}"></script>

    <!-- Notifications System -->
    <div id="notification-container" class="position-fixed top-0 end-0 p-3" style="z-index: 9999; max-width: 400px;">
        <!-- Les notifications seront ajoutées ici dynamiquement -->
    </div>

    @stack('scripts')

    <!-- Notification System Script -->
    <script>
        // Système de notifications global
        function showNotification(message, type = 'info', duration = 5000) {
            const container = document.getElementById('notification-container');
            const notificationId = 'notification-' + Date.now();
            
            const notificationHTML = `
                <div id="${notificationId}" class="toast align-items-center text-bg-${type} border-0 mb-2" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">
                            <i class="fas ${getNotificationIcon(type)} me-2"></i>
                            ${message}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
            `;
            
            container.insertAdjacentHTML('beforeend', notificationHTML);
            
            const toastElement = document.getElementById(notificationId);
            const toast = new bootstrap.Toast(toastElement, {
                autohide: true,
                delay: duration
            });
            
            toast.show();
            
            // Nettoyer après disparition
            toastElement.addEventListener('hidden.bs.toast', function () {
                this.remove();
            });
        }
        
        function getNotificationIcon(type) {
            const icons = {
                'success': 'fa-check-circle',
                'danger': 'fa-exclamation-triangle',
                'warning': 'fa-exclamation-circle',
                'info': 'fa-info-circle'
            };
            return icons[type] || icons['info'];
        }
        
        // Afficher les messages de session Laravel
        document.addEventListener('DOMContentLoaded', function() {
            @if(session('success'))
                showNotification("{{ session('success') }}", 'success');
            @endif
            
            @if(session('error'))
                showNotification("{{ session('error') }}", 'danger');
            @endif
            
            @if(session('warning'))
                showNotification("{{ session('warning') }}", 'warning');
            @endif
            
            @if(session('info'))
                showNotification("{{ session('info') }}", 'info');
            @endif
            
            @if($errors->any())
                @foreach($errors->all() as $error)
                    showNotification("{{ $error }}", 'danger');
                @endforeach
            @endif
        });
    </script>
</body>
</html>
