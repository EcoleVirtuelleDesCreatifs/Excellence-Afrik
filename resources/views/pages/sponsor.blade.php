@extends('layouts.app')

@section('title', 'Devenir Sponsor - Excellence Afrik')
@section('meta_description', 'Rejoignez nos sponsors et soutenez l\'excellence entrepreneuriale africaine. Découvrez nos packages de sponsoring et opportunités de partenariat')

@section('page_title', 'Devenir Sponsor')
@section('page_subtitle', 'Soutenez l\'excellence entrepreneuriale africaine')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-10">

            <!-- Hero Section -->
            <section class="sponsor-hero mb-5">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="hero-content">
                            <h1 class="hero-title">Investissez dans l'Avenir de l'Afrique</h1>
                            <p class="hero-description">
                                En devenant sponsor d'Excellence Afrik, vous soutenez directement 
                                l'écosystème entrepreneurial africain et renforcez votre engagement 
                                pour le développement économique du continent.
                            </p>
                            <div class="hero-benefits">
                                <div class="benefit-item">
                                    <i class="fas fa-rocket text-primary"></i>
                                    <span>Soutien à l'innovation africaine</span>
                                </div>
                                <div class="benefit-item">
                                    <i class="fas fa-users text-success"></i>
                                    <span>Réseau d'entrepreneurs qualifiés</span>
                                </div>
                                <div class="benefit-item">
                                    <i class="fas fa-award text-warning"></i>
                                    <span>Reconnaissance de votre engagement</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="hero-image">
                            <img src="https://images.unsplash.com/photo-1521737604893-d14cc237f11d?w=600&h=400&fit=crop" 
                                 alt="Sponsoring Excellence Afrik" class="img-fluid rounded-3">
                        </div>
                    </div>
                </div>
            </section>

            <!-- Why Sponsor -->
            <section class="why-sponsor mb-5">
                <div class="why-header text-center mb-5">
                    <h2 class="why-title">Pourquoi Devenir Sponsor ?</h2>
                    <p class="why-subtitle">L'impact de votre soutien va bien au-delà de la visibilité</p>
                </div>
                
                <div class="row g-4">
                    <div class="col-lg-4">
                        <div class="why-card">
                            <div class="why-icon">
                                <i class="fas fa-seedling"></i>
                            </div>
                            <h3>Cultivez l'Excellence</h3>
                            <p>
                                Votre sponsoring permet de mettre en lumière les entrepreneurs 
                                africains les plus prometteurs et de soutenir leurs projets innovants.
                            </p>
                        </div>
                    </div>
                    
                    <div class="col-lg-4">
                        <div class="why-card">
                            <div class="why-icon">
                                <i class="fas fa-network-wired"></i>
                            </div>
                            <h3>Créez des Connexions</h3>
                            <p>
                                Accédez à un réseau exclusif d'entrepreneurs, investisseurs 
                                et décideurs économiques à travers toute l'Afrique.
                            </p>
                        </div>
                    </div>
                    
                    <div class="col-lg-4">
                        <div class="why-card">
                            <div class="why-icon">
                                <i class="fas fa-globe-africa"></i>
                            </div>
                            <h3>Impactez le Continent</h3>
                            <p>
                                Participez activement au développement économique de l'Afrique 
                                en soutenant les acteurs du changement.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Sponsorship Packages -->
            <section class="sponsorship-packages mb-5">
                <div class="packages-header text-center mb-5">
                    <h2 class="packages-title">Nos Packages de Sponsoring</h2>
                    <p class="packages-subtitle">Choisissez le niveau d'engagement qui vous correspond</p>
                </div>
                
                <div class="row g-4">
                    <div class="col-lg-4">
                        <div class="package-card">
                            <div class="package-header">
                                <div class="package-name">Bronze</div>
                                <div class="package-price">2 500€<span>/an</span></div>
                            </div>
                            <div class="package-features">
                                <ul>
                                    <li><i class="fas fa-check"></i> Logo sur le site web</li>
                                    <li><i class="fas fa-check"></i> Mention dans la newsletter</li>
                                    <li><i class="fas fa-check"></i> 2 articles sponsorisés/an</li>
                                    <li><i class="fas fa-check"></i> Rapport d'impact trimestriel</li>
                                </ul>
                            </div>
                            <div class="package-cta">
                                <a href="#contact" class="btn btn-outline-primary">Choisir Bronze</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-4">
                        <div class="package-card featured">
                            <div class="package-badge">Populaire</div>
                            <div class="package-header">
                                <div class="package-name">Argent</div>
                                <div class="package-price">5 000€<span>/an</span></div>
                            </div>
                            <div class="package-features">
                                <ul>
                                    <li><i class="fas fa-check"></i> Tout du package Bronze</li>
                                    <li><i class="fas fa-check"></i> Logo dans le magazine</li>
                                    <li><i class="fas fa-check"></i> Sponsoring d'une émission WEB TV</li>
                                    <li><i class="fas fa-check"></i> 4 articles sponsorisés/an</li>
                                    <li><i class="fas fa-check"></i> Accès événements VIP</li>
                                    <li><i class="fas fa-check"></i> Rapport mensuel détaillé</li>
                                </ul>
                            </div>
                            <div class="package-cta">
                                <a href="#contact" class="btn btn-primary">Choisir Argent</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-4">
                        <div class="package-card premium">
                            <div class="package-header">
                                <div class="package-name">Or</div>
                                <div class="package-price">10 000€<span>/an</span></div>
                            </div>
                            <div class="package-features">
                                <ul>
                                    <li><i class="fas fa-check"></i> Tout du package Argent</li>
                                    <li><i class="fas fa-check"></i> Partenaire titre d'événements</li>
                                    <li><i class="fas fa-check"></i> Contenu sur mesure mensuel</li>
                                    <li><i class="fas fa-check"></i> Accès base de données entrepreneurs</li>
                                    <li><i class="fas fa-check"></i> Rencontres B2B organisées</li>
                                    <li><i class="fas fa-check"></i> Support marketing dédié</li>
                                </ul>
                            </div>
                            <div class="package-cta">
                                <a href="#contact" class="btn btn-warning">Choisir Or</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Success Stories -->
            <section class="sponsor-stories mb-5">
                <div class="stories-header text-center mb-5">
                    <h2 class="stories-title">Nos Sponsors Témoignent</h2>
                    <p class="stories-subtitle">L'impact concret de leur engagement</p>
                </div>
                
                <div class="row g-4">
                    <div class="col-lg-6">
                        <div class="story-card">
                            <div class="story-content">
                                <p>
                                    "Notre partenariat avec Excellence Afrik nous a permis d'identifier 
                                    et de soutenir des entrepreneurs exceptionnels. Un investissement 
                                    dans l'avenir de l'Afrique qui porte ses fruits."
                                </p>
                            </div>
                            <div class="story-author">
                                <img src="https://via.placeholder.com/80x80/007bff/ffffff?text=AF" alt="Africa Fund" class="author-logo">
                                <div class="author-info">
                                    <div class="author-name">Marie Kouassi</div>
                                    <div class="author-title">Directrice - Africa Investment Fund</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-6">
                        <div class="story-card">
                            <div class="story-content">
                                <p>
                                    "Excellence Afrik nous offre une plateforme unique pour soutenir 
                                    l'entrepreneuriat africain tout en renforçant notre positionnement 
                                    sur le marché. Une collaboration gagnant-gagnant."
                                </p>
                            </div>
                            <div class="story-author">
                                <img src="https://via.placeholder.com/80x80/28a745/ffffff?text=BW" alt="Bank West" class="author-logo">
                                <div class="author-info">
                                    <div class="author-name">Amadou Diallo</div>
                                    <div class="author-title">CEO - West Africa Bank</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Impact Metrics -->
            <section class="impact-metrics mb-5">
                <div class="metrics-wrapper">
                    <div class="metrics-header text-center mb-5">
                        <h2 class="metrics-title">L'Impact de Nos Sponsors</h2>
                        <p class="metrics-subtitle">Des résultats mesurables pour l'écosystème entrepreneurial</p>
                    </div>
                    
                    <div class="row g-4">
                        <div class="col-lg-3 col-md-6">
                            <div class="metric-card">
                                <div class="metric-icon">
                                    <i class="fas fa-users"></i>
                                </div>
                                <div class="metric-number">500+</div>
                                <div class="metric-label">Entrepreneurs soutenus</div>
                            </div>
                        </div>
                        
                        <div class="col-lg-3 col-md-6">
                            <div class="metric-card">
                                <div class="metric-icon">
                                    <i class="fas fa-building"></i>
                                </div>
                                <div class="metric-number">150+</div>
                                <div class="metric-label">Entreprises mises en avant</div>
                            </div>
                        </div>
                        
                        <div class="col-lg-3 col-md-6">
                            <div class="metric-card">
                                <div class="metric-icon">
                                    <i class="fas fa-handshake"></i>
                                </div>
                                <div class="metric-number">75+</div>
                                <div class="metric-label">Partenariats créés</div>
                            </div>
                        </div>
                        
                        <div class="col-lg-3 col-md-6">
                            <div class="metric-card">
                                <div class="metric-icon">
                                    <i class="fas fa-chart-line"></i>
                                </div>
                                <div class="metric-number">25M€</div>
                                <div class="metric-label">Financements facilités</div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Contact Form -->
            <section class="sponsor-contact" id="contact">
                <div class="contact-wrapper">
                    <div class="row">
                        <div class="col-lg-8 mx-auto">
                            <div class="contact-header text-center mb-5">
                                <h2 class="contact-title">Rejoignez Nos Sponsors</h2>
                                <p class="contact-subtitle">
                                    Discutons ensemble de votre engagement pour l'excellence africaine
                                </p>
                            </div>
                            
                            <form class="sponsor-form">
                                @csrf
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="company_name">Nom de l'entreprise *</label>
                                            <input type="text" id="company_name" name="company_name" class="form-control" required>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="contact_name">Nom du contact *</label>
                                            <input type="text" id="contact_name" name="contact_name" class="form-control" required>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">Email *</label>
                                            <input type="email" id="email" name="email" class="form-control" required>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="phone">Téléphone</label>
                                            <input type="tel" id="phone" name="phone" class="form-control">
                                        </div>
                                    </div>
                                    
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="package">Package d'intérêt</label>
                                            <select id="package" name="package" class="form-control">
                                                <option value="">Sélectionnez un package</option>
                                                <option value="bronze">Bronze - 2 500€/an</option>
                                                <option value="silver">Argent - 5 000€/an</option>
                                                <option value="gold">Or - 10 000€/an</option>
                                                <option value="custom">Package sur mesure</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="message">Message</label>
                                            <textarea id="message" name="message" rows="5" class="form-control" 
                                                      placeholder="Parlez-nous de vos objectifs et de votre vision du sponsoring..."></textarea>
                                        </div>
                                    </div>
                                    
                                    <div class="col-12 text-center">
                                        <button type="submit" class="btn btn-primary btn-lg">
                                            <i class="fas fa-paper-plane me-2"></i>Envoyer ma demande
                                        </button>
                                    </div>
                                </div>
                            </form>
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

.hero-benefits {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.benefit-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-weight: 500;
}

.why-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 1rem;
}

.why-subtitle {
    font-size: 1.1rem;
    color: var(--bs-gray-600);
}

.why-card {
    background: white;
    padding: 2.5rem;
    border-radius: 1.5rem;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    text-align: center;
    height: 100%;
    transition: transform 0.3s ease;
}

.why-card:hover {
    transform: translateY(-10px);
}

.why-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    font-size: 2rem;
}

.why-card h3 {
    font-size: 1.5rem;
    font-weight: 600;
    margin-bottom: 1rem;
    color: var(--bs-dark);
}

.why-card p {
    color: var(--bs-gray-600);
    line-height: 1.6;
}

.packages-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 1rem;
}

.packages-subtitle {
    font-size: 1.1rem;
    color: var(--bs-gray-600);
}

.package-card {
    background: white;
    border-radius: 1.5rem;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    overflow: hidden;
    position: relative;
    height: 100%;
    transition: transform 0.3s ease;
}

.package-card:hover {
    transform: translateY(-5px);
}

.package-card.featured {
    border: 3px solid var(--bs-primary);
    transform: scale(1.05);
}

.package-card.premium {
    border: 3px solid #ffc107;
}

.package-badge {
    position: absolute;
    top: 20px;
    right: -30px;
    background: var(--bs-primary);
    color: white;
    padding: 0.5rem 2rem;
    transform: rotate(45deg);
    font-size: 0.8rem;
    font-weight: 600;
}

.package-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 2rem;
    text-align: center;
}

.package-card.premium .package-header {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
}

.package-name {
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 1rem;
}

.package-price {
    font-size: 2.5rem;
    font-weight: 700;
}

.package-price span {
    font-size: 1rem;
    opacity: 0.8;
}

.package-features {
    padding: 2rem;
}

.package-features ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.package-features li {
    padding: 0.75rem 0;
    border-bottom: 1px solid #f1f3f4;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.package-features li:last-child {
    border-bottom: none;
}

.package-features i {
    color: var(--bs-success);
    font-size: 0.9rem;
}

.package-cta {
    padding: 0 2rem 2rem;
}

.package-cta .btn {
    width: 100%;
    padding: 0.75rem;
    font-weight: 600;
}

.story-card {
    background: white;
    padding: 2.5rem;
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
    font-size: 1.1rem;
    margin: 0;
    color: var(--bs-gray-700);
}

.story-author {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.author-logo {
    width: 60px;
    height: 60px;
    border-radius: 50%;
}

.author-name {
    font-weight: 600;
    margin-bottom: 0.25rem;
    font-size: 1.1rem;
}

.author-title {
    font-size: 0.9rem;
    color: var(--bs-gray-600);
}

.impact-metrics {
    background: #f8f9fa;
    padding: 4rem 0;
    border-radius: 2rem;
}

.metrics-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 1rem;
}

.metrics-subtitle {
    font-size: 1.1rem;
    color: var(--bs-gray-600);
}

.metric-card {
    background: white;
    padding: 2rem;
    border-radius: 1.5rem;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    text-align: center;
    transition: transform 0.3s ease;
}

.metric-card:hover {
    transform: translateY(-5px);
}

.metric-icon {
    width: 60px;
    height: 60px;
    background: var(--bs-primary);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    font-size: 1.5rem;
}

.metric-number {
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--bs-primary);
    margin-bottom: 0.5rem;
}

.metric-label {
    color: var(--bs-gray-600);
    font-weight: 500;
}

.sponsor-contact {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 4rem 0;
    border-radius: 2rem;
    margin-top: 4rem;
}

.contact-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: white;
    margin-bottom: 1rem;
}

.contact-subtitle {
    font-size: 1.1rem;
    color: rgba(255,255,255,0.9);
}

.sponsor-form {
    background: white;
    padding: 3rem;
    border-radius: 1.5rem;
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: var(--bs-dark);
}

.form-control {
    border: 2px solid #e9ecef;
    border-radius: 0.75rem;
    padding: 0.75rem 1rem;
    font-size: 1rem;
    transition: border-color 0.3s ease;
}

.form-control:focus {
    border-color: var(--bs-primary);
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
}

@media (max-width: 768px) {
    .hero-title,
    .why-title,
    .packages-title,
    .metrics-title,
    .contact-title {
        font-size: 2rem;
    }
    
    .hero-benefits {
        margin-top: 2rem;
    }
    
    .package-card.featured {
        transform: none;
    }
    
    .why-card,
    .package-card,
    .story-card,
    .metric-card {
        padding: 2rem;
    }
    
    .sponsor-form {
        padding: 2rem;
    }
}
</style>
@endpush
