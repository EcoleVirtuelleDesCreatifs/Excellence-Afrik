@extends('layouts.dashboard-ultra')

@section('title', 'Modifier l\'Article - Excellence Afrik')
@section('page_title', 'Modifier l\'Article')

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

.progress-bar {
    height: 4px;
    background: #e5e7eb;
    border-radius: 2px;
    margin-bottom: 2rem;
    overflow: hidden;
}

.progress-fill {
    height: 100%;
    background: linear-gradient(90deg, #2563eb, #3b82f6);
    width: 0%;
    transition: width 0.3s ease;
}

.form-container {
    background: white;
    border-radius: 1rem;
    padding: 2rem;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    border: 1px solid #e5e7eb;
}

.section-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 1.5rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid #e5e7eb;
    display: flex;
    align-items: center;
}

.section-title i {
    margin-right: 0.5rem;
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
    width: 100%;
    padding: 0.75rem 1rem;
    border: 2px solid #e5e7eb;
    border-radius: 0.5rem;
    font-size: 1rem;
    background: #f9fafb;
    transition: all 0.3s ease;
}

.form-select:focus {
    outline: none;
    border-color: #2563eb;
    background: white;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
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

.btn-primary {
    background: linear-gradient(135deg, #2563eb, #3b82f6);
    border: none;
    padding: 0.75rem 2rem;
    border-radius: 0.5rem;
    color: white;
    font-weight: 600;
    font-size: 1rem;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(37, 99, 235, 0.3);
}

.btn-secondary {
    background: #6b7280;
    border: none;
    padding: 0.75rem 2rem;
    border-radius: 0.5rem;
    color: white;
    font-weight: 600;
    font-size: 1rem;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-secondary:hover {
    background: #4b5563;
    transform: translateY(-2px);
}

.form-actions {
    display: flex;
    gap: 1rem;
    justify-content: flex-end;
    margin-top: 2rem;
    padding-top: 2rem;
    border-top: 1px solid #e5e7eb;
}

.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
}

@media (max-width: 768px) {
    .form-grid {
        grid-template-columns: 1fr;
    }
    
    .article-create-container {
        padding: 1rem;
    }
    
    .form-actions {
        flex-direction: column;
    }
}

.quill-editor {
    background: white;
    border-radius: 0.5rem;
    border: 2px solid #e5e7eb;
}

.ql-toolbar {
    border-top: 2px solid #e5e7eb;
    border-left: 2px solid #e5e7eb;
    border-right: 2px solid #e5e7eb;
    border-bottom: none;
    border-radius: 0.5rem 0.5rem 0 0;
}

.ql-container {
    border-bottom: 2px solid #e5e7eb;
    border-left: 2px solid #e5e7eb;
    border-right: 2px solid #e5e7eb;
    border-top: none;
    border-radius: 0 0 0.5rem 0.5rem;
    font-size: 1rem;
}

.ql-editor {
    min-height: 300px;
    font-size: 1rem;
    line-height: 1.6;
}

.current-image {
    max-width: 200px;
    border-radius: 0.5rem;
    margin-bottom: 1rem;
}

.image-preview {
    text-align: center;
    margin-bottom: 1rem;
}
</style>
@endpush

@section('content')
<div class="article-create-container">
    <!-- Header Section -->
    <div class="create-header">
        <h1>
            <i class="fas fa-edit"></i>
            Modifier l'Article
        </h1>
        <p>Modifiez et mettez à jour votre contenu pour votre audience Excellence Afrik</p>
    </div>

    <!-- Progress Bar -->
    <div class="progress-bar">
        <div class="progress-fill" id="formProgress" style="width: 100%;"></div>
    </div>

    <!-- Main Form -->
    <form id="articleForm" class="form-container" action="{{ route('dashboard.articles.update', $article->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Section 1: Informations de base -->
        <div class="section-title">
            <i class="fas fa-info-circle"></i>
            Informations de base
        </div>

        <div class="form-grid">
            <div class="form-group">
                <label for="title" class="form-label required">Titre de l'article</label>
                <input type="text" id="title" name="title" class="form-input @error('title') is-invalid @enderror" 
                       value="{{ old('title', $article->title) }}" required>
                @error('title')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="category_id" class="form-label required">Catégorie</label>
                <select id="category_id" name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                    <option value="">Sélectionner une catégorie</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $article->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="sector" class="form-label">Secteur</label>
                <select id="sector" name="sector" class="form-select @error('sector') is-invalid @enderror">
                    @php $oldSector = strtolower(old('sector', $article->sector)); @endphp
                    <option value="" {{ $oldSector === '' ? 'selected' : '' }}>Tout</option>
                    <option value="agriculture" {{ $oldSector === 'agriculture' ? 'selected' : '' }}>Agriculture</option>
                    <option value="technologie" {{ $oldSector === 'technologie' ? 'selected' : '' }}>Technologie</option>
                    <option value="industrie" {{ $oldSector === 'industrie' ? 'selected' : '' }}>Industrie</option>
                    <option value="services" {{ $oldSector === 'services' ? 'selected' : '' }}>Services</option>
                    <option value="energie" {{ $oldSector === 'energie' ? 'selected' : '' }}>Énergie</option>
                </select>
                @error('sector')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="theme" class="form-label">Thématique</label>
                <select id="theme" name="theme" class="form-select @error('theme') is-invalid @enderror">
                    @php $oldTheme = strtolower(old('theme', $article->theme)); @endphp
                    <option value="" {{ $oldTheme === '' ? 'selected' : '' }}>Tout</option>
                    <option value="reportages" {{ $oldTheme === 'reportages' ? 'selected' : '' }}>Reportages</option>
                    <option value="interviews" {{ $oldTheme === 'interviews' ? 'selected' : '' }}>Interviews</option>
                    <option value="documentaires" {{ $oldTheme === 'documentaires' ? 'selected' : '' }}>Documentaires</option>
                    <option value="temoignages" {{ $oldTheme === 'temoignages' ? 'selected' : '' }}>Témoignages</option>
                </select>
                @error('theme')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-group">
            <label for="excerpt" class="form-label required">Résumé de l'article</label>
            <textarea id="excerpt" name="excerpt" class="form-input form-textarea @error('excerpt') is-invalid @enderror" 
                      required>{{ old('excerpt', $article->excerpt) }}</textarea>
            @error('excerpt')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Section 2: Contenu -->
        <div class="section-title">
            <i class="fas fa-edit"></i>
            Contenu de l'article
        </div>

        <div class="form-group">
            <label for="content" class="form-label required">Contenu</label>
            <div id="editor-container">
                <div id="editor">{!! old('content', $article->content) !!}</div>
            </div>
            <textarea id="content" name="content" style="display: none;" required>{{ old('content', $article->content) }}</textarea>
            @error('content')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Section 3: Image à la une -->
        <div class="section-title">
            <i class="fas fa-image"></i>
            Image à la une
        </div>

        @if($article->featured_image_path && file_exists(public_path('storage/' . $article->featured_image_path)))
            <div class="image-preview">
                <img src="{{ asset('storage/' . $article->featured_image_path) }}" class="current-image" alt="Image actuelle">
                <p><small>Image actuelle</small></p>
            </div>
        @endif

        <div class="form-group">
            <label for="featured_image" class="form-label">{{ $article->featured_image_path ? 'Changer l\'image' : 'Télécharger une image' }}</label>
            <div class="image-upload-area" onclick="document.getElementById('featured_image').click()">
                <div class="upload-icon">
                    <i class="fas fa-cloud-upload-alt"></i>
                </div>
                <div class="upload-text">Cliquez pour télécharger une image</div>
                <div class="upload-hint">JPG, PNG, GIF (max 2MB)</div>
            </div>
            <input type="file" id="featured_image" name="featured_image" accept="image/*" style="display: none;" class="@error('featured_image') is-invalid @enderror">
            @error('featured_image')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="featured_image_url" class="form-label">Ou URL d'image</label>
            <input type="url" id="featured_image_url" name="featured_image_url" class="form-input @error('featured_image_url') is-invalid @enderror" 
                   value="{{ old('featured_image_url', $article->featured_image_url) }}" placeholder="https://example.com/image.jpg">
            @error('featured_image_url')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Section 4: SEO et métadonnées -->
        <div class="section-title">
            <i class="fas fa-search"></i>
            SEO et métadonnées
        </div>

        <div class="form-grid">
            <div class="form-group">
                <label for="meta_title" class="form-label">Titre SEO</label>
                <input type="text" id="meta_title" name="meta_title" class="form-input @error('meta_title') is-invalid @enderror" 
                       value="{{ old('meta_title', $article->meta_title) }}" maxlength="60">
                @error('meta_title')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="tags" class="form-label">Mots-clés</label>
                <input type="text" id="tags" name="tags" class="form-input @error('tags') is-invalid @enderror" 
                       value="{{ old('tags', $article->tags) }}" placeholder="innovation, tech, afrique">
                @error('tags')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-group">
            <label for="meta_description" class="form-label">Description SEO</label>
            <textarea id="meta_description" name="meta_description" class="form-input form-textarea @error('meta_description') is-invalid @enderror" 
                      maxlength="160">{{ old('meta_description', $article->meta_description) }}</textarea>
            @error('meta_description')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Section 5: Paramètres de publication -->
        <div class="section-title">
            <i class="fas fa-cog"></i>
            Paramètres de publication
        </div>

        <div class="form-group">
            <label class="form-label" for="featured">
                <i class="fas fa-star" style="color:#D4AF37"></i>
                Article à la une
            </label>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="featured" name="featured" value="1" {{ old('featured', $article->is_featured) ? 'checked' : '' }}>
                <label class="form-check-label" for="featured">Mettre cet article à la une (visible en tête de la catégorie Entreprises & Impacts)</label>
            </div>
        </div>

        <div class="form-group">
            <label for="status" class="form-label required">Statut</label>
            <select id="status" name="status" class="form-select @error('status') is-invalid @enderror" required>
                <option value="draft" {{ old('status', $article->status) == 'draft' ? 'selected' : '' }}>Brouillon</option>
                @if(auth()->user()->estJournaliste())
                    <option value="pending" {{ old('status', $article->status) == 'pending' ? 'selected' : '' }}>Soumettre pour validation</option>
                @else
                    <option value="pending" {{ old('status', $article->status) == 'pending' ? 'selected' : '' }}>En attente de validation</option>
                    <option value="published" {{ old('status', $article->status) == 'published' ? 'selected' : '' }}>Publié</option>
                    <option value="archived" {{ old('status', $article->status) == 'archived' ? 'selected' : '' }}>Archivé</option>
                @endif
            </select>
            @if(auth()->user()->estJournaliste())
                <small class="text-muted mt-1">
                    <i class="fas fa-info-circle"></i>
                    Choisir "Soumettre pour validation" enverra votre article aux administrateurs pour révision et déclenchera une notification par email.
                </small>
            @endif
            @error('status')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Actions -->
        <div class="form-actions">
            <a href="{{ route('dashboard.articles') }}" class="btn-secondary">
                <i class="fas fa-times"></i>
                Annuler
            </a>
            <button type="submit" class="btn-primary">
                <i class="fas fa-save"></i>
                Mettre à jour l'article
            </button>
        </div>
    </form>
</div>

@push('styles')
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<style>
.ql-editor {
    min-height: 300px;
    font-size: 16px;
    line-height: 1.6;
}
.ql-toolbar {
    border-top: 1px solid #ccc;
    border-left: 1px solid #ccc;
    border-right: 1px solid #ccc;
}
.ql-container {
    border-bottom: 1px solid #ccc;
    border-left: 1px solid #ccc;
    border-right: 1px solid #ccc;
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Quill editor
    var quill = new Quill('#editor', {
        theme: 'snow',
        modules: {
            toolbar: [
                [{ 'header': [1, 2, 3, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'color': [] }, { 'background': [] }],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'align': [] }],
                ['link', 'image'],
                ['clean']
            ]
        }
    });

    // Sync Quill content with hidden textarea
    var contentTextarea = document.getElementById('content');
    quill.on('text-change', function() {
        contentTextarea.value = quill.root.innerHTML;
    });

    // Form submission
    const form = document.getElementById('articleForm');
    form.addEventListener('submit', function(event) {
        // Ensure Quill content is synced
        contentTextarea.value = quill.root.innerHTML;
    });

    // Image upload preview
    const imageInput = document.getElementById('featured_image');
    const uploadArea = document.querySelector('.image-upload-area');
    
    imageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                uploadArea.innerHTML = `
                    <img src="${e.target.result}" style="max-width: 200px; max-height: 200px; border-radius: 0.5rem;">
                    <div class="upload-text mt-2">Image sélectionnée: ${file.name}</div>
                `;
            };
            reader.readAsDataURL(file);
        }
    });

    // Drag and drop functionality
    uploadArea.addEventListener('dragover', function(e) {
        e.preventDefault();
        uploadArea.classList.add('dragover');
    });

    uploadArea.addEventListener('dragleave', function(e) {
        e.preventDefault();
        uploadArea.classList.remove('dragover');
    });

    uploadArea.addEventListener('drop', function(e) {
        e.preventDefault();
        uploadArea.classList.remove('dragover');
        
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            imageInput.files = files;
            imageInput.dispatchEvent(new Event('change'));
        }
    });
});
</script>
@endpush
