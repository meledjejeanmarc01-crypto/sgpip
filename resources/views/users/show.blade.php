@extends('layouts.app')

@section('title', $user->name . ' - SGSPIP')

@section('content')
<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-start mb-4 flex-wrap gap-2">
        <div class="d-flex align-items-center gap-3">
            <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center fw-bold" style="width:56px;height:56px;font-size:1.4rem;">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div>
                <span class="badge text-bg-{{ $user->statut ? 'success' : 'secondary' }} mb-1">
                    {{ $user->statut ? 'Actif' : 'Inactif' }}
                </span>
                <h2 class="fw-bold mb-0">{{ $user->name }}</h2>
                <p class="text-muted mb-0">{{ $user->email }}</p>
            </div>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('users.edit', $user) }}" class="btn btn-outline-warning"><i class="bi bi-pencil"></i> Modifier</a>
            <a href="{{ route('users.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Retour</a>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white fw-semibold">Informations du compte</div>
        <div class="card-body">
            <dl class="row mb-0">
                <dt class="col-sm-3 text-muted">Rôle</dt>
                <dd class="col-sm-9">{{ $user->role?->nom ?? '—' }}</dd>

                <dt class="col-sm-3 text-muted">Structure</dt>
                <dd class="col-sm-9">
                    @if($user->structure)
                        <a href="{{ route('structures.show', $user->structure) }}">{{ $user->structure->nom }}</a>
                    @else
                        —
                    @endif
                </dd>

                <dt class="col-sm-3 text-muted">Créé le</dt>
                <dd class="col-sm-9 mb-0">{{ $user->created_at->format('d/m/Y à H:i') }}</dd>
            </dl>
        </div>
    </div>

</div>
@endsection
