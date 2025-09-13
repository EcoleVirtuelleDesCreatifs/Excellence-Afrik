@extends('layouts.dashboard-ultra')

@section('title', 'Messages de Contact')
@section('page_title', 'Messages de Contact')

@section('content')
<!-- Modern Header Section -->
<div class="page-header-modern">
    <div class="header-content">
        <div class="header-icon">
            <i class="fas fa-message"></i>
        </div>
        <div class="header-text">
            <h1 class="header-title">Messages de Contact</h1>
            <p class="header-subtitle">Gérez tous les messages reçus via le formulaire de contact</p>
            <div class="header-breadcrumb">
                <span class="breadcrumb-item"><i class="fas fa-home"></i> Dashboard</span>
                <span class="breadcrumb-separator">/</span>
                <span class="breadcrumb-item active">Messages de Contact</span>
            </div>
        </div>
    </div>
    <div class="header-actions">
        <form action="{{ route('dashboard.contacts.export') }}" method="GET" style="display: inline;">
            @if(request('statut'))
                <input type="hidden" name="statut" value="{{ request('statut') }}">
            @endif
            @if(request('search'))
                <input type="hidden" name="search" value="{{ request('search') }}">
            @endif
            <button type="submit" class="btn btn-outline-success">
                <i class="fas fa-download"></i>
                <span>Exporter CSV</span>
            </button>
        </form>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-center border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-center">
                    <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                        <i class="fas fa-envelope text-primary fs-4"></i>
                    </div>
                    <div>
                        <h3 class="card-title mb-0">{{ $stats['total'] }}</h3>
                        <p class="card-text text-muted">Total</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-center">
                    <div class="bg-success bg-opacity-10 rounded-circle p-3 me-3">
                        <i class="fas fa-star text-success fs-4"></i>
                    </div>
                    <div>
                        <h3 class="card-title mb-0 text-success">{{ $stats['nouveaux'] }}</h3>
                        <p class="card-text text-muted">Nouveaux</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-center">
                    <div class="bg-info bg-opacity-10 rounded-circle p-3 me-3">
                        <i class="fas fa-eye text-info fs-4"></i>
                    </div>
                    <div>
                        <h3 class="card-title mb-0 text-info">{{ $stats['lus'] }}</h3>
                        <p class="card-text text-muted">Lus</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-center">
                    <div class="bg-warning bg-opacity-10 rounded-circle p-3 me-3">
                        <i class="fas fa-check text-warning fs-4"></i>
                    </div>
                    <div>
                        <h3 class="card-title mb-0 text-warning">{{ $stats['traites'] }}</h3>
                        <p class="card-text text-muted">Traités</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filters Section -->
<div class="dashboard-card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('dashboard.contacts.index') }}">
            <div class="row g-3 align-items-end">
                <div class="col-lg-4">
                    <label class="form-label">Rechercher</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" class="form-control" name="search" 
                               placeholder="Nom, email, objet..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-lg-3">
                    <label class="form-label">Statut</label>
                    <select class="form-select" name="statut">
                        <option value="">Tous les statuts</option>
                        <option value="nouveau" {{ request('statut') == 'nouveau' ? 'selected' : '' }}>Nouveaux</option>
                        <option value="lu" {{ request('statut') == 'lu' ? 'selected' : '' }}>Lus</option>
                        <option value="traite" {{ request('statut') == 'traite' ? 'selected' : '' }}>Traités</option>
                        <option value="archive" {{ request('statut') == 'archive' ? 'selected' : '' }}>Archivés</option>
                    </select>
                </div>
                <div class="col-lg-5">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-filter me-1"></i>Filtrer
                        </button>
                        <a href="{{ route('dashboard.contacts.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-undo me-1"></i>Reset
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Bulk Actions -->
@if($contacts->count() > 0)
<div class="mb-3">
    <form id="bulkActionForm" action="{{ route('dashboard.contacts.bulk-action') }}" method="POST">
        @csrf
        <div class="d-flex align-items-center gap-3">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="selectAll">
                <label class="form-check-label" for="selectAll">
                    Tout sélectionner
                </label>
            </div>
            <select class="form-select" name="action" style="width: auto;" required>
                <option value="">Actions groupées...</option>
                <option value="marquer_lu">Marquer comme lu</option>
                <option value="marquer_traite">Marquer comme traité</option>
                <option value="archiver">Archiver</option>
                <option value="supprimer">Supprimer</option>
            </select>
            <button type="submit" class="btn btn-outline-primary" id="bulkActionBtn" disabled>
                <i class="fas fa-cogs"></i> Appliquer
            </button>
        </div>
    </form>
</div>
@endif

<!-- Contacts Table -->
<div class="dashboard-card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-list"></i>
            Liste des Messages
        </h3>
        <div class="card-badge">{{ $contacts->total() }} messages</div>
    </div>
    <div class="card-body p-0">
        @if($contacts->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="40">
                                <input type="checkbox" class="form-check-input" id="selectAllTable">
                            </th>
                            <th>Contact</th>
                            <th>Objet</th>
                            <th>Message</th>
                            <th>Statut</th>
                            <th>Date</th>
                            <th width="120">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($contacts as $contact)
                        <tr class="{{ $contact->statut === 'nouveau' ? 'table-warning' : '' }}">
                            <td>
                                <input type="checkbox" class="form-check-input contact-checkbox" 
                                       name="contact_ids[]" value="{{ $contact->id }}">
                            </td>
                            <td>
                                <div>
                                    <strong>{{ $contact->nom }}</strong>
                                    <br>
                                    <small class="text-muted">{{ $contact->email }}</small>
                                </div>
                            </td>
                            <td>
                                <span class="text-truncate d-inline-block" style="max-width: 200px;" 
                                      title="{{ $contact->objet }}">
                                    {{ $contact->objet }}
                                </span>
                            </td>
                            <td>
                                <span class="text-truncate d-inline-block" style="max-width: 250px;" 
                                      title="{{ $contact->message }}">
                                    {{ Str::limit($contact->message, 100) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-{{ $contact->status_badge }}">
                                    {{ $contact->status_label }}
                                </span>
                            </td>
                            <td>
                                <div>
                                    {{ $contact->created_at->format('d/m/Y') }}
                                    <br>
                                    <small class="text-muted">{{ $contact->created_at->format('H:i') }}</small>
                                </div>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('dashboard.contacts.show', $contact) }}" 
                                       class="btn btn-sm btn-outline-primary" title="Voir">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-outline-danger" 
                                            onclick="deleteContact({{ $contact->id }})" title="Supprimer">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="card-footer">
                {{ $contacts->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-inbox fs-1 text-muted mb-3"></i>
                <h4>Aucun message trouvé</h4>
                <p class="text-muted">
                    @if(request('search') || request('statut'))
                        Aucun message ne correspond à vos critères de recherche.
                    @else
                        Aucun message de contact n'a encore été reçu.
                    @endif
                </p>
            </div>
        @endif
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmer la suppression</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                Êtes-vous sûr de vouloir supprimer ce message ? Cette action est irréversible.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Supprimer</button>
                </form>
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
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gestion de la sélection multiple
    const selectAll = document.getElementById('selectAll');
    const selectAllTable = document.getElementById('selectAllTable');
    const checkboxes = document.querySelectorAll('.contact-checkbox');
    const bulkActionBtn = document.getElementById('bulkActionBtn');
    const bulkActionForm = document.getElementById('bulkActionForm');

    function updateBulkActionButton() {
        const checkedBoxes = document.querySelectorAll('.contact-checkbox:checked');
        bulkActionBtn.disabled = checkedBoxes.length === 0;
    }

    function updateSelectAllState() {
        const checkedBoxes = document.querySelectorAll('.contact-checkbox:checked');
        const allCheckboxes = document.querySelectorAll('.contact-checkbox');
        
        if (checkedBoxes.length === 0) {
            selectAll.indeterminate = false;
            selectAll.checked = false;
            selectAllTable.indeterminate = false;
            selectAllTable.checked = false;
        } else if (checkedBoxes.length === allCheckboxes.length) {
            selectAll.indeterminate = false;
            selectAll.checked = true;
            selectAllTable.indeterminate = false;
            selectAllTable.checked = true;
        } else {
            selectAll.indeterminate = true;
            selectAllTable.indeterminate = true;
        }
    }

    [selectAll, selectAllTable].forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            checkboxes.forEach(cb => cb.checked = this.checked);
            updateBulkActionButton();
            updateSelectAllState();
        });
    });

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateBulkActionButton();
            updateSelectAllState();
        });
    });

    // Soumission du formulaire d'actions groupées
    if (bulkActionForm) {
        bulkActionForm.addEventListener('submit', function(e) {
            const checkedBoxes = document.querySelectorAll('.contact-checkbox:checked');
            
            // Ajouter les IDs sélectionnés au formulaire
            checkedBoxes.forEach(checkbox => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'contact_ids[]';
                input.value = checkbox.value;
                this.appendChild(input);
            });
        });
    }

    // État initial
    updateBulkActionButton();
    updateSelectAllState();
});

function deleteContact(contactId) {
    const deleteForm = document.getElementById('deleteForm');
    deleteForm.action = '/dashboard/contacts/' + contactId;
    
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    deleteModal.show();
}
</script>
@endpush