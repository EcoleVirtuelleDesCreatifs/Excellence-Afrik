@extends('layouts.app')

@section('title', 'Ligne Éditoriale - Excellence Afrik')
@section('meta_description', 'Découvrez la ligne éditoriale d\'Excellence Afrik, notre vision et notre approche unique du journalisme économique africain')

@section('page_title', 'Notre Ligne Éditoriale')
@section('page_subtitle', 'Une approche unique du journalisme économique africain')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-10">

            <!-- Editorial Vision -->
            <section class="editorial-vision mb-5">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="vision-content">
                            <h1 class="vision-title">Notre Vision Éditoriale</h1>
                            <p class="vision-description">
                                Excellence Afrik adopte une approche journalistique unique, centrée sur l'humain 
                                et l'authenticité. Nous croyons que derrière chaque entreprise, il y a une histoire 
                                personnelle qui mérite d'être racontée.
                            </p>
                            <div class="vision-principles">
                                <div class="principle-item">
                                    <i class="fas fa-heart text-danger"></i>
                                    <span>Journalisme humain et incarné</span>
                                </div>
                                <div class="principle-item">
                                    <i class="fas fa-search text-primary"></i>
                                    <span>Enquêtes approfondies sur le terrain</span>
                                </div>
                                <div class="principle-item">
                                    <i class="fas fa-balance-scale text-success"></i>
                                    <span>Objectivité et transparence</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="vision-image">
                            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=600&h=400&fit=crop" 
                                 alt="Vision éditoriale" class="img-fluid rounded-3">
                        </div>
                    </div>
                </div>
            </section>

            <!-- Editorial Formats -->
            <section class="editorial-formats mb-5">
                <div class="formats-header text-center mb-5">
                    <h2 class="formats-title">Nos Formats Éditoriaux</h2>
                    <p class="formats-subtitle">Une diversité de contenus pour raconter l'Afrique économique</p>
                </div>
                
                <div class="row g-4">
                    <div class="col-lg-4">
                        <div class="format-card">
                            <div class="format-icon">
                                <i class="fas fa-user-circle"></i>
                            </div>
                            <h3>Portraits d'Entrepreneurs</h3>
                            <p>Des récits humains authentiques qui révèlent l'âme des bâtisseurs africains</p>
                            <ul class="format-features">
                                <li>Interviews approfondies</li>
                                <li>Photographies originales</li>
                                <li>Contexte économique</li>
                                <li>Impact social</li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="col-lg-4">
                        <div class="format-card">
                            <div class="format-icon">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <h3>Analyses Économiques</h3>
                            <p>Des décryptages experts des tendances et enjeux économiques africains</p>
                            <ul class="format-features">
                                <li>Données exclusives</li>
                                <li>Expertise sectorielle</li>
                                <li>Perspectives régionales</li>
                                <li>Prévisions</li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="col-lg-4">
                        <div class="format-card">
                            <div class="format-icon">
                                <i class="fas fa-map-marked-alt"></i>
                            </div>
                            <h3>Reportages Terrain</h3>
                            <p>L'économie africaine vue depuis les zones rurales et périphériques</p>
                            <ul class="format-features">
                                <li>Immersion locale</li>
                                <li>Témoignages directs</li>
                                <li>Réalités du terrain</li>
                                <li>Solutions innovantes</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Editorial Charter -->
            <section class="editorial-charter mb-5">
                <div class="charter-wrapper">
                    <div class="row">
                        <div class="col-lg-8 mx-auto">
                            <div class="charter-content">
                                <h2 class="charter-title">Notre Charte Éditoriale</h2>
                                
                                <div class="charter-section">
                                    <h3><i class="fas fa-bullseye text-primary"></i> Objectifs</h3>
                                    <ul>
                                        <li>Révéler l'excellence silencieuse des entrepreneurs africains</li>
                                        <li>Documenter les innovations économiques du continent</li>
                                        <li>Connecter les écosystèmes entrepreneuriaux africains</li>
                                        <li>Inspirer la prochaine génération d'entrepreneurs</li>
                                    </ul>
                                </div>
                                
                                <div class="charter-section">
                                    <h3><i class="fas fa-compass text-success"></i> Valeurs</h3>
                                    <ul>
                                        <li><strong>Authenticité :</strong> Nous privilégions la vérité des témoignages</li>
                                        <li><strong>Inclusivité :</strong> Toutes les voix méritent d'être entendues</li>
                                        <li><strong>Excellence :</strong> Qualité journalistique irréprochable</li>
                                        <li><strong>Impact :</strong> Créer du lien et de la valeur</li>
                                    </ul>
                                </div>
                                
                                <div class="charter-section">
                                    <h3><i class="fas fa-shield-alt text-warning"></i> Déontologie</h3>
                                    <ul>
                                        <li>Vérification systématique des sources</li>
                                        <li>Respect de la confidentialité</li>
                                        <li>Indépendance éditoriale totale</li>
                                        <li>Transparence sur nos méthodes</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Editorial Team -->
            <section class="editorial-team mb-5">
                <div class="team-header text-center mb-5">
                    <h2 class="team-title">Notre Équipe Éditoriale</h2>
                    <p class="team-subtitle">Des journalistes passionnés par l'Afrique économique</p>
                </div>
                
                <div class="row g-4">
                    <div class="col-lg-4">
                        <div class="team-member">
                            <div class="member-image">
                                <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=300&h=300&fit=crop&crop=face" 
                                     alt="Deza Auguste César" class="img-fluid">
                            </div>
                            <div class="member-info">
                                <h4>Deza Auguste César</h4>
                                <p class="member-role">Directeur de Publication</p>
                                <p class="member-description">
                                    Communicant panafricain et expert en marketing stratégique, 
                                    fondateur d'Excellence Afrik.
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-4">
                        <div class="team-member">
                            <div class="member-image">
                                <img src="https://images.unsplash.com/photo-1494790108755-2616c2d1e0e0?w=300&h=300&fit=crop&crop=face" 
                                     alt="Rédactrice en chef" class="img-fluid">
                            </div>
                            <div class="member-info">
                                <h4>Aminata Traoré</h4>
                                <p class="member-role">Rédactrice en Chef</p>
                                <p class="member-description">
                                    Journaliste économique avec 12 ans d'expérience 
                                    dans la presse africaine.
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-4">
                        <div class="team-member">
                            <div class="member-image">
                                <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=300&h=300&fit=crop&crop=face" 
                                     alt="Chef de rubrique" class="img-fluid">
                            </div>
                            <div class="member-info">
                                <h4>Kwame Asante</h4>
                                <p class="member-role">Chef de Rubrique Startups</p>
                                <p class="member-description">
                                    Spécialiste de l'écosystème entrepreneurial africain 
                                    et des nouvelles technologies.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Contact Editorial -->
            <section class="editorial-contact">
                <div class="contact-card">
                    <div class="row align-items-center">
                        <div class="col-lg-8">
                            <h3 class="contact-title">Vous avez une histoire à nous raconter ?</h3>
                            <p class="contact-description">
                                Notre équipe éditoriale est toujours à la recherche de nouvelles histoires 
                                d'entrepreneurs africains. Contactez-nous pour partager votre expérience.
                            </p>
                        </div>
                        <div class="col-lg-4 text-lg-end">
                            <a href="{{ route('pages.contact') }}" class="btn btn-primary btn-lg">
                                <i class="fas fa-envelope me-2"></i>Nous contacter
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
.vision-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 1.5rem;
    color: var(--bs-primary);
}

.vision-description {
    font-size: 1.1rem;
    line-height: 1.6;
    color: var(--bs-gray-600);
    margin-bottom: 2rem;
}

.vision-principles {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.principle-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-weight: 500;
}

.formats-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 1rem;
}

.formats-subtitle {
    font-size: 1.1rem;
    color: var(--bs-gray-600);
}

.format-card {
    background: white;
    padding: 2.5rem;
    border-radius: 1.5rem;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    text-align: center;
    height: 100%;
    transition: transform 0.3s ease;
}

.format-card:hover {
    transform: translateY(-10px);
}

.format-icon {
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

.format-card h3 {
    font-size: 1.5rem;
    font-weight: 600;
    margin-bottom: 1rem;
    color: var(--bs-dark);
}

.format-card p {
    color: var(--bs-gray-600);
    margin-bottom: 1.5rem;
    line-height: 1.6;
}

.format-features {
    list-style: none;
    padding: 0;
    text-align: left;
}

.format-features li {
    padding: 0.5rem 0;
    border-bottom: 1px solid #f1f3f4;
    position: relative;
    padding-left: 1.5rem;
}

.format-features li:before {
    content: "✓";
    color: var(--bs-success);
    font-weight: bold;
    position: absolute;
    left: 0;
}

.editorial-charter {
    background: #f8f9fa;
    padding: 4rem 0;
    border-radius: 2rem;
}

.charter-title {
    font-size: 2.5rem;
    font-weight: 700;
    text-align: center;
    margin-bottom: 3rem;
    color: var(--bs-dark);
}

.charter-section {
    background: white;
    padding: 2rem;
    border-radius: 1rem;
    margin-bottom: 2rem;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
}

.charter-section h3 {
    font-size: 1.3rem;
    font-weight: 600;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.charter-section ul {
    margin: 0;
    padding-left: 1.5rem;
}

.charter-section li {
    margin-bottom: 0.75rem;
    line-height: 1.6;
}

.team-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 1rem;
}

.team-subtitle {
    font-size: 1.1rem;
    color: var(--bs-gray-600);
}

.team-member {
    background: white;
    padding: 2rem;
    border-radius: 1.5rem;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    text-align: center;
    transition: transform 0.3s ease;
}

.team-member:hover {
    transform: translateY(-5px);
}

.member-image {
    margin-bottom: 1.5rem;
}

.member-image img {
    width: 150px;
    height: 150px;
    object-fit: cover;
    border-radius: 50%;
    border: 4px solid #f8f9fa;
}

.member-info h4 {
    font-size: 1.3rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: var(--bs-dark);
}

.member-role {
    color: var(--bs-primary);
    font-weight: 600;
    margin-bottom: 1rem;
}

.member-description {
    color: var(--bs-gray-600);
    line-height: 1.6;
    font-size: 0.95rem;
}

.editorial-contact {
    margin-top: 4rem;
}

.contact-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 3rem;
    border-radius: 2rem;
    color: white;
}

.contact-title {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 1rem;
    color: white;
}

.contact-description {
    font-size: 1.1rem;
    line-height: 1.6;
    opacity: 0.9;
    margin: 0;
}

@media (max-width: 768px) {
    .vision-title,
    .formats-title,
    .charter-title,
    .team-title {
        font-size: 2rem;
    }
    
    .vision-principles {
        margin-top: 2rem;
    }
    
    .format-card,
    .team-member {
        padding: 2rem;
    }
    
    .contact-card {
        text-align: center;
        padding: 2rem;
    }
    
    .contact-title {
        font-size: 1.5rem;
    }
}
</style>
@endpush
