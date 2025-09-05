@extends('layouts.dashboard-ultra')

@section('title', 'Modifier WebTV')
@section('page-title', 'Modifier WebTV')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/pages/webtv.css') }}">
@endpush

@section('content')
<div class="modern-webtv-edit-section">
    <!-- Enhanced Header -->
    <div class="page-header-modern">
        <div class="header-content">
            <div class="header-main">
                <div class="header-icon">
                    <i class="fas fa-edit"></i>
                </div>
                <div class="header-info">
                    <h1 class="page-title">Modifier WebTV</h1>
                    <p class="page-subtitle">{{ $webtv->titre }}</p>
                    <div class="breadcrumb-modern">
                        <a href="{{ url('/') }}" class="breadcrumb-item">
                            <i class="fas fa-home"></i>
                            Dashboard
                        </a>
                        <i class="fas fa-chevron-right breadcrumb-separator"></i>
                        <a href="{{ route('dashboard.webtv.index') }}" class="breadcrumb-item">WebTV</a>
                        <i class="fas fa-chevron-right breadcrumb-separator"></i>
                        <span class="breadcrumb-item active">Modifier</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-actions">
            <div class="status-indicator status-{{ $webtv->statut_couleur }}">
                @if($webtv->statut === 'en_direct')
                    <div class="live-dot"></div>
                @endif
                <span>{{ $webtv->statut_formatte }}</span>
            </div>
            <a href="{{ route('dashboard.webtv.index') }}" class="btn-secondary-modern">
                <i class="fas fa-arrow-left"></i>
                <span>Retour</span>
            </a>
        </div>
    </div>

    <!-- Form Container -->
    <div class="form-container-modern">
        <form id="webtv-form" action="{{ route('dashboard.webtv.update', $webtv) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-grid">
                <!-- Informations Principales -->
                <div class="form-section">
                    <div class="section-header">
                        <h3 class="section-title">
                            <i class="fas fa-info-circle"></i>
                            Informations du Live
                        </h3>
                        <p class="section-description">Modifiez les détails de votre diffusion en direct</p>
                    </div>

                    <div class="form-fields">
                        <div class="form-field">
                            <label for="titre" class="form-label required">Titre du Live</label>
                            <input type="text" 
                                   id="titre" 
                                   name="titre" 
                                   class="form-input @error('titre') error @enderror" 
                                   placeholder="Ex: Débat Économique - Excellence Afrik"
                                   value="{{ old('titre', $webtv->titre) }}"
                                   maxlength="255"
                                   required>
                            @error('titre')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                            <div class="field-help">Titre visible sur la page WebTV (max 255 caractères)</div>
                        </div>

                        <div class="form-field">
                            <label for="description" class="form-label">Description</label>
                            <textarea id="description" 
                                      name="description" 
                                      class="form-textarea @error('description') error @enderror" 
                                      placeholder="Description détaillée de votre live..."
                                      rows="4"
                                      maxlength="1000">{{ old('description', $webtv->description) }}</textarea>
                            @error('description')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                            <div class="field-help">Description optionnelle du contenu (max 1000 caractères)</div>
                        </div>

                        <div class="form-field">
                            <label for="date_programmee" class="form-label">Date de Programmation</label>
                            <input type="datetime-local" 
                                   id="date_programmee" 
                                   name="date_programmee" 
                                   class="form-input @error('date_programmee') error @enderror"
                                   value="{{ old('date_programmee', $webtv->date_programmee ? $webtv->date_programmee->format('Y-m-d\TH:i') : '') }}">
                            @error('date_programmee')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                            <div class="field-help">Optionnel - Laissez vide pour un live immédiat</div>
                        </div>

                        <div class="form-field">
                            <label for="duree_estimee" class="form-label">Durée Estimée</label>
                            <div class="duration-input">
                                <input type="number" 
                                       id="duree_estimee" 
                                       name="duree_estimee" 
                                       class="form-input @error('duree_estimee') error @enderror"
                                       placeholder="90"
                                       value="{{ old('duree_estimee', $webtv->duree_estimee) }}"
                                       min="1" 
                                       max="600">
                                <span class="duration-unit">minutes</span>
                            </div>
                            @error('duree_estimee')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                            <div class="field-help">Durée approximative de votre live (1-600 minutes)</div>
                        </div>

                        <div class="form-field">
                            <label for="statut" class="form-label required">Statut</label>
                            <select id="statut" name="statut" class="form-select @error('statut') error @enderror" required>
                                <option value="draft" {{ old('statut', $webtv->statut) === 'draft' ? 'selected' : '' }}>Brouillon</option>
                                <option value="programme" {{ old('statut', $webtv->statut) === 'programme' ? 'selected' : '' }}>Programmé</option>
                                <option value="en_direct" {{ old('statut', $webtv->statut) === 'en_direct' ? 'selected' : '' }}>En Direct</option>
                                <option value="termine" {{ old('statut', $webtv->statut) === 'termine' ? 'selected' : '' }}>Terminé</option>
                            </select>
                            @error('statut')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                            <div class="field-help">
                                Statut actuel du live
                                @if($webtv->statut === 'en_direct')
                                    <strong style="color: #28a745;"> - Actuellement EN DIRECT</strong>
                                @endif
                            </div>
                        </div>

                        <div class="form-field">
                            <div class="checkbox-field">
                                <input type="hidden" name="est_actif" value="0">
                                <input type="checkbox" 
                                       id="est_actif" 
                                       name="est_actif" 
                                       value="1" 
                                       class="form-checkbox"
                                       {{ old('est_actif', $webtv->est_actif) ? 'checked' : '' }}>
                                <label for="est_actif" class="checkbox-label">
                                    Actif sur la page WebTV
                                    @if($webtv->est_actif)
                                        <span style="color: #28a745; font-weight: 600;"> - Actuellement ACTIF</span>
                                    @endif
                                </label>
                            </div>
                            <div class="field-help">Si coché, ce live sera visible côté client</div>
                        </div>

                        <!-- Informations supplémentaires -->
                        <div class="info-panel">
                            <h4>Informations Système</h4>
                            <div class="info-grid">
                                <div class="info-item">
                                    <label>ID Vimeo:</label>
                                    <span>{{ $webtv->vimeo_event_id ?? 'Non détecté' }}</span>
                                </div>
                                <div class="info-item">
                                    <label>Nombre de vues:</label>
                                    <span>{{ $webtv->nombre_vues_formatte }}</span>
                                </div>
                                <div class="info-item">
                                    <label>Créé le:</label>
                                    <span>{{ $webtv->created_at->format('d/m/Y à H:i') }}</span>
                                </div>
                                <div class="info-item">
                                    <label>Dernière modification:</label>
                                    <span>{{ $webtv->updated_at->format('d/m/Y à H:i') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Code Embed Vimeo -->
                <div class="form-section">
                    <div class="section-header">
                        <h3 class="section-title">
                            <i class="fab fa-vimeo-v"></i>
                            Code Embed Vimeo
                        </h3>
                        <p class="section-description">Modifiez le code d'intégration de votre live Vimeo</p>
                    </div>

                    <div class="form-fields">
                        <div class="form-field">
                            <label for="code_embed_vimeo" class="form-label required">Code d'Intégration</label>
                            <textarea id="code_embed_vimeo" 
                                      name="code_embed_vimeo" 
                                      class="form-textarea code-textarea @error('code_embed_vimeo') error @enderror" 
                                      placeholder='<div style="padding:56.25% 0 0 0;position:relative;"><iframe src="https://vimeo.com/event/5339809/embed/interaction" frameborder="0" allow="autoplay; fullscreen; picture-in-picture; encrypted-media; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen style="position:absolute;top:0;left:0;width:100%;height:100%;"></iframe></div>'
                                      rows="6"
                                      required>{{ old('code_embed_vimeo', $webtv->code_embed_vimeo) }}</textarea>
                            @error('code_embed_vimeo')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                            <div class="field-help">
                                <div class="help-warning">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    <strong>Attention:</strong> Modifier ce code peut affecter l'affichage du live en cours.
                                </div>
                            </div>
                        </div>

                        <!-- Informations extraites -->
                        <div id="embed-info" class="embed-info">
                            <h4>Informations Actuelles</h4>
                            <div class="info-grid">
                                <div class="info-item">
                                    <label>URL Vimeo:</label>
                                    <span id="detected-url">{{ $webtv->url_vimeo_event ?? 'Non détecté' }}</span>
                                </div>
                                <div class="info-item">
                                    <label>ID Événement:</label>
                                    <span id="detected-id">{{ $webtv->vimeo_event_id ?? 'Non détecté' }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Preview actuel -->
                        <div id="current-preview" class="embed-preview">
                            <h4>Aperçu Actuel</h4>
                            <div class="preview-container">
                                {!! $webtv->code_embed_vimeo !!}
                            </div>
                        </div>

                        <!-- Nouveau preview -->
                        <div id="new-preview" class="embed-preview" style="display: none;">
                            <h4>Nouvel Aperçu</h4>
                            <div class="preview-container">
                                <div id="preview-content"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="form-actions">
                <div class="actions-left">
                    <button type="button" id="preview-btn" class="btn-secondary-modern">
                        <i class="fas fa-eye"></i>
                        <span>Prévisualiser</span>
                    </button>
                    @if($webtv->peutEtreActive())
                    <button type="button" id="toggle-actif-btn" class="btn-outline-modern">
                        <i class="fas fa-power-off"></i>
                        <span>{{ $webtv->est_actif ? 'Désactiver' : 'Activer' }}</span>
                    </button>
                    @endif
                </div>
                <div class="actions-right">
                    <a href="{{ route('admin.webtv.show', $webtv) }}" class="btn-outline-modern">
                        <i class="fas fa-eye"></i>
                        <span>Voir</span>
                    </a>
                    <a href="{{ route('dashboard.webtv.index') }}" class="btn-outline-modern">
                        <i class="fas fa-times"></i>
                        <span>Annuler</span>
                    </a>
                    <button type="submit" class="btn-primary-modern" id="submit-btn">
                        <i class="fas fa-save"></i>
                        <span>Sauvegarder</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/pages/webtv.css') }}">
@endpush

<script>
document.addEventListener('DOMContentLoaded', function() {
    const codeTextarea = document.getElementById('code_embed_vimeo');
    const newPreview = document.getElementById('new-preview');
    const previewBtn = document.getElementById('preview-btn');
    const previewContent = document.getElementById('preview-content');
    const detectedUrl = document.getElementById('detected-url');
    const detectedId = document.getElementById('detected-id');
    const toggleActifBtn = document.getElementById('toggle-actif-btn');
    
    let hasChanges = false;
    const originalCode = codeTextarea.value;

    // Détecter les changements
    codeTextarea.addEventListener('input', function() {
        hasChanges = this.value !== originalCode;
        updatePreviewButton();
    });

    // Bouton de prévisualisation
    previewBtn.addEventListener('click', function() {
        const newCode = codeTextarea.value.trim();
        if (newCode && hasChanges) {
            validateAndPreview(newCode);
        } else if (!hasChanges) {
            // Afficher l'aperçu actuel
            newPreview.style.display = 'none';
            alert('Aucune modification détectée dans le code embed.');
        }
    });

    // Toggle actif/inactif
    if (toggleActifBtn) {
        toggleActifBtn.addEventListener('click', function() {
            const webtvId = {{ $webtv->id }};
            
            fetch(`{{ route('dashboard.webtv.index') }}/${webtvId}/toggle-actif`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.succes) {
                    // Recharger la page pour mettre à jour l'interface
                    location.reload();
                } else {
                    alert('Erreur lors du changement de statut.');
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                alert('Erreur lors du changement de statut.');
            });
        });
    }

    function updatePreviewButton() {
        if (hasChanges) {
            previewBtn.innerHTML = '<i class="fas fa-eye"></i><span>Prévisualiser Modifications</span>';
            previewBtn.classList.remove('btn-secondary-modern');
            previewBtn.classList.add('btn-primary-modern');
        } else {
            previewBtn.innerHTML = '<i class="fas fa-eye"></i><span>Aperçu Actuel</span>';
            previewBtn.classList.add('btn-secondary-modern');
            previewBtn.classList.remove('btn-primary-modern');
        }
    }

    function validateAndPreview(code) {
        fetch('{{ route("dashboard.webtv.preview-embed") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ code_embed: code })
        })
        .then(response => response.json())
        .then(data => {
            if (data.valide) {
                showNewPreview(code);
                updateEmbedInfo(data);
            } else {
                alert('Code embed invalide: ' + (data.message || 'Format non reconnu'));
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            alert('Erreur lors de la validation du code.');
        });
    }

    function showNewPreview(code) {
        previewContent.innerHTML = code;
        newPreview.style.display = 'block';
        newPreview.classList.add('fade-in');
        
        // Scroll vers la nouvelle preview
        newPreview.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }

    function updateEmbedInfo(data) {
        if (data.url_vimeo) {
            detectedUrl.textContent = data.url_vimeo;
            detectedUrl.style.color = '#28a745';
        }
        
        if (data.event_id) {
            detectedId.textContent = data.event_id;
            detectedId.style.color = '#28a745';
        }
    }

    // Validation avant soumission
    document.getElementById('webtv-form').addEventListener('submit', function(e) {
        const titre = document.getElementById('titre').value.trim();
        const code = codeTextarea.value.trim();
        
        if (!titre || !code) {
            e.preventDefault();
            alert('Veuillez remplir tous les champs obligatoires.');
            return false;
        }

        if (hasChanges) {
            const confirmMessage = 'Vous avez modifié le code embed. Cette modification peut affecter l\'affichage du live. Confirmer ?';
            if (!confirm(confirmMessage)) {
                e.preventDefault();
                return false;
            }
        }
    });

    // Compteurs de caractères
    const createCharCounter = (input, maxLength) => {
        const counter = document.createElement('div');
        counter.className = 'char-counter';
        counter.style.cssText = 'font-size: 0.8rem; color: #6c757d; text-align: right; margin-top: 0.25rem;';
        input.parentElement.appendChild(counter);
        
        const updateCounter = () => {
            const current = input.value.length;
            counter.textContent = `${current}/${maxLength}`;
            counter.style.color = current > maxLength * 0.9 ? '#dc3545' : '#6c757d';
        };
        
        input.addEventListener('input', updateCounter);
        updateCounter();
    };

    createCharCounter(document.getElementById('titre'), 255);
    createCharCounter(document.getElementById('description'), 1000);

    // Auto-resize du textarea
    codeTextarea.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';
    });

    // Initialisation
    updatePreviewButton();
});
</script>
@endsection