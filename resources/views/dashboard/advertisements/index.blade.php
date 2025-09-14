@extends('layouts.dashboard-ultra')

@section('title', 'Gestion des Publicités')

@section('content')
<div class="dashboard-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-bullhorn me-2"></i>
                            Gestion des Publicités
                        </h5>
                        <a href="{{ route('dashboard.advertisements.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>
                            Nouvelle Publicité
                        </a>
                    </div>
                    <div class="card-body">
                        @if($advertisements->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Image</th>
                                            <th>Titre</th>
                                            <th>Page</th>
                                            <th>Position</th>
                                            <th>Statut</th>
                                            <th>Clics</th>
                                            <th>Impressions</th>
                                            <th>Période</th>
                                            <th>Priorité</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($advertisements as $ad)
                                            <tr>
                                                <td>
                                                    <img src="{{ asset('storage/' . $ad->image) }}" 
                                                         alt="{{ $ad->title }}" 
                                                         class="img-thumbnail"
                                                         style="width: 80px; height: 50px; object-fit: cover;">
                                                </td>
                                                <td>
                                                    <strong>{{ $ad->title }}</strong><br>
                                                    <small class="text-muted">{{ Str::limit($ad->url, 40) }}</small>
                                                </td>
                                                <td>
                                                    <span class="badge bg-info">{{ ucfirst($ad->page_type) }}</span>
                                                    @if($ad->category_slug)
                                                        <br><small class="text-muted">{{ $ad->category_slug }}</small>
                                                    @endif
                                                </td>
                                                <td>
                                                    <span class="badge bg-secondary">
                                                        {{ str_replace('_', ' ', ucfirst($ad->position_in_page)) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <form action="{{ route('dashboard.advertisements.toggle-status', $ad) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm {{ $ad->status === 'active' ? 'btn-success' : 'btn-danger' }}">
                                                            {{ $ad->status === 'active' ? 'Actif' : 'Inactif' }}
                                                        </button>
                                                    </form>
                                                </td>
                                                <td>
                                                    <span class="badge bg-primary">{{ $ad->click_count }}</span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-info">{{ $ad->impression_count ?? 0 }}</span>
                                                </td>
                                                <td>
                                                    <small>
                                                        <strong>Du:</strong> {{ $ad->start_date->format('d/m/Y') }}<br>
                                                        <strong>Au:</strong> {{ $ad->end_date->format('d/m/Y') }}
                                                        @if($ad->end_date < now())
                                                            <br><span class="text-danger">Expirée</span>
                                                        @elseif($ad->start_date > now())
                                                            <br><span class="text-warning">À venir</span>
                                                        @else
                                                            <br><span class="text-success">Active</span>
                                                        @endif
                                                    </small>
                                                </td>
                                                <td>
                                                    <span class="badge bg-warning">{{ $ad->priority }}</span>
                                                </td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <a href="{{ route('dashboard.advertisements.show', $ad) }}" 
                                                           class="btn btn-sm btn-info" title="Voir">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="{{ route('dashboard.advertisements.edit', $ad) }}" 
                                                           class="btn btn-sm btn-warning" title="Éditer">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <form action="{{ route('dashboard.advertisements.destroy', $ad) }}" 
                                                              method="POST" 
                                                              style="display: inline;"
                                                              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette publicité ?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger" title="Supprimer">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                            <!-- Pagination -->
                            <div class="d-flex justify-content-center">
                                {{ $advertisements->links() }}
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-bullhorn fa-3x text-muted mb-3"></i>
                                <h5>Aucune publicité trouvée</h5>
                                <p class="text-muted">Commencez par créer votre première publicité.</p>
                                <a href="{{ route('dashboard.advertisements.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>
                                    Créer une publicité
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.card {
    border: none;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}

.card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
}

.table th {
    border-top: none;
    font-weight: 600;
    color: #495057;
}

.img-thumbnail {
    border: 1px solid #dee2e6;
}

.btn-group .btn {
    border-radius: 0.25rem !important;
    margin-right: 2px;
}

.badge {
    font-size: 0.75rem;
}
</style>
@endpush