<!DOCTYPE html>
<html lang="fr" data-bs-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@yield('meta_description', 'Excellence Afrik - Votre source d\'information sur l\'économie, l\'entrepreneuriat et l\'investissement en Afrique')">
    <meta name="keywords" content="@yield('meta_keywords', 'Afrique, économie, entrepreneuriat, investissement, actualités, diaspora')">
    <meta name="author" content="Excellence Afrik">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Excellence Afrik — Actualités Économiques & Entrepreneuriat')</title>

    <!-- Preload critical resources -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Playfair+Display:wght@400;500;600;700&display=swap" as="style">

    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/excellence-style.css') }}?v={{ time() }}">

    @stack('styles')
</head>

<body>
    @php
        // Catégories actives pour la navigation publique
        try {
            $navCategories = \App\Models\Category::where('status', 'active')
                ->where('is_active', 1)
                ->orderBy('name')
                ->get();

            // Parents pour "ÉCONOMIE RÉELLE"
            $parentSlugs = [
                'grands-genres',
                'entreprises-impacts',
                'contributions-analyses',
            ];
            $economyParents = \App\Models\Category::whereIn('slug', $parentSlugs)
                ->where('status', 'active')
                ->where('is_active', 1)
                ->get()
                ->keyBy('slug');

            // Enfants par parent
            $economyChildren = [];
            foreach ($parentSlugs as $ps) {
                $p = $economyParents->get($ps);
                if ($p) {
                    $economyChildren[$ps] = \App\Models\Category::where('parent_id', $p->id)
                        ->where('status', 'active')
                        ->where('is_active', 1)
                        ->orderBy('name')
                        ->get();
                } else {
                    $economyChildren[$ps] = collect();
                }
            }

            // Parents pour "PORTRAITS"
            $portraitsParentsQuery = \App\Models\Category::query()
                ->where('status', 'active')
                ->where('is_active', 1)
                ->where(function($q){
                    $q->whereIn('slug', [
                        'figures-de-leconomie','figures-de-l-economie','figures-economie'
                    ])->orWhereIn('name', [
                        "Figures de l'Economie","Figures de l'économie","Figures de l’economie"
                    ]);
                })
                ->orWhere(function($q){
                    $q->whereIn('slug', [
                        'portrait-de-l-entreprise','portrait-entreprise'
                    ])->orWhereIn('name', [
                        "Portrait de l'entreprise","Portrait de l’Entreprise"
                    ]);
                })
                ->orWhere(function($q){
                    $q->whereIn('slug', [
                        'portrait-de-l-entrepreneur','portrait-entrepreneur'
                    ])->orWhereIn('name', [
                        "Portrait de l'entrepreneur","Portrait de l’Entrepreneur"
                    ]);
                });
            $portraitsParents = $portraitsParentsQuery->get();
            $portraitsParentsMap = $portraitsParents->mapWithKeys(function($c){ return [$c->slug => $c]; });
            $portraitsChildren = [];
            foreach ($portraitsParents as $pp) {
                $portraitsChildren[$pp->slug] = \App\Models\Category::where('parent_id', $pp->id)
                    ->where('status','active')->where('is_active',1)->orderBy('name')->get();
            }

            // Parents pour "ANALYSES & EXPERTS"
            $expertsParents = \App\Models\Category::where(function($q){
                    $q->whereIn('slug',['parole-experts','parole-d-experts'])
                      ->orWhereIn('name',["Parole d'experts","Parole d’experts"]);
                })
                ->where('status','active')->where('is_active',1)->get();
            $expertsChildren = [];
            foreach ($expertsParents as $ep) {
                $expertsChildren[$ep->slug] = \App\Models\Category::where('parent_id', $ep->id)
                    ->where('status','active')->where('is_active',1)->orderBy('name')->get();
            }
        } catch (\Throwable $e) {
            $navCategories = collect();
            $economyParents = collect();
            $economyChildren = [];
            $portraitsParents = collect();
            $portraitsParentsMap = collect();
            $portraitsChildren = [];
            $expertsParents = collect();
            $expertsChildren = [];
        }
    @endphp
    <!-- Modern Revolutionary Topbar -->
    <div class="topbar-modern">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-10">
                    <div class="topbar-content">
                        <!-- Left Section: Navigation Links -->
                        <div class="topbar-left">
                            <div class="topbar-nav">
                                <div class="topbar-dropdown">
                                    <a href="#" class="topbar-link" data-dropdown="about">
                                        <span class="topbar-text">À PROPOS</span>
                                        <i class="fas fa-chevron-down topbar-icon"></i>
                                    </a>
                                    <div class="topbar-menu" id="about-menu">
                                        <a href="{{ route('pages.editorial') }}" class="topbar-menu-item">
                                            <i class="fas fa-edit topbar-menu-icon"></i>
                                            <span>Ligne éditoriale</span>
                                        </a>
                                        <a href="{{ route('pages.contact') }}" class="topbar-menu-item">
                                            <i class="fas fa-envelope topbar-menu-icon"></i>
                                            <span>Contact</span>
                                        </a>
                                    </div>
                                </div>

                                <div class="topbar-separator"></div>

                                <div class="topbar-dropdown">
                                    <a href="#" class="topbar-link" data-dropdown="advertise">
                                        <span class="topbar-text">ANNONCER</span>
                                        <i class="fas fa-chevron-down topbar-icon"></i>
                                    </a>
                                    <div class="topbar-menu" id="advertise-menu">
                                        <a href="{{ route('pages.advertise') }}" class="topbar-menu-item">
                                            <i class="fas fa-bullhorn topbar-menu-icon"></i>
                                            <span>Publier avec nous</span>
                                        </a>
                                        <a href="{{ route('pages.sponsor') }}" class="topbar-menu-item">
                                            <i class="fas fa-handshake topbar-menu-icon"></i>
                                            <span>Devenir Sponsor</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Section: Social & Language -->
                        <div class="topbar-right">
                            <!-- Social Media -->
                            <div class="topbar-social">
                                <a href="#" class="topbar-social-link" title="Facebook">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="#" class="topbar-social-link" title="Instagram">
                                    <i class="fab fa-instagram"></i>
                                </a>
                                <a href="#" class="topbar-social-link" title="LinkedIn">
                                    <i class="fab fa-linkedin-in"></i>
                                </a>
                                <a href="#" class="topbar-social-link" title="YouTube">
                                    <i class="fab fa-youtube"></i>
                                </a>
                            </div>


                            <!-- Language Selector -->
                            <div class="topbar-language">
                                <div class="topbar-dropdown">
                                    <a href="#" class="topbar-lang-link" data-dropdown="language">
                                        <i class="fas fa-globe topbar-lang-icon"></i>
                                        <span class="topbar-lang-text">FR</span>
                                        <i class="fas fa-chevron-down topbar-icon"></i>
                                    </a>
                                    <div class="topbar-menu topbar-lang-menu" id="language-menu">
                                        <a href="#" class="topbar-menu-item">
                                            <i class="fas fa-flag topbar-menu-icon"></i>
                                            <span>Français</span>
                                        </a>
                                        <a href="#" class="topbar-menu-item">
                                            <i class="fas fa-flag topbar-menu-icon"></i>
                                            <span>English</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modern Revolutionary Logo Section -->
    <div class="logo-modern">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-10">
                    <div class="logo-content">
                        <!-- Logo Brand -->
                        <div class="logo-brand-wrapper">
                            <a href="{{ route('home') }}" class="logo-brand-link">
                                <div class="logo-brand-container">
                                    <img src="{{ asset('assets/images/logo.png') }}" alt="Excellence Afrik" class="logo-brand-image">
                                </div>
                            </a>
                        </div>

                        <!-- Ad Banner -->
                        <div class="ad-modern">
                            <div class="ad-container">
                                <div class="ad-content">

                                    <div class="ad-placeholder">
                                        <img src="{{ asset('assets/banner-ads/ad-banner.jpg') }}" alt="Publicité" class="ad-image">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modern Revolutionary Navigation -->
    <nav class="nav-modern sticky-top">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-10">
                    <div class="nav-content">
                        <!-- Mobile Toggle -->
                        <button class="nav-mobile-toggle d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarModern" aria-controls="navbarModern" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="nav-toggle-line"></span>
                            <span class="nav-toggle-line"></span>
                            <span class="nav-toggle-line"></span>
                        </button>

                        <div class="collapse navbar-collapse" id="navbarModern">
                            <div class="nav-layout">
                                <!-- Main Navigation Menu -->
                                <div class="nav-main">
                                    <div class="nav-item">
                                        <a href="{{ route('home') }}" class="nav-link-modern nav-link-home {{ request()->routeIs('home') ? 'active' : '' }}">
                                            <span class="nav-text">ACCUEIL</span>
                                        </a>
                                    </div>

                                    <div class="nav-item">
                                        <a href="{{ route('pages.presentation') }}" class="nav-link-modern {{ request()->routeIs('pages.presentation') ? 'active' : '' }}">
                                            <span class="nav-text">QUI SOMMES-NOUS?</span>
                                        </a>
                                    </div>


                                    <div class="nav-item nav-dropdown">
                                        <a href="#" class="nav-link-modern" data-nav-dropdown="economy">
                                            <span class="nav-text">ÉCONOMIE RÉELLE</span>
                                            <i class="fas fa-chevron-down nav-chevron"></i>
                                        </a>
                                        <div class="nav-submenu" id="economy-submenu">
                                            @php $gg = $economyParents['grands-genres'] ?? null; @endphp
                                            <a href="{{ route('articles.category', $gg->slug ?? 'grands-genres') }}" class="nav-submenu-item">
                                                <i class="fas fa-newspaper nav-submenu-icon"></i>
                                                <span>{{ $gg->name ?? 'Grands genres' }}</span>
                                            </a>
                                            @if(!empty($economyChildren['grands-genres']) && $economyChildren['grands-genres']->count())
                                                @foreach($economyChildren['grands-genres'] as $sub)
                                                    <a href="{{ route('articles.category', $sub->slug) }}" class="nav-submenu-item">
                                                        <i class="fas fa-angle-right nav-submenu-icon"></i>
                                                        <span>{{ $sub->name }}</span>
                                                    </a>
                                                @endforeach
                                            @endif

                                            @php $ei = $economyParents['entreprises-impacts'] ?? null; @endphp
                                            <a href="{{ route('articles.category', $ei->slug ?? 'entreprises-impacts') }}" class="nav-submenu-item">
                                                <i class="fas fa-user-tie nav-submenu-icon"></i>
                                                <span>{{ $ei->name ?? 'Entreprises & Impacts' }}</span>
                                            </a>
                                            @if(!empty($economyChildren['entreprises-impacts']) && $economyChildren['entreprises-impacts']->count())
                                                @foreach($economyChildren['entreprises-impacts'] as $sub)
                                                    <a href="{{ route('articles.category', $sub->slug) }}" class="nav-submenu-item">
                                                        <i class="fas fa-angle-right nav-submenu-icon"></i>
                                                        <span>{{ $sub->name }}</span>
                                                    </a>
                                                @endforeach
                                            @endif

                                            @php $ca = $economyParents['contributions-analyses'] ?? null; @endphp
                                            <a href="{{ route('articles.category', $ca->slug ?? 'contributions-analyses') }}" class="nav-submenu-item">
                                                <i class="fas fa-quote-left nav-submenu-icon"></i>
                                                <span>{{ $ca->name ?? 'Contributions & Analyses' }}</span>
                                            </a>
                                            @if(!empty($economyChildren['contributions-analyses']) && $economyChildren['contributions-analyses']->count())
                                                @foreach($economyChildren['contributions-analyses'] as $sub)
                                                    <a href="{{ route('articles.category', $sub->slug) }}" class="nav-submenu-item">
                                                        <i class="fas fa-angle-right nav-submenu-icon"></i>
                                                        <span>{{ $sub->name }}</span>
                                                    </a>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>

                                    <div class="nav-item nav-dropdown">
                                        <a href="#" class="nav-link-modern" data-nav-dropdown="portraits">
                                            <span class="nav-text">PORTRAITS</span>
                                            <i class="fas fa-chevron-down nav-chevron"></i>
                                        </a>
                                        <div class="nav-submenu" id="portraits-submenu">
                                            @foreach($portraitsParents as $pp)
                                                <a href="{{ route('articles.category', $pp->slug) }}" class="nav-submenu-item">
                                                    <i class="fas fa-user nav-submenu-icon"></i>
                                                    <span>{{ $pp->name }}</span>
                                                </a>
                                                @if(!empty($portraitsChildren[$pp->slug]) && $portraitsChildren[$pp->slug]->count())
                                                    @foreach($portraitsChildren[$pp->slug] as $sub)
                                                        <a href="{{ route('articles.category', $sub->slug) }}" class="nav-submenu-item">
                                                            <i class="fas fa-angle-right nav-submenu-icon"></i>
                                                            <span>{{ $sub->name }}</span>
                                                        </a>
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="nav-item nav-dropdown">
                                        <a href="#" class="nav-link-modern" data-nav-dropdown="experts">
                                            <span class="nav-text">ANALYSES & EXPERTS</span>
                                            <i class="fas fa-chevron-down nav-chevron"></i>
                                        </a>
                                        <div class="nav-submenu" id="experts-submenu">
                                            @php $expertParent = $expertsParents->first(); @endphp
                                            @if($expertParent)
                                                <a href="{{ route('articles.category', $expertParent->slug) }}" class="nav-submenu-item">
                                                    <i class="fas fa-graduation-cap nav-submenu-icon"></i>
                                                    <span>{{ $expertParent->name }}</span>
                                                </a>
                                            @else
                                                <a href="{{ route('articles.category', 'parole-experts') }}" class="nav-submenu-item">
                                                    <i class="fas fa-graduation-cap nav-submenu-icon"></i>
                                                    <span>Parole d'experts</span>
                                                </a>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="nav-item nav-dropdown">
                                        <a href="#" class="nav-link-modern" data-nav-dropdown="diaspora">
                                            <span class="nav-text">DIASPORA</span>
                                            <i class="fas fa-chevron-down nav-chevron"></i>
                                        </a>
                                        <div class="nav-submenu" id="diaspora-submenu">
                                            <a href="{{ route('articles.category', 'opportunites') }}" class="nav-submenu-item">
                                                <i class="fas fa-lightbulb nav-submenu-icon"></i>
                                                <span>Opportunités</span>
                                            </a>
                                            <a href="{{ route('articles.category', 'startups-diaspora') }}" class="nav-submenu-item">
                                                <i class="fas fa-rocket nav-submenu-icon"></i>
                                                <span>Startups de la diaspora</span>
                                            </a>
                                        </div>
                                    </div>

                                    <div class="nav-item">
                                        <a href="{{ route('magazines.index') }}" class="nav-link-modern {{ request()->routeIs('magazines.*') ? 'active' : '' }}">
                                            <span class="nav-text">MAGAZINES</span>
                                        </a>
                                    </div>

                                    <div class="nav-item nav-special">
                                        <a href="{{ route('webtv.index') }}" class="nav-link-webtv {{ request()->routeIs('webtv.*') ? 'active' : '' }}">
                                            <i class="fas fa-video nav-webtv-icon"></i>
                                            <span class="nav-webtv-text">WEB TV</span>
                                            <span class="nav-live-badge">LIVE</span>
                                        </a>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    @hasSection('page_title')
    <!-- Page Title Banner -->
    <div class="page-title-banner">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-10">
                    <div class="page-title-content">
                        <h1 class="page-title">@yield('page_title')</h1>
                        @hasSection('page_subtitle')
                        <p class="page-subtitle">@yield('page_subtitle')</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Main Content -->
    <main class="main-content">
        @yield('content')
    </main>

    <!-- Search Modal -->
    <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="searchModalLabel">Rechercher</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('articles.search') }}" method="GET">
                        <div class="input-group">
                            <input type="text" class="form-control" name="q" placeholder="Tapez votre recherche..." value="{{ request('q') }}">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search"></i> Rechercher
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <h5 class="font-display mb-3">Excellence Afrik</h5>
                    <p class="text-light mb-4">Votre source d'information de référence sur l'économie, l'entrepreneuriat et l'investissement en Afrique.</p>
                    <div class="d-flex gap-3">
                        <a href="#" class="text-white"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6">
                    <h5>Catégories</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('articles.category', 'economie') }}">Économie</a></li>
                        <li><a href="{{ route('articles.category', 'societe') }}">Société</a></li>
                        <li><a href="{{ route('articles.category', 'entrepreneuriat') }}">Entrepreneuriat</a></li>
                        <li><a href="{{ route('articles.category', 'investissement') }}">Investissement</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5>Newsletter</h5>
                    <p>Restez informé de nos dernières actualités.</p>
                    <form class="newsletter-form d-flex" action="{{ route('newsletter.subscribe') }}" method="POST">
                        @csrf
                        <input type="email" class="form-control me-2" name="email" placeholder="Votre e-mail" required>
                        <button type="submit" class="btn btn-primary">S'abonner</button>
                    </form>
                </div>
                <div class="col-lg-3">
                    <h5>Contact</h5>
                    <p><i class="fas fa-envelope me-2"></i>contact@excellenceafrik.com</p>
                    <p><i class="fas fa-phone me-2"></i>+33 1 23 45 67 89</p>
                </div>
            </div>
            <hr class="my-4">
            <div class="text-center">
                <p class="mb-0">&copy; {{ date('Y') }} Excellence Afrik. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JavaScript -->
    <script src="{{ asset('assets/js/modern-app.js') }}"></script>

    @stack('scripts')
</body>

</html>
