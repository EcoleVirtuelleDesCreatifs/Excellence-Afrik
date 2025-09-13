@extends('layouts.dashboard-ultra')

@section('title', 'Gestion des Utilisateurs')
@section('page_title', 'Utilisateurs')

@push('head')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@push('styles')
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
        .users-management-section {
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
        
        .search-filters-body {
            /* Styles pour le contenu des filtres */
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
    </style>
@endpush

@section('breadcrumbs')
    <li class="breadcrumb-item active">Utilisateurs</li>
@endsection

@section('content')
<div class="users-management-section">
    <!-- Header moderne -->
    <div class="page-header-modern">
        <div class="header-content">
            <div class="header-main">
                <div class="header-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="header-info">
                    <h1 class="page-title">Gestion des Utilisateurs</h1>
                    <p class="page-subtitle">Gérez les comptes utilisateurs et leurs permissions</p>
                    <div class="breadcrumb-modern">
                        <a href="{{ url('/dashboard') }}" class="breadcrumb-item">
                            <i class="fas fa-home"></i>
                            Dashboard
                        </a>
                        <i class="fas fa-chevron-right breadcrumb-separator"></i>
                        <span class="breadcrumb-item active">Utilisateurs</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-actions">
            <button class="btn-primary-modern" onclick="showCreateUserModal()">
                <i class="fas fa-user-plus"></i>
                <span>Nouvel utilisateur</span>
            </button>
        </div>
    </div>

<!-- Stats Cards -->
<div class="row g-4 mb-4">
    <div class="col-lg-3 col-md-6">
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(37, 99, 235, 0.1); color: var(--primary-color);">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-value" id="totalUsers">-</div>
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
            <div class="stat-value" id="activeUsers">-</div>
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
            <div class="stat-value" id="inactiveUsers">-</div>
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
            <div class="stat-value" id="adminUsers">-</div>
            <div class="stat-label">Administrateurs</div>
            <div class="stat-change neutral">
                <i class="fas fa-minus"></i> Stable
            </div>
        </div>
    </div>
</div>

<!-- Barre de recherche et filtres -->
<div class="search-filters-card">
    <div class="search-filters-body">
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
                    <option value="directeur_publication">Directeur de Publication</option>
                    <option value="journaliste">Journaliste</option>
                </select>
            </div>
            <div class="col-lg-2">
                <label class="form-label">Statut</label>
                <select class="form-select" id="statusFilter">
                    <option value="">Tous</option>
                    <option value="1">Actif</option>
                    <option value="0">Inactif</option>
                </select>
            </div>
            <div class="col-lg-4">
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
                <tbody id="usersTableBody">
                    <tr>
                        <td colspan="7" class="text-center py-4">
                            <i class="fas fa-spinner fa-spin me-2"></i>Chargement des utilisateurs...
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer d-flex justify-content-between align-items-center">
        <div>
            <span class="text-muted" id="usersCount">Chargement...</span>
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

<!-- Modal Créer Utilisateur -->
<div class="modal fade" id="createUserModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Créer un nouveau compte</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="createUserForm">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nom complet <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Adresse email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Rôle <span class="text-danger">*</span></label>
                        <select class="form-select" name="role_utilisateur" required>
                            <option value="">Sélectionner un rôle</option>
                            <option value="admin">Administrateur</option>
                            <option value="directeur_publication">Directeur de Publication</option>
                            <option value="journaliste">Journaliste</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mot de passe temporaire <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" name="password" required minlength="8">
                        <small class="text-muted">L'utilisateur devra le changer à sa première connexion</small>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="est_actif" checked id="createUserActive">
                        <label class="form-check-label" for="createUserActive">
                            Compte actif
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Créer le compte
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Modifier Utilisateur -->
<div class="modal fade" id="editUserModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifier l'utilisateur</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editUserForm">
                @csrf
                <input type="hidden" name="user_id" id="editUserId">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nom complet <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name" id="editUserName" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Adresse email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" name="email" id="editUserEmail" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Rôle <span class="text-danger">*</span></label>
                        <select class="form-select" name="role_utilisateur" id="editUserRole" required>
                            <option value="admin">Administrateur</option>
                            <option value="directeur_publication">Directeur de Publication</option>
                            <option value="journaliste">Journaliste</option>
                        </select>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="est_actif" id="editUserActive">
                        <label class="form-check-label" for="editUserActive">
                            Compte actif
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- User Details Modal -->
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
                        <div class="user-avatar-large mb-3" id="viewUserAvatar">
                            ?
                        </div>
                        <h5 id="viewUserName">-</h5>
                        <p class="text-muted" id="viewUserRole">-</p>
                    </div>
                    <div class="col-md-8">
                        <div class="user-details">
                            <div class="detail-item">
                                <strong>Email:</strong> <span id="viewUserEmail">-</span>
                            </div>
                            <div class="detail-item">
                                <strong>Statut:</strong> <span id="viewUserStatus">-</span>
                            </div>
                            <div class="detail-item">
                                <strong>Date d'inscription:</strong> <span id="viewUserCreated">-</span>
                            </div>
                            <div class="detail-item">
                                <strong>Dernière connexion:</strong> <span id="viewUserLastLogin">-</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>
</div> <!-- Fermeture de users-management-section -->
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
// Variables globales
let allUsers = [];

// Charger les utilisateurs au chargement de la page
document.addEventListener('DOMContentLoaded', function() {
    loadUsers();
    
    // Event listeners pour les formulaires
    setupFormListeners();
    
    // Event listeners pour les filtres
    setupFilterListeners();
});

// ===== CHARGEMENT ET AFFICHAGE DES UTILISATEURS =====

function loadUsers() {
    fetch('/dashboard/settings/users')
        .then(response => response.json())
        .then(data => {
            if (data.users) {
                allUsers = data.users;
                displayUsers(allUsers);
                updateStats(allUsers);
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            document.getElementById('usersTableBody').innerHTML = 
                '<tr><td colspan="7" class="text-center py-4 text-danger">Erreur lors du chargement</td></tr>';
        });
}

function displayUsers(users) {
    const tbody = document.getElementById('usersTableBody');
    tbody.innerHTML = '';

    if (users && users.length > 0) {
        users.forEach(user => {
            const row = createUserRow(user);
            tbody.appendChild(row);
        });
        
        document.getElementById('usersCount').textContent = 
            `Affichage ${users.length} utilisateur${users.length > 1 ? 's' : ''}`;
    } else {
        tbody.innerHTML = '<tr><td colspan="7" class="text-center py-4">Aucun utilisateur trouvé</td></tr>';
        document.getElementById('usersCount').textContent = 'Aucun utilisateur';
    }
}

function createUserRow(user) {
    const row = document.createElement('tr');
    
    // Badge rôle
    let roleBadge = '';
    let roleText = '';
    switch(user.role_utilisateur) {
        case 'admin':
            roleBadge = '<span class="badge bg-danger">Administrateur</span>';
            roleText = 'Administrateur';
            break;
        case 'directeur_publication':
            roleBadge = '<span class="badge bg-warning">Directeur</span>';
            roleText = 'Directeur de Publication';
            break;
        case 'journaliste':
            roleBadge = '<span class="badge bg-primary">Journaliste</span>';
            roleText = 'Journaliste';
            break;
        default:
            roleBadge = '<span class="badge bg-secondary">-</span>';
            roleText = '-';
    }

    // Badge statut
    const statusBadge = user.est_actif 
        ? '<span class="badge bg-success">Actif</span>'
        : '<span class="badge bg-secondary">Inactif</span>';

    // Dernière connexion
    const lastLogin = user.derniere_connexion 
        ? new Date(user.derniere_connexion).toLocaleDateString('fr-FR')
        : 'Jamais';

    // Date d'inscription
    const createdAt = user.created_at 
        ? new Date(user.created_at).toLocaleDateString('fr-FR')
        : '-';

    // Avatar avec initiales
    const initials = user.name ? user.name.charAt(0).toUpperCase() : '?';

    row.innerHTML = `
        <td>
            <input type="checkbox" class="form-check-input user-checkbox" data-user-id="${user.id}">
        </td>
        <td>
            <div class="d-flex align-items-center">
                <div class="user-avatar me-3" style="background: linear-gradient(135deg, #667eea, #764ba2);">
                    ${initials}
                </div>
                <div>
                    <div class="fw-semibold">${user.name}</div>
                    <small class="text-muted">${user.email}</small>
                </div>
            </div>
        </td>
        <td>${roleBadge}</td>
        <td>${statusBadge}</td>
        <td>${lastLogin}</td>
        <td>${createdAt}</td>
        <td>
            <div class="btn-group btn-group-sm">
                <button class="btn btn-outline-primary" onclick="editUser(${user.id})" title="Modifier">
                    <i class="fas fa-edit"></i>
                </button>
                <button class="btn btn-outline-info" onclick="viewUser(${user.id})" title="Voir détails">
                    <i class="fas fa-eye"></i>
                </button>
                <button class="btn btn-outline-danger" onclick="deleteUser(${user.id}, '${user.name.replace(/'/g, "\\'")}' )" title="Supprimer">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </td>
    `;

    return row;
}

function updateStats(users) {
    const total = users.length;
    const active = users.filter(u => u.est_actif).length;
    const inactive = users.filter(u => !u.est_actif).length;
    const admins = users.filter(u => u.role_utilisateur === 'admin').length;

    document.getElementById('totalUsers').textContent = total;
    document.getElementById('activeUsers').textContent = active;
    document.getElementById('inactiveUsers').textContent = inactive;
    document.getElementById('adminUsers').textContent = admins;
}

// ===== GESTION DES MODALES =====

function showCreateUserModal() {
    document.getElementById('createUserForm').reset();
    const modal = new bootstrap.Modal(document.getElementById('createUserModal'));
    modal.show();
}

function editUser(userId) {
    fetch(`/dashboard/settings/users/${userId}`)
        .then(response => response.json())
        .then(user => {
            document.getElementById('editUserId').value = user.id;
            document.getElementById('editUserName').value = user.name;
            document.getElementById('editUserEmail').value = user.email;
            document.getElementById('editUserRole').value = user.role_utilisateur;
            document.getElementById('editUserActive').checked = user.est_actif;

            const modal = new bootstrap.Modal(document.getElementById('editUserModal'));
            modal.show();
        })
        .catch(error => {
            console.error('Erreur:', error);
            showAlert('Erreur lors du chargement des données utilisateur', 'danger');
        });
}

function viewUser(userId) {
    const user = allUsers.find(u => u.id == userId);
    if (!user) return;

    const initials = user.name ? user.name.charAt(0).toUpperCase() : '?';
    let roleText = '';
    switch(user.role_utilisateur) {
        case 'admin': roleText = 'Administrateur'; break;
        case 'directeur_publication': roleText = 'Directeur de Publication'; break;
        case 'journaliste': roleText = 'Journaliste'; break;
        default: roleText = '-';
    }

    document.getElementById('viewUserAvatar').textContent = initials;
    document.getElementById('viewUserName').textContent = user.name;
    document.getElementById('viewUserRole').textContent = roleText;
    document.getElementById('viewUserEmail').textContent = user.email;
    
    const statusBadge = user.est_actif 
        ? '<span class="badge bg-success">Actif</span>'
        : '<span class="badge bg-secondary">Inactif</span>';
    document.getElementById('viewUserStatus').innerHTML = statusBadge;
    
    document.getElementById('viewUserCreated').textContent = user.created_at 
        ? new Date(user.created_at).toLocaleDateString('fr-FR')
        : '-';
    
    document.getElementById('viewUserLastLogin').textContent = user.derniere_connexion 
        ? new Date(user.derniere_connexion).toLocaleDateString('fr-FR')
        : 'Jamais';

    const modal = new bootstrap.Modal(document.getElementById('userModal'));
    modal.show();
}

function deleteUser(userId, userName) {
    if (!confirm(`Êtes-vous sûr de vouloir supprimer l'utilisateur "${userName}" ?`)) {
        return;
    }

    fetch(`/dashboard/settings/users/${userId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            loadUsers();
            showAlert('Utilisateur supprimé avec succès', 'success');
        } else {
            showAlert('Erreur lors de la suppression: ' + data.message, 'danger');
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        showAlert('Erreur lors de la suppression', 'danger');
    });
}

// ===== FORMULAIRES =====

function setupFormListeners() {
    // Formulaire création
    document.getElementById('createUserForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        fetch('/dashboard/settings/users', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                bootstrap.Modal.getInstance(document.getElementById('createUserModal')).hide();
                loadUsers();
                showAlert('Utilisateur créé avec succès', 'success');
            } else {
                showAlert('Erreur: ' + data.message, 'danger');
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            showAlert('Erreur lors de la création', 'danger');
        });
    });

    // Formulaire modification
    document.getElementById('editUserForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const userId = document.getElementById('editUserId').value;
        
        fetch(`/dashboard/settings/users/${userId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                bootstrap.Modal.getInstance(document.getElementById('editUserModal')).hide();
                loadUsers();
                showAlert('Utilisateur modifié avec succès', 'success');
            } else {
                showAlert('Erreur: ' + data.message, 'danger');
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            showAlert('Erreur lors de la modification', 'danger');
        });
    });
}

// ===== FILTRES =====

function setupFilterListeners() {
    const searchInput = document.getElementById('searchInput');
    const roleFilter = document.getElementById('roleFilter');
    const statusFilter = document.getElementById('statusFilter');

    // Appliquer les filtres avec un délai pour la recherche
    let searchTimeout;
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(applyFilters, 300);
    });

    roleFilter.addEventListener('change', applyFilters);
    statusFilter.addEventListener('change', applyFilters);
}

function applyFilters() {
    const search = document.getElementById('searchInput').value.toLowerCase();
    const role = document.getElementById('roleFilter').value;
    const status = document.getElementById('statusFilter').value;

    let filteredUsers = allUsers.filter(user => {
        const matchesSearch = !search || 
            user.name.toLowerCase().includes(search) ||
            user.email.toLowerCase().includes(search);
        
        const matchesRole = !role || user.role_utilisateur === role;
        
        const matchesStatus = status === '' || user.est_actif.toString() === status;

        return matchesSearch && matchesRole && matchesStatus;
    });

    displayUsers(filteredUsers);
}

function resetFilters() {
    document.getElementById('searchInput').value = '';
    document.getElementById('roleFilter').value = '';
    document.getElementById('statusFilter').value = '';
    applyFilters();
}

// ===== ACTIONS GROUPÉES =====

function exportUsers() {
    showAlert('Fonction d\'export à implémenter', 'info');
}

// ===== UTILITAIRES =====

function showAlert(message, type = 'info') {
    // Créer une alerte Bootstrap temporaire
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
    alertDiv.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;

    document.body.appendChild(alertDiv);

    // Auto-supprimer après 5 secondes
    setTimeout(() => {
        if (alertDiv.parentNode) {
            alertDiv.remove();
        }
    }, 5000);
}

// Gestion des checkboxes (sélection multiple)
document.addEventListener('change', function(e) {
    if (e.target.id === 'selectAll') {
        const checkboxes = document.querySelectorAll('.user-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = e.target.checked;
        });
    } else if (e.target.classList.contains('user-checkbox')) {
        const selectAll = document.getElementById('selectAll');
        const checkboxes = document.querySelectorAll('.user-checkbox');
        const checkedCount = document.querySelectorAll('.user-checkbox:checked').length;
        
        selectAll.checked = checkedCount === checkboxes.length;
        selectAll.indeterminate = checkedCount > 0 && checkedCount < checkboxes.length;
    }
});
</script>
@endpush
