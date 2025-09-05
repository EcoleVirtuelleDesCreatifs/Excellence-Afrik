@extends('layouts.app')

@section('title', 'Collection Magazines - Excellence Afrik')
@section('meta_description', 'Découvrez notre collection exclusive de magazines Excellence Afrik. Articles de qualité, analyses approfondies et contenus inspirants sur l\'excellence africaine.')

@section('content')
<div class="magazine-collection-container">
    <!-- Hero Section with Featured Magazine -->
    <section class="magazine-hero-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-10">
                    <div class="hero-content-wrapper">
                        <div class="row align-items-center">
                            <!-- Featured Magazine Cover -->
                            <div class="col-md-5">
                                <div class="featured-magazine-cover">
                                    <div class="magazine-cover-container">
                                        <img src="{{ asset('assets/images/magazines/featured-cover.jpg') }}" 
                                             alt="Magazine Excellence Afrik - Édition Spéciale" 
                                             class="magazine-cover-img">
                                        <div class="magazine-overlay">
                                            <span class="magazine-badge">
                                                <i class="fas fa-star"></i> Édition Spéciale
                                            </span>
                                            <span class="magazine-date">
                                                <i class="far fa-calendar"></i> Décembre 2024
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Hero Text Content -->
                            <div class="col-md-7">
                                <div class="hero-text-content">
                                    <div class="hero-subtitle">
                                        <i class="fas fa-book-open"></i> Magazine Excellence Afrik
                                    </div>
                                    <h1 class="hero-title">
                                        L'Excellence <span class="gold-accent">Africaine</span>
                                        <span class="issue-number">Numéro Spécial 2024</span>
                                    </h1>
                                    <p class="hero-description">
                                        Découvrez notre collection exclusive de magazines dédiés à l'excellence africaine. 
                                        Des analyses approfondies, des portraits inspirants et des contenus de qualité 
                                        pour célébrer la richesse du continent.
                                    </p>
                                    
                                    <div class="hero-actions">
                                        <a href="#" class="btn-primary-gold">
                                            <i class="fas fa-book-reader"></i> Télécharger
                                        </a>
                                        <a href="#" class="btn-secondary-outline">
                                            <i class="fas fa-download"></i> Télécharger PDF
                                        </a>
                                    </div>
                                    
                                    {{-- hero-stats removed as requested --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Collection Header -->
    <section class="collection-header-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-10">
                    <div class="collection-header">
                        <h2 class="collection-title">Notre Collection</h2>
                        <p class="collection-subtitle">
                            Explorez tous nos magazines et plongez dans l'univers de l'excellence africaine. 
                            Chaque édition est soigneusement conçue pour vous offrir des contenus de qualité exceptionnelle.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Magazines Grid -->
    <section class="magazines-grid-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-10">
                    @include('magazines.partials.magazine-grid')
                    
                    <!-- Pagination -->
                    <div class="magazines-pagination">
                        <div class="pagination-wrapper">
                            <div class="pagination-info">
                                Affichage de 1 à 12 sur 25 magazines
                            </div>
                            <nav aria-label="Navigation magazines">
                                <ul class="pagination-list">
                                    <li class="page-item disabled">
                                        <span class="page-link">
                                            <i class="fas fa-chevron-left"></i> Précédent
                                        </span>
                                    </li>
                                    <li class="page-item active">
                                        <span class="page-link">1</span>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">2</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">3</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">
                                            Suivant <i class="fas fa-chevron-right"></i>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="newsletter-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-10">
                    <div class="newsletter-card">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <div class="newsletter-content">
                                    <div class="newsletter-icon">
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                    <div class="newsletter-text">
                                        <h3>Restez Informé</h3>
                                        <p>Recevez nos derniers magazines et articles directement dans votre boîte mail.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <form class="newsletter-form">
                                    <div class="input-group">
                                        <input type="email" 
                                               class="form-control" 
                                               placeholder="Votre adresse email"
                                               required>
                                        <button type="submit" class="btn-subscribe">
                                            <i class="fas fa-paper-plane"></i> S'abonner
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('styles')
<link href="{{ asset('assets/css/magazine-style.css') }}" rel="stylesheet">
<style>
/* Additional custom styles if needed */
</style>
@endpush
