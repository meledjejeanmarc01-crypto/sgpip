@extends('layouts.app')

@section('title', 'Utilisateurs - SGSPIP')

@section('content')
<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1"><i class="bi bi-people"></i> Utilisateurs</h2>
            <p class="text-muted mb-0">Gestion des comptes et des accès</p>
        </div>
        <a href="{{ route('users.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Nouvel utilisateur
        </a>
    </div>

    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body">
            <form method="GET" class="row g-2">
                <div class="col-md-6">
                    <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Rechercher par nom ou email...">
                </div>
                <div class="col-md-2">
                    <button class="btn btn-outline-primary w-100"><i class="bi bi-search"></i> Rechercher</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            @if($users->count())
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr><th>Nom</th><th>Email</th><th>Rôle</th><th>Structure</th><th>Statut</th><th class="text-end">Actions</th></tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td class="fw-semibold">{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->role?->nom ?? '—' }}</td>
                                <td>{{ $user->structure?->nom ?? '—' }}</td>
                                <td><span class="badge text-bg-{{ $user->statut ? 'success' : 'secondary' }}">{{ $user->statut ? 'Actif' : 'Inactif' }}</span></td>
                                <td class="text-end">
                                    <div class="btn-group">
                                        <a href="{{ route('users.show', $user) }}" class="btn btn-sm btn-outline-primary" title="Voir"><i class="bi bi-eye"></i></a>
                                        <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-outline-warning" title="Modifier"><i class="bi bi-pencil"></i></a>
                                        <form action="{{ route('users.destroy', $user) }}" method="POST" onsubmit="return confirm('Supprimer cet utilisateur ?');">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger" title="Supprimer"><i class="bi bi-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-muted text-center p-5 mb-0">Aucun utilisateur enregistré.</p>
            @endif
        </div>
        @if($users->hasPages())
            <div class="card-footer bg-white">{{ $users->links() }}</div>
        @endif
    </div>

</div>
@endsection
