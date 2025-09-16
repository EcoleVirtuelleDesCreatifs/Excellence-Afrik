@extends('layouts.dashboard-ultra')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/dashboard-ultra.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/dashboard-pages.css') }}">

<style>
/* Variables CSS pour la cohérence */
:root {
    --ea-gold: #F2CB05;
    --ea-blue: #2563eb;
    --ea-green: #10b981;
    --ea-danger: #dc3545;
    --card-bg: #ffffff;
    --card-border: #e9ecef;
    --text-primary: #2c3e50;
    --text-secondary: #6c757d;
    --shadow-light: 0 2px 10px rgba(0,0,0,0.08);
    --shadow-hover: 0 4px 20px rgba(0,0,0,0.12);
}

/* Layout principal */
.articles-management-section {
    background: #f8f9fa;
    min-height: 100vh;
}

/* Header moderne */
.page-header-modern {
    background: white;
    border-radius: 12px;
    box-shadow: var(--shadow-light);
    padding: 2rem;
    margin-bottom: 2rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1rem;
}

.header-content {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.header-main {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.header-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, var(--ea-gold), var(--ea-blue));
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: white;
}

.page-title {
    font-size: 1.8rem;
    font-weight: 700;
    color: var(--text-primary);
    margin: 0;
}

.page-subtitle {
    color: var(--text-secondary);
    margin: 0.25rem 0 0 0;
}

.breadcrumb-modern {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.9rem;
    color: var(--text-secondary);
    margin-top: 0.5rem;
}

.breadcrumb-item {
    color: var(--text-secondary);
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.breadcrumb-item:hover {
    color: var(--ea-gold);
    text-decoration: none;
}

.breadcrumb-item.active {
    color: var(--ea-gold);
    font-weight: 600;
}

.breadcrumb-separator {
    color: var(--text-secondary);
    font-size: 0.8rem;
}

/* Boutons d'actions du header */
.header-actions {
    display: flex;
    gap: 1rem;
    align-items: center;
}

.btn-primary-modern {
    background: linear-gradient(135deg, var(--ea-gold), #e6b800);
    color: #000;
    padding: 0.75rem 1.5rem;
    border-radius: 10px;
    text-decoration: none;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    border: none;
    transition: all 0.3s ease;
    cursor: pointer;
}

.btn-primary-modern:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-hover);
    color: #000;
    text-decoration: none;
}

/* Barre de recherche et filtres */
.search-filters-card {
    background: white;
    border-radius: 12px;
    box-shadow: var(--shadow-light);
    padding: 1.5rem;
    margin-bottom: 2rem;
}

.form-label {
    font-weight: 500;
    color: var(--text-primary);
    margin-bottom: 0.5rem;
}

.form-control, .form-select {
    border: 2px solid var(--card-border);
    border-radius: 8px;
    padding: 0.75rem 1rem;
    transition: all 0.3s ease;
}

.form-control:focus, .form-select:focus {
    outline: none;
    border-color: var(--ea-gold);
    box-shadow: 0 0 0 0.2rem rgba(242, 203, 5, 0.25);
}

.input-group-text {
    background: #f8f9fa;
    border: 2px solid var(--card-border);
    border-right: none;
    color: var(--text-secondary);
}

.input-group .form-control {
    border-left: none;
}

.btn {
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-outline-secondary {
    border: 2px solid var(--card-border);
    color: var(--text-secondary);
}

.btn-outline-secondary:hover {
    background: var(--text-secondary);
    border-color: var(--text-secondary);
    color: white;
}

.btn-primary {
    background: linear-gradient(135deg, var(--ea-gold), #e6b800);
    border: 2px solid transparent;
    color: #000;
}

.btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: var(--shadow-hover);
    color: #000;
}

/* Status dots */
.status-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    display: inline-block;
}

.status-dot.online {
    background-color: #10b981;
    animation: pulse 2s infinite;
}

.status-dot.offline {
    background-color: #6b7280;
}

@keyframes pulse {
    0% {
        opacity: 1;
        transform: scale(1);
    }
    50% {
        opacity: 0.5;
        transform: scale(1.1);
    }
    100% {
        opacity: 1;
        transform: scale(1);
    }
}

/* Responsive */
@media (max-width: 768px) {
    .page-header-modern {
        flex-direction: column;
        text-align: center;
    }
    
    .header-actions {
        width: 100%;
        justify-content: center;
    }
    
    .header-main {
        flex-direction: column;
        text-align: center;
    }
    
    .search-filters-card .row > div {
        margin-bottom: 1rem;
    }
    
    .d-flex.gap-2 {
        justify-content: center;
    }
}

/* Custom Pagination Styles */
.pagination {
    justify-content: center;
    margin-top: 1rem;
    padding: 1rem 0;
}
.pagination .page-item .page-link {
    color: var(--ea-blue);
    border: 1px solid #dee2e6;
    margin: 0 3px;
    border-radius: 0.375rem; /* 6px */
    transition: all 0.3s ease;
    font-weight: 500;
    padding: 0.5rem 1rem;
}
.pagination .page-item.active .page-link {
    background: linear-gradient(135deg, var(--ea-gold), var(--ea-blue));
    border-color: var(--ea-gold);
    color: white;
    z-index: 3;
    box-shadow: var(--shadow-light);
}
.pagination .page-item.disabled .page-link {
    color: #6c757d;
    background-color: #e9ecef;
    border-color: #dee2e6;
}
.pagination .page-item:not(.active) .page-link:hover {
    background-color: #f0f0f0;
    border-color: var(--ea-gold);
}
</style>
@endpush

@section('title', 'Gestion des Articles')

@section('content')
<div class="articles-management-section">
    <!-- Header moderne -->
    <div class="page-header-modern">
        <div class="header-content">
            <div class="header-main">
                <div class="header-icon">
                    <i class="fas fa-newspaper"></i>
                </div>
                <div class="header-info">
                    <h1 class="page-title">
                        @if(auth()->check() && auth()->user()->estJournaliste())
                            Mes Articles
                        @else
                            Gestion des Articles
                        @endif
                    </h1>
                    <p class="page-subtitle">
                        @if(auth()->check() && auth()->user()->estJournaliste())
                            Créez et gérez vos articles personnels
                        @else
                            Créez, modifiez et gérez tous les articles
                        @endif
                    </p>
                    <div class="breadcrumb-modern">
                        <a href="{{ url('/dashboard') }}" class="breadcrumb-item">
                            <i class="fas fa-home"></i>
                            Dashboard
                        </a>
                        <i class="fas fa-chevron-right breadcrumb-separator"></i>
                        <span class="breadcrumb-item active">Articles</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-actions">
            <a href="{{ route('dashboard.articles.create') }}" class="btn-primary-modern">
                <i class="fas fa-plus"></i>
                <span>Nouvel article</span>
            </a>
        </div>
    </div>

    <!-- Barre de recherche et filtres -->
    <div class="search-filters-card">
        <div class="row g-3 align-items-end">
            <div class="col-lg-3">
                <label class="form-label">Rechercher</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" class="form-control" placeholder="Titre, auteur..." id="searchInput">
                </div>
            </div>
            <div class="col-lg-2">
                <label class="form-label">Catégorie</label>
                <select class="form-select" id="categoryFilter">
                    <option value="">Toutes</option>
                    <option value="portrait">Portrait</option>
                    <option value="startup">Startup</option>
                    <option value="finance">Finance</option>
                    <option value="tech">Tech</option>
                    <option value="analyse">Analyse</option>
                </select>
            </div>
            <div class="col-lg-2">
                <label class="form-label">Statut</label>
                <select class="form-select" id="statusFilter">
                    <option value="">Tous</option>
                    <option value="published">Publié</option>
                    <option value="draft">Brouillon</option>
                    <option value="pending">En attente</option>
                </select>
            </div>
            <div class="col-lg-2">
                <label class="form-label">Auteur</label>
                <select class="form-select" id="authorFilter">
                    <option value="">Tous</option>
                    <option value="sarah">Sarah Koné</option>
                    <option value="kwame">Kwame Asante</option>
                    <option value="aminata">Aminata Traoré</option>
                    <option value="deza">Deza Auguste</option>
                </select>
            </div>
            <div class="col-lg-3">
                <label class="form-label">&nbsp;</label> <!-- Espace pour alignement -->
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-secondary" onclick="resetFilters()">
                        <i class="fas fa-undo me-1"></i>Reset
                    </button>
                    <button class="btn btn-primary" onclick="applyFilters()">
                        <i class="fas fa-filter me-1"></i>Filtrer
                    </button>
                </div>
            </div>
        </div>
    </div>

<!-- Articles Table -->
<div class="dashboard-card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">Liste des Articles ({{ $articles->count() }})</h3>
        <div class="btn-group" role="group">
            <button class="btn btn-outline-secondary btn-sm active" onclick="setViewMode('table')">
                <i class="fas fa-list"></i>
            </button>
            <button class="btn btn-outline-secondary btn-sm" onclick="setViewMode('grid')">
                <i class="fas fa-th-large"></i>
            </button>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0" id="articlesTable">
                <thead class="table-light">
                    <tr>
                        <th>
                            <input type="checkbox" class="form-check-input" id="selectAll">
                        </th>
                        <th>Article</th>
                        <th>Auteur</th>
                        <th>Catégorie</th>
                        <th>Statut</th>
                        <th>Vues</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($articles as $article)
                    <tr>
                        <td>
                            <input type="checkbox" class="form-check-input article-checkbox" value="{{ $article->id }}">
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                @if($article->featured_image_path && file_exists(public_path('storage/' . $article->featured_image_path)))
                                    <img src="{{ asset('storage/' . $article->featured_image_path) }}" 
                                         class="rounded me-3 object-fit-cover" width="60" height="40" alt="Article"
                                         style="object-fit: cover;">
                                @elseif($article->featured_image_url)
                                    <img src="{{ $article->featured_image_url }}" 
                                         class="rounded me-3 object-fit-cover" width="60" height="40" alt="Article"
                                         style="object-fit: cover;">
                                @else
                                    <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center" 
                                         style="width: 60px; height: 40px;">
                                        <i class="fas fa-image text-muted"></i>
                                    </div>
                                @endif
                                <div>
                                    <div class="fw-semibold">{{ Str::limit($article->title, 60) }}</div>
                                    <small class="text-muted">{{ Str::limit($article->excerpt, 80) }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($article->user)
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary rounded-circle me-2 d-flex align-items-center justify-content-center text-white" style="width: 30px; height: 30px; font-size: 12px;">
                                        {{ strtoupper(substr($article->user->name, 0, 1)) }}
                                    </div>
                                    {{ $article->user->name }}
                                </div>
                            @else
                                Utilisateur inconnu
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-primary">{{ $article->category->name ?? 'Sans catégorie' }}</span>
                        </td>
                        <td>
                            @if($article->status === 'published')
                                <span class="d-flex align-items-center text-success">
                                    <span class="status-dot online me-2"></span>
                                    En ligne
                                </span>
                            @elseif($article->status === 'draft')
                                <span class="d-flex align-items-center text-muted">
                                    <span class="status-dot offline me-2"></span>
                                    Brouillon
                                </span>
                            @elseif($article->status === 'pending')
                                <span class="d-flex align-items-center text-warning">
                                    <span class="status-dot offline me-2" style="background-color: #f59e0b;"></span>
                                    En attente
                                </span>
                            @else
                                <span class="d-flex align-items-center text-secondary">
                                    <span class="status-dot offline me-2"></span>
                                    {{ ucfirst($article->status) }}
                                </span>
                            @endif
                        </td>
                        <td>{{ number_format($article->view_count ?? 0) }}</td>
                        <td>{{ $article->created_at->translatedFormat('d F Y') }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <!-- Bouton modifier - Permissions selon le rôle -->
                                @if(auth()->check() && auth()->user()->peutModifierArticle($article))
                                    <a href="{{ route('dashboard.articles.edit', $article->id) }}" class="btn btn-outline-primary" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                @endif
                                <button class="btn btn-outline-info" onclick="viewArticle({{ $article->id }})" title="Voir">
                                    <i class="fas fa-eye"></i>
                                </button>
                                
                                <!-- Bouton approuver - Seulement Admin et Directeur pour articles en attente -->
                                @if(auth()->check() && (auth()->user()->estAdmin() || auth()->user()->estDirecteurPublication()) && $article->status === 'pending')
                                    <form method="POST" action="{{ route('dashboard.articles.approve', $article->id) }}" style="display: inline;" onsubmit="return confirm('Approuver et publier cet article ?')">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-success" title="Approuver et publier">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                    
                                    <!-- Bouton refuser -->
                                    <form method="POST" action="{{ route('dashboard.articles.reject', $article->id) }}" style="display: inline;" onsubmit="return confirm('Refuser cet article et le renvoyer en brouillon ?')">
                                        @csrf
                                        <input type="hidden" name="reason" value="">
                                        <button type="submit" class="btn btn-outline-danger" title="Refuser l'article">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                @endif
                                
                                <!-- Bouton supprimer - Admin/Directeur (tous) ou Journaliste (ses articles non-publiés) -->
                                @if(auth()->check() && (
                                    auth()->user()->estAdmin() || 
                                    auth()->user()->estDirecteurPublication() ||
                                    (auth()->user()->estJournaliste() && $article->user_id === auth()->id() && $article->status !== 'published')
                                ))
                                    <form method="POST" action="{{ route('dashboard.articles.delete', $article->id) }}" style="display: inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet article ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger" title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5">
                            <div class="text-muted">
                                <i class="fas fa-newspaper fa-3x mb-3 opacity-50"></i>
                                <h5>Aucun article trouvé</h5>
                                <p class="mb-3">Vous n'avez pas encore créé d'articles.</p>
                                <a href="{{ route('dashboard.articles.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>Créer votre premier article
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white">
        {{ $articles->links() }}
    </div>
</div>

<!-- Bulk Actions (Hidden by default) -->
<div class="bulk-actions-bar" id="bulkActionsBar" style="display: none;">
    <div class="d-flex align-items-center justify-content-between">
        <div>
            <span id="selectedCount">0</span> article(s) sélectionné(s)
        </div>
        <div class="btn-group">
            <!-- Actions de publication - Seulement Admin et Directeur -->
            @if(auth()->check() && (auth()->user()->estAdmin() || auth()->user()->estDirecteurPublication()))
                <button class="btn btn-sm btn-success" onclick="publishSelected()">
                    <i class="fas fa-check me-1"></i>Publier
                </button>
                <button class="btn btn-sm btn-info" onclick="approveSelected()">
                    <i class="fas fa-thumbs-up me-1"></i>Approuver
                </button>
            @endif
            
            <button class="btn btn-sm btn-warning" onclick="draftSelected()">
                <i class="fas fa-edit me-1"></i>Brouillon
            </button>
            
            @if(auth()->check() && auth()->user()->estJournaliste())
                <button class="btn btn-sm btn-primary" onclick="submitSelected()">
                    <i class="fas fa-paper-plane me-1"></i>Soumettre
                </button>
            @endif
            
            <!-- Bouton supprimer - Pour tous (permissions gérées côté serveur) -->
            <button class="btn btn-sm btn-danger" onclick="deleteSelected()">
                <i class="fas fa-trash me-1"></i>Supprimer
            </button>
        </div>
    </div>
</div>
</div> <!-- Fermeture de articles-management-section -->
@endsection

@push('styles')
<style>
.bulk-actions-bar {
    position: fixed;
    bottom: 2rem;
    left: 50%;
    transform: translateX(-50%);
    background: white;
    padding: 1rem 2rem;
    border-radius: 2rem;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    z-index: 1000;
    animation: slideUp 0.3s ease;
}

@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateX(-50%) translateY(100%);
    }
    to {
        opacity: 1;
        transform: translateX(-50%) translateY(0);
    }
}

.table th {
    font-weight: 600;
    border-bottom: 2px solid #e5e7eb;
    background: #f8fafc;
}

.table td {
    vertical-align: middle;
}

.badge {
    font-size: 0.75rem;
    padding: 0.35rem 0.65rem;
}

.btn-group-sm .btn {
    padding: 0.25rem 0.5rem;
}

.form-check-input:checked {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
}
</style>
@endpush

@push('scripts')
<script>
// Articles Management
function createNewArticle() {
    alert('Redirection vers l\'éditeur d\'article...');
}

function editArticle(id) {
    alert(`Modification de l'article ${id}`);
}

function viewArticle(id) {
    alert(`Affichage de l'article ${id}`);
}

function deleteArticle(id) {
    if (confirm('Êtes-vous sûr de vouloir supprimer cet article ?')) {
        alert(`Article ${id} supprimé`);
    }
}

// Filters
function applyFilters() {
    const search = document.getElementById('searchInput').value;
    const category = document.getElementById('categoryFilter').value;
    const status = document.getElementById('statusFilter').value;
    const author = document.getElementById('authorFilter').value;
    
    console.log('Applying filters:', { search, category, status, author });
    // Implement filter logic here
}

function resetFilters() {
    document.getElementById('searchInput').value = '';
    document.getElementById('categoryFilter').value = '';
    document.getElementById('statusFilter').value = '';
    document.getElementById('authorFilter').value = '';
    applyFilters();
}

// View Mode
function setViewMode(mode) {
    document.querySelectorAll('.btn-group .btn').forEach(btn => {
        btn.classList.remove('active');
    });
    event.target.classList.add('active');
    
    if (mode === 'grid') {
        alert('Vue grille à implémenter');
    }
}

// Bulk Actions
document.addEventListener('DOMContentLoaded', function() {
    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('.article-checkbox');
    const bulkBar = document.getElementById('bulkActionsBar');
    const selectedCount = document.getElementById('selectedCount');
    
    selectAll.addEventListener('change', function() {
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateBulkActions();
    });
    
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateBulkActions);
    });
    
    function updateBulkActions() {
        const selected = document.querySelectorAll('.article-checkbox:checked').length;
        selectedCount.textContent = selected;
        
        if (selected > 0) {
            bulkBar.style.display = 'block';
        } else {
            bulkBar.style.display = 'none';
        }
        
        selectAll.checked = selected === checkboxes.length;
        selectAll.indeterminate = selected > 0 && selected < checkboxes.length;
    }
});

function publishSelected() {
    executeBulkAction('publish');
}

function approveSelected() {
    const selectedCount = document.querySelectorAll('.article-checkbox:checked').length;
    if (confirm(`Approuver et publier ${selectedCount} article(s) en attente ?`)) {
        executeBulkAction('approve');
    }
}

function submitSelected() {
    const selectedCount = document.querySelectorAll('.article-checkbox:checked').length;
    if (confirm(`Soumettre ${selectedCount} article(s) pour validation ?`)) {
        executeBulkAction('submit');
    }
}

function draftSelected() {
    executeBulkAction('draft');
}

function executeBulkAction(action) {
    const selectedCheckboxes = document.querySelectorAll('.article-checkbox:checked');
    const articleIds = Array.from(selectedCheckboxes).map(cb => cb.value);
    
    if (articleIds.length === 0) {
        alert('Veuillez sélectionner au moins un article');
        return;
    }
    
    // Créer un formulaire pour envoyer les données
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '{{ route("dashboard.articles.bulk-action") }}';
    
    // Token CSRF
    const csrfToken = document.createElement('input');
    csrfToken.type = 'hidden';
    csrfToken.name = '_token';
    csrfToken.value = '{{ csrf_token() }}';
    form.appendChild(csrfToken);
    
    // Action
    const actionInput = document.createElement('input');
    actionInput.type = 'hidden';
    actionInput.name = 'action';
    actionInput.value = action;
    form.appendChild(actionInput);
    
    // IDs des articles
    articleIds.forEach(id => {
        const idInput = document.createElement('input');
        idInput.type = 'hidden';
        idInput.name = 'articles[]';
        idInput.value = id;
        form.appendChild(idInput);
    });
    
    document.body.appendChild(form);
    form.submit();
}

function deleteSelected() {
    const selectedCount = document.querySelectorAll('.article-checkbox:checked').length;
    if (confirm(`Êtes-vous sûr de vouloir supprimer ${selectedCount} article(s) ?`)) {
        executeBulkAction('delete');
    }
}
</script>
@endpush
