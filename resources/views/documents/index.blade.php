@extends('layouts.app')

@section('title', 'Documents - SGSPIP')

@section('content')
<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-start mb-4 flex-wrap gap-2">
        <div>
            <h2 class="fw-bold mb-1"><i class="bi bi-file-earmark-text"></i> Documents</h2>
            <p class="text-muted mb-0">Vue d'ensemble des documents, tous projets confondus.</p>
        </div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalDocument">
            <i class="bi bi-plus-lg"></i> Nouveau document
        </button>
    </div>

    <form method="GET" class="row g-2 mb-3">
        <div class="col-auto">
            <select name="projet_id" class="form-select" onchange="this.form.submit()">
                <option value="">Tous les projets</option>
                @foreach($projets as $p)
                    <option value="{{ $p->id }}" @selected(request('projet_id') == $p->id)>{{ $p->reference }} — {{ $p->intitule }}</option>
                @endforeach
            </select>
        </div>
        @if(request('projet_id'))
            <div class="col-auto"><a href="{{ route('documents.index') }}" class="btn btn-outline-secondary">Réinitialiser</a></div>
        @endif
    </form>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            @if($documents->count())
                <table class="table mb-0 align-middle">
                    <thead class="table-light"><tr><th>Projet</th><th>Titre</th><th>Type</th><th>Extension</th><th>Ajouté par</th><th class="text-end">Action</th></tr></thead>
                    <tbody>
                    @foreach($documents as $doc)
                        <tr>
                            <td><a href="{{ route('projets.show', $doc->projet) }}" class="small">{{ $doc->projet?->reference }}</a></td>
                            <td>{{ $doc->titre }}</td>
                            <td>{{ $doc->type ?? '—' }}</td>
                            <td><span class="badge text-bg-light">{{ strtoupper($doc->extension ?? '') }}</span></td>
                            <td>{{ $doc->ajoutePar?->name ?? '—' }}</td>
                            <td class="text-end">
                                <a href="{{ route('documents.open', $doc) }}" target="_blank" class="btn btn-sm btn-outline-success" title="Ouvrir">
                                    <i class="bi bi-box-arrow-up-right"></i>
                                </a>
                                <a href="{{ route('documents.download', $doc) }}" class="btn btn-sm btn-outline-primary" title="Télécharger">
                                    <i class="bi bi-download"></i>
                                </a>
                                <form action="{{ route('documents.destroy', $doc) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer ?');">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" title="Supprimer"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-muted p-4 mb-0">Aucun document trouvé. Utilisez le bouton « Nouveau document » ci-dessus, ou ajoutez-en un depuis la fiche d'un projet.</p>
            @endif
        </div>
        <div class="card-footer bg-white">{{ $documents->links() }}</div>
    </div>
</div>

{{-- MODAL NOUVEAU DOCUMENT --}}
<div class="modal fade" id="modalDocument" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formDocument" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header"><h5 class="modal-title">Nouveau document</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <div class="mb-2">
                        <label class="form-label">Projet</label>
                        <select id="documentProjetSelect" class="form-select" required>
                            <option value="">-- Sélectionner un projet --</option>
                            @foreach($projets as $p)
                                <option value="{{ $p->id }}">{{ $p->reference }} — {{ $p->intitule }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-2"><label class="form-label">Titre</label><input type="text" name="titre" class="form-control" required></div>
                    <div class="mb-2"><label class="form-label">Type</label><input type="text" name="type" class="form-control" placeholder="Ex : rapport technique, contrat..."></div>
                    <div class="mb-2"><label class="form-label">Fichier (PDF, Word, Excel — 5 Mo max)</label><input type="file" name="fichier" class="form-control" accept=".pdf,.doc,.docx,.xls,.xlsx" required></div>
                    <div class="mb-2"><label class="form-label">Description</label><textarea name="description" class="form-control" rows="2"></textarea></div>
                </div>
                <div class="modal-footer"><button type="submit" class="btn btn-primary" id="btnDocumentSubmit" disabled>Ajouter</button></div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('documentProjetSelect').addEventListener('change', function () {
        const form = document.getElementById('formDocument');
        const btn = document.getElementById('btnDocumentSubmit');
        if (this.value) {
            form.action = '/projets/' + this.value + '/documents';
            btn.disabled = false;
        } else {
            btn.disabled = true;
        }
    });
</script>
@endpush
@endsection
