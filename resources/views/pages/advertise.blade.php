@extends('layouts.app')

@section('title', 'Publicité & Partenariats - Excellence Afrik')
@section('meta_description', 'Découvrez nos solutions publicitaires et opportunités de partenariat pour promouvoir votre marque auprès de notre audience qualifiée')

@section('page_title', 'Publicité & Partenariats')
@section('page_subtitle', 'Atteignez votre audience cible avec Excellence Afrik')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-10">

            <!-- Hero Section -->
            <section class="advertise-hero mb-5">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="hero-content">
                            <h1 class="hero-title">Votre Message au Cœur de l'Excellence Africaine</h1>
                            <p class="hero-description">
                                Rejoignez les marques qui font confiance à Excellence Afrik pour toucher 
                                les décideurs économiques et entrepreneurs africains les plus influents.
                            </p>
                            <div class="hero-stats">
                                <div class="stat-item">
                                    <span class="stat-number">50K+</span>
                                    <span class="stat-label">Lecteurs mensuels</span>
                                </div>
                                <div class="stat-item">
                                    <span class="stat-number">85%</span>
                                    <span class="stat-label">Dirigeants d'entreprise</span>
                                </div>
                                <div class="stat-item">
                                    <span class="stat-number">15</span>
                                    <span class="stat-label">Pays africains</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="hero-image">
                            <img src="https://images.unsplash.com/photo-1560472354-b33ff0c44a43?w=600&h=400&fit=crop" 
                                 alt="Publicité Excellence Afrik" class="img-fluid rounded-3">
                        </div>
                    </div>
                </div>
            </section>

            <!-- Advertising Solutions -->
            <section class="advertising-solutions mb-5">
                <div class="solutions-header text-center mb-5">
                    <h2 class="solutions-title">Nos Solutions Publicitaires</h2>
                    <p class="solutions-subtitle">Des formats adaptés à vos objectifs marketing</p>
                </div>
                
                <div class="row g-4">
                    <div class="col-lg-4">
                        <div class="solution-card">
                            <div class="solution-icon">
                                <i class="fas fa-desktop"></i>
                            </div>
                            <h3>Display Digital</h3>
                            <p>Bannières et contenus sponsorisés sur notre site web et newsletter</p>
                            <ul class="solution-features">
                                <li>Bannières premium</li>
                                <li>Articles sponsorisés</li>
                                <li>Newsletter dédiée</li>
                                <li>Ciblage géographique</li>
                            </ul>
                            <div class="solution-price">À partir de 500€/mois</div>
                        </div>
                    </div>
                    
                    <div class="col-lg-4">
                        <div class="solution-card featured">
                            <div class="solution-badge">Populaire</div>
                            <div class="solution-icon">
                                <i class="fas fa-video"></i>
                            </div>
                            <h3>Sponsoring WEB TV</h3>
                            <p>Parrainage d'émissions et intégrations dans nos contenus vidéo</p>
                            <ul class="solution-features">
                                <li>Sponsoring d'émissions</li>
                                <li>Placement de produit</li>
                                <li>Interviews dédiées</li>
                                <li>Contenu sur mesure</li>
                            </ul>
                            <div class="solution-price">À partir de 1500€/mois</div>
                        </div>
                    </div>
                    
                    <div class="col-lg-4">
                        <div class="solution-card">
                            <div class="solution-icon">
                                <i class="fas fa-book"></i>
                            </div>
                            <h3>Magazine Print</h3>
                            <p>Publicité dans nos éditions imprimées et versions PDF</p>
                            <ul class="solution-features">
                                <li>Pages publicitaires</li>
                                <li>Encarts personnalisés</li>
                                <li>Cahiers spéciaux</li>
                                <li>Distribution ciblée</li>
                            </ul>
                            <div class="solution-price">À partir de 800€/numéro</div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Partnership Types -->
            <section class="partnership-types mb-5">
                <div class="partnerships-header text-center mb-5">
                    <h2 class="partnerships-title">Types de Partenariats</h2>
                    <p class="partnerships-subtitle">Collaborons pour créer de la valeur ensemble</p>
                </div>
                
                <div class="row g-4">
                    <div class="col-lg-6">
                        <div class="partnership-card">
                            <div class="partnership-header">
                                <i class="fas fa-handshake text-primary"></i>
                                <h3>Partenariat Média</h3>
                            </div>
                            <div class="partnership-content">
                                <p>Collaboration éditoriale pour créer du contenu de qualité</p>
                                <ul>
                                    <li>Co-création de contenus</li>
                                    <li>Échange de visibilité</li>
                                    <li>Événements conjoints</li>
                                    <li>Cross-promotion</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-6">
                        <div class="partnership-card">
                            <div class="partnership-header">
                                <i class="fas fa-trophy text-warning"></i>
                                <h3>Sponsoring Événements</h3>
                            </div>
                            <div class="partnership-content">
                                <p>Associez votre marque à nos événements exclusifs</p>
                                <ul>
                                    <li>Conférences thématiques</li>
                                    <li>Awards entrepreneurs</li>
                                    <li>Networking premium</li>
                                    <li>Visibilité maximale</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Audience Profile -->
            <section class="audience-profile mb-5">
                <div class="profile-wrapper">
                    <div class="row">
                        <div class="col-lg-8 mx-auto">
                            <div class="profile-content">
                                <h2 class="profile-title">Notre Audience</h2>
                                <p class="profile-description">
                                    Une communauté qualifiée de décideurs économiques africains
                                </p>
                                
                                <div class="audience-stats">
                                    <div class="row g-4">
                                        <div class="col-md-3 col-6">
                                            <div class="audience-stat">
                                                <div class="stat-number">45%</div>
                                                <div class="stat-label">CEOs & Fondateurs</div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-6">
                                            <div class="audience-stat">
                                                <div class="stat-number">30%</div>
                                                <div class="stat-label">Cadres dirigeants</div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-6">
                                            <div class="audience-stat">
                                                <div class="stat-number">15%</div>
                                                <div class="stat-label">Investisseurs</div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-6">
                                            <div class="audience-stat">
                                                <div class="stat-number">10%</div>
                                                <div class="stat-label">Consultants</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="geographic-reach">
                                    <h3>Couverture Géographique</h3>
                                    <div class="countries-list">
                                        <span class="country-tag">Côte d'Ivoire</span>
                                        <span class="country-tag">Sénégal</span>
                                        <span class="country-tag">Mali</span>
                                        <span class="country-tag">Burkina Faso</span>
                                        <span class="country-tag">Ghana</span>
                                        <span class="country-tag">Nigeria</span>
                                        <span class="country-tag">Cameroun</span>
                                        <span class="country-tag">Maroc</span>
                                        <span class="country-tag">Tunisie</span>
                                        <span class="country-tag">Kenya</span>
                                        <span class="country-tag">+5 autres</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Success Stories -->
            <section class="success-stories mb-5">
                <div class="stories-header text-center mb-5">
                    <h2 class="stories-title">Ils Nous Font Confiance</h2>
                    <p class="stories-subtitle">Témoignages de nos partenaires</p>
                </div>
                
                <div class="row g-4">
                    <div class="col-lg-4">
                        <div class="story-card">
                            <div class="story-content">
                                <p>"Notre partenariat avec Excellence Afrik nous a permis d'atteindre précisément notre cible d'entrepreneurs africains. ROI exceptionnel !"</p>
                            </div>
                            <div class="story-author">
                                <img src="https://via.placeholder.com/60x60/007bff/ffffff?text=AB" alt="AfriBank" class="author-logo">
                                <div class="author-info">
                                    <div class="author-name">AfriBank</div>
                                    <div class="author-title">Banque d'investissement</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-4">
                        <div class="story-card">
                            <div class="story-content">
                                <p>"La qualité éditoriale et l'audience qualifiée d'Excellence Afrik correspondent parfaitement à nos objectifs de communication."</p>
                            </div>
                            <div class="story-author">
                                <img src="https://via.placeholder.com/60x60/28a745/ffffff?text=TC" alt="TechCorp" class="author-logo">
                                <div class="author-info">
                                    <div class="author-name">TechCorp Africa</div>
                                    <div class="author-title">Solutions technologiques</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-4">
                        <div class="story-card">
                            <div class="story-content">
                                <p>"Excellence Afrik nous a aidés à positionner notre marque comme leader sur le marché africain. Résultats mesurables !"</p>
                            </div>
                            <div class="story-author">
                                <img src="https://via.placeholder.com/60x60/ffc107/000000?text=IC" alt="InvestCorp" class="author-logo">
                                <div class="author-info">
                                    <div class="author-name">InvestCorp</div>
                                    <div class="author-title">Fonds d'investissement</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Contact CTA -->
            <section class="advertise-cta">
                <div class="cta-card">
                    <div class="row align-items-center">
                        <div class="col-lg-8">
                            <h3 class="cta-title">Prêt à Booster Votre Visibilité ?</h3>
                            <p class="cta-description">
                                Contactez notre équipe commerciale pour discuter de vos objectifs 
                                et découvrir la solution publicitaire qui vous correspond.
                            </p>
                        </div>
                        <div class="col-lg-4 text-lg-end">
                            <a href="{{ route('pages.contact') }}" class="btn btn-light btn-lg">
                                <i class="fas fa-phone me-2"></i>Nous contacter
                            </a>
                        </div>
                    </div>
                </div>
            </section>

        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.hero-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 1.5rem;
    color: var(--bs-primary);
}

.hero-description {
    font-size: 1.1rem;
    line-height: 1.6;
    color: var(--bs-gray-600);
    margin-bottom: 2rem;
}

.hero-stats {
    display: flex;
    gap: 2rem;
    flex-wrap: wrap;
}

.stat-item {
    text-align: center;
}

.stat-number {
    display: block;
    font-size: 2rem;
    font-weight: 700;
    color: var(--bs-primary);
}

.stat-label {
    font-size: 0.9rem;
    color: var(--bs-gray-600);
}

.solutions-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 1rem;
}

.solutions-subtitle {
    font-size: 1.1rem;
    color: var(--bs-gray-600);
}

.solution-card {
    background: white;
    padding: 2.5rem;
    border-radius: 1.5rem;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    text-align: center;
    height: 100%;
    position: relative;
    transition: transform 0.3s ease;
}

.solution-card:hover {
    transform: translateY(-10px);
}

.solution-card.featured {
    border: 3px solid var(--bs-primary);
    transform: scale(1.05);
}

.solution-badge {
    position: absolute;
    top: -10px;
    left: 50%;
    transform: translateX(-50%);
    background: var(--bs-primary);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 1rem;
    font-size: 0.8rem;
    font-weight: 600;
}

.solution-icon {
    width: 80px;
    height: 80px;
    background: var(--bs-primary);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    font-size: 2rem;
}

.solution-card h3 {
    font-size: 1.5rem;
    font-weight: 600;
    margin-bottom: 1rem;
}

.solution-features {
    list-style: none;
    padding: 0;
    text-align: left;
    margin-bottom: 2rem;
}

.solution-features li {
    padding: 0.5rem 0;
    position: relative;
    padding-left: 1.5rem;
}

.solution-features li:before {
    content: "✓";
    color: var(--bs-success);
    font-weight: bold;
    position: absolute;
    left: 0;
}

.solution-price {
    background: #f8f9fa;
    padding: 1rem;
    border-radius: 0.5rem;
    font-weight: 600;
    color: var(--bs-primary);
    font-size: 1.1rem;
}

.partnership-card {
    background: white;
    padding: 2rem;
    border-radius: 1.5rem;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    height: 100%;
}

.partnership-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.partnership-header i {
    font-size: 2rem;
}

.partnership-header h3 {
    font-size: 1.3rem;
    font-weight: 600;
    margin: 0;
}

.partnership-content ul {
    list-style: none;
    padding: 0;
}

.partnership-content li {
    padding: 0.5rem 0;
    position: relative;
    padding-left: 1.5rem;
}

.partnership-content li:before {
    content: "▸";
    color: var(--bs-primary);
    position: absolute;
    left: 0;
}

.audience-profile {
    background: #f8f9fa;
    padding: 4rem 0;
    border-radius: 2rem;
}

.profile-title {
    font-size: 2.5rem;
    font-weight: 700;
    text-align: center;
    margin-bottom: 1rem;
}

.profile-description {
    text-align: center;
    font-size: 1.1rem;
    color: var(--bs-gray-600);
    margin-bottom: 3rem;
}

.audience-stats {
    margin-bottom: 3rem;
}

.audience-stat {
    text-align: center;
    background: white;
    padding: 2rem 1rem;
    border-radius: 1rem;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
}

.audience-stat .stat-number {
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--bs-primary);
    display: block;
    margin-bottom: 0.5rem;
}

.audience-stat .stat-label {
    font-size: 0.9rem;
    color: var(--bs-gray-600);
    font-weight: 500;
}

.geographic-reach h3 {
    text-align: center;
    margin-bottom: 2rem;
    font-size: 1.5rem;
    font-weight: 600;
}

.countries-list {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    justify-content: center;
}

.country-tag {
    background: var(--bs-primary);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 1rem;
    font-size: 0.9rem;
    font-weight: 500;
}

.story-card {
    background: white;
    padding: 2rem;
    border-radius: 1.5rem;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    height: 100%;
}

.story-content {
    margin-bottom: 2rem;
}

.story-content p {
    font-style: italic;
    line-height: 1.6;
    margin: 0;
}

.story-author {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.author-logo {
    width: 50px;
    height: 50px;
    border-radius: 50%;
}

.author-name {
    font-weight: 600;
    margin-bottom: 0.25rem;
}

.author-title {
    font-size: 0.9rem;
    color: var(--bs-gray-600);
}

.advertise-cta {
    margin-top: 4rem;
}

.cta-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 3rem;
    border-radius: 2rem;
    color: white;
}

.cta-title {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 1rem;
    color: white;
}

.cta-description {
    font-size: 1.1rem;
    line-height: 1.6;
    opacity: 0.9;
    margin: 0;
}

@media (max-width: 768px) {
    .hero-title,
    .solutions-title,
    .profile-title {
        font-size: 2rem;
    }
    
    .hero-stats {
        justify-content: center;
        margin-top: 2rem;
    }
    
    .solution-card.featured {
        transform: none;
    }
    
    .cta-card {
        text-align: center;
        padding: 2rem;
    }
    
    .cta-title {
        font-size: 1.5rem;
    }
}
</style>
@endpush
