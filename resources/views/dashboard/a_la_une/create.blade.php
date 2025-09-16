@extends('layouts.dashboard-ultra')

@section('title', 'Ajouter un Article À la une - Excellence Afrik')
@section('page_title', 'Ajouter un Article À la une')

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
}

.create-header h1 {
    font-size: 2rem;
    font-weight: 700;
}

.form-container {
    background: white;
    border-radius: 1rem;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

.form-section {
    padding: 2rem;
    border-bottom: 1px solid #f3f4f6;
}

.section-title {
    font-size: 1.25rem;
    font-weight: 600;
    margin-bottom: 1.5rem;
}

.form-label.required::after {
    content: ' *';
    color: #ef4444;
}

.form-input, .form-select, .form-textarea {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 2px solid #e5e7eb;
    border-radius: 0.5rem;
}

#editor {
    min-height: 300px;
}

.form-actions {
    padding: 2rem;
    display: flex;
    justify-content: flex-end;
    gap: 1rem;
}
</style>
@endpush

@section('content')
<div class="article-create-container">
    <div class="create-header">
        <h1>Ajouter un Article "À la une"</h1>
        <p>Remplissez tous les champs pour créer un nouvel article "À la une".</p>
    </div>

    <form action="{{ route('dashboard.a_la_une.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-container">
            <div class="form-section">
                <h2 class="section-title">Contenu Principal</h2>
                <div class="form-group">
                    <label for="title" class="form-label required">Titre</label>
                    <input type="text" id="title" name="title" class="form-input" value="{{ old('title') }}" required>
                </div>
                <div class="form-group">
                    <label for="excerpt" class="form-label required">Extrait</label>
                    <textarea id="excerpt" name="excerpt" class="form-input form-textarea" rows="3" required>{{ old('excerpt') }}</textarea>
                </div>
                <div class="form-group">
                    <label for="content" class="form-label required">Contenu complet</label>
                    <div id="editor">{!! old('content') !!}</div>
                    <input type="hidden" name="content" id="content">
                </div>
            </div>

            <div class="form-section">
                <h2 class="section-title">Organisation et Statut</h2>
                <div class="form-group">
                    <label for="category_id" class="form-label required">Catégorie</label>
                    <select id="category_id" name="category_id" class="form-input form-select" required>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="status" class="form-label required">Statut</label>
                    <select id="status" name="status" class="form-input form-select" required>
                        <option value="draft" {{ old('status', 'draft') == 'draft' ? 'selected' : '' }}>Brouillon</option>
                        <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Publié</option>
                        <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>En attente</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="featured" class="form-label">Mettre en avant</label>
                    <input type="checkbox" id="featured" name="featured" value="1" {{ old('featured') ? 'checked' : '' }}>
                </div>
            </div>

            <div class="form-section">
                <h2 class="section-title">Média</h2>
                <div class="form-group">
                    <label for="featured_image" class="form-label">Image de mise en avant</label>
                    <input type="file" id="featured_image" name="featured_image" class="form-input">
                </div>
            </div>

            <div class="form-section">
                <h2 class="section-title">SEO</h2>
                <div class="form-group">
                    <label for="meta_title" class="form-label">Titre SEO</label>
                    <input type="text" id="meta_title" name="meta_title" class="form-input" value="{{ old('meta_title') }}">
                </div>
                <div class="form-group">
                    <label for="meta_description" class="form-label">Description SEO</label>
                    <textarea id="meta_description" name="meta_description" class="form-input form-textarea" rows="2">{{ old('meta_description') }}</textarea>
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('dashboard.a_la_une.index') }}" class="btn btn-secondary">Annuler</a>
                <button type="submit" class="btn btn-primary">Enregistrer l'article</button>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var quill = new Quill('#editor', {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{'list': 'ordered'}, {'list': 'bullet'}],
                    ['link', 'image', 'video'],
                    ['clean']
                ]
            }
        });

        var form = document.querySelector('form');
        form.addEventListener('submit', function() {
            var content = document.querySelector('input[name=content]');
            content.value = quill.root.innerHTML;
        });
    });
</script>
@endpush
