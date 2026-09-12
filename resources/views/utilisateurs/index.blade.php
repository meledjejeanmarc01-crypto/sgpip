@extends('layouts.app')
@section('page-title', 'Utilisateurs')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold m-0">Gestion des utilisateurs</h5>
    <a href="{{ route('utilisateurs.create') }}" class="btn btn-sm text-white" style="background:#FF8200;"><i class="bi bi-plus-lg"></i> Nouvel utilisateur</a>
</div>
<div class="card card-stat">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light"><tr><th>Nom</th><th>Email</th><th>Rôle</th><th>Statut</th><th class="text-end">Actions</th></tr></thead>
            <tbody>
                @forelse($utilisateurs as $u)
                <tr>
                    <td>{{ $u->prenom }} {{ $u->nom }}</td>
                    <td>{{ $u->email }}</td>
                    <td><span class="badge bg-light text-dark border">{{ str_replace('_',' ',$u->role) }}</span></td>
                    <td>@if($u->actif)<span class="badge bg-success">Actif</span>@else<span class="badge bg-secondary">Désactivé</span>@endif</td>
                    <td class="text-end">
                        <a href="{{ route('utilisateurs.edit', $u) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('utilisateurs.destroy', $u) }}" method="POST" class="d-inline" onsubmit="return confirm('Confirmer la suppression ?');">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted py-4">Aucun utilisateur enregistré.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $utilisateurs->links() }}</div>
@endsection
