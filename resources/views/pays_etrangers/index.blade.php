@extends('layouts.app')
@section('page-title', 'Pays étrangers')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold m-0">Pays étrangers</h5>
    @if(auth()->user()->peutModifier('pays-etrangers'))
    <a href="{{ route('pays-etrangers.create') }}" class="btn btn-sm btn-brand"><i class="bi bi-plus-lg"></i> Nouveau pays</a>
    @endif
</div>
<p class="text-muted small">Utilisés pour rattacher les zones d'exécution situées hors de Côte d'Ivoire.</p>
<div class="card card-stat">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light"><tr><th>Libellé</th><th>Zones d'exécution rattachées</th><th class="text-end">Actions</th></tr></thead>
            <tbody>
                @forelse($paysEtrangers as $pays)
                <tr>
                    <td>{{ $pays->libelle }}</td>
                    <td>{{ $pays->zones_execution_count }}</td>
                    <td class="text-end">
                        @if(auth()->user()->peutModifier('pays-etrangers'))
                        <a href="{{ route('pays-etrangers.edit', $pays) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('pays-etrangers.destroy', $pays) }}" method="POST" class="d-inline" onsubmit="return confirm('Confirmer la suppression ?');">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="3" class="text-center text-muted py-4">Aucun pays étranger enregistré.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $paysEtrangers->links() }}</div>
@endsection
