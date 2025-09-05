@extends('layouts.dashboard-ultra')

@section('title', 'Éditer Magazine — Dashboard Excellence Afrik')
@section('page_title', 'Éditer Magazine')

@push('styles')
<style>
  .magazine-admin-card { border: 0; border-radius: 16px; box-shadow: 0 10px 25px rgba(0,0,0,0.06); }
  .magazine-admin-card .card-header { background: #000; color: #D4AF37; border: 0; border-radius: 16px 16px 0 0; }
  .form-text-muted { font-size: 0.9rem; opacity: .75; }
  .mag-thumb { width: 90px; height: 120px; object-fit: cover; border-radius: 10px; }
</style>
@endpush

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-10">
      <div class="card magazine-admin-card mb-4">
        <div class="card-header d-flex align-items-center justify-content-between">
          <div>
            <h5 class="mb-0">Éditer: {{ $magazine->title }}</h5>
            <small class="opacity-75">Mettez à jour les informations du magazine</small>
          </div>
          <div class="d-flex gap-2">
            <a href="{{ route('dashboard.magazines.index') }}" class="btn btn-light btn-sm">
              <i class="fas fa-arrow-left me-2"></i>Retour à la liste
            </a>
            <form action="{{ route('dashboard.magazines.destroy', $magazine->id) }}" method="POST" onsubmit="return confirm('Supprimer ce magazine ?');">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash me-2"></i>Supprimer</button>
            </form>
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

          <form action="{{ route('dashboard.magazines.update', $magazine->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row g-3">
              <div class="col-md-8">
                <label class="form-label">Titre</label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $magazine->title) }}" required>
              </div>
              <div class="col-md-4">
                <label class="form-label">Slug (optionnel)</label>
                <input type="text" name="slug" class="form-control" value="{{ old('slug', $magazine->slug) }}">
              </div>
              <div class="col-md-4">
                <label class="form-label">Date de parution</label>
                <input type="date" name="published_at" class="form-control" value="{{ old('published_at', optional($magazine->published_at)->format('Y-m-d')) }}">
              </div>
              <div class="col-md-4">
                <label class="form-label">Statut</label>
                <select name="status" class="form-select" required>
                  <option value="draft" {{ old('status', $magazine->status)==='draft' ? 'selected' : '' }}>Brouillon</option>
                  <option value="published" {{ old('status', $magazine->status)==='published' ? 'selected' : '' }}>Publié</option>
                </select>
              </div>
              <div class="col-md-4 d-flex align-items-end">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1" {{ old('is_featured', $magazine->is_featured) ? 'checked' : '' }}>
                  <label class="form-check-label" for="is_featured">
                    À la UNE
                  </label>
                  <div class="form-text form-text-muted">Un seul magazine peut être à la une.</div>
                </div>
              </div>
              <div class="col-12">
                <label class="form-label">Description (optionnel)</label>
                <textarea name="description" class="form-control" rows="4">{{ old('description', $magazine->description) }}</textarea>
              </div>
              <div class="col-md-6">
                <label class="form-label">Couverture (remplacer)</label>
                <input type="file" name="cover" class="form-control" accept="image/*">
                <div class="form-text form-text-muted">Max 5 Mo. Affichée à 279x377 sur la grille.</div>
                @if($magazine->cover_thumb_path || $magazine->cover_path)
                  <div class="mt-2">
                    <img class="mag-thumb" src="{{ asset('storage/'.($magazine->cover_thumb_path ?: $magazine->cover_path)) }}" alt="Cover">
                  </div>
                @endif
              </div>
              <div class="col-md-6">
                <label class="form-label">Fichier PDF (remplacer)</label>
                <input type="file" name="pdf" class="form-control" accept="application/pdf">
                <div class="form-text form-text-muted">Max 20 Mo.</div>
                @if($magazine->pdf_path)
                  <div class="mt-2">
                    <a href="{{ asset('storage/'.$magazine->pdf_path) }}" target="_blank"><i class="fas fa-file-pdf me-2"></i>Voir le PDF actuel</a>
                  </div>
                @endif
              </div>
            </div>
            <div class="mt-4 d-flex gap-2">
              <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Mettre à jour</button>
              <a href="{{ route('dashboard.magazines.index') }}" class="btn btn-outline-secondary">Annuler</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
