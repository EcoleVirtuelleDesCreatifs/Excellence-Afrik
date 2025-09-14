@extends('layouts.dashboard-ultra')

@section('title', 'Gestion des Flash Info')
@section('page_title', 'Flash Info')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-bolt text-warning me-2"></i>
                    Gestion des Flash Info
                </h5>
                <a href="{{ route('dashboard.flash-infos.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Nouvelle Flash Info
                </a>
            </div>

            <div class="card-body">
                @if($flashInfos->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="20%">Titre</th>
                                    <th width="10%">Statut</th>
                                    <th width="8%">Ordre</th>
                                    <th width="12%">Période</th>
                                    <th width="10%">Créé le</th>
                                    <th width="5%">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($flashInfos as $flashInfo)
                                    <tr>
                                        <td>{{ $flashInfo->id }}</td>
                                        <td>
                                            <strong>{{ Str::limit($flashInfo->titre, 50) }}</strong>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm toggle-statut-btn {{ $flashInfo->statut === 'actif' ? 'btn-success' : 'btn-secondary' }}"
                                                    data-id="{{ $flashInfo->id }}"
                                                    data-statut="{{ $flashInfo->statut }}">
                                                <i class="fas fa-{{ $flashInfo->statut === 'actif' ? 'check' : 'times' }}"></i>
                                                {{ ucfirst($flashInfo->statut) }}
                                            </button>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">{{ $flashInfo->ordre }}</span>
                                        </td>
                                        <td>
                                            @if($flashInfo->date_debut && $flashInfo->date_fin)
                                                <small>
                                                    {{ $flashInfo->date_debut->format('d/m/y') }}<br>
                                                    au {{ $flashInfo->date_fin->format('d/m/y') }}
                                                </small>
                                            @elseif($flashInfo->date_debut)
                                                <small>Depuis {{ $flashInfo->date_debut->format('d/m/y') }}</small>
                                            @elseif($flashInfo->date_fin)
                                                <small>Jusqu'au {{ $flashInfo->date_fin->format('d/m/y') }}</small>
                                            @else
                                                <small class="text-muted">Permanente</small>
                                            @endif
                                        </td>
                                        <td>
                                            <small>{{ $flashInfo->created_at->format('d/m/y H:i') }}</small>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('dashboard.flash-infos.edit', $flashInfo) }}"
                                                   class="btn btn-sm btn-outline-primary" title="Éditer">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button class="btn btn-sm btn-outline-danger delete-btn"
                                                        data-id="{{ $flashInfo->id }}"
                                                        data-titre="{{ $flashInfo->titre }}" title="Supprimer">
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
                    <div class="d-flex justify-content-center mt-4">
                        {{ $flashInfos->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-bolt fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Aucune Flash Info</h5>
                        <p class="text-muted">Commencez par créer votre première Flash Info.</p>
                        <a href="{{ route('dashboard.flash-infos.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Créer une Flash Info
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal de confirmation de suppression -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirmer la suppression</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Êtes-vous sûr de vouloir supprimer la Flash Info :</p>
                <p><strong id="deleteModalTitle"></strong></p>
                <p class="text-danger">Cette action est irréversible.</p>
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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle statut
    document.querySelectorAll('.toggle-statut-btn').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            const currentStatut = this.dataset.statut;

            fetch(`/dashboard/flash-infos/${id}/toggle-statut`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Mise à jour du bouton
                    const newStatut = data.nouveau_statut;
                    this.dataset.statut = newStatut;
                    this.className = `btn btn-sm toggle-statut-btn ${newStatut === 'actif' ? 'btn-success' : 'btn-secondary'}`;
                    this.innerHTML = `<i class="fas fa-${newStatut === 'actif' ? 'check' : 'times'}"></i> ${newStatut.charAt(0).toUpperCase() + newStatut.slice(1)}`;

                    showNotification(data.message, 'success');
                } else {
                    showNotification(data.message, 'danger');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Erreur lors de la mise à jour', 'danger');
            });
        });
    });

    // Suppression
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            const titre = this.dataset.titre;

            document.getElementById('deleteModalTitle').textContent = titre;
            document.getElementById('deleteForm').action = `/dashboard/flash-infos/${id}`;

            new bootstrap.Modal(document.getElementById('deleteModal')).show();
        });
    });
});
</script>
@endpush