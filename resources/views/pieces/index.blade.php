@extends('layouts.app')
@section('page-title', 'Pièces justificatives')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold m-0">Pièces justificatives</h5>
    <a href="{{ route('pieces-justificatives.create') }}" class="btn btn-sm text-white" style="background:#FF8200;"><i class="bi bi-plus-lg"></i> Ajouter une pièce</a>
</div>
<div class="card card-stat">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light"><tr><th>Libellé</th><th>Catégorie</th><th>Projet</th><th>Déposé par</th><th class="text-end">Actions</th></tr></thead>
            <tbody>
                @forelse($pieces as $p)
                <tr>
                    <td>{{ $p->libelle ?? ucfirst($p->categorie) }}</td>
                    <td><span class="badge bg-light text-dark border">{{ $p->categorie }}</span></td>
                    <td>{{ $p->projet->intitule ?? '—' }}</td>
                    <td>{{ $p->utilisateur->prenom ?? '' }} {{ $p->utilisateur->nom ?? '' }}</td>
                    <td class="text-end">
                        <a href="{{ route('pieces-justificatives.download', $p) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-download"></i></a>
                        <form action="{{ route('pieces-justificatives.destroy', $p) }}" method="POST" class="d-inline" onsubmit="return confirm('Confirmer la suppression ?');">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted py-4">Aucune pièce justificative enregistrée.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $pieces->links() }}</div>
@endsection
