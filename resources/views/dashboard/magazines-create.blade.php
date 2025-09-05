@extends('layouts.dashboard-ultra')

@section('title', 'Nouveau Magazine — Dashboard Excellence Afrik')
@section('page_title', 'Nouveau Magazine')

@push('styles')
<style>
  .magazine-admin-card { border: 0; border-radius: 16px; box-shadow: 0 10px 25px rgba(0,0,0,0.06); }
  .magazine-admin-card .card-header { background: #000; color: #D4AF37; border: 0; border-radius: 16px 16px 0 0; }
  .form-text-muted { font-size: 0.9rem; opacity: .75; }
</style>
@endpush

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-10">
      <div class="card magazine-admin-card mb-4">
        <div class="card-header d-flex align-items-center justify-content-between">
          <div>
            <h5 class="mb-0">Créer un Magazine</h5>
            <small class="opacity-75">Renseignez les informations et téléversez la couverture et le PDF</small>
          </div>
          <div>
            <a href="{{ route('dashboard.magazines.index') }}" class="btn btn-light btn-sm">
              <i class="fas fa-arrow-left me-2"></i>Retour à la liste
            </a>
          </div>
        </div>
        <div class="card-body">
          @if ($errors->any())
            <div class="alert alert-danger" role="alert" style="border-radius: 12px;">
              <strong>Veuillez corriger les erreurs suivantes:</strong>
              <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <form action="{{ route('dashboard.magazines.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row g-3">
              <div class="col-md-8">
                <label class="form-label">Titre</label>
                <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
              </div>
              <div class="col-md-4">
                <label class="form-label">Slug (optionnel)</label>
                <input type="text" name="slug" id="slug" class="form-control" value="{{ old('slug') }}" placeholder="ex: life-numerique-6">
              </div>
              <div class="col-md-4">
                <label class="form-label">Date de parution</label>
                <input type="date" name="published_at" class="form-control" value="{{ old('published_at', now()->format('Y-m-d')) }}">
              </div>
              <div class="col-md-4">
                <label class="form-label">Statut</label>
                <select name="status" class="form-select" required>
                  <option value="draft" {{ old('status')==='draft' ? 'selected' : '' }}>Brouillon</option>
                  <option value="published" {{ old('status')==='published' ? 'selected' : '' }}>Publié</option>
                </select>
              </div>
              <div class="col-md-4 d-flex align-items-end">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                  <label class="form-check-label" for="is_featured">
                    À la UNE
                  </label>
                  <div class="form-text form-text-muted">Un seul magazine peut être à la une. Cocher remplace l'actuel.</div>
                </div>
              </div>
              <div class="col-12">
                <label class="form-label">Description (optionnel)</label>
                <textarea name="description" class="form-control" rows="4">{{ old('description') }}</textarea>
              </div>
              <div class="col-md-6">
                <label class="form-label">Couverture (JPEG/PNG/WebP) — sera recadrée en 279x377</label>
                <input type="file" name="cover" class="form-control" accept="image/*">
                <div class="form-text form-text-muted">Max 5 Mo</div>
              </div>
              <div class="col-md-6">
                <label class="form-label">Fichier PDF (optionnel)</label>
                <input type="file" name="pdf" class="form-control" accept="application/pdf">
                <div class="form-text form-text-muted">Max 20 Mo</div>
              </div>
            </div>
            <div class="mt-4 d-flex gap-2">
              <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Enregistrer</button>
              <a href="{{ route('dashboard.magazines.index') }}" class="btn btn-outline-secondary">Annuler</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@push('scripts')
<script>
  (function(){
    function slugify(str){
      return (str || '')
        .toString()
        .normalize('NFD').replace(/[\u0300-\u036f]/g, '')
        .toLowerCase()
        .replace(/[^a-z0-9]+/g,'-')
        .replace(/^-+|-+$/g,'')
        .substring(0, 255);
    }
    const titleInput = document.querySelector('input[name="title"]');
    const slugInput = document.getElementById('slug');
    if(titleInput && slugInput){
      titleInput.addEventListener('input', function(){
        // Only auto-fill if user hasn't manually edited slug
        if(!slugInput.dataset.touched){
          slugInput.value = slugify(this.value);
        }
      });
      slugInput.addEventListener('input', function(){
        this.dataset.touched = '1';
      });
      // Initialize on load if slug empty
      if(!slugInput.value && titleInput.value){
        slugInput.value = slugify(titleInput.value);
      }
    }
  })();
  </script>
@endpush
