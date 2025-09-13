@php
try {
    $navCategories = \App\Models\Category::where('status', 'active')
        ->where('is_active', 1)
        ->orderBy('name')
        ->get();

    // Parents for "ÉCONOMIE RÉELLE"
    $economyParentSlugs = [
        'grands-genres',
        'entreprises-impacts',
        'contributions-analyses',
    ];
    $economyParents = \App\Models\Category::whereIn('slug', $economyParentSlugs)
        ->where('status', 'active')
        ->where('is_active', 1)
        ->get();

    // Parents for "PORTRAITS"
    $portraitsParentSlugs = [
        'figures-de-leconomie',
        'portrait-de-l-entreprise',
        'portrait-de-l-entrepreneur',
    ];
    $portraitsParents = \App\Models\Category::whereIn('slug', $portraitsParentSlugs)
        ->where('status', 'active')
        ->where('is_active', 1)
        ->get();


    // Parents for "ANALYSES & EXPERTS"
    $expertsParentSlugs = [
        'parole-d-experts',
    ];
    $expertsParents = \App\Models\Category::whereIn('slug', $expertsParentSlugs)
        ->where('status', 'active')
        ->where('is_active', 1)
        ->get();

    // Parents for "DIASPORA"
    $diasporaParentSlugs = [
        'start-up-de-la-diaspora',
        'opportunites',
    ];
    $diasporaParents = \App\Models\Category::whereIn('slug', $diasporaParentSlugs)
        ->where('status', 'active')
        ->where('is_active', 1)
        ->get();

} catch (\Throwable $e) {
    $navCategories = collect();
    $economyParents = collect();
    $portraitsParents = collect();
    $expertsParents = collect();
    $diasporaParents = collect();
}
@endphp
<!doctype html>
<html class="no-js" lang="">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>ACCUEIL - EXCELLENCE AFRIK</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="manifest" href="{{ asset('styles/site.webmanifest') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('styles/img/favicon.ico') }}">
    <!-- Place favicon.ico in the root directory -->

    <!-- CSS here -->
    <link rel="stylesheet" href="{{ asset('styles/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('styles/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('styles/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('styles/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('styles/css/fontawesome-all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('styles/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('styles/css/meanmenu.css') }}">
    <link rel="stylesheet" href="{{ asset('styles/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('styles/css/style.css') }}">
</head>

<body>


    <!-- ============================================================== -->
    <!-- DEBUT DE L'EN-TETE -->
    <!-- ============================================================== -->
    <header class="header">
        <!-- Barre Supérieure (Contacts & Réseaux Sociaux) -->
        <div class="header__top-area grey-bg">
            <div class="container">
                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-6">
                        <div class="header__top-menu top-menu-black">
                            <ul>
                                <li>
                                    <a href="{{ route('pages.presentation') }}">Qui sommes-nous ? </a>
                                </li>
                                <li>
                                    <a href="{{ route('pages.editorial') }}">Ligne éditorial</a>
                                </li>

                                <li>
                                    <a href="{{ route('pages.contact') }}">Nous contacter</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6">
                        <div class="header__social header-social-black text-center text-md-right mt-10">
                            <a href="https://web.facebook.com/excellenceafrik" target="_blank">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="https://x.com/AcdNotif54528" target="_blank">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="https://www.linkedin.com/company/108564982/" target="_blank">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a href="https://www.instagram.com/excellenceafrik/" target="_blank">
                                <i class="fab fa-instagram"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Section Milieu (Logo & Publicité) -->
        <div class="header__middle pt-20">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-3 d-flex align-items-center justify-content-md-start justify-content-center">
                        <div class="header__logo text-center text-md-left mb-20">
                            <a href="index.html">
                                <img src="{{ asset('styles/img/logo/logo.png') }}" alt="Header Logo">
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-9">
                        <div class="header__add text-center text-md-right mb-20">
                            <a href="#">
                                <img src="{{ asset('styles/img/add/header-add.jpg') }}" alt="">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Menu de Navigation Principal -->
        <div class="header__menu-area grey-bg">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="header__right-icon header__icon-black f-right mt-17">
                            <a href="#" data-toggle="modal" data-target="#search-modal">
                                <i class="fas fa-search" style="color: #fff;"></i>
                            </a>
                            <a class="info-bar" href="javascript:void(0)">
                                <i class="fas fa-bars"></i>
                            </a>
                        </div>
                        <div class="header__menu header__menu-black f-left">
                            <nav id="mobile-menu">
                                <ul>
                                    <li class="{{ request()->routeIs('home') ? 'active' : '' }}"><a href="{{ route('home') }}">ACCUEIL</a></li>

                                    <li><a href="#">ECONOMIE RÉELLE</a>
                                        <ul class="submenu">
                                            @foreach($economyParents as $parent)
                                                <li><a href="{{ route('articles.category', $parent->slug) }}">{{ $parent->name }}</a></li>
                                            @endforeach
                                        </ul>
                                    </li>
                                    <li><a href="#">PORTRAITS</a>
                                        <ul class="submenu">
                                            <li><a href="{{ route('articles.category', 'figures-de-leconomie') }}">Figures de l'economie</a></li>
                                            <li><a href="{{ route('articles.category', 'portrait-de-l-entreprise') }}">Portrait de l'entreprise</a></li>
                                            <li><a href="{{ route('articles.category', 'portrait-de-l-entrepreneur') }}">Portrait de l'entrepreneur</a></li>
                                        </ul>
                                    </li>

                                    <li><a href="#">ANALYSES & EXPERTS</a>
                                        <ul class="submenu">
                                            <li><a href="{{ route('articles.category', 'parole-d-experts') }}">Parole d'experts</a></li>
                                        </ul>
                                    </li>

                                    <li class="has-dropdown">
                <a href="#">DIASPORA</a>
                <ul class="submenu">
                    @foreach ($diasporaParents as $category)
                        <li>
                            <a href="{{ route('articles.category', ['slug' => $category->slug]) }}">{{ $category->name }}</a>
                        </li>
                    @endforeach
                </ul>
            </li>

                                    <li><a href="{{ route('magazines.index') }}">MAGAZINE</a></li>
                                    <li class="webtv-menu-item"><a href="{{ route('webtv.index') }}"><i class="fas fa-tv"></i> WEBTV <span class="live-indicator">Live</span></a></li>

                                </ul>
                            </nav>
                        </div>
                        <div class="mobile-menu black-icon"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Fenêtre Modale de Recherche -->
        <div class="modal fade" id="search-modal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form>
                        <input type="text" placeholder="Rechercher un article...">
                        <button>
                            <i class="fa fa-search"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="footer-bg">
        <!-- Section d'Abonnement à la Newsletter -->
        <div class="subscribe-area pt-100 pb-80">
            <div class="container">
                <div class="subscribe-separator pt-50 pb-20">
                    <div class="row">
                        <div class="col-xl-2 col-lg-12">
                            <div class="footer-logo mb-30">
                                <a href="#"><img src="{{ asset('styles/img/logo/footer-logo.png') }}" alt=""></a>
                            </div>
                        </div>
                        <div class="col-xl-10 col-lg-12">
                            <div class="row">
                                <div class="col-xl-7 col-lg-7">
                                    <div class="subscribe-title">
                                        <h2>Restez informé </h2>
                                    </div>
                                </div>
                                <div class="col-xl-5 col-lg-5">
                                    <div class="subscribe-form mb-30">
                                        <form action="#">
                                            <input type="email" placeholder="Entrez votre adresse E-mail">
                                            <button type="submit">
                                                Abonnez-vous
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Section des Widgets du Pied de Page (Liens, etc.) -->
        <div class="footer-bottom-area pb-70">
            <div class="container">
                <div class="row">
                    <div class="col-xl-4">
                        <div class="footer-widget mb-30">
                            <p>Fondé en 2021 mais obtient les accréditations légale 2025, Excellence AFRIK se positionne
                                comme le premier magazine panafricain entièrement consacré aux entreprises non cotées, en
                                particulier les TPE, PME et startups opérant sur le terrain, souvent sans visibilité, mais avec
                                un fort impact économique et social.</p>
                            <div class="footer-social">
                                <a href="https://web.facebook.com/excellenceafrik" target="_blank" class="facebook">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="https://x.com/AcdNotif54528" target="_blank" class="twitter">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a href="https://www.linkedin.com/company/108564982/" target="_blank" class="dribbble">
                                    <i class="fab fa-linkedin-in"></i>
                                </a>
                                <a href="https://www.instagram.com/excellenceafrik/" target="_blank" class="instagram">
                                    <i class="fab fa-instagram"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-8">
                        <div class="widget-box mb-30">
                            <div class="row">
                                <div class="col-xl-3 col-lg-3">
                                    <div class="footer-widget mb-30">
                                        <h3>ACTUALITÉS</h3>
                                        <ul>
                                            @foreach($navCategories->take(9) as $category)
                                                <li><a href="{{ route('articles.category', $category->slug) }}">{{ $category->name }}</a></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3">
                                    <div class="footer-widget mb-30">
                                        <h3>SERVICES</h3>
                                        <ul>
                                            <li><a href="{{ route('pages.contact') }}">Publicité</a></li>
                                            <li><a href="{{ route('pages.contact') }}">Abonnement</a></li>
                                            <li><a href="{{ route('pages.contact') }}">Partenariat</a></li>
                                            <li><a href="{{ route('pages.contact') }}">Contact</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3">
                                    <div class="footer-widget mb-30">
                                        <h3>QUI SOMMES-NOUS</h3>
                                        <ul>
                                            <li><a href="{{ route('pages.presentation') }}">A propos</a></li>
                                            <li><a href="#">Mentions légales</a></li>
                                            <li><a href="#">Conditions d'utilisation</a></li>
                                            <li><a href="#">Politique de confidentialité</a></li>
                                            <li><a href="#">Plan du site</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3">
                                    <div class="footer-widget pt-50 mb-30">
                                        <ul>
                                            <li><a href="#" class="webtv-link"><i class="fas fa-video"></i> WEBTV</a></li>

                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Section Copyright -->
        <div class="copyright-area pt-25 pb-25">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="copyright text-center">
                            <p>© Copyrights 2025. Excellence AFRIK. Tous droits réservés.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- ============================================================== -->
    <!-- FIN DU PIED DE PAGE -->
    <!-- ============================================================== -->

    <!-- JS here -->
    <script src="{{ asset('styles/js/vendor/modernizr-3.5.0.min.js') }}"></script>
    <script src="{{ asset('styles/js/vendor/jquery-1.12.4.min.js') }}"></script>
    <script src="{{ asset('styles/js/popper.min.js') }}"></script>
    <script src="{{ asset('styles/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('styles/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('styles/js/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('styles/js/one-page-nav-min.js') }}"></script>
    <script src="{{ asset('styles/js/slick.min.js') }}"></script>
    <script src="{{ asset('styles/js/jquery.meanmenu.min.js') }}"></script>
    <script src="{{ asset('styles/js/ajax-form.js') }}"></script>
    <script src="{{ asset('styles/js/wow.min.js') }}"></script>
    <script src="{{ asset('styles/js/jquery.scrollUp.min.js') }}"></script>
    <script src="{{ asset('styles/js/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('styles/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('styles/js/plugins.js') }}"></script>
    <script src="{{ asset('styles/js/main.js') }}"></script>

    <!-- Particles.js Scripts for Animated Banner -->
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <script>
        if (document.getElementById('particles-js')) {
            particlesJS("particles-js", {
                "particles": {
                    "number": {
                        "value": 80,
                        "density": {
                            "enable": true,
                            "value_area": 800
                        }
                    },
                    "color": {
                        "value": "#ffffff"
                    },
                    "shape": {
                        "type": "circle",
                        "stroke": {
                            "width": 0,
                            "color": "#000000"
                        }
                    },
                    "opacity": {
                        "value": 0.5,
                        "random": false,
                        "anim": {
                            "enable": false,
                            "speed": 1,
                            "opacity_min": 0.1,
                            "sync": false
                        }
                    },
                    "size": {
                        "value": 3,
                        "random": true,
                        "anim": {
                            "enable": false,
                            "speed": 40,
                            "size_min": 0.1,
                            "sync": false
                        }
                    },
                    "line_linked": {
                        "enable": true,
                        "distance": 150,
                        "color": "#ffffff",
                        "opacity": 0.4,
                        "width": 1
                    },
                    "move": {
                        "enable": true,
                        "speed": 2,
                        "direction": "none",
                        "random": false,
                        "straight": false,
                        "out_mode": "out",
                        "bounce": false
                    }
                },
                "interactivity": {
                    "detect_on": "canvas",
                    "events": {
                        "onhover": {
                            "enable": true,
                            "mode": "repulse"
                        },
                        "onclick": {
                            "enable": true,
                            "mode": "push"
                        },
                        "resize": true
                    },
                    "modes": {
                        "repulse": {
                            "distance": 100,
                            "duration": 0.4
                        },
                        "push": {
                            "particles_nb": 4
                        }
                    }
                },
                "retina_detect": true
            });
        }
    </script>
    @stack('scripts')
</body>

</html>
