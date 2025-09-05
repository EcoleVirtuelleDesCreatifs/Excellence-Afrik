<!-- Newsletter CTA for Magazines -->
<section class="magazine-newsletter-cta">
    <div class="newsletter-cta-card">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="newsletter-cta-content">
                    <div class="newsletter-icon">
                        <i class="fas fa-magazine fa-3x text-primary"></i>
                    </div>
                    <h3 class="newsletter-cta-title">Ne manquez aucun numéro !</h3>
                    <p class="newsletter-cta-description">
                        Recevez une notification dès la sortie de chaque nouveau numéro de notre magazine 
                        et accédez en exclusivité aux contenus premium.
                    </p>
                    <div class="newsletter-benefits">
                        <div class="benefit-item">
                            <i class="fas fa-check-circle text-success"></i>
                            <span>Accès prioritaire aux nouveaux numéros</span>
                        </div>
                        <div class="benefit-item">
                            <i class="fas fa-check-circle text-success"></i>
                            <span>Contenus exclusifs et analyses approfondies</span>
                        </div>
                        <div class="benefit-item">
                            <i class="fas fa-check-circle text-success"></i>
                            <span>Téléchargement gratuit des versions PDF</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="newsletter-form-wrapper">
                    <form class="newsletter-form" action="{{ route('newsletter.subscribe') }}" method="POST">
                        @csrf
                        <input type="hidden" name="source" value="magazines">
                        <div class="form-group mb-3">
                            <label for="email" class="form-label">Votre adresse e-mail</label>
                            <input type="email" class="form-control form-control-lg" id="email" name="email" 
                                   placeholder="exemple@email.com" required>
                        </div>
                        <div class="form-group mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="premium" name="premium" value="1">
                                <label class="form-check-label" for="premium">
                                    <small>Je souhaite recevoir les contenus premium</small>
                                </label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg w-100">
                            <i class="fas fa-envelope me-2"></i>S'abonner maintenant
                        </button>
                        <small class="text-muted d-block text-center mt-2">
                            <i class="fas fa-shield-alt me-1"></i>
                            Vos données sont protégées
                        </small>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.magazine-newsletter-cta {
    margin: 4rem 0;
}

.newsletter-cta-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 1.5rem;
    padding: 3rem;
    color: white;
    position: relative;
    overflow: hidden;
}

.newsletter-cta-card::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 100%;
    height: 100%;
    background: rgba(255,255,255,0.1);
    border-radius: 50%;
    z-index: 0;
}

.newsletter-cta-content,
.newsletter-form-wrapper {
    position: relative;
    z-index: 1;
}

.newsletter-icon {
    margin-bottom: 1.5rem;
}

.newsletter-cta-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 1rem;
    color: white;
}

.newsletter-cta-description {
    font-size: 1.1rem;
    margin-bottom: 2rem;
    opacity: 0.9;
    line-height: 1.6;
}

.newsletter-benefits {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.benefit-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.benefit-item i {
    flex-shrink: 0;
}

.newsletter-form-wrapper {
    background: rgba(255,255,255,0.15);
    backdrop-filter: blur(10px);
    border-radius: 1rem;
    padding: 2rem;
    border: 1px solid rgba(255,255,255,0.2);
}

.newsletter-form .form-control {
    background: rgba(255,255,255,0.9);
    border: none;
    border-radius: 0.5rem;
}

.newsletter-form .form-control:focus {
    background: white;
    box-shadow: 0 0 0 0.2rem rgba(255,255,255,0.25);
}

.newsletter-form .form-label {
    color: white;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.newsletter-form .form-check-label {
    color: rgba(255,255,255,0.9);
}

.newsletter-form .btn-primary {
    background: #28a745;
    border: none;
    border-radius: 0.5rem;
    font-weight: 600;
    padding: 0.75rem 1.5rem;
    transition: all 0.3s ease;
}

.newsletter-form .btn-primary:hover {
    background: #218838;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

@media (max-width: 991px) {
    .newsletter-cta-card {
        padding: 2rem;
        text-align: center;
    }
    
    .newsletter-cta-title {
        font-size: 2rem;
    }
    
    .newsletter-form-wrapper {
        margin-top: 2rem;
    }
}
</style>
