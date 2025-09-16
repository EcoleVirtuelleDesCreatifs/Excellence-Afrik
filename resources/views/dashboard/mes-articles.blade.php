@extends('layouts.dashboard-ultra')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/dashboard-ultra.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/dashboard-pages.css') }}">
<style>
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
</style>
@endpush

@section('title', 'Mes Articles')

@section('content')
<!-- Header Actions -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h4 mb-1">Mes Articles</h2>
        <p class="text-muted mb-0">Gérez vos articles personnels</p>
    </div>
    <a href="{{ route('dashboard.articles.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Nouvel article
    </a>
</div>

<!-- Filters -->
<div class="dashboard-card mb-4">
    <div class="card-body">
        <div class="row g-3 align-items-end">
            <div class="col-lg-3">
                <label class="form-label">Rechercher</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" class="form-control" placeholder="Titre..." id="searchInput">
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
            <div class="col-lg-5">
                <button class="btn btn-outline-secondary me-2" onclick="resetFilters()">
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
        <h3 class="card-title">Mes Articles ({{ $articles->count() }})</h3>
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
                                <a href="{{ route('dashboard.articles.edit', $article->id) }}" class="btn btn-outline-primary" title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button class="btn btn-outline-info" onclick="viewArticle({{ $article->id }})" title="Voir">
                                    <i class="fas fa-eye"></i>
                                </button>
                                
                                <!-- Bouton supprimer - Journaliste peut supprimer ses articles non-publiés -->
                                @if($article->status !== 'published')
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
                        <td colspan="7" class="text-center py-5">
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
    <div class="card-footer d-flex justify-content-between align-items-center">
        <div>
            <span class="text-muted">{{ $articles->count() }} article(s)</span>
        </div>
    </div>
</div>

<!-- Bulk Actions (Hidden by default) -->
<div class="bulk-actions-bar" id="bulkActionsBar" style="display: none;">
    <div class="d-flex align-items-center justify-content-between">
        <div>
            <span id="selectedCount">0</span> article(s) sélectionné(s)
        </div>
        <div class="btn-group">
            <button class="btn btn-sm btn-primary" onclick="submitSelected()">
                <i class="fas fa-paper-plane me-1"></i>Soumettre
            </button>
            
            <button class="btn btn-sm btn-warning" onclick="draftSelected()">
                <i class="fas fa-edit me-1"></i>Brouillon
            </button>
            
            <!-- Bouton supprimer - Journalistes peuvent supprimer leurs articles non-publiés -->
            <button class="btn btn-sm btn-danger" onclick="deleteSelected()">
                <i class="fas fa-trash me-1"></i>Supprimer
            </button>
        </div>
    </div>
</div>
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
function viewArticle(id) {
    alert(`Affichage de l'article ${id}`);
}

// Filters
function applyFilters() {
    const search = document.getElementById('searchInput').value;
    const category = document.getElementById('categoryFilter').value;
    const status = document.getElementById('statusFilter').value;
    
    console.log('Applying filters:', { search, category, status });
    // Implement filter logic here
}

function resetFilters() {
    document.getElementById('searchInput').value = '';
    document.getElementById('categoryFilter').value = '';
    document.getElementById('statusFilter').value = '';
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

function submitSelected() {
    const selectedCount = document.querySelectorAll('.article-checkbox:checked').length;
    if (confirm(`Soumettre ${selectedCount} article(s) pour validation ?`)) {
        executeBulkAction('submit');
    }
}

function draftSelected() {
    executeBulkAction('draft');
}

function deleteSelected() {
    const selectedCount = document.querySelectorAll('.article-checkbox:checked').length;
    if (confirm(`Êtes-vous sûr de vouloir supprimer ${selectedCount} article(s) ?`)) {
        executeBulkAction('delete');
    }
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
</script>
@endpush