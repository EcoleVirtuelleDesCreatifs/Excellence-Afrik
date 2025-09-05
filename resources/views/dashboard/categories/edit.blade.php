@extends('layouts.dashboard-ultra')

@section('title', 'Modifier la Catégorie')

@section('content')
<div class="main-content">
    <!-- Header Section -->
    <div class="content-header" style="background: linear-gradient(135deg, #000000 0%, #1a1a1a 100%); padding: 2rem; margin-bottom: 2rem; border-radius: 15px;">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h3 mb-2" style="color: #D4AF37; font-weight: 700;">
                    <i class="fas fa-edit me-2"></i>Modifier la Catégorie
                </h1>
                <p class="text-light mb-0 opacity-75">
                    Modifiez les informations de la catégorie "{{ $category->name }}"
                </p>
            </div>
            <div>
                <a href="{{ route('dashboard.categories.index') }}" class="btn btn-outline-light">
                    <i class="fas fa-arrow-left me-2"></i>Retour à la liste
                </a>
            </div>
        </div>
    </div>

    <!-- Edit Form -->
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-lg" style="border-radius: 20px; overflow: hidden;">
                <div class="card-header bg-gradient text-white text-center py-4" style="background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);">
                    <h4 class="mb-0" style="font-weight: 600;">
                        <i class="fas fa-edit me-2"></i>Formulaire de Modification
                    </h4>
                </div>

                <div class="card-body p-5">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Erreur !</strong> Veuillez corriger les erreurs suivantes :
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('dashboard.categories.update', $category->id) }}" method="POST" id="editCategoryForm">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <!-- Nom de la catégorie -->
                            <div class="col-md-6 mb-4">
                                <label for="name" class="form-label" style="font-weight: bold; color: #2c3e50;">
                                    <i class="fas fa-tag me-2 text-primary"></i>Nom de la catégorie *
                                </label>
                                <input type="text" 
                                       class="form-control form-control-lg @error('name') is-invalid @enderror" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name', $category->name) }}"
                                       placeholder="Ex: Grand genres"
                                       required
                                       style="border-radius: 12px; border: 2px solid #e9ecef; padding: 15px;">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Slug (généré automatiquement) -->
                            <div class="col-md-6 mb-4">
                                <label for="slug" class="form-label" style="font-weight: bold; color: #2c3e50;">
                                    <i class="fas fa-link me-2 text-info"></i>Slug URL
                                </label>
                                <input type="text" 
                                       class="form-control form-control-lg" 
                                       id="slug" 
                                       name="slug"
                                       value="{{ old('slug', $category->slug) }}"
                                       readonly
                                       style="border-radius: 12px; border: 2px solid #e9ecef; padding: 15px; background-color: #f8f9fa;">
                                <small class="text-muted">
                                    <i class="fas fa-info-circle me-1"></i>Généré automatiquement à partir du nom
                                </small>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <label for="description" class="form-label" style="font-weight: bold; color: #2c3e50;">
                                <i class="fas fa-align-left me-2 text-success"></i>Description
                            </label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" 
                                      name="description" 
                                      rows="4"
                                      placeholder="Décrivez brièvement cette catégorie..."
                                      style="border-radius: 12px; border: 2px solid #e9ecef; padding: 15px; resize: vertical;">{{ old('description', $category->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <!-- Catégorie parente -->
                            <div class="col-md-6 mb-4">
                                <label for="parent_id" class="form-label" style="font-weight: bold; color: #2c3e50;">
                                    <i class="fas fa-sitemap me-2 text-warning"></i>Catégorie parente
                                </label>
                                <select class="form-select form-select-lg @error('parent_id') is-invalid @enderror" 
                                        id="parent_id" 
                                        name="parent_id"
                                        style="border-radius: 12px; border: 2px solid #e9ecef; padding: 15px;">
                                    <option value="">Aucune (catégorie principale)</option>
                                    <option value="1" {{ old('parent_id', $category->parent_id) == 1 ? 'selected' : '' }}>PORTRAITS</option>
                                    <option value="2" {{ old('parent_id', $category->parent_id) == 2 ? 'selected' : '' }}>ÉCONOMIE RÉELLE</option>
                                    <option value="3" {{ old('parent_id', $category->parent_id) == 3 ? 'selected' : '' }}>ANALYSES & EXPERTS</option>
                                    <option value="4" {{ old('parent_id', $category->parent_id) == 4 ? 'selected' : '' }}>DIASPORA</option>
                                    <option value="5" {{ old('parent_id', $category->parent_id) == 5 ? 'selected' : '' }}>MAGAZINES</option>
                                </select>
                                @error('parent_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Ordre d'affichage -->
                            <div class="col-md-6 mb-4">
                                <label for="sort_order" class="form-label" style="font-weight: bold; color: #2c3e50;">
                                    <i class="fas fa-sort-numeric-down me-2 text-secondary"></i>Ordre d'affichage
                                </label>
                                <input type="number" 
                                       class="form-control form-control-lg @error('sort_order') is-invalid @enderror" 
                                       id="sort_order" 
                                       name="sort_order" 
                                       value="{{ old('sort_order', $category->sort_order ?? 0) }}"
                                       min="0"
                                       placeholder="0"
                                       style="border-radius: 12px; border: 2px solid #e9ecef; padding: 15px;">
                                @error('sort_order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">
                                    <i class="fas fa-info-circle me-1"></i>Plus le nombre est petit, plus la catégorie apparaît en premier
                                </small>
                            </div>
                        </div>

                        <!-- Statut -->
                        <div class="mb-4">
                            <label for="status" class="form-label" style="font-weight: bold; color: #2c3e50;">
                                <i class="fas fa-toggle-on me-2 text-success"></i>Statut
                            </label>
                            <select class="form-select form-select-lg @error('status') is-invalid @enderror" 
                                    id="status" 
                                    name="status"
                                    style="border-radius: 12px; border: 2px solid #e9ecef; padding: 15px;">
                                <option value="active" {{ old('status', $category->status) == 'active' ? 'selected' : '' }}>
                                    <i class="fas fa-check-circle me-2"></i>Actif
                                </option>
                                <option value="inactive" {{ old('status', $category->status) == 'inactive' ? 'selected' : '' }}>
                                    <i class="fas fa-pause-circle me-2"></i>Inactif
                                </option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Boutons d'action -->
                        <div class="d-flex justify-content-between align-items-center pt-4 border-top">
                            <a href="{{ route('dashboard.categories.index') }}" class="btn btn-light btn-lg px-4" style="border-radius: 12px;">
                                <i class="fas fa-times me-2"></i>Annuler
                            </a>
                            
                            <div>
                                <button type="submit" class="btn btn-primary btn-lg px-5 me-2" style="border-radius: 12px; background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%); border: none;">
                                    <i class="fas fa-save me-2"></i>Mettre à jour
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.form-control:focus, .form-select:focus {
    border-color: #D4AF37;
    box-shadow: 0 0 0 0.2rem rgba(212, 175, 55, 0.25);
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(37, 99, 235, 0.3);
}

.card {
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.1) !important;
}

.alert {
    border-radius: 12px;
    border: none;
}

.form-label {
    margin-bottom: 8px;
    font-size: 14px;
}

.invalid-feedback {
    font-size: 13px;
    margin-top: 5px;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Génération automatique du slug
    const nameInput = document.getElementById('name');
    const slugInput = document.getElementById('slug');
    
    nameInput.addEventListener('input', function() {
        const name = this.value;
        const slug = name
            .toLowerCase()
            .trim()
            .replace(/[^a-z0-9\s-]/g, '') // Supprimer les caractères spéciaux
            .replace(/\s+/g, '-') // Remplacer les espaces par des tirets
            .replace(/-+/g, '-') // Supprimer les tirets multiples
            .replace(/^-|-$/g, ''); // Supprimer les tirets en début/fin
        
        slugInput.value = slug;
    });
    
    // Validation du formulaire
    const form = document.getElementById('editCategoryForm');
    form.addEventListener('submit', function(e) {
        const name = document.getElementById('name').value.trim();
        
        if (name.length < 2) {
            e.preventDefault();
            alert('Le nom de la catégorie doit contenir au moins 2 caractères.');
            return false;
        }
        
        if (name.length > 100) {
            e.preventDefault();
            alert('Le nom de la catégorie ne peut pas dépasser 100 caractères.');
            return false;
        }
    });
});
</script>
@endsection
