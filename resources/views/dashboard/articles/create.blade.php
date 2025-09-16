@extends('layouts.dashboard-ultra')

@section('title', 'Ajouter un Article - Excellence Afrik')
@section('page_title', 'Ajouter un Article')

@push('styles')
<link rel="stylesheet" href="https://cdn.quilljs.com/1.3.6/quill.snow.css">
<style>
.article-create-container {
    max-width: 1200px;
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
    background: rgba(255, 255, 255, 0.1);
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

.form-container {
    background: white;
    border-radius: 1rem;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.form-section {
    padding: 2rem;
    border-bottom: 1px solid #f3f4f6;
}

.form-section:last-child {
    border-bottom: none;
}

.section-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.section-title i {
    color: #2563eb;
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
    border-color: #2563eb;
    background: white;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
}

.form-textarea {
    min-height: 120px;
    resize: vertical;
}

.form-select {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
    background-position: right 0.5rem center;
    background-repeat: no-repeat;
    background-size: 1.5em 1.5em;
    padding-right: 2.5rem;
}

.editor-container {
    border: 2px solid #e5e7eb;
    border-radius: 0.5rem;
    overflow: hidden;
    background: white;
}

.editor-container:focus-within {
    border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
}

#editor {
    min-height: 300px;
}

.image-upload-area {
    border: 2px dashed #d1d5db;
    border-radius: 0.5rem;
    padding: 2rem;
    text-align: center;
    transition: all 0.3s ease;
    cursor: pointer;
    background: #f9fafb;
}

.image-upload-area:hover {
    border-color: #2563eb;
    background: #eff6ff;
}

.image-upload-area.dragover {
    border-color: #2563eb;
    background: #eff6ff;
    transform: scale(1.02);
}

.upload-icon {
    font-size: 3rem;
    color: #9ca3af;
    margin-bottom: 1rem;
}

.upload-text {
    font-size: 1.1rem;
    color: #6b7280;
    margin-bottom: 0.5rem;
}

.upload-hint {
    font-size: 0.9rem;
    color: #9ca3af;
}

.image-preview {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
    gap: 1rem;
    margin-top: 1rem;
}

.preview-item {
    position: relative;
    border-radius: 0.5rem;
    overflow: hidden;
    aspect-ratio: 16/9;
    background: #f3f4f6;
}

.preview-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.preview-remove {
    position: absolute;
    top: 0.5rem;
    right: 0.5rem;
    background: rgba(239, 68, 68, 0.9);
    color: white;
    border: none;
    border-radius: 50%;
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    font-size: 0.8rem;
}

.tags-input-container {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
    padding: 0.75rem;
    border: 2px solid #e5e7eb;
    border-radius: 0.5rem;
    background: #f9fafb;
    min-height: 50px;
    cursor: text;
}

.tags-input-container:focus-within {
    border-color: #2563eb;
    background: white;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
}

.tag-item {
    background: #2563eb;
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 1rem;
    font-size: 0.85rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.tag-remove {
    background: none;
    border: none;
    color: white;
    cursor: pointer;
    padding: 0;
    font-size: 0.8rem;
}

.tags-input {
    border: none;
    outline: none;
    background: transparent;
    flex: 1;
    min-width: 120px;
    padding: 0.25rem;
}

.form-actions {
    background: #f9fafb;
    padding: 2rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 1rem;
}

.btn {
    padding: 0.75rem 2rem;
    border-radius: 0.5rem;
    font-weight: 500;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    cursor: pointer;
    border: none;
    transition: all 0.3s ease;
    font-size: 1rem;
}

.btn-primary {
    background: #2563eb;
    color: white;
}

.btn-primary:hover {
    background: #1d4ed8;
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(37, 99, 235, 0.3);
}

.btn-secondary {
    background: #6b7280;
    color: white;
}

.btn-secondary:hover {
    background: #4b5563;
}

.btn-outline {
    background: transparent;
    color: #6b7280;
    border: 2px solid #e5e7eb;
}

.btn-outline:hover {
    background: #f3f4f6;
    border-color: #d1d5db;
}

.btn-success {
    background: #10b981;
    color: white;
}

.btn-success:hover {
    background: #059669;
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(16, 185, 129, 0.3);
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
}

@media (max-width: 768px) {
    .form-row {
        grid-template-columns: 1fr;
    }
    
    .form-actions {
        flex-direction: column;
        align-items: stretch;
    }
    
    .article-create-container {
        padding: 1rem;
    }
}

.status-selector {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 1rem;
}

.status-option {
    padding: 1rem;
    border: 2px solid #e5e7eb;
    border-radius: 0.5rem;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
    background: #f9fafb;
}

.status-option:hover {
    border-color: #2563eb;
    background: #eff6ff;
}

.status-option.selected {
    border-color: #2563eb;
    background: #eff6ff;
    color: #2563eb;
}

.status-option i {
    font-size: 1.5rem;
    margin-bottom: 0.5rem;
    display: block;
}

.character-count {
    font-size: 0.8rem;
    color: #6b7280;
    text-align: right;
    margin-top: 0.25rem;
}

.progress-bar {
    width: 100%;
    height: 4px;
    background: #e5e7eb;
    border-radius: 2px;
    overflow: hidden;
    margin-bottom: 1rem;
}

.progress-fill {
    height: 100%;
    background: linear-gradient(90deg, #2563eb, #10b981);
    width: 0%;
    transition: width 0.3s ease;
}

.alert {
    padding: 1rem;
    border-radius: 0.5rem;
    margin-bottom: 1rem;
}

.alert-danger {
    background-color: #fef2f2;
    border: 1px solid #fecaca;
    color: #991b1b;
}

.alert-success {
    background-color: #f0fdf4;
    border: 1px solid #bbf7d0;
    color: #166534;
}

.alert h4 {
    margin-bottom: 0.5rem;
    font-size: 1rem;
    font-weight: 600;
}

.alert ul {
    list-style: disc;
    padding-left: 1.5rem;
}
</style>
@endpush

@section('content')
<div class="article-create-container">
    <!-- Header Section -->
    <div class="create-header">
        <h1>
            <i class="fas fa-plus-circle"></i>
            Créer un Nouvel Article
        </h1>
        <p>Rédigez et publiez du contenu de qualité pour votre audience Excellence Afrik</p>
    </div>

    <!-- Progress Bar -->
    <div class="progress-bar">
        <div class="progress-fill" id="formProgress"></div>
    </div>

    <!-- Main Form -->
    <!-- Affichage des erreurs de validation -->
    @if ($errors->any())
        <div class="alert alert-danger mb-4">
            <h4>Erreurs de validation :</h4>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Affichage des messages de succès -->
    @if (session('success'))
        <div class="alert alert-success mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form id="articleForm" class="form-container" action="{{ route('dashboard.articles.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <!-- Section 1: Informations de base -->
        <div class="form-section">
            <h2 class="section-title">
                <i class="fas fa-info-circle"></i>
                Informations de Base
            </h2>
            
            <div class="form-group">
                <label for="title" class="form-label required">Titre de l'article</label>
                <input 
                    type="text" 
                    id="title" 
                    name="title" 
                    class="form-input" 
                    placeholder="Saisissez un titre accrocheur..."
                    required
                    maxlength="200"
                >
                <div class="character-count">
                    <span id="titleCount">0</span>/200 caractères
                </div>
            </div>

            <div class="form-group">
                <label for="slug" class="form-label">URL personnalisée (slug)</label>
                <input 
                    type="text" 
                    id="slug" 
                    name="slug" 
                    class="form-input" 
                    placeholder="url-de-larticle (généré automatiquement)"
                >
                <small style="color: #6b7280; font-size: 0.85rem;">
                    Laissez vide pour génération automatique à partir du titre
                </small>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="main_category" class="form-label required">Catégorie principale</label>
                    <select id="main_category" name="main_category" class="form-input form-select" required>
                        <option value="">Sélectionnez une catégorie</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('main_category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group" id="subcategory-group" style="display: none;">
                    <label for="subcategory" class="form-label">Sous-catégorie</label>
                    <select id="subcategory" name="category_id" class="form-input form-select">
                        <option value="">Sélectionnez une sous-catégorie</option>
                    </select>
                    <small style="color: #6b7280; font-size: 0.85rem;">
                        Pour "Page accueil", sélectionnez la section spécifique où l'article apparaîtra.
                    </small>
                </div>

                <div class="form-group">
                    <label class="form-label">Auteur</label>
                    <div class="d-flex align-items-center p-3 bg-light rounded">
                        <div class="bg-primary rounded-circle me-3 d-flex align-items-center justify-content-center text-white" style="width: 40px; height: 40px;">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <div>
                            <strong>{{ Auth::user()->name }}</strong>
                            <br>
                            <small class="text-muted">{{ Auth::user()->nom_role }}</small>
                        </div>
                    </div>
                    <small style="color: #6b7280; font-size: 0.85rem; margin-top: 0.5rem; display: block;">
                        L'auteur sera automatiquement défini avec votre compte utilisateur.
                    </small>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="sector" class="form-label">Secteur</label>
                    <select id="sector" name="sector" class="form-input form-select">
                        @php $oldSector = strtolower(old('sector', '')); @endphp
                        <option value="" {{ $oldSector === '' ? 'selected' : '' }}>Tout</option>
                        <option value="agriculture" {{ $oldSector === 'agriculture' ? 'selected' : '' }}>Agriculture</option>
                        <option value="technologie" {{ $oldSector === 'technologie' ? 'selected' : '' }}>Technologie</option>
                        <option value="industrie" {{ $oldSector === 'industrie' ? 'selected' : '' }}>Industrie</option>
                        <option value="services" {{ $oldSector === 'services' ? 'selected' : '' }}>Services</option>
                        <option value="energie" {{ $oldSector === 'energie' ? 'selected' : '' }}>Énergie</option>
                    </select>
                    <small style="color: #6b7280; font-size: 0.85rem;">Sélectionnez le secteur pour les pages "Figures de l'Économie" et "Entreprises & Impacts". Choisissez "Tout" si non applicable.</small>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="theme" class="form-label">Thématique</label>
                    <select id="theme" name="theme" class="form-input form-select">
                        @php $oldTheme = strtolower(old('theme', '')); @endphp
                        <option value="" {{ $oldTheme === '' ? 'selected' : '' }}>Tout</option>
                        <option value="reportages" {{ $oldTheme === 'reportages' ? 'selected' : '' }}>Reportages</option>
                        <option value="interviews" {{ $oldTheme === 'interviews' ? 'selected' : '' }}>Interviews</option>
                        <option value="documentaires" {{ $oldTheme === 'documentaires' ? 'selected' : '' }}>Documentaires</option>
                        <option value="temoignages" {{ $oldTheme === 'temoignages' ? 'selected' : '' }}>Témoignages</option>
                    </select>
                    <small style="color: #6b7280; font-size: 0.85rem;">Sélectionnez la thématique pour l'affichage sur la page "Grands Genres".</small>
                </div>
            </div>

            <div class="form-group">
                <label for="excerpt" class="form-label required">Résumé/Extrait</label>
                <textarea 
                    id="excerpt" 
                    name="excerpt" 
                    class="form-input form-textarea" 
                    placeholder="Rédigez un résumé captivant de votre article..."
                    required
                    maxlength="500"
                ></textarea>
                <div class="character-count">
                    <span id="excerptCount">0</span>/500 caractères
                </div>
            </div>
        </div>

        <!-- Section 2: Contenu -->
        <div class="form-section">
            <h2 class="section-title">
                <i class="fas fa-edit"></i>
                Contenu de l'Article
            </h2>
            
            <div class="form-group">
                <label class="form-label required">Contenu principal</label>
                <div class="editor-container">
                    <div id="editor"></div>
                </div>
                <input type="hidden" id="content" name="content">
            </div>
        </div>

        <!-- Section 3: Images et Médias -->
        <div class="form-section">
            <h2 class="section-title">
                <i class="fas fa-images"></i>
                Images et Médias
            </h2>
            
            <div class="form-group">
                <label class="form-label">Image de couverture</label>
                <div class="image-upload-area" id="imageUpload">
                    <div class="upload-icon">
                        <i class="fas fa-cloud-upload-alt"></i>
                    </div>
                    <div class="upload-text">Cliquez ou glissez-déposez votre image</div>
                    <div class="upload-hint">PNG, JPG, WEBP jusqu'à 5MB</div>
                    <input type="file" id="featuredImage" name="featured_image" accept="image/*" style="display: none;">
                </div>
                <div id="imagePreview" class="image-preview"></div>
            </div>

            <div class="form-group">
                <label for="imageAlt" class="form-label">Texte alternatif de l'image</label>
                <input 
                    type="text" 
                    id="imageAlt" 
                    name="image_alt" 
                    class="form-input" 
                    placeholder="Description de l'image pour l'accessibilité"
                >
            </div>
        </div>

        <!-- Section 4: Métadonnées -->
        <div class="form-section">
            <h2 class="section-title">
                <i class="fas fa-tags"></i>
                Métadonnées et SEO
            </h2>
            
            <div class="form-group">
                <label class="form-label">Tags/Mots-clés</label>
                <div class="tags-input-container" id="tagsContainer">
                    <input 
                        type="text" 
                        id="tagsInput" 
                        class="tags-input" 
                        placeholder="Ajoutez des tags (Entrée pour valider)"
                    >
                </div>
                <input type="hidden" id="tags" name="tags">
                <small style="color: #6b7280; font-size: 0.85rem;">
                    Appuyez sur Entrée ou virgule pour ajouter un tag
                </small>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="metaTitle" class="form-label">Titre SEO</label>
                    <input 
                        type="text" 
                        id="metaTitle" 
                        name="meta_title" 
                        class="form-input" 
                        placeholder="Titre optimisé pour les moteurs de recherche"
                        maxlength="60"
                    >
                    <div class="character-count">
                        <span id="metaTitleCount">0</span>/60 caractères
                    </div>
                </div>

                <div class="form-group">
                    <label for="metaDescription" class="form-label">Description SEO</label>
                    <textarea 
                        id="metaDescription" 
                        name="meta_description" 
                        class="form-input form-textarea" 
                        placeholder="Description pour les moteurs de recherche"
                        maxlength="160"
                        style="min-height: 80px;"
                    ></textarea>
                    <div class="character-count">
                        <span id="metaDescCount">0</span>/160 caractères
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 5: Publication -->
        <div class="form-section">
            <h2 class="section-title">
                <i class="fas fa-rocket"></i>
                Options de Publication
            </h2>
            
            <div class="form-group">
                <label class="form-label required">Statut de publication</label>
                <div class="status-selector">
                    <div class="status-option selected" data-status="draft">
                        <i class="fas fa-edit"></i>
                        <div>Brouillon</div>
                        <small>Enregistrer sans publier</small>
                    </div>
                    @if(auth()->check() && auth()->user()->estJournaliste())
                        <div class="status-option" data-status="pending">
                            <i class="fas fa-hourglass-half"></i>
                            <div>Soumettre</div>
                            <small>Soumettre pour validation</small>
                        </div>
                    @else
                        <div class="status-option" data-status="pending">
                            <i class="fas fa-hourglass-half"></i>
                            <div>En attente</div>
                            <small>En attente de validation</small>
                        </div>
                        <div class="status-option" data-status="published">
                            <i class="fas fa-globe"></i>
                            <div>Publié</div>
                            <small>Visible par tous</small>
                        </div>
                    @endif
                </div>
                <input type="hidden" id="status" name="status" value="draft">
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="publishDate" class="form-label">Date de publication</label>
                    <input 
                        type="datetime-local" 
                        id="publishDate" 
                        name="published_at" 
                        class="form-input"
                        value="{{ date('Y-m-d\TH:i') }}"
                    >
                </div>

                <div class="form-group">
                    <label for="featured" class="form-label">Article à la une</label>
                    <select id="featured" name="featured" class="form-input form-select">
                        <option value="0">Non</option>
                        <option value="1">Oui</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="form-actions">
            <div>
                <a href="{{ route('dashboard.articles') }}" class="btn btn-outline">
                    <i class="fas fa-arrow-left"></i>
                    Retour à la liste
                </a>
            </div>
            <div style="display: flex; gap: 1rem;">
                <button type="button" id="saveDraft" class="btn btn-secondary">
                    <i class="fas fa-save"></i>
                    Enregistrer le brouillon
                </button>
                @if(auth()->check() && auth()->user()->estJournaliste())
                    <button type="button" id="submitForReview" class="btn btn-primary">
                        <i class="fas fa-paper-plane"></i>
                        Soumettre pour validation
                    </button>
                @else
                    <button type="button" id="submitForReview" class="btn btn-warning">
                        <i class="fas fa-hourglass-half"></i>
                        Marquer en attente
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-rocket"></i>
                        Publier l'article
                    </button>
                @endif
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
<script>
// Données des sous-catégories depuis PHP
const subcategoriesData = @json($subcategories);

document.addEventListener('DOMContentLoaded', function() {
    // Initialize Quill Editor
    const quill = new Quill('#editor', {
        theme: 'snow',
        modules: {
            toolbar: [
                [{ 'header': [1, 2, 3, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'color': [] }, { 'background': [] }],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'align': [] }],
                ['blockquote', 'code-block'],
                ['link', 'image'],
                ['clean']
            ]
        },
        placeholder: 'Commencez à écrire votre article...'
    });

    // === Gestion Catégories et Sous-catégories ===
    const mainCategorySelect = document.getElementById('main_category');
    const subcategoryGroup = document.getElementById('subcategory-group');
    const subcategorySelect = document.getElementById('subcategory');

    mainCategorySelect.addEventListener('change', function() {
        const selectedCategoryId = this.value;

        if (selectedCategoryId && subcategoriesData[selectedCategoryId]) {
            // Il y a des sous-catégories pour cette catégorie
            const subcategories = subcategoriesData[selectedCategoryId];

            // Vider le select des sous-catégories
            subcategorySelect.innerHTML = '<option value="">Sélectionnez une sous-catégorie</option>';

            // Ajouter les sous-catégories
            subcategories.forEach(function(subcat) {
                const option = document.createElement('option');
                option.value = subcat.id;
                option.textContent = subcat.name;
                subcategorySelect.appendChild(option);
            });

            // Afficher le groupe sous-catégorie
            subcategoryGroup.style.display = 'block';
            subcategorySelect.required = true;

            // Vider le champ category_id principal pour forcer l'utilisation de la sous-catégorie
            subcategorySelect.name = 'category_id';
        } else {
            // Pas de sous-catégories, utiliser directement la catégorie principale
            subcategoryGroup.style.display = 'none';
            subcategorySelect.required = false;

            // Utiliser directement la catégorie principale
            mainCategorySelect.name = 'category_id';
            subcategorySelect.name = '';
        }
    });

    // Gestion du changement de sous-catégorie
    subcategorySelect.addEventListener('change', function() {
        if (this.value) {
            // Une sous-catégorie est sélectionnée
            this.name = 'category_id';
            mainCategorySelect.name = 'main_category';
        }
    });

    // Character counters
    const setupCharacterCounter = (inputId, countId, maxLength) => {
        const input = document.getElementById(inputId);
        const counter = document.getElementById(countId);
        
        input.addEventListener('input', function() {
            const count = this.value.length;
            counter.textContent = count;
            
            if (count > maxLength * 0.9) {
                counter.style.color = '#ef4444';
            } else if (count > maxLength * 0.7) {
                counter.style.color = '#f59e0b';
            } else {
                counter.style.color = '#6b7280';
            }
        });
    };

    setupCharacterCounter('title', 'titleCount', 200);
    setupCharacterCounter('excerpt', 'excerptCount', 500);
    setupCharacterCounter('metaTitle', 'metaTitleCount', 60);
    setupCharacterCounter('metaDescription', 'metaDescCount', 160);

    // Auto-generate slug from title
    document.getElementById('title').addEventListener('input', function() {
        const slug = this.value
            .toLowerCase()
            .replace(/[^a-z0-9\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-')
            .trim();
        document.getElementById('slug').value = slug;
    });

    // Image upload
    const imageUpload = document.getElementById('imageUpload');
    const fileInput = document.getElementById('featuredImage');
    const imagePreview = document.getElementById('imagePreview');

    imageUpload.addEventListener('click', () => fileInput.click());

    imageUpload.addEventListener('dragover', (e) => {
        e.preventDefault();
        imageUpload.classList.add('dragover');
    });

    imageUpload.addEventListener('dragleave', () => {
        imageUpload.classList.remove('dragover');
    });

    imageUpload.addEventListener('drop', (e) => {
        e.preventDefault();
        imageUpload.classList.remove('dragover');
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            fileInput.files = files;
            handleImagePreview(files[0]);
        }
    });

    fileInput.addEventListener('change', function() {
        if (this.files.length > 0) {
            handleImagePreview(this.files[0]);
        }
    });

    function handleImagePreview(file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            imagePreview.innerHTML = `
                <div class="preview-item">
                    <img src="${e.target.result}" alt="Preview">
                    <button type="button" class="preview-remove" onclick="removeImage()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;
        };
        reader.readAsDataURL(file);
    }

    window.removeImage = function() {
        fileInput.value = '';
        imagePreview.innerHTML = '';
    };

    // Tags system
    const tagsContainer = document.getElementById('tagsContainer');
    const tagsInput = document.getElementById('tagsInput');
    const tagsHidden = document.getElementById('tags');
    let tags = [];

    function addTag(tagText) {
        tagText = tagText.trim();
        if (tagText && !tags.includes(tagText)) {
            tags.push(tagText);
            updateTagsDisplay();
            updateTagsInput();
        }
    }

    function removeTag(tagText) {
        tags = tags.filter(tag => tag !== tagText);
        updateTagsDisplay();
        updateTagsInput();
    }

    function updateTagsDisplay() {
        const tagElements = tags.map(tag => `
            <div class="tag-item">
                ${tag}
                <button type="button" class="tag-remove" onclick="removeTag('${tag}')">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `).join('');
        
        tagsContainer.innerHTML = tagElements + tagsInput.outerHTML;
        document.getElementById('tagsInput').focus();
    }

    function updateTagsInput() {
        tagsHidden.value = tags.join(',');
    }

    tagsInput.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' || e.key === ',') {
            e.preventDefault();
            addTag(this.value);
            this.value = '';
        }
    });

    window.removeTag = removeTag;

    // Status selector
    document.querySelectorAll('.status-option').forEach(option => {
        option.addEventListener('click', function() {
            document.querySelectorAll('.status-option').forEach(opt => opt.classList.remove('selected'));
            this.classList.add('selected');
            document.getElementById('status').value = this.dataset.status;
        });
    });

    // Form progress
    function updateProgress() {
        const requiredFields = ['title', 'category', 'excerpt'];
        const filledFields = requiredFields.filter(field => {
            const element = document.getElementById(field);
            return element && element.value.trim() !== '';
        });
        
        const contentFilled = quill.getText().trim().length > 50;
        const totalFields = requiredFields.length + 1; // +1 for content
        const completedFields = filledFields.length + (contentFilled ? 1 : 0);
        
        const progress = (completedFields / totalFields) * 100;
        document.getElementById('formProgress').style.width = progress + '%';
    }

    // Update progress on input
    document.querySelectorAll('input, select, textarea').forEach(element => {
        element.addEventListener('input', updateProgress);
    });

    quill.on('text-change', updateProgress);

    // Save draft functionality
    document.getElementById('saveDraft').addEventListener('click', function() {
        document.getElementById('status').value = 'draft';
        document.getElementById('content').value = quill.root.innerHTML;
        document.getElementById('articleForm').submit();
    });

    // Submit for review functionality
    const submitForReviewBtn = document.getElementById('submitForReview');
    if (submitForReviewBtn) {
        submitForReviewBtn.addEventListener('click', function(e) {
            console.log('Submit button clicked');
            e.preventDefault(); // Empêcher le comportement par défaut
            
            // Vérifier les champs requis
            const title = document.getElementById('title').value.trim();
            const category = document.getElementById('category').value;
            const excerpt = document.getElementById('excerpt').value.trim();
            const content = quill.getText().trim();
            
            console.log('Title:', title);
            console.log('Category:', category);
            console.log('Excerpt:', excerpt);
            console.log('Content length:', content.length);
            
            if (!title) {
                alert('Veuillez saisir un titre');
                return;
            }
            if (!category) {
                alert('Veuillez sélectionner une catégorie');
                return;
            }
            if (!excerpt) {
                alert('Veuillez saisir un résumé');
                return;
            }
            if (content.length < 10) {
                alert('Veuillez saisir du contenu pour l\'article');
                return;
            }
            
            // Définir le statut et soumettre
            document.getElementById('status').value = 'pending';
            document.getElementById('content').value = quill.root.innerHTML;
            
            console.log('Submitting form with status: pending');
            document.getElementById('articleForm').submit();
        });
    }

    // Form submission
    document.getElementById('articleForm').addEventListener('submit', function() {
        document.getElementById('content').value = quill.root.innerHTML;
    });

    // Initial progress update
    updateProgress();
});
</script>
@endpush
