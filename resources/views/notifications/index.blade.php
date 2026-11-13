@extends('layouts.app')
@section('page-title', 'Notifications')
@section('content')
<div class="card card-stat p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold m-0">Notifications</h5>
        @if(auth()->user()->unreadNotifications->count())
            <form method="POST" action="{{ route('notifications.lues') }}">@csrf
                <button class="btn btn-sm btn-outline-secondary">Tout marquer comme lu</button>
            </form>
        @endif
    </div>
    @forelse($notifications as $n)
        @php $d = $n->data; @endphp
        <div class="border-bottom py-2 {{ $n->read_at ? 'text-muted' : '' }}">
            <div>
                @if(($d['decision'] ?? '') === 'valide')
                    <span class="badge bg-success">Projet validé</span>
                @else
                    <span class="badge bg-danger">Projet rejeté</span>
                @endif
                <a href="{{ route('projets.show', $d['projet_id']) }}" class="text-decoration-none fw-semibold">{{ $d['reference'] ?? '' }} — {{ $d['intitule'] ?? '' }}</a>
            </div>
            @if(!empty($d['motif']))<div class="small">Motif : {{ $d['motif'] }}</div>@endif
            <div class="small text-muted">{{ $n->created_at->format('d/m/Y H:i') }}</div>
        </div>
    @empty
        <p class="text-muted mb-0">Aucune notification.</p>
    @endforelse
    <div class="mt-3">{{ $notifications->links() }}</div>
</div>
@endsection
