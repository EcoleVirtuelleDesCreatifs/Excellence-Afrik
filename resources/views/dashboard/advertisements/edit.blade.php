@extends('layouts.dashboard-ultra')

@section('title', 'Éditer la Publicité')

@section('content')
<div class="dashboard-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-edit me-2"></i>
                            Éditer: {{ $advertisement->title }}
                        </h5>
                        <a href="{{ route('dashboard.advertisements.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Retour
                        </a>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('dashboard.advertisements.update', $advertisement) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="title" class="form-label">Titre de la publicité *</label>
                                        <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                               id="title" name="title" value="{{ old('title', $advertisement->title) }}" required>
                                        @error('title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="url" class="form-label">URL de destination *</label>
                                        <input type="url" class="form-control @error('url') is-invalid @enderror" 
                                               id="url" name="url" value="{{ old('url', $advertisement->url) }}" required>
                                        @error('url')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="image" class="form-label">Image de la publicité</label>
                                        <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                               id="image" name="image" accept="image/*">
                                        @error('image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">Laissez vide pour conserver l'image actuelle</div>
                                        
                                        @if($advertisement->image)
                                            <div class="mt-2">
                                                <small class="text-muted">Image actuelle:</small><br>
                                                <img src="{{ asset('storage/' . $advertisement->image) }}" 
                                                     alt="Image actuelle" 
                                                     class="img-thumbnail mt-1" 
                                                     style="max-width: 200px; max-height: 100px;">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="status" class="form-label">Statut *</label>
                                        <select class="form-select @error('status') is-invalid @enderror" 
                                                id="status" name="status" required>
                                            <option value="active" {{ old('status', $advertisement->status) == 'active' ? 'selected' : '' }}>Actif</option>
                                            <option value="inactive" {{ old('status', $advertisement->status) == 'inactive' ? 'selected' : '' }}>Inactif</option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="page_type" class="form-label">Type de page *</label>
                                        <select class="form-select @error('page_type') is-invalid @enderror" 
                                                id="page_type" name="page_type" required>
                                            <option value="home" {{ old('page_type', $advertisement->page_type) == 'home' ? 'selected' : '' }}>Accueil</option>
                                            <option value="category" {{ old('page_type', $advertisement->page_type) == 'category' ? 'selected' : '' }}>Pages de catégories</option>
                                            <option value="article" {{ old('page_type', $advertisement->page_type) == 'article' ? 'selected' : '' }}>Pages d'articles</option>
                                            <option value="magazines" {{ old('page_type', $advertisement->page_type) == 'magazines' ? 'selected' : '' }}>Pages magazines</option>
                                            <option value="webtv" {{ old('page_type', $advertisement->page_type) == 'webtv' ? 'selected' : '' }}>Pages Web TV</option>
                                        </select>
                                        @error('page_type')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="category_slug" class="form-label">Catégorie spécifique</label>
                                        <input type="text" class="form-control @error('category_slug') is-invalid @enderror" 
                                               id="category_slug" name="category_slug" 
                                               value="{{ old('category_slug', $advertisement->category_slug) }}"
                                               placeholder="Laissez vide pour toutes les catégories">
                                        @error('category_slug')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">Slug de la catégorie (ex: economie-reelle, grands-genres)</div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="position_in_page" class="form-label">Position sur la page *</label>
                                        <select class="form-select @error('position_in_page') is-invalid @enderror" 
                                                id="position_in_page" name="position_in_page" required>
                                            <option value="top_banner" {{ old('position_in_page', $advertisement->position_in_page) == 'top_banner' ? 'selected' : '' }}>
                                                Bannière haute (730x90px)
                                            </option>
                                            <option value="sidebar" {{ old('position_in_page', $advertisement->position_in_page) == 'sidebar' ? 'selected' : '' }}>
                                                Barre latérale (300x250px)
                                            </option>
                                            <option value="middle" {{ old('position_in_page', $advertisement->position_in_page) == 'middle' ? 'selected' : '' }}>
                                                Milieu de page (728x90px)
                                            </option>
                                            <option value="bottom" {{ old('position_in_page', $advertisement->position_in_page) == 'bottom' ? 'selected' : '' }}>
                                                Bas de page (970x250px)
                                            </option>
                                        </select>
                                        @error('position_in_page')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">
                                            <i class="fas fa-info-circle text-info"></i>
                                            Changer la position redimensionnera automatiquement l'image si nécessaire
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="priority" class="form-label">Priorité</label>
                                        <select class="form-select" id="priority" name="priority">
                                            <option value="1" {{ old('priority', $advertisement->priority) == 1 ? 'selected' : '' }}>1 - Faible</option>
                                            <option value="5" {{ old('priority', $advertisement->priority) == 5 ? 'selected' : '' }}>5 - Normale</option>
                                            <option value="10" {{ old('priority', $advertisement->priority) == 10 ? 'selected' : '' }}>10 - Élevée</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="start_date" class="form-label">Date de début *</label>
                                        <input type="datetime-local" class="form-control @error('start_date') is-invalid @enderror" 
                                               id="start_date" name="start_date" 
                                               value="{{ old('start_date', $advertisement->start_date->format('Y-m-d\TH:i')) }}" required>
                                        @error('start_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="end_date" class="form-label">Date de fin *</label>
                                        <input type="datetime-local" class="form-control @error('end_date') is-invalid @enderror" 
                                               id="end_date" name="end_date" 
                                               value="{{ old('end_date', $advertisement->end_date->format('Y-m-d\TH:i')) }}" required>
                                        @error('end_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Statistiques</label>
                                        <div class="d-flex gap-4">
                                            <div>
                                                <strong>Clics totaux:</strong> 
                                                <span class="badge bg-primary">{{ $advertisement->click_count }}</span>
                                            </div>
                                            <div>
                                                <strong>URL trackable:</strong> 
                                                <a href="{{ $advertisement->getTrackableUrl() }}" target="_blank">
                                                    {{ $advertisement->getTrackableUrl() }}
                                                    <i class="fas fa-external-link-alt ms-1"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('dashboard.advertisements.show', $advertisement) }}" class="btn btn-info">
                                    <i class="fas fa-eye me-2"></i>Voir les détails
                                </a>
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save me-2"></i>Mettre à jour
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const positionSelect = document.getElementById('position_in_page');
    
    // Fonction pour créer ou mettre à jour l'aperçu des dimensions
    function updateDimensionsPreview() {
        const position = positionSelect.value;
        const dimensions = {
            'top_banner': '730x90px',
            'sidebar': '300x250px',
            'middle': '728x90px',
            'bottom': '970x250px'
        };
        
        // Trouver ou créer l'élément d'aperçu
        let preview = document.getElementById('dimensions-preview');
        if (!preview) {
            preview = document.createElement('div');
            preview.id = 'dimensions-preview';
            preview.className = 'mt-2 p-2 bg-light border rounded';
            positionSelect.closest('.mb-3').appendChild(preview);
        }
        
        if (position && dimensions[position]) {
            preview.innerHTML = `
                <small class="text-muted">
                    <i class="fas fa-ruler-combined text-primary"></i>
                    <strong>Dimensions:</strong> ${dimensions[position]}
                </small>
            `;
            preview.style.display = 'block';
        } else {
            preview.style.display = 'none';
        }
    }
    
    // Mettre à jour l'aperçu au chargement
    updateDimensionsPreview();
    
    // Mettre à jour l'aperçu quand la position change
    positionSelect.addEventListener('change', updateDimensionsPreview);
});
</script>
@endpush