@extends('layouts.dashboard-ultra')

@section('title', 'Gestion Newsletter')
@section('page_title', 'Newsletter')

@push('head')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('breadcrumbs')
    <li class="breadcrumb-item active">Newsletter</li>
@endsection

@section('content')
<!-- Modern Header Section -->
<div class="page-header-modern">
    <div class="header-content">
        <div class="header-icon">
            <i class="fas fa-envelope"></i>
        </div>
        <div class="header-text">
            <h1 class="header-title">Gestion Newsletter</h1>
            <p class="header-subtitle">Gérez vos abonnés newsletter et suivez les statistiques d'engagement</p>
            <div class="header-breadcrumb">
                <span class="breadcrumb-item"><i class="fas fa-home"></i> Dashboard</span>
                <span class="breadcrumb-separator">/</span>
                <span class="breadcrumb-item active">Newsletter</span>
            </div>
        </div>
    </div>
    <div class="header-actions">
        <button class="btn btn-outline-success" onclick="exportSubscribers()">
            <i class="fas fa-download"></i>
            <span>Exporter</span>
        </button>
        <button class="btn btn-primary" onclick="showCreateSubscriberModal()">
            <i class="fas fa-user-plus"></i>
            <span>Ajouter abonné</span>
        </button>
    </div>
</div>

<!-- Stats Cards -->
<div class="row g-4 mb-4">
    <div class="col-lg-3 col-md-6">
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(37, 99, 235, 0.1); color: var(--primary-color);">
                <i class="fas fa-envelope"></i>
            </div>
            <div class="stat-value" id="totalSubscribers">{{ $stats['total'] ?? 0 }}</div>
            <div class="stat-label">Total abonnés</div>
            <div class="stat-change positive">
                <i class="fas fa-arrow-up"></i> Newsletter
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6">
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(16, 185, 129, 0.1); color: var(--success-color);">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-value" id="activeSubscribers">{{ $stats['active'] ?? 0 }}</div>
            <div class="stat-label">Actifs</div>
            <div class="stat-change positive">
                <i class="fas fa-arrow-up"></i> Vérifiés
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6">
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(245, 158, 11, 0.1); color: var(--warning-color);">
                <i class="fas fa-crown"></i>
            </div>
            <div class="stat-value" id="premiumSubscribers">{{ $stats['premium'] ?? 0 }}</div>
            <div class="stat-label">Premium</div>
            <div class="stat-change neutral">
                <i class="fas fa-minus"></i> Spécial
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6">
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(99, 102, 241, 0.1); color: var(--info-color);">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="stat-value" id="verifiedSubscribers">{{ $stats['verified'] ?? 0 }}</div>
            <div class="stat-label">Vérifiés</div>
            <div class="stat-change positive">
                <i class="fas fa-arrow-up"></i> Email OK
            </div>
        </div>
    </div>
</div>

<!-- Filters Section -->
<div class="dashboard-card mb-4">
    <div class="card-body">
        <div class="row g-3 align-items-end">
            <div class="col-lg-4">
                <label class="form-label">Rechercher</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" class="form-control" placeholder="Email, nom..." id="searchInput" value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-lg-2">
                <label class="form-label">Source</label>
                <select class="form-select" id="sourceFilter">
                    <option value="">Toutes sources</option>
                    <option value="home" {{ request('source') == 'home' ? 'selected' : '' }}>Accueil</option>
                    <option value="magazines" {{ request('source') == 'magazines' ? 'selected' : '' }}>Magazines</option>
                    <option value="footer" {{ request('source') == 'footer' ? 'selected' : '' }}>Footer</option>
                    <option value="articles" {{ request('source') == 'articles' ? 'selected' : '' }}>Articles</option>
                    <option value="manual" {{ request('source') == 'manual' ? 'selected' : '' }}>Manuel</option>
                </select>
            </div>
            <div class="col-lg-2">
                <label class="form-label">Statut</label>
                <select class="form-select" id="statusFilter">
                    <option value="">Tous statuts</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Actif</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactif</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>En attente</option>
                </select>
            </div>
            <div class="col-lg-4">
                <label class="form-label">&nbsp;</label>
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

<!-- Subscribers Table -->
<div class="dashboard-card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">Liste des abonnés</h3>
        <div class="btn-group" role="group">
            <small class="text-muted align-self-center me-3" id="subscribersCount">
                @if($subscribers->total() > 0)
                    Affichage {{ $subscribers->firstItem() }}-{{ $subscribers->lastItem() }} sur {{ $subscribers->total() }} abonnés
                @else
                    Aucun abonné trouvé
                @endif
            </small>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0" id="subscribersTable">
                <thead class="table-light">
                    <tr>
                        <th>
                            <input type="checkbox" class="form-check-input" id="selectAll">
                        </th>
                        <th>Email</th>
                        <th>Nom</th>
                        <th>Source</th>
                        <th>Type</th>
                        <th>Statut</th>
                        <th>Date d'inscription</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="subscribersTableBody">
                    @forelse($subscribers as $subscriber)
                        <tr>
                            <td>
                                <input type="checkbox" class="form-check-input subscriber-checkbox" data-subscriber-id="{{ $subscriber->id }}">
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="subscriber-avatar me-3" style="background: linear-gradient(135deg, #667eea, #764ba2);">
                                        {{ strtoupper(substr($subscriber->email, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-semibold">{{ $subscriber->email }}</div>
                                        @if($subscriber->email_verified_at)
                                            <small class="text-success"><i class="fas fa-check-circle"></i> Vérifié</small>
                                        @else
                                            <small class="text-warning"><i class="fas fa-clock"></i> En attente</small>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>{{ $subscriber->name ?: '-' }}</td>
                            <td><span class="badge bg-info">{{ $subscriber->source_label }}</span></td>
                            <td>
                                @if($subscriber->is_premium)
                                    <span class="badge bg-warning"><i class="fas fa-crown"></i> Premium</span>
                                @else
                                    <span class="badge bg-secondary">Standard</span>
                                @endif
                            </td>
                            <td>
                                @if($subscriber->status === 'active')
                                    <span class="badge bg-success">Actif</span>
                                @elseif($subscriber->status === 'unsubscribed')
                                    <span class="badge bg-danger">Désabonné</span>
                                @else
                                    <span class="badge bg-warning">En attente</span>
                                @endif
                            </td>
                            <td>{{ $subscriber->subscribed_at ? $subscriber->subscribed_at->format('d/m/Y H:i') : '-' }}</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-outline-primary" onclick="editSubscriber({{ $subscriber->id }})" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-outline-info" onclick="viewSubscriber({{ $subscriber->id }})" title="Voir détails">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-outline-danger" onclick="deleteSubscriber({{ $subscriber->id }}, '{{ $subscriber->email }}')" title="Supprimer">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                <i class="fas fa-envelope-open-text fa-3x text-muted mb-3"></i>
                                <p class="text-muted mb-0">Aucun abonné trouvé</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($subscribers->hasPages())
        <div class="card-footer">
            {{ $subscribers->links() }}
        </div>
    @endif
</div>

<!-- Modal Créer Abonné -->
<div class="modal fade" id="createSubscriberModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ajouter un abonné</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="createSubscriberForm">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Adresse email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nom (optionnel)</label>
                        <input type="text" class="form-control" name="name">
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="is_premium" id="createPremium">
                        <label class="form-check-label" for="createPremium">
                            <i class="fas fa-crown text-warning"></i> Abonnement premium
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Ajouter
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Modifier Abonné -->
<div class="modal fade" id="editSubscriberModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifier l'abonné</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editSubscriberForm">
                @csrf
                <input type="hidden" name="subscriber_id" id="editSubscriberId">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Adresse email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" name="email" id="editSubscriberEmail" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nom</label>
                        <input type="text" class="form-control" name="name" id="editSubscriberName">
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="is_premium" id="editPremium">
                                <label class="form-check-label" for="editPremium">
                                    <i class="fas fa-crown text-warning"></i> Premium
                                </label>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="is_active" id="editActive">
                                <label class="form-check-label" for="editActive">
                                    <i class="fas fa-check-circle text-success"></i> Actif
                                </label>
                            </div>
                        </div>
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

<!-- Modal Détails Abonné -->
<div class="modal fade" id="subscriberModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Détails de l'abonné</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4 text-center">
                        <div class="subscriber-avatar-large mb-3" id="viewSubscriberAvatar">
                            ?
                        </div>
                        <h5 id="viewSubscriberEmail">-</h5>
                        <p class="text-muted" id="viewSubscriberSource">-</p>
                    </div>
                    <div class="col-md-8">
                        <div class="subscriber-details">
                            <div class="detail-item">
                                <strong>Nom:</strong> <span id="viewSubscriberName">-</span>
                            </div>
                            <div class="detail-item">
                                <strong>Type:</strong> <span id="viewSubscriberType">-</span>
                            </div>
                            <div class="detail-item">
                                <strong>Statut:</strong> <span id="viewSubscriberStatus">-</span>
                            </div>
                            <div class="detail-item">
                                <strong>Date d'inscription:</strong> <span id="viewSubscriberCreated">-</span>
                            </div>
                            <div class="detail-item">
                                <strong>Email vérifié:</strong> <span id="viewSubscriberVerified">-</span>
                            </div>
                            <div class="detail-item">
                                <strong>Désabonnement:</strong> <span id="viewSubscriberUnsubscribed">-</span>
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
@endsection

@push('styles')
<style>
/* Header moderne */
.page-header-modern {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
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

.header-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #2563eb, #3b82f6);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
    flex-shrink: 0;
}

.header-text {
    min-width: 0;
}

.header-title {
    font-size: 1.75rem;
    font-weight: 700;
    color: #1f2937;
    margin: 0 0 0.25rem 0;
    line-height: 1.2;
}

.header-subtitle {
    color: #6b7280;
    margin: 0 0 0.5rem 0;
    font-size: 1rem;
    line-height: 1.4;
}

.header-breadcrumb {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    color: #6b7280;
}

.breadcrumb-item {
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.breadcrumb-item.active {
    color: #2563eb;
    font-weight: 500;
}

.breadcrumb-separator {
    color: #d1d5db;
    font-weight: 300;
}

.header-actions {
    display: flex;
    gap: 0.75rem;
    align-items: center;
    flex-shrink: 0;
}

.header-actions .btn {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-weight: 500;
    padding: 0.625rem 1.25rem;
    border-radius: 8px;
    transition: all 0.2s ease;
}

.header-actions .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.header-actions .btn i {
    font-size: 0.875rem;
}

/* Responsive */
@media (max-width: 768px) {
    .page-header-modern {
        padding: 1.5rem;
        flex-direction: column;
        align-items: stretch;
    }
    
    .header-content {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }
    
    .header-title {
        font-size: 1.5rem;
    }
    
    .header-actions {
        justify-content: flex-end;
        margin-top: 1rem;
    }
    
    .header-actions .btn span {
        display: none;
    }
}

.subscriber-avatar {
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

.subscriber-avatar-large {
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
    background: linear-gradient(135deg, #667eea, #764ba2);
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
let allSubscribers = [];

// Charger les données au chargement de la page
document.addEventListener('DOMContentLoaded', function() {
    // Event listeners pour les formulaires
    setupFormListeners();
    
    // Event listeners pour les filtres
    setupFilterListeners();
    
    // Event listeners pour les checkboxes
    setupCheckboxListeners();
});

// ===== GESTION DES MODALES =====

function showCreateSubscriberModal() {
    document.getElementById('createSubscriberForm').reset();
    const modal = new bootstrap.Modal(document.getElementById('createSubscriberModal'));
    modal.show();
}

function editSubscriber(subscriberId) {
    fetch(`/dashboard/newsletter/${subscriberId}`)
        .then(response => response.json())
        .then(subscriber => {
            document.getElementById('editSubscriberId').value = subscriber.id;
            document.getElementById('editSubscriberEmail').value = subscriber.email;
            document.getElementById('editSubscriberName').value = subscriber.name || '';
            document.getElementById('editPremium').checked = subscriber.is_premium;
            document.getElementById('editActive').checked = subscriber.is_active;

            const modal = new bootstrap.Modal(document.getElementById('editSubscriberModal'));
            modal.show();
        })
        .catch(error => {
            console.error('Erreur:', error);
            showAlert('Erreur lors du chargement des données', 'danger');
        });
}

function viewSubscriber(subscriberId) {
    fetch(`/dashboard/newsletter/${subscriberId}`)
        .then(response => response.json())
        .then(subscriber => {
            const initials = subscriber.email ? subscriber.email.charAt(0).toUpperCase() : '?';
            
            document.getElementById('viewSubscriberAvatar').textContent = initials;
            document.getElementById('viewSubscriberEmail').textContent = subscriber.email;
            document.getElementById('viewSubscriberName').textContent = subscriber.name || 'Non renseigné';
            document.getElementById('viewSubscriberSource').textContent = subscriber.source_label;
            
            const typeHtml = subscriber.is_premium 
                ? '<span class="badge bg-warning"><i class="fas fa-crown"></i> Premium</span>'
                : '<span class="badge bg-secondary">Standard</span>';
            document.getElementById('viewSubscriberType').innerHTML = typeHtml;
            
            let statusHtml = '';
            switch(subscriber.status) {
                case 'active':
                    statusHtml = '<span class="badge bg-success">Actif</span>';
                    break;
                case 'unsubscribed':
                    statusHtml = '<span class="badge bg-danger">Désabonné</span>';
                    break;
                default:
                    statusHtml = '<span class="badge bg-warning">En attente</span>';
            }
            document.getElementById('viewSubscriberStatus').innerHTML = statusHtml;
            
            document.getElementById('viewSubscriberCreated').textContent = subscriber.subscribed_at || 'Non disponible';
            document.getElementById('viewSubscriberVerified').textContent = subscriber.email_verified_at || 'Non vérifié';
            document.getElementById('viewSubscriberUnsubscribed').textContent = subscriber.unsubscribed_at || '-';

            const modal = new bootstrap.Modal(document.getElementById('subscriberModal'));
            modal.show();
        })
        .catch(error => {
            console.error('Erreur:', error);
            showAlert('Erreur lors du chargement des détails', 'danger');
        });
}

function deleteSubscriber(subscriberId, email) {
    if (!confirm(`Êtes-vous sûr de vouloir supprimer l'abonné "${email}" ?`)) {
        return;
    }

    fetch(`/dashboard/newsletter/${subscriberId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
            showAlert('Abonné supprimé avec succès', 'success');
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
    document.getElementById('createSubscriberForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        fetch('/dashboard/newsletter', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                bootstrap.Modal.getInstance(document.getElementById('createSubscriberModal')).hide();
                location.reload();
                showAlert('Abonné ajouté avec succès', 'success');
            } else {
                showAlert('Erreur: ' + data.message, 'danger');
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            showAlert('Erreur lors de l\'ajout', 'danger');
        });
    });

    // Formulaire modification
    document.getElementById('editSubscriberForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const subscriberId = document.getElementById('editSubscriberId').value;
        
        fetch(`/dashboard/newsletter/${subscriberId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                bootstrap.Modal.getInstance(document.getElementById('editSubscriberModal')).hide();
                location.reload();
                showAlert('Abonné modifié avec succès', 'success');
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
    const sourceFilter = document.getElementById('sourceFilter');
    const statusFilter = document.getElementById('statusFilter');

    // Appliquer les filtres avec un délai pour la recherche
    let searchTimeout;
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(applyFilters, 300);
    });

    sourceFilter.addEventListener('change', applyFilters);
    statusFilter.addEventListener('change', applyFilters);
}

function applyFilters() {
    const search = document.getElementById('searchInput').value;
    const source = document.getElementById('sourceFilter').value;
    const status = document.getElementById('statusFilter').value;

    const params = new URLSearchParams();
    if (search) params.append('search', search);
    if (source) params.append('source', source);
    if (status) params.append('status', status);

    const url = new URL(window.location);
    url.search = params.toString();
    window.location = url;
}

function resetFilters() {
    window.location = '/dashboard/newsletter';
}

function exportSubscribers() {
    const source = document.getElementById('sourceFilter').value;
    const status = document.getElementById('statusFilter').value;

    const params = new URLSearchParams();
    if (source) params.append('source', source);
    if (status) params.append('status', status);

    const url = '/dashboard/newsletter/export/csv?' + params.toString();
    window.open(url, '_blank');
}

// ===== CHECKBOXES =====

function setupCheckboxListeners() {
    document.addEventListener('change', function(e) {
        if (e.target.id === 'selectAll') {
            const checkboxes = document.querySelectorAll('.subscriber-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = e.target.checked;
            });
        } else if (e.target.classList.contains('subscriber-checkbox')) {
            const selectAll = document.getElementById('selectAll');
            const checkboxes = document.querySelectorAll('.subscriber-checkbox');
            const checkedCount = document.querySelectorAll('.subscriber-checkbox:checked').length;
            
            selectAll.checked = checkedCount === checkboxes.length;
            selectAll.indeterminate = checkedCount > 0 && checkedCount < checkboxes.length;
        }
    });
}

// ===== UTILITAIRES =====

function showAlert(message, type = 'info') {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
    alertDiv.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;

    document.body.appendChild(alertDiv);

    setTimeout(() => {
        if (alertDiv.parentNode) {
            alertDiv.remove();
        }
    }, 5000);
}
</script>
@endpush