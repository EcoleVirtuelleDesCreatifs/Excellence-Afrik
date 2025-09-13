@extends('layouts.dashboard-ultra')

@section('title', 'Nouveau Programme')
@section('page-title', 'Nouveau Programme')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/webtv.css') }}">
    <style>
        /* Variables CSS pour la cohérence */
        :root {
            --ea-gold: #F2CB05;
            --ea-blue: #2563eb;
            --ea-green: #10b981;
            --ea-danger: #dc3545;
            --program-purple: #8b5cf6;
            --card-bg: #ffffff;
            --card-border: #e9ecef;
            --text-primary: #2c3e50;
            --text-secondary: #6c757d;
            --shadow-light: 0 2px 10px rgba(0,0,0,0.08);
            --shadow-hover: 0 4px 20px rgba(0,0,0,0.12);
        }

        /* Layout principal */
        .modern-webtv-create-section {
            background: #f8f9fa;
            min-height: 100vh;
        }

        /* Header avec indicateur Programme */
        .page-header-modern {
            background: white;
            border-radius: 12px;
            box-shadow: var(--shadow-light);
            padding: 2rem;
            margin-bottom: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
            border-left: 4px solid var(--program-purple);
        }

        .header-content {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .header-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--program-purple), #a78bfa);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
        }

        .program-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--program-purple);
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-left: 1rem;
        }

        /* Form styling spécifique aux programmes */
        .form-section.program-section {
            border-left: 3px solid var(--program-purple);
        }

        .form-section.program-section .section-title {
            color: var(--program-purple);
        }

        /* Catégories styling */
        .category-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }

        .category-card {
            padding: 1rem;
            border: 2px solid transparent;
            border-radius: 10px;
            background: rgba(139, 92, 246, 0.05);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .category-card:hover,
        .category-card.selected {
            border-color: var(--program-purple);
            background: rgba(139, 92, 246, 0.1);
        }

        .category-card input[type="radio"] {
            display: none;
        }

        .category-icon {
            font-size: 2rem;
            color: var(--program-purple);
            margin-bottom: 0.5rem;
        }

        .category-title {
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.25rem;
        }

        .category-desc {
            font-size: 0.9rem;
            color: var(--text-secondary);
        }

        /* Code embed styling */
        .embed-preview-program {
            border: 2px solid var(--program-purple);
            border-radius: 10px;
            padding: 1rem;
            background: rgba(139, 92, 246, 0.05);
        }

        /* Boutons spécifiques programme */
        .btn-program-primary {
            background: linear-gradient(135deg, var(--program-purple), #a78bfa);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            border: none;
            transition: all 0.3s ease;
        }

        .btn-program-primary:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-hover);
            color: white;
            text-decoration: none;
        }

        /* Métadonnées du programme */
        .program-metadata {
            background: linear-gradient(135deg, rgba(139, 92, 246, 0.1), rgba(167, 139, 250, 0.1));
            border: 1px solid rgba(139, 92, 246, 0.3);
            border-radius: 10px;
            padding: 1.5rem;
            margin-top: 1rem;
        }

        .metadata-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }

        .metadata-item label {
            display: block;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--program-purple);
        }
    </style>
@endpush

@section('content')
<div class="modern-webtv-create-section">
    <!-- Enhanced Header pour Programme -->
    <div class="page-header-modern">
        <div class="header-content">
            <div class="header-main">
                <div class="header-icon">
                    <i class="fas fa-video"></i>
                </div>
                <div class="header-info">
                    <h1 class="page-title">
                        Nouveau Programme
                        <span class="program-badge">Vidéo</span>
                    </h1>
                    <p class="page-subtitle">Ajoutez une vidéo préenregistrée à votre catalogue WebTV</p>
                    <div class="breadcrumb-modern">
                        <a href="{{ url('/') }}" class="breadcrumb-item">
                            <i class="fas fa-home"></i>
                            Dashboard
                        </a>
                        <i class="fas fa-chevron-right breadcrumb-separator"></i>
                        <a href="{{ route('dashboard.webtv.index') }}" class="breadcrumb-item">WebTV</a>
                        <i class="fas fa-chevron-right breadcrumb-separator"></i>
                        <span class="breadcrumb-item active">Nouveau Programme</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-actions">
            <a href="{{ route('dashboard.webtv.index') }}" class="btn-secondary-modern">
                <i class="fas fa-arrow-left"></i>
                <span>Retour</span>
            </a>
        </div>
    </div>

    <!-- Form Container -->
    <div class="form-container-modern">
        <form id="program-form" action="{{ route('dashboard.webtv.store') }}" method="POST">
            @csrf
            <input type="hidden" name="type_programme" value="programme">

            <div class="form-grid">
                <!-- Informations du Programme -->
                <div class="form-section program-section">
                    <div class="section-header">
                        <h3 class="section-title">
                            <i class="fas fa-info-circle"></i>
                            Informations du Programme
                        </h3>
                        <p class="section-description">Détails de votre programme vidéo</p>
                    </div>

                    <div class="form-fields">
                        <div class="form-field">
                            <label for="titre" class="form-label required">Titre du Programme</label>
                            <input type="text"
                                   id="titre"
                                   name="titre"
                                   class="form-input @error('titre') error @enderror"
                                   placeholder="Ex: Portrait d'Entrepreneur - Innovation Tech"
                                   value="{{ old('titre') }}"
                                   maxlength="255"
                                   required>
                            @error('titre')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                            <div class="field-help">Titre affiché dans le catalogue (max 255 caractères)</div>
                        </div>

                        <div class="form-field">
                            <label class="form-label required">Catégorie du Programme</label>
                            <div class="category-grid">
                                <div class="category-card" data-category="debates">
                                    <input type="radio" id="cat_debates" name="categorie" value="debates" {{ old('categorie') === 'debates' ? 'checked' : '' }} required>
                                    <label for="cat_debates">
                                        <div class="category-icon">🎯</div>
                                        <div class="category-title">Débats</div>
                                        <div class="category-desc">Discussions et débats d'experts</div>
                                    </label>
                                </div>
                                <div class="category-card" data-category="interviews">
                                    <input type="radio" id="cat_interviews" name="categorie" value="interviews" {{ old('categorie') === 'interviews' ? 'checked' : '' }}>
                                    <label for="cat_interviews">
                                        <div class="category-icon">🎤</div>
                                        <div class="category-title">Interviews</div>
                                        <div class="category-desc">Entretiens avec des personnalités</div>
                                    </label>
                                </div>
                                <div class="category-card" data-category="reportages">
                                    <input type="radio" id="cat_reportages" name="categorie" value="reportages" {{ old('categorie') === 'reportages' ? 'checked' : '' }}>
                                    <label for="cat_reportages">
                                        <div class="category-icon">📹</div>
                                        <div class="category-title">Reportages</div>
                                        <div class="category-desc">Documentaires et enquêtes</div>
                                    </label>
                                </div>
                                <div class="category-card" data-category="documentaires">
                                    <input type="radio" id="cat_documentaires" name="categorie" value="documentaires" {{ old('categorie') === 'documentaires' ? 'checked' : '' }}>
                                    <label for="cat_documentaires">
                                        <div class="category-icon">🎬</div>
                                        <div class="category-title">Documentaires</div>
                                        <div class="category-desc">Programmes documentaires</div>
                                    </label>
                                </div>
                                <div class="category-card" data-category="general">
                                    <input type="radio" id="cat_general" name="categorie" value="general" {{ old('categorie') === 'general' ? 'checked' : '' }}>
                                    <label for="cat_general">
                                        <div class="category-icon">📺</div>
                                        <div class="category-title">Général</div>
                                        <div class="category-desc">Contenu varié et divertissement</div>
                                    </label>
                                </div>
                            </div>
                            @error('categorie')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-field">
                            <label for="description" class="form-label">Description du Programme</label>
                            <textarea id="description"
                                      name="description"
                                      class="form-textarea @error('description') error @enderror"
                                      placeholder="Description détaillée : sujet traité, invités, points clés abordés..."
                                      rows="5"
                                      maxlength="1000">{{ old('description') }}</textarea>
                            @error('description')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                            <div class="field-help">Description visible dans le catalogue (max 1000 caractères)</div>
                        </div>

                        <div class="program-metadata">
                            <h4><i class="fas fa-cog"></i> Métadonnées du Programme</h4>
                            <div class="metadata-grid">
                                <div class="metadata-item">
                                    <label for="duree_estimee">Durée</label>
                                    <div class="duration-input">
                                        <input type="number"
                                               id="duree_estimee"
                                               name="duree_estimee"
                                               class="form-input @error('duree_estimee') error @enderror"
                                               placeholder="30"
                                               value="{{ old('duree_estimee') }}"
                                               min="1"
                                               max="600">
                                        <span class="duration-unit">minutes</span>
                                    </div>
                                    <div class="field-help">Durée réelle de la vidéo</div>
                                </div>

                                <div class="metadata-item">
                                    <label for="statut">Statut de Publication</label>
                                    <select id="statut" name="statut" class="form-select @error('statut') error @enderror" required>
                                        <option value="draft" {{ old('statut', 'draft') === 'draft' ? 'selected' : '' }}>Brouillon (non publié)</option>
                                        <option value="programme" {{ old('statut') === 'programme' ? 'selected' : '' }}>Publié (visible)</option>
                                        <option value="termine" {{ old('statut') === 'termine' ? 'selected' : '' }}>Archivé</option>
                                    </select>
                                    <div class="field-help">Statut de publication du programme</div>
                                </div>
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
                                       {{ old('est_actif', 1) ? 'checked' : '' }}>
                                <label for="est_actif" class="checkbox-label">
                                    <i class="fas fa-eye"></i>
                                    Visible dans les "Programmes Récents"
                                </label>
                            </div>
                            <div class="field-help">Si coché, ce programme apparaîtra sur la page WebTV</div>
                        </div>
                    </div>
                </div>

                <!-- Configuration Vimeo Programme -->
                <div class="form-section program-section">
                    <div class="section-header">
                        <h3 class="section-title">
                            <i class="fab fa-vimeo-v"></i>
                            Intégration Vidéo Vimeo
                        </h3>
                        <p class="section-description">Configuration de votre vidéo Vimeo préenregistrée</p>
                    </div>

                    <div class="form-fields">
                        <div class="form-field">
                            <label for="code_integration_vimeo" class="form-label required">Code d'Intégration Vidéo Vimeo</label>
                            <textarea id="code_integration_vimeo"
                                      name="code_integration_vimeo"
                                      class="form-textarea code-textarea @error('code_integration_vimeo') error @enderror"
                                      placeholder='<div style="padding:56.25% 0 0 0;position:relative;"><iframe src="https://player.vimeo.com/video/1104807208?badge=0&amp;autopause=0&amp;player_id=0&amp;app_id=58479" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen style="position:absolute;top:0;left:0;width:100%;height:100%;" title="Titre de la vidéo"></iframe></div>'
                                      rows="8"
                                      required>{{ old('code_integration_vimeo') }}</textarea>
                            @error('code_integration_vimeo')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                            <div class="field-help">
                                <div class="help-steps">
                                    <strong>📋 Comment obtenir ce code :</strong>
                                    <ol>
                                        <li><strong>Uploadez votre vidéo</strong> sur Vimeo</li>
                                        <li><strong>Attendez la fin du traitement</strong> de la vidéo</li>
                                        <li><strong>Allez sur la page de votre vidéo</strong> sur Vimeo</li>
                                        <li><strong>Cliquez sur le bouton "Partager"</strong> ou "Share"</li>
                                        <li><strong>Copiez le code d'intégration</strong> complet et collez-le ci-dessus</li>
                                        <li><strong>Vérifiez la prévisualisation</strong> avant de créer</li>
                                    </ol>
                                    <div class="alert alert-info mt-2">
                                        <i class="fas fa-info-circle"></i>
                                        Le code doit contenir "player.vimeo.com/video/" pour être valide
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Informations extraites -->
                        <div id="embed-info" class="embed-info" style="display: none;">
                            <h4><i class="fas fa-check-circle text-success"></i> Informations Détectées</h4>
                            <div class="info-grid">
                                <div class="info-item">
                                    <label>URL Vidéo Vimeo:</label>
                                    <span id="detected-url">-</span>
                                </div>
                                <div class="info-item">
                                    <label>ID Vidéo:</label>
                                    <span id="detected-id">-</span>
                                </div>
                            </div>
                        </div>

                        <!-- Preview Programme -->
                        <div id="embed-preview" class="embed-preview-program" style="display: none;">
                            <h4><i class="fas fa-play-circle"></i> Aperçu du Programme</h4>
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
                    <button type="button" id="preview-btn" class="btn-secondary-modern" disabled>
                        <i class="fas fa-eye"></i>
                        <span>Prévisualiser</span>
                    </button>
                </div>
                <div class="actions-right">
                    <a href="{{ route('dashboard.webtv.index') }}" class="btn-outline-modern">
                        <i class="fas fa-times"></i>
                        <span>Annuler</span>
                    </a>
                    <button type="submit" class="btn-program-primary" id="submit-btn" disabled>
                        <i class="fas fa-video"></i>
                        <span>Créer le Programme</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const codeTextarea = document.getElementById('code_integration_vimeo');
    const embedInfo = document.getElementById('embed-info');
    const embedPreview = document.getElementById('embed-preview');
    const previewBtn = document.getElementById('preview-btn');
    const submitBtn = document.getElementById('submit-btn');
    const previewContent = document.getElementById('preview-content');
    const detectedUrl = document.getElementById('detected-url');
    const detectedId = document.getElementById('detected-id');

    let currentEmbedCode = '';

    // Gestion des cartes de catégorie
    document.querySelectorAll('.category-card').forEach(card => {
        card.addEventListener('click', function() {
            // Désélectionner toutes les cartes
            document.querySelectorAll('.category-card').forEach(c => c.classList.remove('selected'));

            // Sélectionner la carte cliquée
            this.classList.add('selected');

            // Cocher le radio button correspondant
            const radio = this.querySelector('input[type="radio"]');
            if (radio) {
                radio.checked = true;
            }
        });
    });

    // Sélection initiale si une catégorie est déjà cochée
    document.querySelectorAll('input[name="categorie"]:checked').forEach(radio => {
        radio.closest('.category-card').classList.add('selected');
    });

    // Validation en temps réel du code embed (plus simple pour les programmes)
    codeTextarea.addEventListener('input', function() {
        const code = this.value.trim();

        if (code) {
            validateEmbedCode(code);
        } else {
            resetValidation();
        }
    });

    // Bouton de prévisualisation
    previewBtn.addEventListener('click', function() {
        showPreview();
    });

    function validateEmbedCode(code) {
        // Validation simple côté client pour les programmes
        if (code.includes('player.vimeo.com/video/') && code.includes('iframe')) {
            // Extraction de l'ID vidéo
            const match = code.match(/player\.vimeo\.com\/video\/(\d+)/);
            const videoId = match ? match[1] : null;

            showEmbedInfo({
                valide: true,
                url_vimeo: match ? `https://vimeo.com/${videoId}` : 'Détecté',
                event_id: videoId || 'Détecté',
                code_embed: code
            });
            enableActions();
            currentEmbedCode = code;
        } else {
            showError('Code d\'intégration Vimeo invalide. Vérifiez qu\'il contient bien un iframe de player.vimeo.com/video/');
            resetValidation();
        }
    }

    function showEmbedInfo(data) {
        detectedUrl.textContent = data.url_vimeo || 'Non détecté';
        detectedId.textContent = data.event_id || 'Non détecté';

        embedInfo.style.display = 'block';
        embedInfo.classList.add('fade-in');

        // Ajouter indicateur de succès au textarea
        codeTextarea.classList.remove('error');
        codeTextarea.style.borderColor = '#8b5cf6';
        codeTextarea.style.backgroundColor = 'rgba(139, 92, 246, 0.05)';
    }

    function showPreview() {
        if (currentEmbedCode) {
            previewContent.innerHTML = currentEmbedCode;
            embedPreview.style.display = 'block';
            embedPreview.classList.add('fade-in');

            // Scroll vers la preview
            embedPreview.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }
    }

    function enableActions() {
        previewBtn.disabled = false;
        submitBtn.disabled = false;
        previewBtn.classList.remove('btn-secondary-modern');
        previewBtn.classList.add('btn-program-primary');
        submitBtn.style.opacity = '1';
        submitBtn.style.transform = 'none';
    }

    function resetValidation() {
        embedInfo.style.display = 'none';
        embedPreview.style.display = 'none';
        previewBtn.disabled = true;
        submitBtn.disabled = true;
        codeTextarea.style.borderColor = '';
        codeTextarea.style.backgroundColor = '';
        currentEmbedCode = '';

        previewBtn.classList.add('btn-secondary-modern');
        previewBtn.classList.remove('btn-program-primary');
        submitBtn.style.opacity = '0.6';
        submitBtn.style.transform = 'scale(0.98)';
    }

    function showError(message) {
        codeTextarea.classList.add('error');
        codeTextarea.style.borderColor = '#dc3545';
        codeTextarea.style.backgroundColor = 'rgba(220, 53, 69, 0.05)';

        // Créer ou mettre à jour le message d'erreur
        let errorSpan = codeTextarea.parentElement.querySelector('.error-message');
        if (!errorSpan) {
            errorSpan = document.createElement('span');
            errorSpan.className = 'error-message';
            codeTextarea.parentElement.appendChild(errorSpan);
        }
        errorSpan.textContent = message;
    }

    // Validation du formulaire avant soumission
    document.getElementById('program-form').addEventListener('submit', function(e) {
        const titre = document.getElementById('titre').value.trim();
        const code = codeTextarea.value.trim();
        const categorie = document.querySelector('input[name="categorie"]:checked');

        if (!titre || !code || !categorie) {
            e.preventDefault();
            alert('⚠️ Veuillez remplir tous les champs obligatoires (titre, catégorie, code d\'intégration).');
            return false;
        }

        if (!currentEmbedCode) {
            e.preventDefault();
            alert('⚠️ Veuillez vérifier le code d\'intégration Vimeo.');
            return false;
        }
    });

    // Auto-resize du textarea
    codeTextarea.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';
    });

    // Compteur de caractères
    function createCharCounter(input, maxLength) {
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
    }

    createCharCounter(document.getElementById('titre'), 255);
    createCharCounter(document.getElementById('description'), 1000);

    // Activation des actions par défaut pour les programmes (validation plus simple)
    enableActions();

    // Validation initiale si du contenu existe déjà
    if (codeTextarea.value.trim()) {
        validateEmbedCode(codeTextarea.value.trim());
    }
});
</script>
@endsection