@extends('layouts.dashboard-ultra')

@section('title', 'Gestion WebTV')
@section('page-title', 'Gestion WebTV')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/webtv.css') }}">
    <style>
      :root{--ea-gold:#D4AF37;--ea-gold-2:#F2CB05;--ea-blue:#2563eb;--ea-green:#10b981;--ea-soft:rgba(148,163,184,.08);--ea-soft-2:rgba(148,163,184,.05);--ea-card:rgba(15,23,42,.30);--ea-card-border:rgba(148,163,184,.14)}
      /* Toolbar modern styles */
      .webtv-toolbar {display:flex;justify-content:space-between;align-items:center;gap:.75rem;margin:8px 0 4px;padding:6px 0;border-radius:12px;background:transparent;border:none}
      .toolbar-left,.toolbar-right{display:flex;align-items:center;gap:12px}
      .search-group{display:flex;align-items:center;gap:8px;padding:8px 12px;border:1px solid rgba(255,255,255,0.08);border-radius:10px;background:rgba(255,255,255,0.03)}
      .search-group i{color:#94a3b8}
      .search-input{background:transparent;border:none;outline:none;color:#e2e8f0;min-width:260px}
      .filters-group{display:none}
      .filter-item{display:flex;align-items:center;gap:8px;padding:6px 10px;border:1px solid rgba(255,255,255,0.06);border-radius:12px;background:rgba(255,255,255,0.02)}
      .filter-item i{color:#94a3b8}
      .filter-select,.sort-select{background:transparent;border:none;color:#e2e8f0}
      .sort-group{display:none}
      .view-toggle{display:none}
      .toggle-btn{border:1px solid rgba(255,255,255,0.06);background:rgba(255,255,255,0.02);color:#e2e8f0;padding:7px 10px;border-radius:12px}
      .toggle-btn.active{border-color:var(--ea-blue);background:rgba(37,99,235,0.12);color:#bfdbfe}

      /* Minor tweaks for status cards spacing */
      .webtv-status-cards{margin-top:16px}

      /* Modern full-width list, two-column cards */
      .webtv-list-modern{display:grid;grid-template-columns:1fr;gap:18px;margin-top:18px}
      .webtv-card-modern{position:relative;background:var(--ea-card);border:1px solid var(--ea-card-border);border-radius:14px;padding:12px;transition:transform .14s ease, box-shadow .14s ease, border-color .14s ease;display:grid;grid-template-columns: 4fr 8fr;gap:14px;align-items:start}
      .webtv-card-modern:before{content:"";position:absolute;inset:0;border-radius:inherit;padding:1px;background:linear-gradient(135deg, rgba(212,175,55,.35), rgba(37,99,235,.35));-webkit-mask:linear-gradient(#000 0 0) content-box, linear-gradient(#000 0 0);-webkit-mask-composite:xor;mask-composite:exclude;pointer-events:none;opacity:.55}
      .webtv-card-modern:hover{transform:translateY(-2px);box-shadow:0 10px 24px rgba(0,0,0,.22);border-color:rgba(148,163,184,.22)}
      .webtv-preview{position:relative}
      .embed-preview,.no-preview{width:100%;height:620px;aspect-ratio:auto;margin:0;border-radius:12px;overflow:hidden;background:#0b1220;border:1px solid var(--ea-card-border)}
      .embed-container-preview{position:relative;width:100%;height:100%;}
      /* Force any inner responsive wrapper to fill the box */
      .embed-container-preview [style*="padding"]{padding:0 !important;height:100% !important;width:100% !important;position:static !important}
      .embed-container-preview iframe,.embed-container-preview object,.embed-container-preview embed{position:static !important;width:100% !important;height:100% !important;inset:auto !important}
      .preview-overlay{display:none}
      /* Status badges (top-left over preview) */
      .status-badge{position:absolute;top:10px;left:10px;z-index:2;display:inline-flex;align-items:center;gap:8px;padding:6px 10px;border-radius:999px;font-weight:700;letter-spacing:.3px;border:1px solid rgba(255,255,255,.08);backdrop-filter:blur(6px)}
      .status-badge{background:rgba(148,163,184,0.15);color:#e5e7eb;border-color:rgba(148,163,184,.35)}
      .status-programme{background:rgba(37,99,235,0.15);color:#bfdbfe;border-color:rgba(37,99,235,.45)}
      .status-en_direct{background:linear-gradient(90deg, rgba(212,175,55,.18), rgba(37,99,235,.18));color:#fde68a;border-color:rgba(212,175,55,.45)}
      .status-termine,.status-archived{background:rgba(16,185,129,0.15);color:#bbf7d0;border-color:rgba(16,185,129,.45)}
      /* Details column */
      .webtv-details{padding:0}
      .webtv-header{display:flex;justify-content:space-between;align-items:flex-start;gap:12px}
      .webtv-title{font-size:1.06rem;margin:0 0 4px 0;font-weight:800;letter-spacing:.1px;background:linear-gradient(90deg,var(--ea-gold),var(--ea-blue));-webkit-background-clip:text;background-clip:text;color:transparent}
      .webtv-meta{display:flex;flex-wrap:wrap;gap:6px;color:#9fb0c6;font-size:.9rem}
      .webtv-meta .meta-item{display:inline-flex;align-items:center;gap:6px;padding:3px 8px;border:1px solid rgba(255,255,255,0.06);border-radius:999px;background:rgba(255,255,255,0.02)}
      .webtv-description{color:#cbd5e1;margin:4px 0 0 0;max-height:2.8em;overflow:hidden}
      .webtv-actions{display:flex;justify-content:space-between;align-items:center;margin-top:10px}
      .status-controls{display:flex;align-items:center;gap:14px;flex-wrap:wrap}
      .action-buttons{display:flex;gap:8px}
      /* Responsive stacking */
      @media (max-width: 992px){
        .webtv-card-modern{grid-template-columns:1fr}
      }
      .live-badge{position:absolute;top:10px;left:10px;display:inline-flex;align-items:center;gap:8px;background:rgba(220,53,69,.15);color:#ff6b6b;border:1px solid rgba(220,53,69,.35);padding:6px 10px;border-radius:999px;font-weight:600;letter-spacing:.4px}
      .live-dot{width:10px;height:10px;background:#ff3b3b;border-radius:50%;box-shadow:0 0 0 0 rgba(255,59,59,0.7);animation:pulse 1.2s infinite}
      @keyframes pulse{0%{box-shadow:0 0 0 0 rgba(255,59,59,.7)}70%{box-shadow:0 0 0 10px rgba(255,59,59,0)}100%{box-shadow:0 0 0 0 rgba(255,59,59,0)}}
      .webtv-details{padding:12px 6px}
      .webtv-title{font-size:1.05rem;margin:0 0 6px 0}
      .webtv-meta{display:flex;gap:12px;color:#93a4b8;font-size:.9rem}
      .webtv-actions{display:flex;justify-content:space-between;align-items:center;margin-top:10px}
      .action-buttons{display:flex;gap:8px}
      .btn-action{display:inline-flex;align-items:center;justify-content:center;width:34px;height:34px;border-radius:12px;border:1px solid var(--ea-card-border);background:rgba(255,255,255,0.02);color:#e2e8f0;transition:all .14s ease}
      .btn-action:hover{background:rgba(37,99,235,0.12);border-color:var(--ea-blue);color:#cfe3ff;transform:translateY(-1px)}
      .btn-delete:hover{background:rgba(239,68,68,.12);border-color:#ef4444;color:#fecaca}

      /* Header buttons brand styling */
      .btn-primary-modern{display:inline-flex;align-items:center;gap:8px;border:1px solid rgba(212,175,55,.45);background:linear-gradient(90deg, rgba(212,175,55,.22), rgba(37,99,235,.22));color:#fff;padding:10px 14px;border-radius:12px;font-weight:700;letter-spacing:.2px;transition:all .15s ease}
      .btn-primary-modern:hover{transform:translateY(-1px);background:linear-gradient(90deg, rgba(212,175,55,.32), rgba(37,99,235,.32));border-color:var(--ea-gold)}
      .btn-secondary-modern{display:inline-flex;align-items:center;gap:8px;border:1px solid rgba(37,99,235,.45);background:rgba(37,99,235,.10);color:#eaf2ff;padding:10px 14px;border-radius:12px;font-weight:700;letter-spacing:.2px;transition:all .15s ease}
      .btn-secondary-modern:hover{transform:translateY(-1px);background:rgba(37,99,235,.18);border-color:var(--ea-blue)}
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

    <!-- Toolbar: Search, Filters, Sorting, View Toggle -->
    <div class="webtv-toolbar">
        <div class="toolbar-left">
            <div class="search-group">
                <i class="fas fa-search"></i>
                <input type="text" class="search-input" placeholder="Rechercher un live ou programme..." />
            </div>
            <div class="filters-group">
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
                <div class="filter-item">
                    <i class="fas fa-tags"></i>
                    <select class="filter-select" aria-label="Filtrer par type">
                        <option value="all" selected>Tous les types</option>
                        <option value="live">Live</option>
                        <option value="programme">Programme</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="toolbar-right">
            <div class="sort-group">
                <i class="fas fa-sort"></i>
                <select class="sort-select" aria-label="Trier">
                    <option value="recent" selected>Plus récents</option>
                    <option value="views">Plus vus</option>
                    <option value="duration">Durée</option>
                    <option value="date">Date programmée</option>
                </select>
            </div>
            <div class="size-selector" title="Taille des previews">
                <i class="fas fa-expand-arrows-alt"></i>
                <select id="preview-size-select" aria-label="Taille des aperçus">
                    <option value="420">420 px</option>
                    <option value="500" selected>500 px</option>
                    <option value="560">560 px</option>
                </select>
            </div>
            <div class="view-toggle" role="group" aria-label="Affichage">
                <button class="toggle-btn active" title="Cartes"><i class="fas fa-th-large"></i></button>
                <button class="toggle-btn" title="Liste"><i class="fas fa-list"></i></button>
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
                        <a href="{{ route('dashboard.webtv.edit', $webtv) }}" class="btn-action btn-edit" title="Modifier">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form class="d-inline delete-form" action="{{ route('dashboard.webtv.destroy', $webtv) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-action btn-delete" title="Supprimer">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
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
