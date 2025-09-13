@extends('layouts.dashboard-ultra')

@section('title', 'Nouveau Live')
@section('page-title', 'Nouveau Live')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/webtv.css') }}">
    <style>
        /* Variables CSS pour la cohérence */
        :root {
            --ea-gold: #F2CB05;
            --ea-blue: #2563eb;
            --ea-green: #10b981;
            --ea-danger: #dc3545;
            --live-red: #ff3333;
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

        /* Header avec indicateur Live */
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
            border-left: 4px solid var(--live-red);
        }

        .header-content {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .header-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--live-red), #ff6666);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.05); opacity: 0.9; }
        }

        .live-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--live-red);
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-left: 1rem;
        }

        .live-badge::before {
            content: '';
            width: 8px;
            height: 8px;
            background: white;
            border-radius: 50%;
            animation: blink 1s infinite;
        }

        @keyframes blink {
            0%, 50% { opacity: 1; }
            51%, 100% { opacity: 0.3; }
        }

        /* Form styling spécifique aux lives */
        .form-section.live-section {
            border-left: 3px solid var(--live-red);
        }

        .form-section.live-section .section-title {
            color: var(--live-red);
        }

        /* Code embed styling */
        .embed-preview-live {
            border: 2px solid var(--live-red);
            border-radius: 10px;
            padding: 1rem;
            background: rgba(255, 51, 51, 0.05);
        }

        /* Boutons spécifiques live */
        .btn-live-primary {
            background: linear-gradient(135deg, var(--live-red), #ff6666);
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

        .btn-live-primary:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-hover);
            color: white;
            text-decoration: none;
        }

        /* Alert de programmation */
        .scheduling-alert {
            background: linear-gradient(135deg, rgba(255, 51, 51, 0.1), rgba(255, 102, 102, 0.1));
            border: 1px solid rgba(255, 51, 51, 0.3);
            border-radius: 10px;
            padding: 1rem;
            margin-top: 1rem;
        }

        .scheduling-alert .alert-icon {
            color: var(--live-red);
            font-size: 1.2rem;
            margin-right: 0.5rem;
        }
    </style>
@endpush

@section('content')
<div class="modern-webtv-create-section">
    <!-- Enhanced Header pour Live -->
    <div class="page-header-modern">
        <div class="header-content">
            <div class="header-main">
                <div class="header-icon">
                    <i class="fas fa-broadcast-tower"></i>
                </div>
                <div class="header-info">
                    <h1 class="page-title">
                        Nouveau Live
                        <span class="live-badge">Live</span>
                    </h1>
                    <p class="page-subtitle">Créez une nouvelle diffusion en direct Vimeo</p>
                    <div class="breadcrumb-modern">
                        <a href="{{ url('/') }}" class="breadcrumb-item">
                            <i class="fas fa-home"></i>
                            Dashboard
                        </a>
                        <i class="fas fa-chevron-right breadcrumb-separator"></i>
                        <a href="{{ route('dashboard.webtv.index') }}" class="breadcrumb-item">WebTV</a>
                        <i class="fas fa-chevron-right breadcrumb-separator"></i>
                        <span class="breadcrumb-item active">Nouveau Live</span>
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
        <form id="live-form" action="{{ route('dashboard.webtv.store') }}" method="POST">
            @csrf
            <input type="hidden" name="type_programme" value="live">

            <div class="form-grid">
                <!-- Informations du Live -->
                <div class="form-section live-section">
                    <div class="section-header">
                        <h3 class="section-title">
                            <i class="fas fa-broadcast-tower"></i>
                            Informations du Live
                        </h3>
                        <p class="section-description">Configurez les détails de votre diffusion en direct</p>
                    </div>

                    <div class="form-fields">
                        <div class="form-field">
                            <label for="titre" class="form-label required">Titre du Live</label>
                            <input type="text"
                                   id="titre"
                                   name="titre"
                                   class="form-input @error('titre') error @enderror"
                                   placeholder="Ex: Débat Économique - Excellence Afrik Live"
                                   value="{{ old('titre') }}"
                                   maxlength="255"
                                   required>
                            @error('titre')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                            <div class="field-help">Titre affiché pendant la diffusion (max 255 caractères)</div>
                        </div>

                        <div class="form-field">
                            <label for="description" class="form-label">Description du Live</label>
                            <textarea id="description"
                                      name="description"
                                      class="form-textarea @error('description') error @enderror"
                                      placeholder="Description de votre live : sujet, invités, thème..."
                                      rows="4"
                                      maxlength="1000">{{ old('description') }}</textarea>
                            @error('description')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                            <div class="field-help">Description visible sur la page WebTV (max 1000 caractères)</div>
                        </div>

                        <div class="form-field">
                            <label for="date_programmee" class="form-label">Programmation</label>
                            <input type="datetime-local"
                                   id="date_programmee"
                                   name="date_programmee"
                                   class="form-input @error('date_programmee') error @enderror"
                                   value="{{ old('date_programmee') }}"
                                   min="{{ now()->format('Y-m-d\TH:i') }}">
                            @error('date_programmee')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                            <div class="scheduling-alert">
                                <i class="fas fa-clock alert-icon"></i>
                                <strong>Live immédiat :</strong> Laissez ce champ vide pour un live qui commence maintenant.<br>
                                <strong>Live programmé :</strong> Sélectionnez la date et heure de début.
                            </div>
                        </div>

                        <div class="form-field">
                            <label for="duree_estimee" class="form-label">Durée Estimée</label>
                            <div class="duration-input">
                                <input type="number"
                                       id="duree_estimee"
                                       name="duree_estimee"
                                       class="form-input @error('duree_estimee') error @enderror"
                                       placeholder="60"
                                       value="{{ old('duree_estimee') }}"
                                       min="5"
                                       max="480">
                                <span class="duration-unit">minutes</span>
                            </div>
                            @error('duree_estimee')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                            <div class="field-help">Durée approximative du live (5-480 minutes)</div>
                        </div>

                        <div class="form-field">
                            <label for="statut" class="form-label required">Statut Initial</label>
                            <select id="statut" name="statut" class="form-select @error('statut') error @enderror" required>
                                <option value="draft" {{ old('statut', 'draft') === 'draft' ? 'selected' : '' }}>Brouillon (non visible)</option>
                                <option value="programme" {{ old('statut') === 'programme' ? 'selected' : '' }}>Programmé (visible, en attente)</option>
                                <option value="en_direct" {{ old('statut') === 'en_direct' ? 'selected' : '' }}>En Direct (diffusion active)</option>
                            </select>
                            @error('statut')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                            <div class="field-help">Statut de publication du live</div>
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
                                    Visible immédiatement sur la page WebTV
                                </label>
                            </div>
                            <div class="field-help">Si coché, ce live sera visible côté visiteur selon son statut</div>
                        </div>
                    </div>
                </div>

                <!-- Configuration Vimeo Live -->
                <div class="form-section live-section">
                    <div class="section-header">
                        <h3 class="section-title">
                            <i class="fab fa-vimeo-v"></i>
                            Configuration Vimeo Live
                        </h3>
                        <p class="section-description">Intégration avec votre événement live Vimeo</p>
                    </div>

                    <div class="form-fields">
                        <div class="form-field">
                            <label for="code_embed_vimeo" class="form-label required">Code d'Intégration Live Vimeo</label>
                            <textarea id="code_embed_vimeo"
                                      name="code_embed_vimeo"
                                      class="form-textarea code-textarea @error('code_embed_vimeo') error @enderror"
                                      placeholder='<div style="padding:56.25% 0 0 0;position:relative;"><iframe src="https://vimeo.com/event/1234567/embed/interaction" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen style="position:absolute;top:0;left:0;width:100%;height:100%;"></iframe></div>'
                                      rows="8"
                                      required>{{ old('code_embed_vimeo') }}</textarea>
                            @error('code_embed_vimeo')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                            <div class="field-help">
                                <div class="help-steps">
                                    <strong>📋 Comment obtenir ce code :</strong>
                                    <ol>
                                        <li><strong>Créez votre événement live</strong> sur Vimeo</li>
                                        <li><strong>Configurez les paramètres</strong> de diffusion</li>
                                        <li><strong>Allez dans l'onglet "Embed"</strong> de votre événement</li>
                                        <li><strong>Copiez le code d'intégration complet</strong> et collez-le ci-dessus</li>
                                        <li><strong>Testez la prévisualisation</strong> avant de créer</li>
                                    </ol>
                                    <div class="alert alert-info mt-2">
                                        <i class="fas fa-info-circle"></i>
                                        Le code doit contenir "vimeo.com/event/" pour être valide
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Informations extraites -->
                        <div id="embed-info" class="embed-info" style="display: none;">
                            <h4><i class="fas fa-check-circle text-success"></i> Informations Détectées</h4>
                            <div class="info-grid">
                                <div class="info-item">
                                    <label>URL Vimeo Event:</label>
                                    <span id="detected-url">-</span>
                                </div>
                                <div class="info-item">
                                    <label>ID Événement:</label>
                                    <span id="detected-id">-</span>
                                </div>
                            </div>
                        </div>

                        <!-- Preview Live -->
                        <div id="embed-preview" class="embed-preview-live" style="display: none;">
                            <h4><i class="fas fa-play-circle"></i> Aperçu du Player Live</h4>
                            <div class="preview-container">
                                <div id="preview-content"></div>
                            </div>
                            <div class="alert alert-warning mt-2">
                                <i class="fas fa-exclamation-triangle"></i>
                                <strong>Note :</strong> L'aperçu peut ne pas fonctionner complètement avant que votre live ne soit actif sur Vimeo.
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
                    <button type="submit" class="btn-live-primary" id="submit-btn" disabled>
                        <i class="fas fa-broadcast-tower"></i>
                        <span>Créer le Live</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const codeTextarea = document.getElementById('code_embed_vimeo');
    const embedInfo = document.getElementById('embed-info');
    const embedPreview = document.getElementById('embed-preview');
    const previewBtn = document.getElementById('preview-btn');
    const submitBtn = document.getElementById('submit-btn');
    const previewContent = document.getElementById('preview-content');
    const detectedUrl = document.getElementById('detected-url');
    const detectedId = document.getElementById('detected-id');

    let currentEmbedCode = '';
    let validationTimeout;

    // Validation en temps réel du code embed
    codeTextarea.addEventListener('input', function() {
        clearTimeout(validationTimeout);
        const code = this.value.trim();

        if (code) {
            validationTimeout = setTimeout(() => {
                validateEmbedCode(code);
            }, 500);
        } else {
            resetValidation();
        }
    });

    // Bouton de prévisualisation
    previewBtn.addEventListener('click', function() {
        showPreview();
    });

    function validateEmbedCode(code) {
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
                showEmbedInfo(data);
                enableActions();
                currentEmbedCode = code;
            } else {
                showError(data.message || 'Code embed invalide');
                resetValidation();
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            showError('Erreur lors de la validation');
            resetValidation();
        });
    }

    function showEmbedInfo(data) {
        detectedUrl.textContent = data.url_vimeo || 'Non détecté';
        detectedId.textContent = data.event_id || 'Non détecté';

        embedInfo.style.display = 'block';
        embedInfo.classList.add('fade-in');

        // Ajouter indicateur de succès au textarea
        codeTextarea.classList.remove('error');
        codeTextarea.style.borderColor = '#10b981';
        codeTextarea.style.backgroundColor = 'rgba(16, 185, 129, 0.05)';
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
        previewBtn.classList.add('btn-live-primary');
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
        previewBtn.classList.remove('btn-live-primary');
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
    document.getElementById('live-form').addEventListener('submit', function(e) {
        const titre = document.getElementById('titre').value.trim();
        const code = codeTextarea.value.trim();

        if (!titre || !code) {
            e.preventDefault();
            alert('⚠️ Veuillez remplir tous les champs obligatoires.');
            return false;
        }

        if (!currentEmbedCode) {
            e.preventDefault();
            alert('⚠️ Veuillez vérifier le code embed du live Vimeo.');
            return false;
        }

        // Message de confirmation pour live immédiat
        const statut = document.getElementById('statut').value;
        if (statut === 'en_direct') {
            const confirm_message = '🔴 Vous allez créer un live en cours de diffusion. Êtes-vous sûr que le live Vimeo est déjà actif ?';
            if (!confirm(confirm_message)) {
                e.preventDefault();
                return false;
            }
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

    // Validation initiale si du contenu existe déjà
    if (codeTextarea.value.trim()) {
        validateEmbedCode(codeTextarea.value.trim());
    }
});
</script>
@endsection