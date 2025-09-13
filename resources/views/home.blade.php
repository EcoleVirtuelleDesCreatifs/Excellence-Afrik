@extends('layouts.app')

@section('content')
    <!-- ============================================================== -->
    <!-- DEBUT DU CONTENU PRINCIPAL -->
    <!-- ============================================================== -->
    <main>
        <!-- Section 'Breaking News' (Informations Météo/Date) -->
        <section class="breaking pt-25 pb-25">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="breaking__meta mb-30">
                            <ul>
                                <li id="weather-info"><i class="fas fa-cloud-sun"></i> <span>Chargement...</span></li>
                                <li id="brvm-info"><i class="fas fa-chart-line"></i> <span>Chargement...</span></li>
                                <li id="eur-currency-info"><i class="fas fa-euro-sign"></i> <span>Chargement...</span></li>
                                <li id="usd-currency-info"><i class="fas fa-dollar-sign"></i> <span>Chargement...</span></li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </section>
        <!-- breaking end -->

        <!-- ============================================================== -->
        <!-- Section Principale (Hero Area) -->
        <!-- ============================================================== -->

        <section class="hero-area">
            <div class="container">

                <div class="row">
                    <div class="col-12">
                        <div class="section-title mb-30">
                            <h2>TOPS 3 DE L'ARTICLE DU JOUR</h2>
                        </div>
                    </div>
                @if(isset($dailyNews) && $dailyNews->count() > 0)
                    @php
                        $topArticle = $dailyNews->first();
                        $sideArticles = $dailyNews->slice(1, 2);
                    @endphp
                    <div class="row">
                        {{-- Main Article --}}
                        @if($topArticle)
                            <div class="col-lg-6 col-md-12">
                                <div class="hero pos-relative mb-30">
                                    <div class="hero__thumb" data-overlay="dark-gradient">
                                        <a href="{{ route('articles.show', $topArticle->slug) }}">
                                            @if($topArticle->featured_image_path && file_exists(public_path('storage/' . $topArticle->featured_image_path)))
                                                <img src="{{ asset('storage/' . $topArticle->featured_image_path) }}" alt="{{ $topArticle->title }}">
                                            @elseif($topArticle->featured_image_url)
                                                <img src="{{ $topArticle->featured_image_url }}" alt="{{ $topArticle->title }}">
                                            @else
                                                <img src="{{ asset('styles/img/hero/part1/hero1.jpg') }}" alt="{{ $topArticle->title }}">
                                            @endif
                                        </a>
                                    </div>
                                    <div class="hero__text">
                                        <span class="post-cat mb-10"><a href="{{ route('articles.category', $topArticle->category->slug) }}">{{ $topArticle->category->name }}</a></span>
                                        <h3 class="pr-100"><a href="{{ route('articles.show', $topArticle->slug) }}">{{ $topArticle->title }}</a></h3>
                                        <small>{{ $topArticle->created_at->format('d M Y') }} | {{ $topArticle->user->name ?? 'Admin' }}</small>
                                    </div>
                                </div>
                            </div>
                        @endif

                        {{-- Side Articles --}}
                        <div class="col-lg-6">
                            <div class="row">
                                @if($sideArticles->count() > 0)
                                    @foreach($sideArticles as $article)
                                        <div class="col-lg-6 col-md-6">
                                            <div class="hero pos-relative mb-30">
                                                <div class="hero__thumb" data-overlay="dark-gradient">
                                                    <a href="{{ route('articles.show', $article->slug) }}">
                                                        @if($article->featured_image_path && file_exists(public_path('storage/' . $article->featured_image_path)))
                                                            <img src="{{ asset('storage/' . $article->featured_image_path) }}" alt="{{ $article->title }}">
                                                        @elseif($article->featured_image_url)
                                                            <img src="{{ $article->featured_image_url }}" alt="{{ $article->title }}">
                                                        @else
                                                            <img src="{{ asset('styles/img/hero/part1/hero2.jpg') }}" alt="{{ $article->title }}">
                                                        @endif
                                                    </a>
                                                </div>
                                                <div class="hero__text hero__text-small">
                                                    <span class="post-cat mb-10">
                                                        <a href="{{ route('articles.category', $article->category->slug) }}">{{ $article->category->name }}</a>
                                                    </span>
                                                    <h3 class="pr-0">
                                                        <a href="{{ route('articles.show', $article->slug) }}">{{ Str::limit($article->title, 50) }}</a>
                                                    </h3>
                                                    <small>{{ $article->created_at->format('d M Y') }}</small>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </section>
        <!-- hero-area end -->

        <!-- ============================================================== -->
        <!-- Section des Actualités du Jour -->
        <!-- ============================================================== -->
        <section class="news-area pt-30 pb-30">
            <br />
            <br />
            <!-- trendy news -->
            <div class="container">
                <div class="row ">
                    <div class="col-12">
                        <div class="section-title mb-30">
                            <h2 style="color: #fff;">ACTUALITÉ DU JOUR</h2>
                        </div>
                    </div>
                </div>
                <br />
            </div>
            <div class="container">
                <div class="row row-10">
                    <div class="col-20 wow fadeInUp" data-wow-delay=".3s">
                        <div class="hero pos-relative mb-30">
                            <div class="hero__thumb" data-overlay="dark-gradient">
                                <a href="#"><img src="{{ asset('styles/img/trendy/sm1.jpg') }}" alt="hero image"></a>
                            </div>
                            <div class="hero__text hero__text-small">
                                <h3 class="pr-0"><a href="#">Paul Manafort’s Accountant Testifies She Helped Alter Financial Documents</a></h3>
                                <small>01 Sep 2018 | Nom de la Catégorie</small>
                            </div>
                        </div>
                        <div class="hero pos-relative mb-30">
                            <div class="hero__thumb" data-overlay="dark-gradient">
                                <a href="#"><img src="{{ asset('styles/img/trendy/sm2.jpg') }}" alt="hero image"></a>
                            </div>
                            <div class="hero__text hero__text-small">
                                <h3 class="pr-0"><a href="#">Rina Sawayama Is Not the Asian Britney Spears</a></h3>
                                <small>01 Sep 2018 | Nom de la Catégorie</small>
                            </div>
                        </div>
                        <div class="hero pos-relative mb-30">
                            <div class="hero__thumb" data-overlay="dark-gradient">
                                <a href="#"><img src="{{ asset('styles/img/trendy/sm3.jpg') }}" alt="hero image"></a>
                            </div>
                            <div class="hero__text hero__text-small">
                                <h3 class="pr-0"><a href="#">Receiving the Summer Sols tice the Swedish Way</a></h3>
                                <small>01 Sep 2018 | Nom de la Catégorie</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-40 wow fadeInUp" data-wow-delay=".5s">
                        <div class="hero pos-relative mb-30">
                            <div class="hero__thumb" data-overlay="dark-gradient">
                                <a href="#"><img src="{{ asset('styles/img/trendy/lg1.jpg') }}" alt="hero image"></a>
                            </div>
                            <div class="hero__text">
                                <h3 class="pr-100"><a href="#">Trump’s Inaccurate Claims About High ways the world, Immigration and Beyoncé.</a></h3>
                                <small>01 Sep 2018 | Nom de la Catégorie</small>
                            </div>
                        </div>

                        <div class="hero pos-relative mb-30">
                            <div class="hero__thumb" data-overlay="dark-gradient">
                                <a href="#"><img src="{{ asset('styles/img/trendy/lg2.jpg') }}" alt="hero image"></a>
                            </div>
                            <div class="hero__text">
                                <h3 class="pr-100"><a href="#">Moving From Buyer to Seller, Major League Soccer Revenue In The World Wide Claims About.</a></h3>
                                <small>01 Sep 2018 | Nom de la Catégorie</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-20 d-md-none d-xl-block wow fadeInUp" data-wow-delay=".7s">
                        <div class="hero pos-relative mb-30">
                            <div class="hero__thumb" data-overlay="dark-gradient">
                                <a href="#"><img src="{{ asset('styles/img/trendy/xs/xs-1.jpg') }}" alt="hero image"></a>
                            </div>
                            <div class="hero__text hero__text-small">
                                <span class="post-cat mb-10"><a href="#">Fashion</a></span>
                                <h3 class="pr-0"><a href="#">Storm in aw ame home away.</a></h3>
                            </div>
                        </div>
                        <div class="hero pos-relative mb-30">
                            <div class="hero__thumb" data-overlay="dark-gradient">
                                <a href="#"><img src="{{ asset('styles/img/trendy/xs/xs-2.jpg') }}" alt="hero image"></a>
                            </div>
                            <div class="hero__text hero__text-small">
                                <span class="post-cat mb-10"><a href="#">Fashion</a></span>
                                <h3 class="pr-0"><a href="#">Good ridre urants bid farewell.</a></h3>
                            </div>
                        </div>
                        <div class="hero pos-relative mb-30">
                            <div class="hero__thumb" data-overlay="dark-gradient">
                                <a href="#"><img src="{{ asset('styles/img/trendy/xs/xs-3.jpg') }}" alt="hero image"></a>
                            </div>
                            <div class="hero__text hero__text-small">
                                <span class="post-cat mb-10"><a href="#">Fashion</a></span>
                                <h3 class="pr-0"><a href="#">Nahan dow plays Lieral lership..</a></h3>
                            </div>
                        </div>

                    </div>
                    <div class="col-20 wow fadeInUp" data-wow-delay=".9s">
                        <div class="hero pos-relative mb-30">
                            <div class="hero__thumb" data-overlay="dark-gradient">
                                <a href="#"><img src="{{ asset('styles/img/trendy/sm4.jpg') }}" alt="hero image"></a>
                            </div>
                            <div class="hero__text hero__text-small">
                                <h3 class="pr-0"><a href="#">Paul Manafort’s Accountant Testifies She Helped Alter Financial Documents</a></h3>
                                <small>01 Sep 2018 | Nom de la Catégorie</small>
                            </div>
                        </div>
                        <div class="hero pos-relative mb-30">
                            <div class="hero__thumb" data-overlay="dark-gradient">
                                <a href="#"><img src="{{ asset('styles/img/trendy/sm5.jpg') }}" alt="hero image"></a>
                            </div>
                            <div class="hero__text hero__text-small">
                                <h3 class="pr-0"><a href="#">Rina Sawayama Is Not the Asian Britney Spears</a></h3>
                                <small>01 Sep 2018 | Nom de la Catégorie</small>
                            </div>
                        </div>
                        <div class="hero pos-relative mb-30">
                            <div class="hero__thumb" data-overlay="dark-gradient">
                                <a href="#"><img src="{{ asset('styles/img/trendy/sm6.jpg') }}" alt="hero image"></a>
                            </div>
                            <div class="hero__text hero__text-small">
                                <h3 class="pr-0"><a href="#">Receiving the Summer Sols tice the Swedish Way</a></h3>
                                <small>01 Sep 2018 | Nom de la Catégorie</small>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
            <br />
            <br />
            <br />
            <div class="post-btn mb-50">
                <a href="#" class="btn btn-border">Voir plus </a>
            </div>
            <!-- trendy news end -->
        </section>
        <!-- news area end -->



        <br />
        <br />
        <br />
        <br />

        <!-- ============================================================== -->
        <!-- Section 'Portrait d'Entrepreneurs' -->
        <!-- ============================================================== -->
        <section class="portrait-area pb-30">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="section-title mb-30">
                            <h2>Portrait d'Entrepreneurs</h2>
                        </div>
                    </div>
                </div>

                @if(isset($entrepreneurArticles) && $entrepreneurArticles->count() > 0)
                    @foreach($entrepreneurArticles as $article)
                        <div class="row align-items-center portrait-item mb-50">
                            <div class="col-lg-6 @if($loop->odd) order-lg-2 @endif wow fadeInUp">
                                <a href="{{ route('articles.show', $article->slug) }}">
                                    <img src="{{ $article->image_url ?? asset('styles/img/video/video-2.jpg') }}" alt="{{ $article->title }}" class="img-fluid">
                                </a>
                            </div>
                            <div class="col-lg-6 @if($loop->odd) order-lg-1 @endif wow fadeInUp">
                                <div class="portrait-text">
                                    <h3>{{ $article->title }}</h3>
                                    <p>{{ Str::limit(strip_tags($article->content), 150) }}</p>
                                    <a href="{{ route('articles.show', $article->slug) }}" class="btn btn-link">Lire la suite</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-12">
                        <p>Aucun portrait d'entrepreneur à afficher pour le moment.</p>
                    </div>
                @endif
            </div>
        </section>


        <!-- ============================================================== -->
        <!-- Section des Magazines -->
        <!-- ============================================================== -->
        <section class="add-area pb-30">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12">
                        <div class="section-title mb-30">
                            <h2>Magazines</h2>
                        </div>

                        @if(isset($latestMagazine))
                            <div class="row">
                                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay=".3s">
                                    <div class="hero pos-relative mb-30">
                                        <div class="hero__thumb" data-overlay="dark-gradient">
                                            <a href="{{ route('magazines.show', $latestMagazine->slug) }}">
                                                <img src="{{ Storage::url($latestMagazine->cover_image_path) ?? asset('styles/img/hero/part1/hero2.jpg') }}" alt="{{ $latestMagazine->title }}">
                                            </a>
                                        </div>
                                        <div class="hero__text hero__text-small">
                                            <span class="post-cat mb-10">
                                                <a href="{{ route('magazines.index') }}">Magazine</a>
                                            </span>
                                            <h3 class="pr-0">
                                                <a href="{{ route('magazines.show', $latestMagazine->slug) }}">{{ $latestMagazine->title }}</a>
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <p>Aucun magazine à afficher pour le moment.</p>
                        @endif
                    </div>
                </div>
            </div>
        </section>
        <!-- add-area end -->



        <!-- ============================================================== -->
        <!-- Section de Téléchargement des Applications -->
        <!-- ============================================================== -->
        <section class="app-area pb-60">
            <div class="container">
                <div class="grey-bg pt-55 pb-55 pl-60 pr-60 wow fadeInUp" data-wow-delay=".3s">
                    <div class="row">
                        <div class="col-xl-6 col-lg-12">
                            <div class="app-text text-center text-xl-left">
                                <h2>Download our apps now</h2>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-12">
                            <div class="app-store text-center text-xl-right">
                                <a href="#"><img src="{{ asset('styles/img/store/apple.png') }}" alt=""></a>
                                <a href="#"><img src="{{ asset('styles/img/store/google.png') }}" alt=""></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>



    </main>
    <!-- ============================================================== -->
    <!-- FIN DU CONTENU PRINCIPAL -->
    <!-- ============================================================== -->
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const weatherEl = document.getElementById('weather-info');
        const brvmEl = document.getElementById('brvm-info');
        const eurEl = document.getElementById('eur-currency-info');
        const usdEl = document.getElementById('usd-currency-info');

        // Fetch Weather
        fetch('{{ route('api.weather') }}')
            .then(response => response.json())
            .then(data => {
                const info = data.success ? data.data : data.fallback;
                weatherEl.innerHTML = `<i class="fas fa-cloud-sun"></i> <span>${info.city}: ${info.temp}°C, ${info.description}</span>`;
            })
            .catch(() => {
                weatherEl.innerHTML = `<i class="fas fa-cloud-sun"></i> <span>Météo indisponible</span>`;
            });

        // Fetch BRVM
        fetch('{{ route('api.brvm') }}')
            .then(response => response.json())
            .then(data => {
                const info = data.success ? data.data : data.fallback;
                brvmEl.innerHTML = `<i class="fas fa-chart-line"></i> <span>${info.index_name}: ${info.value} <span class="${info.change_class}">(${info.change_display})</span></span>`;
            })
            .catch(() => {
                brvmEl.innerHTML = `<i class="fas fa-chart-line"></i> <span>Bourse indisponible</span>`;
            });

        // Fetch Currency
        fetch('{{ route('api.currency') }}')
            .then(response => response.json())
            .then(data => {
                const info = data.success ? data.data : data.fallback;
                eurEl.innerHTML = `<i class="fas fa-euro-sign"></i> <span>1 EUR = ${info.eur_xof} XOF</span>`;
                usdEl.innerHTML = `<i class="fas fa-dollar-sign"></i> <span>1 USD = ${info.usd_xof} XOF</span>`;
            })
            .catch(() => {
                eurEl.innerHTML = `<i class="fas fa-euro-sign"></i> <span>EUR/XOF indisponible</span>`;
                usdEl.innerHTML = `<i class="fas fa-dollar-sign"></i> <span>USD/XOF indisponible</span>`;
            });
    });
</script>
@endpush

@endsection
