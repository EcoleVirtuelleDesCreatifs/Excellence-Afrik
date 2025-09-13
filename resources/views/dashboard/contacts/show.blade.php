@extends('layouts.dashboard-ultra')

@section('title', 'Message de Contact - ' . $contact->nom)
@section('page_title', 'Détail du Message')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8">
            <!-- Message Principal -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-envelope-open me-2"></i>
                            {{ $contact->objet }}
                        </h5>
                        <span class="badge bg-{{ $contact->status_badge }} fs-6">
                            {{ $contact->status_label }}
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Informations de l'expéditeur -->
                    <div class="row mb-4">
                        <div class="col-sm-6">
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-user text-primary me-2"></i>
                                <strong>De:</strong>
                                <span class="ms-2">{{ $contact->nom }}</span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-envelope text-primary me-2"></i>
                                <strong>Email:</strong>
                                <a href="mailto:{{ $contact->email }}" class="ms-2 text-decoration-none">
                                    {{ $contact->email }}
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Date et informations -->
                    <div class="row mb-4 text-muted small">
                        <div class="col-sm-4">
                            <i class="fas fa-calendar me-1"></i>
                            Reçu le: {{ $contact->created_at->format('d/m/Y à H:i') }}
                        </div>
                        @if($contact->date_lecture)
                        <div class="col-sm-4">
                            <i class="fas fa-eye me-1"></i>
                            Lu le: {{ $contact->date_lecture->format('d/m/Y à H:i') }}
                        </div>
                        @endif
                        @if($contact->ip_address)
                        <div class="col-sm-4">
                            <i class="fas fa-globe me-1"></i>
                            IP: {{ $contact->ip_address }}
                        </div>
                        @endif
                    </div>

                    <hr>

                    <!-- Message -->
                    <div class="message-content">
                        <h6 class="fw-bold mb-3">Message:</h6>
                        <div class="bg-light p-3 rounded">
                            {!! nl2br(e($contact->message)) !!}
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-light">
                    <div class="d-flex gap-2">
                        <a href="mailto:{{ $contact->email }}?subject=Re: {{ urlencode($contact->objet) }}" 
                           class="btn btn-primary">
                            <i class="fas fa-reply me-2"></i>Répondre par email
                        </a>
                        
                        @if($contact->statut !== 'traite')
                        <button type="button" class="btn btn-success" onclick="updateStatus('traite')">
                            <i class="fas fa-check me-2"></i>Marquer comme traité
                        </button>
                        @endif
                        
                        @if($contact->statut !== 'archive')
                        <button type="button" class="btn btn-warning" onclick="updateStatus('archive')">
                            <i class="fas fa-archive me-2"></i>Archiver
                        </button>
                        @endif
                        
                        <button type="button" class="btn btn-danger" onclick="deleteContact()">
                            <i class="fas fa-trash me-2"></i>Supprimer
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Actions rapides -->
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-tools me-2"></i>Actions rapides
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-outline-primary btn-sm" onclick="updateStatus('lu')">
                            <i class="fas fa-eye me-2"></i>Marquer comme lu
                        </button>
                        <button type="button" class="btn btn-outline-success btn-sm" onclick="updateStatus('traite')">
                            <i class="fas fa-check me-2"></i>Marquer comme traité
                        </button>
                        <button type="button" class="btn btn-outline-warning btn-sm" onclick="updateStatus('archive')">
                            <i class="fas fa-archive me-2"></i>Archiver
                        </button>
                        <hr>
                        <a href="{{ route('dashboard.contacts.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-arrow-left me-2"></i>Retour à la liste
                        </a>
                    </div>
                </div>
            </div>

            <!-- Notes administrateur -->
            <div class="card shadow-sm">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-sticky-note me-2"></i>Notes administrateur
                    </h6>
                </div>
                <div class="card-body">
                    <form id="notesForm">
                        @csrf
                        <div class="mb-3">
                            <textarea class="form-control" name="notes_admin" rows="5" 
                                      placeholder="Ajoutez vos notes privées sur ce contact...">{{ $contact->notes_admin }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm w-100">
                            <i class="fas fa-save me-2"></i>Sauvegarder les notes
                        </button>
                    </form>
                </div>
            </div>

            <!-- Informations techniques -->
            @if($contact->user_agent || $contact->ip_address)
            <div class="card shadow-sm mt-3">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2"></i>Informations techniques
                    </h6>
                </div>
                <div class="card-body">
                    @if($contact->ip_address)
                    <div class="mb-2">
                        <strong>Adresse IP:</strong>
                        <span class="text-muted">{{ $contact->ip_address }}</span>
                    </div>
                    @endif
                    @if($contact->user_agent)
                    <div class="mb-2">
                        <strong>Navigateur:</strong>
                        <small class="text-muted d-block">{{ $contact->user_agent }}</small>
                    </div>
                    @endif
                </div>
            </div>
            @endif
        </div>
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
                Êtes-vous sûr de vouloir supprimer ce message de contact ? Cette action est irréversible.
                <br><br>
                <strong>De:</strong> {{ $contact->nom }} ({{ $contact->email }})<br>
                <strong>Objet:</strong> {{ $contact->objet }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <form action="{{ route('dashboard.contacts.destroy', $contact) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Supprimer définitivement</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.message-content {
    font-size: 1rem;
    line-height: 1.6;
}

.card {
    border: none;
    border-radius: 10px;
}

.card-header {
    border-radius: 10px 10px 0 0 !important;
    border-bottom: 1px solid rgba(0,0,0,0.1);
}

.btn-group .btn {
    border-radius: 6px;
    margin-right: 5px;
}

.badge {
    font-size: 0.75em;
    padding: 0.5em 0.75em;
}

@media (max-width: 768px) {
    .d-flex.gap-2 {
        flex-direction: column;
    }
    
    .d-flex.gap-2 .btn {
        margin-bottom: 0.5rem;
    }
}
</style>
@endpush

@push('scripts')
<script>
function updateStatus(newStatus) {
    fetch(`{{ route('dashboard.contacts.update', $contact) }}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            statut: newStatus
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Actualiser la page pour refléter les changements
            location.reload();
        } else {
            alert('Erreur lors de la mise à jour du statut');
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        alert('Erreur lors de la mise à jour du statut');
    });
}

function deleteContact() {
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    deleteModal.show();
}

// Gestion des notes administrateur
document.getElementById('notesForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const notesData = {
        notes_admin: formData.get('notes_admin')
    };
    
    fetch(`{{ route('dashboard.contacts.update', $contact) }}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(notesData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Afficher un message de succès
            const alert = document.createElement('div');
            alert.className = 'alert alert-success alert-dismissible fade show';
            alert.innerHTML = `
                <i class="fas fa-check me-2"></i>Notes sauvegardées avec succès
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            
            this.insertBefore(alert, this.firstChild);
            
            // Supprimer l'alerte après 3 secondes
            setTimeout(() => {
                alert.remove();
            }, 3000);
        } else {
            alert('Erreur lors de la sauvegarde des notes');
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        alert('Erreur lors de la sauvegarde des notes');
    });
});
</script>
@endpush