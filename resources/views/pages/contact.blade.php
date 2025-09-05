@extends('layouts.app')

@section('title', 'Contact - Excellence Afrik')
@section('meta_description', 'Contactez l\'équipe d\'Excellence Afrik pour vos questions, partenariats ou propositions de collaboration')

@section('page_title', 'Contactez-nous')
@section('page_subtitle', 'Nous sommes à votre écoute pour toute question ou collaboration')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-10">
            
            <!-- Contact Hero -->
            <section class="contact-hero mb-5">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="contact-content">
                            <h1 class="contact-title">Parlons de votre projet</h1>
                            <p class="contact-description">
                                Excellence Afrik est toujours à la recherche de nouvelles histoires inspirantes 
                                d'entrepreneurs africains. Partagez votre expérience ou proposez-nous un sujet.
                            </p>
                            <div class="contact-stats">
                                <div class="stat-item">
                                    <i class="fas fa-clock text-primary"></i>
                                    <span>Réponse sous 24h</span>
                                </div>
                                <div class="stat-item">
                                    <i class="fas fa-globe-africa text-success"></i>
                                    <span>Couverture panafricaine</span>
                                </div>
                                <div class="stat-item">
                                    <i class="fas fa-handshake text-warning"></i>
                                    <span>Partenariats ouverts</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="contact-image">
                            <img src="https://images.unsplash.com/photo-1560472354-b33ff0c44a43?w=600&h=400&fit=crop" 
                                 alt="Contact Excellence Afrik" class="img-fluid rounded-3">
                        </div>
                    </div>
                </div>
            </section>

            <!-- Contact Form & Info -->
            <section class="contact-section">
                <div class="row g-5">
                    <div class="col-lg-8">
                        <div class="contact-form-wrapper">
                            <h2 class="form-title">Envoyez-nous un message</h2>
                            <form class="contact-form" action="#" method="POST">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="name" class="form-label">Nom complet *</label>
                                        <input type="text" class="form-control" id="name" name="name" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="email" class="form-label">Email *</label>
                                        <input type="email" class="form-control" id="email" name="email" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="phone" class="form-label">Téléphone</label>
                                        <input type="tel" class="form-control" id="phone" name="phone">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="subject" class="form-label">Sujet *</label>
                                        <select class="form-select" id="subject" name="subject" required>
                                            <option value="">Choisissez un sujet</option>
                                            <option value="portrait">Proposer un portrait d'entrepreneur</option>
                                            <option value="partenariat">Partenariat média</option>
                                            <option value="publicite">Publicité et sponsoring</option>
                                            <option value="presse">Demande de presse</option>
                                            <option value="autre">Autre</option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <label for="message" class="form-label">Message *</label>
                                        <textarea class="form-control" id="message" name="message" rows="6" 
                                                  placeholder="Décrivez votre projet, votre demande ou votre histoire..." required></textarea>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="newsletter" name="newsletter">
                                            <label class="form-check-label" for="newsletter">
                                                Je souhaite recevoir la newsletter d'Excellence Afrik
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary btn-lg">
                                            <i class="fas fa-paper-plane me-2"></i>Envoyer le message
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    <div class="col-lg-4">
                        <div class="contact-info">
                            <h3 class="info-title">Informations de contact</h3>
                            
                            <div class="info-item">
                                <div class="info-icon">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div class="info-content">
                                    <h4>Email</h4>
                                    <p>contact@excellenceafrik.com</p>
                                    <p>redaction@excellenceafrik.com</p>
                                </div>
                            </div>
                            
                            <div class="info-item">
                                <div class="info-icon">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <div class="info-content">
                                    <h4>Téléphone</h4>
                                    <p>+33 1 23 45 67 89</p>
                                    <p>+971 4 123 4567 (UAE)</p>
                                </div>
                            </div>
                            
                            <div class="info-item">
                                <div class="info-icon">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div class="info-content">
                                    <h4>Bureaux</h4>
                                    <p>Paris, France</p>
                                    <p>Dubaï, UAE</p>
                                    <p>Abidjan, Côte d'Ivoire</p>
                                </div>
                            </div>
                            
                            <div class="social-links">
                                <h4>Suivez-nous</h4>
                                <div class="social-icons">
                                    <a href="#" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
                                    <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                                    <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                                    <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                                </div>
                            </div>
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
.contact-hero {
    padding: 3rem 0;
}

.contact-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 1.5rem;
    color: var(--bs-primary);
}

.contact-description {
    font-size: 1.1rem;
    line-height: 1.6;
    color: var(--bs-gray-600);
    margin-bottom: 2rem;
}

.contact-stats {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.stat-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-weight: 500;
}

.contact-form-wrapper {
    background: white;
    padding: 2.5rem;
    border-radius: 1.5rem;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.form-title {
    font-size: 2rem;
    font-weight: 600;
    margin-bottom: 2rem;
    color: var(--bs-dark);
}

.form-control, .form-select {
    border-radius: 0.5rem;
    border: 2px solid #f1f3f4;
    padding: 0.75rem 1rem;
    transition: border-color 0.3s ease;
}

.form-control:focus, .form-select:focus {
    border-color: var(--bs-primary);
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
}

.contact-info {
    background: #f8f9fa;
    padding: 2.5rem;
    border-radius: 1.5rem;
    height: fit-content;
}

.info-title {
    font-size: 1.5rem;
    font-weight: 600;
    margin-bottom: 2rem;
    color: var(--bs-dark);
}

.info-item {
    display: flex;
    gap: 1rem;
    margin-bottom: 2rem;
    padding-bottom: 2rem;
    border-bottom: 1px solid #dee2e6;
}

.info-item:last-of-type {
    border-bottom: none;
    margin-bottom: 2rem;
}

.info-icon {
    width: 50px;
    height: 50px;
    background: var(--bs-primary);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.info-content h4 {
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: var(--bs-dark);
}

.info-content p {
    margin: 0;
    color: var(--bs-gray-600);
    font-size: 0.95rem;
}

.social-links h4 {
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 1rem;
    color: var(--bs-dark);
}

.social-icons {
    display: flex;
    gap: 1rem;
}

.social-icon {
    width: 40px;
    height: 40px;
    background: var(--bs-primary);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    transition: all 0.3s ease;
}

.social-icon:hover {
    background: var(--bs-dark);
    color: white;
    transform: translateY(-2px);
}

@media (max-width: 768px) {
    .contact-title {
        font-size: 2rem;
    }
    
    .contact-stats {
        margin-top: 2rem;
    }
    
    .contact-form-wrapper,
    .contact-info {
        padding: 2rem;
    }
}
</style>
@endpush
