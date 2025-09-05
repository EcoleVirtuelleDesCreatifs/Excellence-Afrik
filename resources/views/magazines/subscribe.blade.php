@extends('layouts.app')

@section('title', 'Abonnement Magazine - Excellence Afrik')
@section('meta_description', 'Abonnez-vous au magazine Excellence Afrik et recevez tous nos numéros en exclusivité avec des contenus premium')

@section('page_title', 'Abonnement Magazine')
@section('page_subtitle', 'Accédez à tous nos contenus premium et recevez nos numéros en avant-première')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-10">

            <!-- Hero Section -->
            <section class="subscription-hero mb-5">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="hero-content">
                            <h1 class="hero-title">Abonnez-vous au Magazine <span class="text-primary">Excellence Afrik</span></h1>
                            <p class="hero-description">
                                Rejoignez plus de 50 000 lecteurs qui font confiance à Excellence Afrik pour 
                                rester informés des dernières tendances économiques et entrepreneuriales en Afrique.
                            </p>
                            <div class="hero-benefits">
                                <div class="benefit-item">
                                    <i class="fas fa-check-circle text-success"></i>
                                    <span>Accès à tous les numéros dès leur publication</span>
                                </div>
                                <div class="benefit-item">
                                    <i class="fas fa-check-circle text-success"></i>
                                    <span>Contenus exclusifs et analyses approfondies</span>
                                </div>
                                <div class="benefit-item">
                                    <i class="fas fa-check-circle text-success"></i>
                                    <span>Téléchargement gratuit des versions PDF</span>
                                </div>
                                <div class="benefit-item">
                                    <i class="fas fa-check-circle text-success"></i>
                                    <span>Newsletter hebdomadaire premium</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="hero-image">
                            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=600&h=400&fit=crop" 
                                 alt="Magazine Excellence Afrik" class="img-fluid rounded-3 shadow-lg">
                        </div>
                    </div>
                </div>
            </section>

            <!-- Subscription Plans -->
            <section class="subscription-plans mb-5">
                <div class="plans-header text-center mb-5">
                    <h2 class="plans-title">Choisissez votre formule</h2>
                    <p class="plans-subtitle">Des options flexibles adaptées à vos besoins</p>
                </div>

                <div class="row g-4">
                    <!-- Free Plan -->
                    <div class="col-lg-4">
                        <div class="plan-card">
                            <div class="plan-header">
                                <div class="plan-icon">
                                    <i class="fas fa-book text-secondary"></i>
                                </div>
                                <h3 class="plan-name">Gratuit</h3>
                                <div class="plan-price">
                                    <span class="price-amount">0€</span>
                                    <span class="price-period">/mois</span>
                                </div>
                            </div>
                            <div class="plan-features">
                                <ul>
                                    <li><i class="fas fa-check text-success"></i> Accès aux 3 derniers numéros</li>
                                    <li><i class="fas fa-check text-success"></i> Articles sélectionnés</li>
                                    <li><i class="fas fa-check text-success"></i> Newsletter mensuelle</li>
                                    <li><i class="fas fa-times text-muted"></i> Archives complètes</li>
                                    <li><i class="fas fa-times text-muted"></i> Contenus premium</li>
                                    <li><i class="fas fa-times text-muted"></i> Téléchargement PDF</li>
                                </ul>
                            </div>
                            <div class="plan-action">
                                <button class="btn btn-outline-secondary w-100">Inscription gratuite</button>
                            </div>
                        </div>
                    </div>

                    <!-- Premium Plan -->
                    <div class="col-lg-4">
                        <div class="plan-card featured">
                            <div class="plan-badge">Populaire</div>
                            <div class="plan-header">
                                <div class="plan-icon">
                                    <i class="fas fa-crown text-warning"></i>
                                </div>
                                <h3 class="plan-name">Premium</h3>
                                <div class="plan-price">
                                    <span class="price-amount">9€</span>
                                    <span class="price-period">/mois</span>
                                </div>
                                <div class="plan-savings">Économisez 20% avec l'abonnement annuel</div>
                            </div>
                            <div class="plan-features">
                                <ul>
                                    <li><i class="fas fa-check text-success"></i> Accès illimité à tous les numéros</li>
                                    <li><i class="fas fa-check text-success"></i> Archives complètes depuis 2022</li>
                                    <li><i class="fas fa-check text-success"></i> Contenus exclusifs premium</li>
                                    <li><i class="fas fa-check text-success"></i> Téléchargement PDF illimité</li>
                                    <li><i class="fas fa-check text-success"></i> Newsletter hebdomadaire</li>
                                    <li><i class="fas fa-check text-success"></i> Accès prioritaire aux événements</li>
                                </ul>
                            </div>
                            <div class="plan-action">
                                <button class="btn btn-primary w-100">Choisir Premium</button>
                            </div>
                        </div>
                    </div>

                    <!-- Enterprise Plan -->
                    <div class="col-lg-4">
                        <div class="plan-card">
                            <div class="plan-header">
                                <div class="plan-icon">
                                    <i class="fas fa-building text-info"></i>
                                </div>
                                <h3 class="plan-name">Entreprise</h3>
                                <div class="plan-price">
                                    <span class="price-amount">49€</span>
                                    <span class="price-period">/mois</span>
                                </div>
                            </div>
                            <div class="plan-features">
                                <ul>
                                    <li><i class="fas fa-check text-success"></i> Tout du plan Premium</li>
                                    <li><i class="fas fa-check text-success"></i> Licences multiples (jusqu'à 50)</li>
                                    <li><i class="fas fa-check text-success"></i> Rapports personnalisés</li>
                                    <li><i class="fas fa-check text-success"></i> Support prioritaire</li>
                                    <li><i class="fas fa-check text-success"></i> Sessions de formation</li>
                                    <li><i class="fas fa-check text-success"></i> Accès API</li>
                                </ul>
                            </div>
                            <div class="plan-action">
                                <button class="btn btn-outline-primary w-100">Contactez-nous</button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Testimonials -->
            <section class="testimonials mb-5">
                <div class="testimonials-header text-center mb-5">
                    <h2>Ce que disent nos abonnés</h2>
                </div>
                <div class="row g-4">
                    <div class="col-lg-4">
                        <div class="testimonial-card">
                            <div class="testimonial-content">
                                <p>"Excellence Afrik est devenu ma source de référence pour comprendre les enjeux économiques africains. Les analyses sont toujours pertinentes et bien documentées."</p>
                            </div>
                            <div class="testimonial-author">
                                <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=60&h=60&fit=crop&crop=face" 
                                     alt="Amadou Diallo" class="author-avatar">
                                <div class="author-info">
                                    <div class="author-name">Amadou Diallo</div>
                                    <div class="author-title">CEO, TechAfrik Solutions</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="testimonial-card">
                            <div class="testimonial-content">
                                <p>"Les portraits d'entrepreneurs m'inspirent énormément. C'est formidable de voir des success stories africaines mises en avant avec autant de qualité."</p>
                            </div>
                            <div class="testimonial-author">
                                <img src="https://images.unsplash.com/photo-1494790108755-2616c2d1e0e0?w=60&h=60&fit=crop&crop=face" 
                                     alt="Aïsha Koné" class="author-avatar">
                                <div class="author-info">
                                    <div class="author-name">Aïsha Koné</div>
                                    <div class="author-title">Fondatrice, GreenHarvest Mali</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="testimonial-card">
                            <div class="testimonial-content">
                                <p>"Indispensable pour rester au courant des tendances d'investissement en Afrique. La qualité éditoriale est exceptionnelle."</p>
                            </div>
                            <div class="testimonial-author">
                                <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=60&h=60&fit=crop&crop=face" 
                                     alt="Joseph Mbeki" class="author-avatar">
                                <div class="author-info">
                                    <div class="author-name">Joseph Mbeki</div>
                                    <div class="author-title">Directeur, AfriCapital Ventures</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- FAQ -->
            <section class="faq mb-5">
                <div class="faq-header text-center mb-5">
                    <h2>Questions fréquentes</h2>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="accordion" id="faqAccordion">
                            <div class="accordion-item">
                                <h3 class="accordion-header">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                        Puis-je annuler mon abonnement à tout moment ?
                                    </button>
                                </h3>
                                <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        Oui, vous pouvez annuler votre abonnement à tout moment depuis votre espace personnel. L'annulation prend effet à la fin de votre période de facturation en cours.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h3 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                        Les anciens numéros sont-ils inclus dans l'abonnement ?
                                    </button>
                                </h3>
                                <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        Avec l'abonnement Premium, vous avez accès à toutes nos archives depuis 2022. L'abonnement gratuit donne accès aux 3 derniers numéros uniquement.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h3 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                        Y a-t-il une période d'essai gratuite ?
                                    </button>
                                </h3>
                                <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        Oui, nous offrons 14 jours d'essai gratuit pour l'abonnement Premium. Vous pouvez annuler à tout moment pendant cette période sans frais.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h3 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                                        Quels sont les moyens de paiement acceptés ?
                                    </button>
                                </h3>
                                <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        Nous acceptons les cartes de crédit (Visa, Mastercard), PayPal, et les virements bancaires. Pour les entreprises, nous proposons également la facturation.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- CTA Section -->
            <section class="subscription-cta">
                <div class="cta-card">
                    <div class="row align-items-center">
                        <div class="col-lg-8">
                            <h3 class="cta-title">Prêt à rejoindre notre communauté ?</h3>
                            <p class="cta-description">
                                Commencez votre essai gratuit de 14 jours et découvrez pourquoi Excellence Afrik 
                                est la référence en matière d'information économique africaine.
                            </p>
                        </div>
                        <div class="col-lg-4 text-lg-end">
                            <button class="btn btn-primary btn-lg">
                                <i class="fas fa-rocket me-2"></i>Commencer l'essai gratuit
                            </button>
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
.subscription-hero {
    padding: 3rem 0;
}

.hero-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 1.5rem;
    line-height: 1.2;
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
}

.benefit-item i {
    flex-shrink: 0;
    font-size: 1.2rem;
}

.plans-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 1rem;
}

.plans-subtitle {
    font-size: 1.1rem;
    color: var(--bs-gray-600);
}

.plan-card {
    background: white;
    border: 2px solid #f8f9fa;
    border-radius: 1.5rem;
    padding: 2rem;
    text-align: center;
    transition: all 0.3s ease;
    height: 100%;
    position: relative;
}

.plan-card:hover {
    border-color: var(--bs-primary);
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.1);
}

.plan-card.featured {
    border-color: var(--bs-primary);
    transform: scale(1.05);
    box-shadow: 0 15px 35px rgba(0,0,0,0.15);
}

.plan-badge {
    position: absolute;
    top: -10px;
    left: 50%;
    transform: translateX(-50%);
    background: var(--bs-primary);
    color: white;
    padding: 0.5rem 1.5rem;
    border-radius: 1rem;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
}

.plan-icon {
    margin-bottom: 1rem;
}

.plan-icon i {
    font-size: 3rem;
}

.plan-name {
    font-size: 1.5rem;
    font-weight: 600;
    margin-bottom: 1rem;
}

.plan-price {
    margin-bottom: 1rem;
}

.price-amount {
    font-size: 3rem;
    font-weight: 700;
    color: var(--bs-primary);
}

.price-period {
    font-size: 1rem;
    color: var(--bs-gray-600);
}

.plan-savings {
    font-size: 0.9rem;
    color: var(--bs-success);
    font-weight: 500;
    margin-bottom: 2rem;
}

.plan-features {
    margin-bottom: 2rem;
}

.plan-features ul {
    list-style: none;
    padding: 0;
    text-align: left;
}

.plan-features li {
    padding: 0.5rem 0;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.testimonials {
    background: #f8f9fa;
    border-radius: 1.5rem;
    padding: 3rem 2rem;
}

.testimonial-card {
    background: white;
    border-radius: 1rem;
    padding: 2rem;
    height: 100%;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
}

.testimonial-content {
    margin-bottom: 1.5rem;
}

.testimonial-content p {
    font-style: italic;
    line-height: 1.6;
    margin: 0;
}

.testimonial-author {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.author-avatar {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    object-fit: cover;
}

.author-name {
    font-weight: 600;
    margin-bottom: 0.25rem;
}

.author-title {
    font-size: 0.9rem;
    color: var(--bs-gray-600);
}

.faq .accordion-item {
    border: none;
    margin-bottom: 1rem;
}

.faq .accordion-button {
    background: #f8f9fa;
    border: none;
    border-radius: 0.5rem;
    font-weight: 600;
    padding: 1.5rem;
}

.faq .accordion-button:not(.collapsed) {
    background: var(--bs-primary);
    color: white;
}

.faq .accordion-body {
    padding: 1.5rem;
    background: white;
    border-radius: 0 0 0.5rem 0.5rem;
}

.subscription-cta {
    margin-top: 3rem;
}

.cta-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 1.5rem;
    padding: 3rem;
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
    .hero-title {
        font-size: 2rem;
    }
    
    .plans-title {
        font-size: 2rem;
    }
    
    .plan-card.featured {
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
