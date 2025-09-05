@extends('layouts.dashboard-ultra')

@section('title', 'Créer une Catégorie - Excellence Afrik')
@section('page_title', 'Créer une Catégorie')

@push('styles')
<style>
.category-create-container {
    max-width: 800px;
    margin: 0 auto;
    padding: 2rem;
}

.create-header {
    background: linear-gradient(135deg, #1a1a1a 0%, #000000 100%);
    border-radius: 1rem;
    padding: 2rem;
    margin-bottom: 2rem;
    color: #D4AF37;
    position: relative;
    overflow: hidden;
}

.create-header::before {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    width: 200px;
    height: 200px;
    background: rgba(212, 175, 55, 0.1);
    border-radius: 50%;
    transform: translate(50%, -50%);
}

.create-header h1 {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    position: relative;
    z-index: 1;
}

.create-header p {
    font-size: 1.1rem;
    opacity: 0.9;
    margin: 0;
    position: relative;
    z-index: 1;
}

.form-card {
    background: white;
    border-radius: 1rem;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.form-header {
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    padding: 1.5rem 2rem;
    border-bottom: 1px solid #e5e7eb;
}

.form-header h2 {
    font-size: 1.25rem;
    font-weight: 600;
    color: #1f2937;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.form-body {
    padding: 2rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    display: block;
    font-weight: bold;
    color: #374151;
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
}

.form-label.required::after {
    content: ' *';
    color: #ef4444;
}

.form-input {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 2px solid #e5e7eb;
    border-radius: 0.5rem;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: #f9fafb;
}

.form-input:focus {
    outline: none;
    border-color: #D4AF37;
    background: white;
    box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.1);
}

.form-textarea {
    min-height: 100px;
    resize: vertical;
}

.form-select {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
    background-position: right 0.5rem center;
    background-repeat: no-repeat;
    background-size: 1.5em 1.5em;
    padding-right: 2.5rem;
}



.form-actions {
    background: #f8fafc;
    padding: 1.5rem 2rem;
    border-top: 1px solid #e5e7eb;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 1rem;
}

.btn {
    padding: 0.75rem 1.5rem;
    border-radius: 0.5rem;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
    cursor: pointer;
    border: none;
    font-size: 0.9rem;
}

.btn-primary {
    background: linear-gradient(135deg, #D4AF37 0%, #B8941F 100%);
    color: white;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #B8941F 0%, #9A7B1A 100%);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(212, 175, 55, 0.3);
}

.btn-secondary {
    background: #6b7280;
    color: white;
}

.btn-secondary:hover {
    background: #4b5563;
    transform: translateY(-2px);
}

.help-text {
    font-size: 0.8rem;
    color: #6b7280;
    margin-top: 0.25rem;
}

.slug-preview {
    font-size: 0.8rem;
    color: #6b7280;
    margin-top: 0.25rem;
    font-family: monospace;
    background: #f3f4f6;
    padding: 0.25rem 0.5rem;
    border-radius: 0.25rem;
}

@media (max-width: 768px) {
    .category-create-container {
        padding: 1rem;
    }

    .create-header {
        padding: 1.5rem;
    }

    .form-body {
        padding: 1.5rem;
    }

    .form-actions {
        flex-direction: column;
        align-items: stretch;
    }

    .btn {
        justify-content: center;
    }
}
</style>
@endpush

@section('content')
<div class="category-create-container">
    <!-- Header -->
    <div class="create-header">
        <h1><i class="fas fa-folder-plus"></i> Créer une Nouvelle Catégorie</h1>
        <p>Organisez vos articles en créant des catégories thématiques</p>
    </div>

    <!-- Formulaire -->
    <div class="form-card">
        <div class="form-header">
            <h2>
                <i class="fas fa-info-circle text-blue-500"></i>
                Informations de la Catégorie
            </h2>
        </div>

        <form action="{{ route('dashboard.categories.store') }}" method="POST" id="categoryForm">
            @csrf

            <div class="form-body">
                <!-- Nom de la catégorie -->
                <div class="form-group">
                    <label for="name" class="form-label required">Nom de la catégorie</label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        class="form-input"
                        placeholder="Ex: Technologie, Économie, Culture..."
                        required
                        maxlength="100"
                        oninput="generateSlug()"
                    >
                    <div class="help-text">Le nom affiché publiquement pour cette catégorie</div>
                </div>

                <!-- Slug -->
                <div class="form-group">
                    <label for="slug" class="form-label">URL personnalisée (slug)</label>
                    <input
                        type="text"
                        id="slug"
                        name="slug"
                        class="form-input"
                        placeholder="technologie-innovation"
                        maxlength="150"
                    >
                    <div class="slug-preview" id="slugPreview">
                        URL: /categories/<span id="slugText">nom-de-la-categorie</span>
                    </div>
                </div>

                <!-- Description -->
                <div class="form-group">
                    <label for="description" class="form-label">Description</label>
                    <textarea
                        id="description"
                        name="description"
                        class="form-input form-textarea"
                        placeholder="Description courte de cette catégorie..."
                        maxlength="500"
                    ></textarea>
                    <div class="help-text">Description optionnelle pour expliquer le contenu de cette catégorie</div>
                </div>



                <!-- Catégorie parente -->
                <div class="form-group">
                    <label for="parent_id" class="form-label">Catégorie parente</label>
                    <select id="parent_id" name="parent_id" class="form-input form-select">
                        <option value="">Aucune (catégorie principale)</option>
                        <option value="1">PORTRAITS</option>
                        <option value="2">ÉCONOMIE RÉELLE</option>
                        <option value="3">ANALYSES & EXPERTS</option>
                        <option value="4">DIASPORA</option>
                        <option value="5">MAGAZINES</option>
                    </select>
                    <div class="help-text">Sélectionnez une catégorie parente pour créer une sous-catégorie</div>
                </div>

                <!-- Ordre d'affichage -->
                <div class="form-group">
                    <label for="sort_order" class="form-label">Ordre d'affichage</label>
                    <input
                        type="number"
                        id="sort_order"
                        name="sort_order"
                        class="form-input"
                        value="0"
                        min="0"
                        max="999"
                    >
                    <div class="help-text">Ordre d'affichage (0 = premier, plus le nombre est élevé, plus la catégorie apparaît en bas)</div>
                </div>

                <!-- Statut -->
                <div class="form-group">
                    <label for="status" class="form-label required">Statut</label>
                    <select id="status" name="status" class="form-input form-select" required>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                    <div class="help-text">Les catégories inactives ne sont pas visibles sur le site</div>
                </div>
            </div>

            <!-- Actions -->
            <div class="form-actions">
                <a href="{{ route('dashboard.categories.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i>
                    Retour à la liste
                </a>

                <div style="display: flex; gap: 1rem;">
                    <button type="submit" name="action" value="draft" class="btn btn-secondary">
                        <i class="fas fa-save"></i>
                        Enregistrer comme brouillon
                    </button>
                    <button type="submit" name="action" value="publish" class="btn btn-primary">
                        <i class="fas fa-check"></i>
                        Créer et Activer
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Génération automatique du slug
function generateSlug() {
    const nameInput = document.getElementById('name');
    const slugInput = document.getElementById('slug');
    const slugText = document.getElementById('slugText');

    if (nameInput.value && !slugInput.dataset.manual) {
        let slug = nameInput.value
            .toLowerCase()
            .trim()
            .replace(/[àáâãäå]/g, 'a')
            .replace(/[èéêë]/g, 'e')
            .replace(/[ìíîï]/g, 'i')
            .replace(/[òóôõö]/g, 'o')
            .replace(/[ùúûü]/g, 'u')
            .replace(/[ç]/g, 'c')
            .replace(/[ñ]/g, 'n')
            .replace(/[^a-z0-9\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-')
            .replace(/^-|-$/g, '');

        slugInput.value = slug;
        slugText.textContent = slug || 'nom-de-la-categorie';
    }
}

// Marquer le slug comme modifié manuellement
document.getElementById('slug').addEventListener('input', function() {
    this.dataset.manual = 'true';
    document.getElementById('slugText').textContent = this.value || 'nom-de-la-categorie';
});



// Validation du formulaire
document.getElementById('categoryForm').addEventListener('submit', function(e) {
    const name = document.getElementById('name').value.trim();
    const status = document.getElementById('status').value;

    if (!name) {
        e.preventDefault();
        alert('Le nom de la catégorie est obligatoire.');
        document.getElementById('name').focus();
        return false;
    }

    if (!status) {
        e.preventDefault();
        alert('Veuillez sélectionner un statut pour la catégorie.');
        document.getElementById('status').focus();
        return false;
    }


});

// Initialisation
document.addEventListener('DOMContentLoaded', function() {
    generateSlug();
});
</script>
@endpush
