@extends('layouts.dashboard')

@section('title', 'Gestion des Utilisateurs')
@section('page_title', 'Utilisateurs')

@section('breadcrumbs')
    <li class="breadcrumb-item active">Utilisateurs</li>
@endsection

@section('content')
<!-- Header Actions -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h4 mb-1">Gestion des Utilisateurs</h2>
        <p class="text-muted mb-0">Gérez les comptes utilisateurs et leurs permissions</p>
    </div>
    <button class="btn btn-primary" onclick="createNewUser()">
        <i class="fas fa-user-plus me-2"></i>Nouvel utilisateur
    </button>
</div>

<!-- Stats Cards -->
<div class="row g-4 mb-4">
    <div class="col-lg-3 col-md-6">
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(37, 99, 235, 0.1); color: var(--primary-color);">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-value">12</div>
            <div class="stat-label">Total utilisateurs</div>
            <div class="stat-change positive">
                <i class="fas fa-arrow-up"></i> +2 ce mois
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6">
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(16, 185, 129, 0.1); color: var(--success-color);">
                <i class="fas fa-user-check"></i>
            </div>
            <div class="stat-value">10</div>
            <div class="stat-label">Actifs</div>
            <div class="stat-change positive">
                <i class="fas fa-arrow-up"></i> +1 ce mois
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6">
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(245, 158, 11, 0.1); color: var(--warning-color);">
                <i class="fas fa-user-clock"></i>
            </div>
            <div class="stat-value">2</div>
            <div class="stat-label">En attente</div>
            <div class="stat-change neutral">
                <i class="fas fa-minus"></i> Stable
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6">
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(239, 68, 68, 0.1); color: var(--danger-color);">
                <i class="fas fa-user-shield"></i>
            </div>
            <div class="stat-value">3</div>
            <div class="stat-label">Administrateurs</div>
            <div class="stat-change neutral">
                <i class="fas fa-minus"></i> Stable
            </div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="dashboard-card mb-4">
    <div class="card-body">
        <div class="row g-3 align-items-end">
            <div class="col-lg-4">
                <label class="form-label">Rechercher</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" class="form-control" placeholder="Nom, email..." id="searchInput">
                </div>
            </div>
            <div class="col-lg-2">
                <label class="form-label">Rôle</label>
                <select class="form-select" id="roleFilter">
                    <option value="">Tous</option>
                    <option value="admin">Administrateur</option>
                    <option value="editor">Éditeur</option>
                    <option value="writer">Rédacteur</option>
                    <option value="subscriber">Abonné</option>
                </select>
            </div>
            <div class="col-lg-2">
                <label class="form-label">Statut</label>
                <select class="form-select" id="statusFilter">
                    <option value="">Tous</option>
                    <option value="active">Actif</option>
                    <option value="pending">En attente</option>
                    <option value="suspended">Suspendu</option>
                </select>
            </div>
            <div class="col-lg-4">
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

<!-- Users Table -->
<div class="dashboard-card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">Liste des Utilisateurs</h3>
        <div class="btn-group" role="group">
            <button class="btn btn-outline-secondary btn-sm" onclick="exportUsers()">
                <i class="fas fa-download me-1"></i>Exporter
            </button>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0" id="usersTable">
                <thead class="table-light">
                    <tr>
                        <th>
                            <input type="checkbox" class="form-check-input" id="selectAll">
                        </th>
                        <th>Utilisateur</th>
                        <th>Rôle</th>
                        <th>Statut</th>
                        <th>Dernière connexion</th>
                        <th>Date d'inscription</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <input type="checkbox" class="form-check-input user-checkbox">
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="user-avatar me-3" style="background: linear-gradient(135deg, #667eea, #764ba2);">
                                    DC
                                </div>
                                <div>
                                    <div class="fw-semibold">Deza Auguste César</div>
                                    <small class="text-muted">admin@excellenceafrik.com</small>
                                </div>
                            </div>
                        </td>
                        <td><span class="badge bg-danger">Administrateur</span></td>
                        <td><span class="badge bg-success">Actif</span></td>
                        <td>Il y a 2 heures</td>
                        <td>15 Jan 2024</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <button class="btn btn-outline-primary" onclick="editUser(1)" title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-outline-info" onclick="viewUser(1)" title="Profil">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-outline-warning" onclick="suspendUser(1)" title="Suspendre">
                                    <i class="fas fa-ban"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="checkbox" class="form-check-input user-checkbox">
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="user-avatar me-3" style="background: linear-gradient(135deg, #f093fb, #f5576c);">
                                    SK
                                </div>
                                <div>
                                    <div class="fw-semibold">Sarah Koné</div>
                                    <small class="text-muted">sarah@excellenceafrik.com</small>
                                </div>
                            </div>
                        </td>
                        <td><span class="badge bg-primary">Éditeur</span></td>
                        <td><span class="badge bg-success">Actif</span></td>
                        <td>Il y a 1 jour</td>
                        <td>20 Jan 2024</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <button class="btn btn-outline-primary" onclick="editUser(2)" title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-outline-info" onclick="viewUser(2)" title="Profil">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-outline-danger" onclick="deleteUser(2)" title="Supprimer">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="checkbox" class="form-check-input user-checkbox">
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="user-avatar me-3" style="background: linear-gradient(135deg, #4facfe, #00f2fe);">
                                    KA
                                </div>
                                <div>
                                    <div class="fw-semibold">Kwame Asante</div>
                                    <small class="text-muted">kwame@excellenceafrik.com</small>
                                </div>
                            </div>
                        </td>
                        <td><span class="badge bg-info">Rédacteur</span></td>
                        <td><span class="badge bg-success">Actif</span></td>
                        <td>Il y a 3 jours</td>
                        <td>25 Jan 2024</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <button class="btn btn-outline-primary" onclick="editUser(3)" title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-outline-info" onclick="viewUser(3)" title="Profil">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-outline-danger" onclick="deleteUser(3)" title="Supprimer">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer d-flex justify-content-between align-items-center">
        <div>
            <span class="text-muted">Affichage 1-10 sur 12 utilisateurs</span>
        </div>
        <nav>
            <ul class="pagination pagination-sm mb-0">
                <li class="page-item disabled">
                    <span class="page-link">Précédent</span>
                </li>
                <li class="page-item active">
                    <span class="page-link">1</span>
                </li>
                <li class="page-item">
                    <a class="page-link" href="#">2</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="#">Suivant</a>
                </li>
            </ul>
        </nav>
    </div>
</div>

<!-- User Modal (Hidden) -->
<div class="modal fade" id="userModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Détails de l'utilisateur</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4 text-center">
                        <div class="user-avatar-large mb-3" style="background: linear-gradient(135deg, #667eea, #764ba2);">
                            DC
                        </div>
                        <h5>Deza Auguste César</h5>
                        <p class="text-muted">Administrateur</p>
                    </div>
                    <div class="col-md-8">
                        <div class="user-details">
                            <div class="detail-item">
                                <strong>Email:</strong> admin@excellenceafrik.com
                            </div>
                            <div class="detail-item">
                                <strong>Statut:</strong> <span class="badge bg-success">Actif</span>
                            </div>
                            <div class="detail-item">
                                <strong>Date d'inscription:</strong> 15 Janvier 2024
                            </div>
                            <div class="detail-item">
                                <strong>Dernière connexion:</strong> Il y a 2 heures
                            </div>
                            <div class="detail-item">
                                <strong>Articles publiés:</strong> 25
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="button" class="btn btn-primary">Modifier</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.user-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 600;
    font-size: 0.9rem;
}

.user-avatar-large {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 700;
    font-size: 2rem;
    margin: 0 auto;
}

.detail-item {
    padding: 0.5rem 0;
    border-bottom: 1px solid #f3f4f6;
}

.detail-item:last-child {
    border-bottom: none;
}

.stat-change.neutral {
    color: #6b7280;
}

.badge {
    font-size: 0.75rem;
    padding: 0.35rem 0.65rem;
}

.table th {
    font-weight: 600;
    border-bottom: 2px solid #e5e7eb;
    background: #f8fafc;
}

.table td {
    vertical-align: middle;
}
</style>
@endpush

@push('scripts')
<script>
// User Management Functions
function createNewUser() {
    alert('Formulaire de création d\'utilisateur à implémenter');
}

function editUser(id) {
    alert(`Modification de l'utilisateur ${id}`);
}

function viewUser(id) {
    // Show user modal
    const modal = new bootstrap.Modal(document.getElementById('userModal'));
    modal.show();
}

function deleteUser(id) {
    if (confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')) {
        alert(`Utilisateur ${id} supprimé`);
    }
}

function suspendUser(id) {
    if (confirm('Êtes-vous sûr de vouloir suspendre cet utilisateur ?')) {
        alert(`Utilisateur ${id} suspendu`);
    }
}

function exportUsers() {
    alert('Export des utilisateurs en cours...');
}

// Filters
function applyFilters() {
    const search = document.getElementById('searchInput').value;
    const role = document.getElementById('roleFilter').value;
    const status = document.getElementById('statusFilter').value;
    
    console.log('Applying filters:', { search, role, status });
}

function resetFilters() {
    document.getElementById('searchInput').value = '';
    document.getElementById('roleFilter').value = '';
    document.getElementById('statusFilter').value = '';
    applyFilters();
}

// Bulk Actions
document.addEventListener('DOMContentLoaded', function() {
    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('.user-checkbox');
    
    selectAll.addEventListener('change', function() {
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });
    
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const checkedCount = document.querySelectorAll('.user-checkbox:checked').length;
            selectAll.checked = checkedCount === checkboxes.length;
            selectAll.indeterminate = checkedCount > 0 && checkedCount < checkboxes.length;
        });
    });
});
</script>
@endpush
