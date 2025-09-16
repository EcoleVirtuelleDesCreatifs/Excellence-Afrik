@php
  // Helper to format month-year in French
  $formatDate = function($date) {
    return $date ? \Illuminate\Support\Carbon::parse($date)->translatedFormat('F Y') : '';
  };
@endphp

@forelse(($magazines ?? []) as $mag)
  <div class="magazine-item">
      <a href="{{ route('magazines.show', $mag->slug) }}" class="magazine-card-link">
          <div class="magazine-card">
              <div class="magazine-cover">
                  @php
                    $src = $mag->cover_thumb_path ? asset('storage/'.$mag->cover_thumb_path)
                         : ($mag->cover_path ? asset('storage/'.$mag->cover_path) : 'https://via.placeholder.com/279x377');
                  @endphp
                  <div class="magazine-cover-wrap" style="position:relative;width:279px;height:377px;">
                    <img src="{{ $src }}" alt="{{ $mag->title }}" class="magazine-image" style="width:279px;height:377px;object-fit:cover;display:block;">
                    <div class="magazine-hover-overlay">
                      @if($mag->pdf_path)
                        <span class="btn-primary-gold btn-sm">Lire</span>
                        <a href="{{ asset('storage/'.$mag->pdf_path) }}" download class="btn-download-brown btn-sm" onclick="event.stopPropagation();">Télécharger</a>
                      @else
                        <span class="btn-primary-gold btn-sm disabled" aria-disabled="true">Lire</span>
                        <a href="#" class="btn-download-brown btn-sm disabled" aria-disabled="true" onclick="event.stopPropagation();">Télécharger</a>
                      @endif
                    </div>
                  </div>
              </div>
              <div class="magazine-info">
                  <div class="magazine-meta">
                      <span class="magazine-date">{{ $formatDate($mag->published_at) }}</span>
                  </div>
                  <h4 class="magazine-title">{{ $mag->title }}</h4>
              </div>
          </div>
      </a>
  </div>
@empty
  <div class="col-12 text-center text-muted">Aucun magazine publié pour le moment.</div>
@endforelse
