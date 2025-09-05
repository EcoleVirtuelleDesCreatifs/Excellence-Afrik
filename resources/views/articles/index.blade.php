@extends('layouts.app')

@section('title', 'Articles - Excellence Afrik')
@section('meta_description', 'Découvrez tous nos articles sur l\'entrepreneuriat africain, les success stories et les analyses économiques du continent')

@section('page_title', 'Nos Articles')
@section('page_subtitle', 'L\'actualité entrepreneuriale africaine')

@section('content')
<div class="container my-5">
    <!-- Hero Section -->
    <section class="articles-hero mb-5">
        <div class="row">
            <div class="col-12">
                <div class="hero-content text-center">
                    <h1 class="hero-title">Explorez l'Excellence Africaine</h1>
                    <p class="hero-description">
                        Découvrez les histoires inspirantes des entrepreneurs qui façonnent l'avenir économique de l'Afrique
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Filters -->
    <section class="articles-filters mb-5">
        <div class="row">
            <div class="col-12">
                <div class="filters-wrapper">
                    <div class="row align-items-center">
                        <div class="col-lg-8">
                            <div class="category-filters">
                                <button class="filter-btn active" data-category="all">Tous les articles</button>
                                <button class="filter-btn" data-category="portraits">Portraits</button>
                                <button class="filter-btn" data-category="analyses">Analyses</button>
                                <button class="filter-btn" data-category="startups">Startups</button>
                                <button class="filter-btn" data-category="finance">Finance</button>
                                <button class="filter-btn" data-category="tech">Tech</button>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="search-box">
                                <input type="text" class="form-control" placeholder="Rechercher un article...">
                                <i class="fas fa-search"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Article -->
    <section class="featured-article mb-5">
        <div class="row">
            <div class="col-12">
                <div class="featured-card">
                    <div class="row g-0">
                        <div class="col-lg-6">
                            <div class="featured-image">
                                <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=600&h=400&fit=crop" 
                                     alt="Article vedette" class="img-fluid">
                                <div class="featured-badge">À la Une</div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="featured-content">
                                <div class="article-meta">
                                    <span class="category-tag">Portrait</span>
                                    <span class="date">15 Décembre 2024</span>
                                </div>
                                <h2 class="featured-title">
                                    Aminata Traoré : La révolution fintech qui transforme l'Afrique de l'Ouest
                                </h2>
                                <p class="featured-excerpt">
                                    À 32 ans, cette entrepreneure malienne a créé une solution de paiement mobile 
                                    qui révolutionne les transactions financières dans 8 pays africains...
                                </p>
                                <div class="featured-author">
                                    <img src="https://images.unsplash.com/photo-1494790108755-2616c2d1e0e0?w=50&h=50&fit=crop&crop=face" 
                                         alt="Auteur" class="author-avatar">
                                    <div class="author-info">
                                        <div class="author-name">Sarah Koné</div>
                                        <div class="author-role">Journaliste Tech</div>
                                    </div>
                                </div>
                                <a href="#" class="btn btn-primary">Lire l'article</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Articles Grid -->
    <section class="articles-grid">
        <div class="row g-4">
            <!-- Article 1 -->
            <div class="col-lg-4 col-md-6">
                <article class="article-card">
                    <div class="article-image">
                        <img src="https://images.unsplash.com/photo-1560472354-b33ff0c44a43?w=400&h=250&fit=crop" 
                             alt="Article" class="img-fluid">
                        {{-- Duration removed as requested --}}
                    </div>
                    <div class="article-content">
                        <div class="article-meta">
                            <span class="category-tag startup">Startup</span>
                            <span class="date">12 Déc 2024</span>
                        </div>
                        <h3 class="article-title">
                            <a href="#">L'agritech ivoirienne qui nourrit l'Afrique</a>
                        </h3>
                        <p class="article-excerpt">
                            Comment une startup d'Abidjan révolutionne l'agriculture avec l'IA et connecte 50,000 agriculteurs...
                        </p>
                        <div class="article-author">
                            <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=40&h=40&fit=crop&crop=face" 
                                 alt="Auteur" class="author-avatar">
                            <span class="author-name">Kwame Asante</span>
                        </div>
                    </div>
                </article>
            </div>

            <!-- Article 2 -->
            <div class="col-lg-4 col-md-6">
                <article class="article-card">
                    <div class="article-image">
                        <img src="https://images.unsplash.com/photo-1551434678-e076c223a692?w=400&h=250&fit=crop" 
                             alt="Article" class="img-fluid">
                        {{-- Duration removed as requested --}}
                    </div>
                    <div class="article-content">
                        <div class="article-meta">
                            <span class="category-tag finance">Finance</span>
                            <span class="date">10 Déc 2024</span>
                        </div>
                        <h3 class="article-title">
                            <a href="#">Les néobanques africaines défient les géants</a>
                        </h3>
                        <p class="article-excerpt">
                            Analyse des stratégies disruptives des nouvelles banques digitales qui transforment le secteur...
                        </p>
                        <div class="article-author">
                            <img src="https://images.unsplash.com/photo-1494790108755-2616c2d1e0e0?w=40&h=40&fit=crop&crop=face" 
                                 alt="Auteur" class="author-avatar">
                            <span class="author-name">Aminata Traoré</span>
                        </div>
                    </div>
                </article>
            </div>

            <!-- Article 3 -->
            <div class="col-lg-4 col-md-6">
                <article class="article-card">
                    <div class="article-image">
                        <img src="https://images.unsplash.com/photo-1521737604893-d14cc237f11d?w=400&h=250&fit=crop" 
                             alt="Article" class="img-fluid">
                        {{-- Duration removed as requested --}}
                    </div>
                    <div class="article-content">
                        <div class="article-meta">
                            <span class="category-tag portrait">Portrait</span>
                            <span class="date">8 Déc 2024</span>
                        </div>
                        <h3 class="article-title">
                            <a href="#">Le roi du e-commerce ouest-africain</a>
                        </h3>
                        <p class="article-excerpt">
                            Rencontre avec l'entrepreneur qui a créé la plus grande plateforme de vente en ligne de la région...
                        </p>
                        <div class="article-author">
                            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=40&h=40&fit=crop&crop=face" 
                                 alt="Auteur" class="author-avatar">
                            <span class="author-name">Deza Auguste</span>
                        </div>
                    </div>
                </article>
            </div>

            <!-- Article 4 -->
            <div class="col-lg-4 col-md-6">
                <article class="article-card">
                    <div class="article-image">
                        <img src="https://images.unsplash.com/photo-1559136555-9303baea8ebd?w=400&h=250&fit=crop" 
                             alt="Article" class="img-fluid">
                        {{-- Duration removed as requested --}}
                    </div>
                    <div class="article-content">
                        <div class="article-meta">
                            <span class="category-tag tech">Tech</span>
                            <span class="date">5 Déc 2024</span>
                        </div>
                        <h3 class="article-title">
                            <a href="#">L'IA au service de la santé africaine</a>
                        </h3>
                        <p class="article-excerpt">
                            Comment les startups africaines utilisent l'intelligence artificielle pour démocratiser l'accès aux soins...
                        </p>
                        <div class="article-author">
                            <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=40&h=40&fit=crop&crop=face" 
                                 alt="Auteur" class="author-avatar">
                            <span class="author-name">Kwame Asante</span>
                        </div>
                    </div>
                </article>
            </div>

            <!-- Article 5 -->
            <div class="col-lg-4 col-md-6">
                <article class="article-card">
                    <div class="article-image">
                        <img src="https://images.unsplash.com/photo-1553729459-efe14ef6055d?w=400&h=250&fit=crop" 
                             alt="Article" class="img-fluid">
                        {{-- Duration removed as requested --}}
                    </div>
                    <div class="article-content">
                        <div class="article-meta">
                            <span class="category-tag analyse">Analyse</span>
                            <span class="date">3 Déc 2024</span>
                        </div>
                        <h3 class="article-title">
                            <a href="#">L'économie verte : l'avenir de l'Afrique ?</a>
                        </h3>
                        <p class="article-excerpt">
                            Décryptage des opportunités et défis de la transition écologique pour les entreprises africaines...
                        </p>
                        <div class="article-author">
                            <img src="https://images.unsplash.com/photo-1494790108755-2616c2d1e0e0?w=40&h=40&fit=crop&crop=face" 
                                 alt="Auteur" class="author-avatar">
                            <span class="author-name">Aminata Traoré</span>
                        </div>
                    </div>
                </article>
            </div>

            <!-- Article 6 -->
            <div class="col-lg-4 col-md-6">
                <article class="article-card">
                    <div class="article-image">
                        <img src="https://images.unsplash.com/photo-1507679799987-c73779587ccf?w=400&h=250&fit=crop" 
                             alt="Article" class="img-fluid">
                        {{-- Duration removed as requested --}}
                    </div>
                    <div class="article-content">
                        <div class="article-meta">
                            <span class="category-tag portrait">Portrait</span>
                            <span class="date">1 Déc 2024</span>
                        </div>
                        <h3 class="article-title">
                            <a href="#">La femme qui électrifie l'Afrique rurale</a>
                        </h3>
                        <p class="article-excerpt">
                            Portrait d'une ingénieure qui apporte l'électricité solaire dans les villages les plus reculés...
                        </p>
                        <div class="article-author">
                            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=40&h=40&fit=crop&crop=face" 
                                 alt="Auteur" class="author-avatar">
                            <span class="author-name">Deza Auguste</span>
                        </div>
                    </div>
                </article>
            </div>
        </div>

        <!-- Load More -->
        <div class="row mt-5">
            <div class="col-12 text-center">
                <button class="btn btn-outline-primary btn-lg">
                    <i class="fas fa-plus me-2"></i>Charger plus d'articles
                </button>
            </div>
        </div>
    </section>

    <!-- Newsletter CTA -->
    <section class="newsletter-cta mt-5">
        <div class="cta-card">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h3 class="cta-title">Ne Manquez Aucune Histoire</h3>
                    <p class="cta-description">
                        Recevez chaque semaine les meilleures histoires d'entrepreneurs africains directement dans votre boîte mail.
                    </p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a href="{{ route('newsletter.subscribe') }}" class="btn btn-light btn-lg">
                        <i class="fas fa-envelope me-2"></i>S'abonner
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('styles')
<style>
.hero-title {
    font-size: 3rem;
    font-weight: 700;
    margin-bottom: 1.5rem;
    color: var(--bs-primary);
}

.hero-description {
    font-size: 1.2rem;
    color: var(--bs-gray-600);
    max-width: 600px;
    margin: 0 auto;
}

.filters-wrapper {
    background: white;
    padding: 2rem;
    border-radius: 1.5rem;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.category-filters {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
}

.filter-btn {
    background: #f8f9fa;
    border: none;
    padding: 0.75rem 1.5rem;
    border-radius: 2rem;
    font-weight: 500;
    color: var(--bs-gray-600);
    transition: all 0.3s ease;
    cursor: pointer;
}

.filter-btn:hover,
.filter-btn.active {
    background: var(--bs-primary);
    color: white;
}

.search-box {
    position: relative;
}

.search-box input {
    padding-right: 3rem;
    border-radius: 2rem;
    border: 2px solid #e9ecef;
}

.search-box i {
    position: absolute;
    right: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: var(--bs-gray-400);
}

.featured-card {
    background: white;
    border-radius: 2rem;
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    overflow: hidden;
}

.featured-image {
    position: relative;
    height: 400px;
    overflow: hidden;
}

.featured-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.featured-badge {
    position: absolute;
    top: 1.5rem;
    left: 1.5rem;
    background: var(--bs-primary);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 1rem;
    font-size: 0.9rem;
    font-weight: 600;
}

.featured-content {
    padding: 3rem;
    height: 400px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.article-meta {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1rem;
}

.category-tag {
    background: var(--bs-primary);
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 1rem;
    font-size: 0.8rem;
    font-weight: 600;
}

.category-tag.startup { background: #28a745; }
.category-tag.finance { background: #17a2b8; }
.category-tag.portrait { background: #ffc107; color: #000; }
.category-tag.tech { background: #6f42c1; }
.category-tag.analyse { background: #fd7e14; }

.date {
    color: var(--bs-gray-500);
    font-size: 0.9rem;
}

.featured-title {
    font-size: 2rem;
    font-weight: 700;
    line-height: 1.3;
    margin-bottom: 1rem;
    color: var(--bs-dark);
}

.featured-excerpt {
    font-size: 1.1rem;
    line-height: 1.6;
    color: var(--bs-gray-600);
    margin-bottom: 2rem;
}

.featured-author {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 2rem;
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

.author-role {
    font-size: 0.9rem;
    color: var(--bs-gray-500);
}

.article-card {
    background: white;
    border-radius: 1.5rem;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    overflow: hidden;
    transition: transform 0.3s ease;
    height: 100%;
}

.article-card:hover {
    transform: translateY(-10px);
}

.article-image {
    position: relative;
    height: 200px;
    overflow: hidden;
}

.article-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.article-card:hover .article-image img {
    transform: scale(1.1);
}

.reading-time {
    position: absolute;
    top: 1rem;
    right: 1rem;
    background: rgba(0,0,0,0.7);
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 1rem;
    font-size: 0.8rem;
}

.article-content {
    padding: 2rem;
    display: flex;
    flex-direction: column;
    height: calc(100% - 200px);
}

.article-title {
    margin-bottom: 1rem;
    flex-grow: 1;
}

.article-title a {
    color: var(--bs-dark);
    text-decoration: none;
    font-size: 1.2rem;
    font-weight: 600;
    line-height: 1.4;
}

.article-title a:hover {
    color: var(--bs-primary);
}

.article-excerpt {
    color: var(--bs-gray-600);
    line-height: 1.6;
    margin-bottom: 1.5rem;
    font-size: 0.95rem;
}

.article-author {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-top: auto;
}

.article-author .author-avatar {
    width: 35px;
    height: 35px;
}

.article-author .author-name {
    font-size: 0.9rem;
    font-weight: 500;
    color: var(--bs-gray-700);
}

.newsletter-cta {
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
    .hero-title {
        font-size: 2rem;
    }
    
    .category-filters {
        justify-content: center;
        margin-bottom: 2rem;
    }
    
    .featured-content {
        padding: 2rem;
        height: auto;
    }
    
    .featured-title {
        font-size: 1.5rem;
    }
    
    .article-content {
        padding: 1.5rem;
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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Filter functionality
    const filterBtns = document.querySelectorAll('.filter-btn');
    const articles = document.querySelectorAll('.article-card');
    
    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            // Remove active class from all buttons
            filterBtns.forEach(b => b.classList.remove('active'));
            // Add active class to clicked button
            this.classList.add('active');
            
            const category = this.getAttribute('data-category');
            
            articles.forEach(article => {
                if (category === 'all') {
                    article.closest('.col-lg-4').style.display = 'block';
                } else {
                    const articleCategory = article.querySelector('.category-tag').textContent.toLowerCase();
                    if (articleCategory.includes(category)) {
                        article.closest('.col-lg-4').style.display = 'block';
                    } else {
                        article.closest('.col-lg-4').style.display = 'none';
                    }
                }
            });
        });
    });
    
    // Search functionality
    const searchInput = document.querySelector('.search-box input');
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        
        articles.forEach(article => {
            const title = article.querySelector('.article-title a').textContent.toLowerCase();
            const excerpt = article.querySelector('.article-excerpt').textContent.toLowerCase();
            
            if (title.includes(searchTerm) || excerpt.includes(searchTerm)) {
                article.closest('.col-lg-4').style.display = 'block';
            } else {
                article.closest('.col-lg-4').style.display = 'none';
            }
        });
    });
});
</script>
@endpush
