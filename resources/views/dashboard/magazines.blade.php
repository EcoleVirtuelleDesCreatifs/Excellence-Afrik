@extends('layouts.dashboard-ultra')

@section('title', 'Gestion des Magazines — Dashboard Excellence Afrik')
@section('page_title', 'Gestion des Magazines')

@push('styles')
<style>
  /* Magazines admin page specific styles */
  .magazine-admin-card { border: 0; border-radius: 16px; box-shadow: 0 10px 25px rgba(0,0,0,0.06); }
  .magazine-admin-card .card-header { background: #000; color: #D4AF37; border: 0; border-radius: 16px 16px 0 0; }
  .magazine-cover-thumb { width: 60px; height: 80px; object-fit: cover; border-radius: 8px; }
  .status-badge { border-radius: 999px; padding: 6px 10px; font-size: 12px; }
  .status-published { background: #10b981; color: #fff; }
  .status-draft { background: #f59e0b; color: #fff; }
</style>
@endpush

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-10">
      <div class="card magazine-admin-card mb-4">
        <div class="card-header d-flex align-items-center justify-content-between">
          <div>
            <h5 class="mb-0">Magazines</h5>
            <small class="opacity-75">Gérez vos magazines (ebooks): création, édition, publication</small>
          </div>
          <div>
            <a href="{{ route('dashboard.magazines.create') }}" class="btn btn-light btn-sm">
              <i class="fas fa-plus me-2"></i>Nouveau magazine
            </a>
          </div>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table align-middle">
              <thead>
                <tr>
                  <th>Couverture</th>
                  <th>Titre</th>
                  <th>Date</th>
                  <th>Statut</th>
                  <th class="text-end">Actions</th>
                </tr>
              </thead>
              <tbody>
                @forelse(($magazines ?? []) as $mag)
                  <tr>
                    <td>
                      @if($mag->cover_thumb_path)
                        <img src="{{ asset('storage/'.$mag->cover_thumb_path) }}" alt="Cover" class="magazine-cover-thumb">
                      @elseif($mag->cover_path)
                        <img src="{{ asset('storage/'.$mag->cover_path) }}" alt="Cover" class="magazine-cover-thumb">
                      @else
                        <img src="https://via.placeholder.com/60x80" alt="Cover" class="magazine-cover-thumb">
                      @endif
                    </td>
                    <td>{{ $mag->title }}</td>
                    <td>{{ optional($mag->published_at)->translatedFormat('F Y') ?? '-' }}</td>
                    <td>
                      @if($mag->status === 'published')
                        <span class="status-badge status-published">Publié</span>
                      @else
                        <span class="status-badge status-draft">Brouillon</span>
                      @endif
                    </td>
                    <td class="text-end">
                      <div class="btn-group btn-group-sm" role="group">
                        @if($mag->pdf_path)
                          <a href="{{ asset('storage/'.$mag->pdf_path) }}" class="btn btn-outline-secondary" target="_blank" title="Voir le PDF"><i class="fas fa-eye"></i></a>
                        @endif
                        <a href="{{ route('dashboard.magazines.edit', $mag->id) }}" class="btn btn-outline-primary" title="Éditer"><i class="fas fa-pen"></i></a>
                        <form action="{{ route('dashboard.magazines.destroy', $mag->id) }}" method="POST" onsubmit="return confirm('Supprimer ce magazine ?');">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-outline-danger" title="Supprimer"><i class="fas fa-trash"></i></button>
                        </form>
                      </div>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="5" class="text-center text-muted">Aucun magazine pour le moment.</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>

          @if(isset($magazines) && is_object($magazines) && method_exists($magazines, 'links'))
            <div class="d-flex justify-content-end">
              {{ $magazines->links() }}
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
