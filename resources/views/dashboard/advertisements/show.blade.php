@extends('layouts.dashboard-ultra')

@section('title', 'Détails de la Publicité')

@section('content')
<div class="dashboard-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-bullhorn me-2"></i>
                            {{ $advertisement->title }}
                        </h5>
                        <div>
                            <a href="{{ route('dashboard.advertisements.edit', $advertisement) }}" class="btn btn-warning">
                                <i class="fas fa-edit me-2"></i>Éditer
                            </a>
                            <a href="{{ route('dashboard.advertisements.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Retour
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <h6>Aperçu de la publicité</h6>
                                    <img src="{{ asset('storage/' . $advertisement->image) }}" 
                                         alt="{{ $advertisement->title }}" 
                                         class="img-fluid border rounded"
                                         style="max-height: 300px;">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <strong>Statut:</strong>
                                            <span class="badge {{ $advertisement->status === 'active' ? 'bg-success' : 'bg-danger' }}">
                                                {{ $advertisement->status === 'active' ? 'Actif' : 'Inactif' }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <strong>Priorité:</strong>
                                            <span class="badge bg-warning">{{ $advertisement->priority }}</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <strong>Type de page:</strong>
                                            <span class="badge bg-info">{{ ucfirst($advertisement->page_type) }}</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <strong>Position:</strong>
                                            <span class="badge bg-secondary">
                                                {{ str_replace('_', ' ', ucfirst($advertisement->position_in_page)) }}
                                            </span>
                                        </div>
                                    </div>
                                    @if($advertisement->category_slug)
                                        <div class="col-12">
                                            <div class="mb-3">
                                                <strong>Catégorie:</strong>
                                                <span class="badge bg-primary">{{ $advertisement->category_slug }}</span>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <hr>
                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="text-center">
                                    <h3 class="text-primary">{{ $advertisement->click_count }}</h3>
                                    <small class="text-muted">Clics totaux</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="text-center">
                                    <h5>{{ $advertisement->start_date->format('d/m/Y H:i') }}</h5>
                                    <small class="text-muted">Date de début</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="text-center">
                                    <h5>{{ $advertisement->end_date->format('d/m/Y H:i') }}</h5>
                                    <small class="text-muted">Date de fin</small>
                                </div>
                            </div>
                        </div>
                        
                        <hr>
                        
                        <div class="row">
                            <div class="col-12">
                                <h6>URL de destination</h6>
                                <a href="{{ $advertisement->url }}" target="_blank" class="text-primary">
                                    {{ $advertisement->url }}
                                    <i class="fas fa-external-link-alt ms-1"></i>
                                </a>
                            </div>
                        </div>
                        
                        <hr>
                        
                        <div class="row">
                            <div class="col-12">
                                <h6>URL trackable</h6>
                                <div class="input-group">
                                    <input type="text" class="form-control" value="{{ $advertisement->getTrackableUrl() }}" readonly>
                                    <button class="btn btn-outline-secondary" type="button" onclick="copyToClipboard('{{ $advertisement->getTrackableUrl() }}')">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                </div>
                                <small class="text-muted">Utilisez cette URL pour tracker les clics sur la publicité</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        alert('URL copiée dans le presse-papiers !');
    });
}
</script>
@endpush