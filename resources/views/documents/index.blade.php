@extends('layouts.app')

@section('title', 'Documents - SGSPIP')

@push('styles')
<style>
    .reg-titre { font-family: Georgia, 'Times New Roman', serif; font-size: 20pt; font-weight: 700; color: #111827; margin: 14px 0 2px; }
    .reg-sous { font-size: 10pt; color: #6B7280; margin-bottom: 14px; }
    .reg-kicker { font-size: 8.5pt; font-weight: 700; letter-spacing: .12em; text-transform: uppercase; color: #D9811A; margin-top: 4px; }
</style>
@endpush

@section('content')
<div class="container-fluid py-4">

    {{-- Titre du registre : visible seulement à l'impression --}}
    <div class="print-only">
        <div class="reg-kicker">Registre</div>
        <div class="reg-titre">Liste des documents</div>
        <div class="reg-sous">
            @php $projetFiltre = request('projet_id') ? $projets->firstWhere('id', (int) request('projet_id')) : null; @endphp
            {{ $projetFiltre ? 'Projet : '.$projetFiltre->reference.' — '.$projetFiltre->intitule : 'Tous projets confondus' }}
            &middot; {{ $documents->count() }} document{{ $documents->count() > 1 ? 's' : '' }}
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-start mb-4 flex-wrap gap-2 no-print">
        <div>
            <h2 class="fw-bold mb-1"><i class="bi bi-file-earmark-text"></i> Documents</h2>
            <p class="text-muted mb-0">Vue d'ensemble des documents, tous projets confondus.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('documents.index', array_merge(request()->query(), ['imprimer' => 1])) }}" target="_blank" class="btn btn-outline-secondary">
                <i class="bi bi-printer"></i> Imprimer le registre
            </a>
            @if(auth()->user()->peutModifier('documents'))
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalDocument">
                <i class="bi bi-plus-lg"></i> Nouveau document
            </button>
            @endif
        </div>
    </div>

    <form method="GET" class="row g-2 mb-3 no-print">
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
                    <thead class="table-light"><tr><th style="width:42px">N°</th><th>Projet</th><th>Titre</th><th>Type</th><th>Format</th><th>Ajouté par</th><th>Date</th><th class="text-end no-print">Action</th></tr></thead>
                    <tbody>
                    @foreach($documents as $doc)
                        <tr>
                            <td class="text-muted">{{ $loop->iteration }}</td>
                            <td><a href="{{ route('projets.show', $doc->projet) }}" class="small">{{ $doc->projet?->reference }}</a></td>
                            <td>{{ $doc->titre }}</td>
                            <td>{{ $doc->type ?? '—' }}</td>
                            <td><span class="badge text-bg-light">{{ strtoupper($doc->extension ?? '') }}</span></td>
                            <td>{{ trim(($doc->ajoutePar->prenom ?? '').' '.($doc->ajoutePar->nom ?? '')) ?: '—' }}</td>
                            <td class="text-nowrap">{{ $doc->created_at?->format('d/m/Y') ?? '—' }}</td>
                            <td class="text-end no-print">
                                <a href="{{ route('documents.open', $doc) }}" target="_blank" class="btn btn-sm btn-outline-success" title="Ouvrir">
                                    <i class="bi bi-box-arrow-up-right"></i>
                                </a>
                                <a href="{{ route('documents.download', $doc) }}" class="btn btn-sm btn-outline-primary" title="Télécharger">
                                    <i class="bi bi-download"></i>
                                </a>
                                @if(auth()->user()->peutModifierProjet($doc->projet))
                                <form action="{{ route('documents.destroy', $doc) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer ?');">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" title="Supprimer"><i class="bi bi-trash"></i></button>
                                </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-muted p-4 mb-0">Aucun document trouvé. Utilisez le bouton « Nouveau document » ci-dessus, ou ajoutez-en un depuis la fiche d'un projet.</p>
            @endif
        </div>
        @if(method_exists($documents, 'hasPages'))
        <div class="card-footer bg-white no-print">{{ $documents->links() }}</div>
        @endif
    </div>
</div>

@if(auth()->user()->peutModifier('documents'))
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
                                @if(auth()->user()->peutModifierProjet($p))
                                <option value="{{ $p->id }}">{{ $p->reference }} — {{ $p->intitule }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-2"><label class="form-label">Titre</label><input type="text" name="titre" class="form-control" required></div>
                    <div class="mb-2">
                        <label class="form-label">Type de document</label>
                        <select name="type_document_id" class="form-select" data-creer-url="{{ route('types-document.store') }}" data-creer-nom="Nom du nouveau type de document">
                            <option value="">-- Choisir --</option>
                            @foreach(\App\Models\TypeDocument::orderBy('libelle')->get() as $td)
                                <option value="{{ $td->id }}">{{ $td->libelle }}</option>
                            @endforeach
                        </select>
                    </div>
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
@endif
@if(request()->boolean('imprimer'))
@push('scripts')
<script>window.addEventListener('load', function () { setTimeout(function () { window.print(); }, 400); });</script>
@endpush
@endif
@endsection
