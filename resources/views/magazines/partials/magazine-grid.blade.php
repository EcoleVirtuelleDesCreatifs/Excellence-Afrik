@php
  // Helper to format month-year in French
  $formatDate = function($date) {
    return $date ? \Illuminate\Support\Carbon::parse($date)->translatedFormat('F Y') : '';
  };
@endphp

@forelse(($magazines ?? []) as $mag)
  <div class="magazine-item">
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
                    <a href="{{ asset('storage/'.$mag->pdf_path) }}" target="_blank" class="btn-primary-gold btn-sm">Voir</a>
                    <a href="{{ asset('storage/'.$mag->pdf_path) }}" download class="btn-download-brown btn-sm">Télécharger</a>
                  @else
                    <a href="#" class="btn-primary-gold btn-sm disabled" aria-disabled="true">Voir</a>
                    <a href="#" class="btn-download-brown btn-sm disabled" aria-disabled="true">Télécharger</a>
                  @endif
                </div>
              </div>
          </div>
          <div class="magazine-info">
              <div class="magazine-meta">
                  <span class="magazine-date">{{ $formatDate($mag->published_at) }}</span>
                  {{-- Category removed per requirements --}}
              </div>
              <h4 class="magazine-title">{{ $mag->title }}</h4>
              {{-- Description hidden per requirements --}}
          </div>
      </div>
  </div>
@empty
  <div class="col-12 text-center text-muted">Aucun magazine publié pour le moment.</div>
@endforelse
