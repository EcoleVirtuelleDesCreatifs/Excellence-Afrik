@extends('layouts.dashboard-ultra')

@section('title', 'Créer une Flash Info')
@section('page_title', 'Créer une Flash Info')

@section('content')
<div class="row justify-content-center">
    <div class="col-xl-8 col-lg-10">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-plus text-primary me-2"></i>
                    Créer une Flash Info
                </h5>
                <a href="{{ route('dashboard.flash-infos.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-arrow-left me-2"></i>Retour
                </a>
            </div>

            <div class="card-body">
                <form action="{{ route('dashboard.flash-infos.store') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="titre" class="form-label required">Titre de la Flash Info</label>
                                <input type="text"
                                       class="form-control @error('titre') is-invalid @enderror"
                                       id="titre"
                                       name="titre"
                                       value="{{ old('titre') }}"
                                       placeholder="Ex: La BRVM enregistre une hausse de 2.3% aujourd'hui"
                                       maxlength="200"
                                       required>
                                <div class="form-text">Maximum 200 caractères</div>
                                @error('titre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="ordre" class="form-label">Ordre d'affichage</label>
                                <input type="number"
                                       class="form-control @error('ordre') is-invalid @enderror"
                                       id="ordre"
                                       name="ordre"
                                       value="{{ old('ordre', 0) }}"
                                       min="0"
                                       placeholder="0">
                                <div class="form-text">Plus le nombre est petit, plus la Flash Info apparaît tôt</div>
                                @error('ordre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="statut" class="form-label required">Statut</label>
                                <select class="form-select @error('statut') is-invalid @enderror"
                                        id="statut"
                                        name="statut"
                                        required>
                                    <option value="actif" {{ old('statut', 'actif') === 'actif' ? 'selected' : '' }}>Actif</option>
                                    <option value="inactif" {{ old('statut') === 'inactif' ? 'selected' : '' }}>Inactif</option>
                                </select>
                                @error('statut')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="date_debut" class="form-label">Date de début</label>
                                <input type="datetime-local"
                                       class="form-control @error('date_debut') is-invalid @enderror"
                                       id="date_debut"
                                       name="date_debut"
                                       value="{{ old('date_debut') }}">
                                <div class="form-text">Laisser vide pour commencer immédiatement</div>
                                @error('date_debut')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="date_fin" class="form-label">Date de fin</label>
                                <input type="datetime-local"
                                       class="form-control @error('date_fin') is-invalid @enderror"
                                       id="date_fin"
                                       name="date_fin"
                                       value="{{ old('date_fin') }}">
                                <div class="form-text">Laisser vide pour une durée illimitée</div>
                                @error('date_fin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="border-top pt-3 mt-4">
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('dashboard.flash-infos.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>Annuler
                            </a>

                            <div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Créer la Flash Info
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.required:after {
    content: " *";
    color: red;
}
</style>
@endpush