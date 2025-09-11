@extends('layouts.dashboard-ultra')

@section('title', 'Gestion WebTV')
@section('page-title', 'Gestion WebTV')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/webtv.css') }}">
    <style>
        /* Variables CSS pour la cohérence */
        :root {
            --ea-gold: #F2CB05;
            --ea-blue: #2563eb;
            --ea-green: #10b981;
            --ea-danger: #dc3545;
            --card-bg: #ffffff;
            --card-border: #e9ecef;
            --text-primary: #2c3e50;
            --text-secondary: #6c757d;
            --shadow-light: 0 2px 10px rgba(0,0,0,0.08);
            --shadow-hover: 0 4px 20px rgba(0,0,0,0.12);
        }
        
        /* Layout principal */
        .modern-webtv-section {
            background: #f8f9fa;
            min-height: 100vh;
        }
        
        /* Header amélioré */
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
        }
        
        .header-content {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .header-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--ea-gold), var(--ea-blue));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
        }
        
        .page-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0;
        }
        
        .page-subtitle {
            color: var(--text-secondary);
            margin: 0.25rem 0 0 0;
        }
        
        .breadcrumb-modern {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.9rem;
            color: var(--text-secondary);
            margin-top: 0.5rem;
        }
        
        .breadcrumb-item {
            color: var(--text-secondary);
            text-decoration: none;
        }
        
        .breadcrumb-item.active {
            color: var(--ea-gold);
            font-weight: 600;
        }
        
        /* Boutons d'actions du header */
        .header-actions {
            display: flex;
            gap: 1rem;
            align-items: center;
        }
        
        .btn-primary-modern {
            background: linear-gradient(135deg, var(--ea-gold), #e6b800);
            color: #000;
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
        
        .btn-primary-modern:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-hover);
            color: #000;
            text-decoration: none;
        }
        
        .btn-secondary-modern {
            background: var(--ea-blue);
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
        
        .btn-secondary-modern:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-hover);
            background: #1d4ed8;
            color: white;
            text-decoration: none;
        }
        
        /* Toolbar simplifié */
        .webtv-toolbar {
            background: white;
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 1rem;
            box-shadow: var(--shadow-light);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }
        
        .search-group {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border: 2px solid var(--card-border);
            border-radius: 8px;
            background: #f8f9fa;
            min-width: 300px;
        }
        
        .search-input {
            background: transparent;
            border: none;
            outline: none;
            color: var(--text-primary);
            width: 100%;
        }
        
        .search-input::placeholder {
            color: var(--text-secondary);
        }
        
        .toolbar-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .filter-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border: 2px solid var(--card-border);
            border-radius: 8px;
            background: #f8f9fa;
        }
        
        .filter-select {
            background: transparent;
            border: none;
            outline: none;
            color: var(--text-primary);
            cursor: pointer;
        }
        
        /* Messages d'alerte */
        .alert-modern {
            padding: 1rem 1.5rem;
            border-radius: 10px;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1rem;
        }
        
        .alert-modern.success {
            background: rgba(16, 185, 129, 0.1);
            border: 1px solid rgba(16, 185, 129, 0.3);
            color: var(--ea-green);
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .page-header-modern {
                flex-direction: column;
                text-align: center;
            }
            
            .header-actions {
                width: 100%;
                justify-content: center;
            }
            
            .search-group {
                min-width: 100%;
            }
        }
    </style>
@endpush

@section('content')
<div class="modern-webtv-section">
    @php
        // Ensure collection methods like where()/count() work even if $webtvs is a Paginator
        $webtvItems = $webtvs instanceof \Illuminate\Pagination\AbstractPaginator
            ? $webtvs->getCollection()
            : $webtvs;
    @endphp
    <!-- Enhanced Header -->
    <div class="page-header-modern">
        <div class="header-content">
            <div class="header-main">
                <div class="header-icon">
                    <i class="fas fa-tv"></i>
                </div>
                <div class="header-info">
                    <h1 class="page-title">Gestion WebTV</h1>
                    <p class="page-subtitle">Gérez vos lives Vimeo et diffusions en direct</p>
                    <div class="breadcrumb-modern">
                        <a href="{{ url('/') }}" class="breadcrumb-item">
                            <i class="fas fa-home"></i>
                            Dashboard
                        </a>
                        <i class="fas fa-chevron-right breadcrumb-separator"></i>
                        <span class="breadcrumb-item active">WebTV</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-actions">
            <a href="{{ route('dashboard.webtv.media.create') }}" class="btn-primary-modern main-btn">
                <i class="fas fa-broadcast-tower"></i>
                <span>Nouveau Live</span>
            </a>
            <a href="{{ route('dashboard.webtv.programs.create') }}" class="btn-secondary-modern">
                <i class="fas fa-video"></i>
                <span>Nouveau Programme</span>
            </a>
        </div>
    </div>

    @if(session('status'))
    <div class="alert-modern success" role="alert" style="margin-top:12px">
        <i class="fas fa-check-circle"></i>
        <span>{{ session('status') }}</span>
    </div>
    @endif

    <!-- Toolbar simplifié -->
    <div class="webtv-toolbar">
        <div class="search-group">
            <i class="fas fa-search"></i>
            <input type="text" class="search-input" placeholder="Rechercher un live ou programme..." />
        </div>
        <div class="toolbar-actions">
            <div class="filter-item">
                <i class="fas fa-filter"></i>
                <select class="filter-select" aria-label="Filtrer par statut">
                    <option value="all" selected>Tous les statuts</option>
                    <option value="en_direct">En direct</option>
                    <option value="programme">Programmé</option>
                    <option value="draft">Brouillon</option>
                    <option value="termine">Terminé</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Status Cards -->
    <div class="webtv-status-cards">
        <div class="status-card live-card">
            <div class="status-icon">
                <i class="fas fa-circle status-dot"></i>
                <i class="fas fa-broadcast-tower"></i>
            </div>
            <div class="status-info">
                <div class="status-value">{{ $webtvItems->where('statut', 'en_direct')->where('est_actif', true)->count() }}</div>
                <div class="status-label">En Direct</div>
            </div>
        </div>
        <div class="status-card scheduled-card">
            <div class="status-icon">
                <i class="fas fa-clock"></i>
            </div>
            <div class="status-info">
                <div class="status-value">{{ $webtvItems->where('statut', 'programme')->count() }}</div>
                <div class="status-label">Programmés</div>
            </div>
        </div>
        <div class="status-card draft-card">
            <div class="status-icon">
                <i class="fas fa-edit"></i>
            </div>
            <div class="status-info">
                <div class="status-value">{{ $webtvItems->where('statut', 'draft')->count() }}</div>
                <div class="status-label">Brouillons</div>
            </div>
        </div>
        <div class="status-card archived-card">
            <div class="status-icon">
                <i class="fas fa-archive"></i>
            </div>
            <div class="status-info">
                <div class="status-value">{{ $webtvItems->where('statut', 'termine')->count() }}</div>
                <div class="status-label">Terminés</div>
            </div>
        </div>
    </div>

    <!-- WebTV List -->
    <div class="webtv-list-modern">
        @forelse($webtvs as $webtv)
        <div class="webtv-card-modern">
            <div class="webtv-preview">
                <!-- Status Badge -->
                <div class="status-badge status-{{ $webtv->statut_couleur }}">
                    @if($webtv->statut === 'en_direct')
                        <div class="live-dot"></div>
                    @endif
                    <span>{{ $webtv->statut_formatte }}</span>
                </div>

                <!-- Vimeo Embed Preview -->
                @if($webtv->vimeo_event_id || $webtv->video_id)
                <div class="embed-preview">
                    <div class="embed-container-preview">
                        @if($webtv->type_programme === 'live' && $webtv->code_embed_vimeo)
                            {!! $webtv->code_embed_vimeo !!}
                        @elseif($webtv->type_programme === 'programme' && $webtv->code_integration_vimeo)
                            {!! $webtv->code_integration_vimeo !!}
                        @endif
                        @if($webtv->statut === 'en_direct')
                            <div class="live-badge">
                                <span class="live-dot"></span>
                                EN DIRECT
                            </div>
                        @endif
                    </div>
                    <div class="preview-overlay">
                        <div class="vimeo-info">
                            <i class="fab fa-vimeo-v"></i>
                            @if($webtv->type_programme === 'live' && $webtv->vimeo_event_id)
                                <span>Event ID: {{ $webtv->vimeo_event_id }}</span>
                            @elseif($webtv->type_programme === 'programme' && $webtv->video_id)
                                <span>Video ID: {{ $webtv->video_id }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                @else
                <div class="no-preview">
                    <i class="fas fa-tv"></i>
                    <span>Aperçu non disponible</span>
                </div>
                @endif

                <!-- Hidden embed source for modal playback -->
                <div id="embed-src-{{ $webtv->id }}" class="embed-source" style="display:none">
                    @if($webtv->type_programme === 'live' && $webtv->code_embed_vimeo)
                        {!! $webtv->code_embed_vimeo !!}
                    @elseif($webtv->type_programme === 'programme' && $webtv->code_integration_vimeo)
                        {!! $webtv->code_integration_vimeo !!}
                    @elseif($webtv->vimeo_event_id)
                        <iframe src="https://player.vimeo.com/video/{{ $webtv->vimeo_event_id }}" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                    @elseif($webtv->video_id)
                        <iframe src="https://player.vimeo.com/video/{{ $webtv->video_id }}" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                    @endif
                </div>
            </div>

            <div class="webtv-details">
                <div class="webtv-header">
                    <h3 class="webtv-title">{{ $webtv->titre }}</h3>
                    <div class="webtv-meta">
                        @if($webtv->date_programmee)
                        <span class="meta-item">
                            <i class="fas fa-calendar-alt"></i>
                            {{ $webtv->date_programmee_formatee }}
                        </span>
                        @endif
                        @if($webtv->duree_estimee_formatee)
                        <span class="meta-item">
                            <i class="fas fa-clock"></i>
                            {{ $webtv->duree_estimee_formatee }}
                        </span>
                        @endif
                        @if($webtv->categorie)
                        <span class="meta-item">
                            <i class="fas fa-tags"></i>
                            {{ ucfirst($webtv->categorie) }}
                        </span>
                        @endif
                    </div>
                </div>

                @if($webtv->description)
                <p class="webtv-description">{{ Str::limit($webtv->description, 120) }}</p>
                @endif

                <div class="webtv-actions">
                    <!-- Status et Toggle dans la même ligne -->
                    <div class="status-controls">
                        <!-- Status Dropdown -->
                        <div class="status-dropdown">
                            <select class="status-select" data-id="{{ $webtv->id }}">
                                <option value="draft" {{ $webtv->statut === 'draft' ? 'selected' : '' }}>Brouillon</option>
                                <option value="programme" {{ $webtv->statut === 'programme' ? 'selected' : '' }}>Programmé</option>
                                <option value="en_direct" {{ $webtv->statut === 'en_direct' ? 'selected' : '' }}>En Direct</option>
                                <option value="termine" {{ $webtv->statut === 'termine' ? 'selected' : '' }}>Terminé</option>
                            </select>
                        </div>

                        <!-- Toggle Actif Amélioré -->
                        <div class="toggle-container">
                            <span class="toggle-text">Visible sur la page WebTV ?</span>
                            <div class="toggle-switch-modern" data-id="{{ $webtv->id }}">
                                <input type="checkbox"
                                       id="toggle-{{ $webtv->id }}"
                                       class="toggle-input"
                                       {{ $webtv->est_actif ? 'checked' : '' }}>
                                <label for="toggle-{{ $webtv->id }}" class="toggle-slider">
                                    <span class="toggle-knob"></span>
                                </label>
                            </div>
                            <span class="toggle-status {{ $webtv->est_actif ? 'active' : 'inactive' }}">
                                {{ $webtv->est_actif ? 'ACTIF' : 'INACTIF' }}
                            </span>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="action-buttons">
                        <button type="button" class="btn-action btn-view" title="Lire" data-embed-container-id="embed-src-{{ $webtv->id }}">
                            <i class="fas fa-play"></i>
                        </button>
                        
                        <!-- Bouton modifier - Permissions selon le rôle -->
                        @if(auth()->check() && auth()->user()->peutModifierWebtv($webtv))
                            <a href="{{ route('dashboard.webtv.edit', $webtv) }}" class="btn-action btn-edit" title="Modifier">
                                <i class="fas fa-edit"></i>
                            </a>
                        @endif
                        
                        <!-- Bouton supprimer - Permissions selon le rôle -->
                        @if(auth()->check() && auth()->user()->peutModifierWebtv($webtv))
                            <form class="d-inline delete-form" action="{{ route('dashboard.webtv.destroy', $webtv) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action btn-delete" title="Supprimer">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        @endif
                    </div>
                </div>

                <!-- Alerts -->
                @if($webtv->estEnRetard())
                <div class="webtv-alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    <span>Ce live est en retard !</span>
                </div>
                @endif

                @if($webtv->estProgrammePourAujourdhui())
                <div class="webtv-alert alert-info">
                    <i class="fas fa-info-circle"></i>
                    <span>Programmé pour aujourd'hui</span>
                </div>
                @endif
            </div>
        </div>
        @empty
        <div class="empty-state">
            <div class="empty-icon">
                <i class="fas fa-tv"></i>
            </div>
            <h3>Aucun WebTV pour le moment</h3>
            <p>Créez votre premier live Vimeo pour commencer à diffuser.</p>
            <a href="{{ route('dashboard.webtv.media.create') }}" class="btn-primary-modern">
                <i class="fas fa-plus"></i>
                Créer un Live
            </a>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($webtvs->hasPages())
    <div class="pagination-wrapper">
        {{ $webtvs->links() }}
    </div>
    @endif
</div>



<script>
// Simple modal for viewing video
const webtvModal = (() => {
    let modal, backdrop, content, closeBtn;
    function ensureModal() {
        if (modal) return;
        backdrop = document.createElement('div');
        backdrop.className = 'webtv-modal-backdrop';
        backdrop.style.cssText = `position:fixed;inset:0;background:rgba(0,0,0,.6);display:none;z-index:1050;`;
        modal = document.createElement('div');
        modal.className = 'webtv-modal';
        modal.style.cssText = `position:fixed;inset:0;display:none;z-index:1060;align-items:center;justify-content:center;`;
        const box = document.createElement('div');
        box.className = 'webtv-modal-box';
        box.style.cssText = `background:#0b1220;border:1px solid rgba(255,255,255,.08);border-radius:14px;width:min(980px,92vw);padding:10px;box-shadow:0 20px 40px rgba(0,0,0,.35);`;
        closeBtn = document.createElement('button');
        closeBtn.className = 'webtv-modal-close';
        closeBtn.innerHTML = '<i class="fas fa-times"></i>';
        closeBtn.style.cssText = `position:absolute;top:14px;right:18px;background:transparent;border:none;color:#9fb0c6;font-size:20px;cursor:pointer;`;
        const wrap = document.createElement('div');
        wrap.className = 'webtv-modal-content-wrap';
        wrap.style.cssText = `position:relative`;
        content = document.createElement('div');
        content.className = 'webtv-modal-content';
        content.style.cssText = `aspect-ratio:16/9;width:100%;background:#000;border-radius:10px;overflow:hidden;`;
        wrap.appendChild(closeBtn);
        wrap.appendChild(content);
        box.appendChild(wrap);
        modal.appendChild(box);
        document.body.appendChild(backdrop);
        document.body.appendChild(modal);
        backdrop.addEventListener('click', hide);
        closeBtn.addEventListener('click', hide);
    }
    function show(html) {
        ensureModal();
        content.innerHTML = html || '<div style="display:flex;align-items:center;justify-content:center;height:100%;color:#94a3b8">Aucune vidéo</div>';
        backdrop.style.display = 'block';
        modal.style.display = 'flex';
    }
    function hide() {
        if (!modal) return;
        backdrop.style.display = 'none';
        modal.style.display = 'none';
        content.innerHTML = '';
    }
    return { show, hide };
})();

document.addEventListener('DOMContentLoaded', function() {
    // Toggle Actif avec nouveaux sélecteurs
    // Preview size persistence
    const select = document.getElementById('preview-size-select');
    const saved = localStorage.getItem('webtvPreviewSize');
    const applySize = (px) => document.documentElement.style.setProperty('--preview-size', px + 'px');
    if (saved) {
        select.value = saved;
        applySize(saved);
    }
    select.addEventListener('change', () => {
        const val = select.value;
        applySize(val);
        localStorage.setItem('webtvPreviewSize', val);
    });
    document.querySelectorAll('.toggle-input').forEach(toggle => {
        toggle.addEventListener('change', function() {
            const id = this.closest('.toggle-switch-modern').dataset.id;

            fetch(`{{ route('dashboard.webtv.index') }}/${id}/toggle-actif`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.succes) {
                    // Mettre à jour le statut visuel
                    const container = this.closest('.toggle-container');
                    const statusSpan = container.querySelector('.toggle-status');

                    if (data.est_actif) {
                        statusSpan.textContent = 'ACTIF';
                        statusSpan.classList.remove('inactive');
                        statusSpan.classList.add('active');
                    } else {
                        statusSpan.textContent = 'INACTIF';
                        statusSpan.classList.remove('active');
                        statusSpan.classList.add('inactive');
                    }

                    // Toast notification
                    showToast(data.message, 'success');
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                this.checked = !this.checked; // Revenir à l'état précédent
                showToast('Erreur lors du changement de statut', 'error');
            });
        });
    });

    // Changement de statut
    document.querySelectorAll('.status-select').forEach(select => {
        select.addEventListener('change', function() {
            const id = this.dataset.id;
            const nouveauStatut = this.value;

            fetch(`{{ route('dashboard.webtv.index') }}/${id}/changer-statut`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ statut: nouveauStatut })
            })
            .then(response => {
                if (response.ok) {
                    location.reload();
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
            });
        });
    });

    // Confirmation suppression
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            if (confirm('Êtes-vous sûr de vouloir supprimer ce WebTV ?')) {
                this.submit();
            }
        });
    });

    // Open view modal
    document.querySelectorAll('.btn-view').forEach(btn => {
        btn.addEventListener('click', () => {
            const srcId = btn.getAttribute('data-embed-container-id');
            const srcEl = document.getElementById(srcId);
            const html = srcEl ? srcEl.innerHTML.trim() : '';
            webtvModal.show(html);
        });
    });
});

function showToast(message, type = 'info') {
    // Toast notification améliorée
    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;

    // Ajouter icône selon le type
    const icon = type === 'success' ? '✓' : type === 'error' ? '✗' : 'ℹ';
    toast.innerHTML = `<span class="toast-icon">${icon}</span><span class="toast-message">${message}</span>`;

    // Couleurs selon le type
    const colors = {
        success: { bg: '#28a745', border: '#1e7e34' },
        error: { bg: '#dc3545', border: '#c82333' },
        info: { bg: '#007bff', border: '#0056b3' }
    };

    const color = colors[type] || colors.info;

    toast.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 1rem 1.5rem;
        background: ${color.bg};
        border-left: 4px solid ${color.border};
        color: white;
        border-radius: 6px;
        z-index: 9999;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        transform: translateX(100%);
        transition: all 0.3s ease;
        font-weight: 500;
        max-width: 350px;
    `;

    document.body.appendChild(toast);

    // Animation d'entrée
    setTimeout(() => {
        toast.style.transform = 'translateX(0)';
    }, 10);

    // Animation de sortie et suppression
    setTimeout(() => {
        toast.style.transform = 'translateX(100%)';
        setTimeout(() => {
            if (toast.parentNode) {
                toast.remove();
            }
        }, 300);
    }, 3000);
}
</script>
@endsection
