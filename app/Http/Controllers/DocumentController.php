<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Projet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function index(Request $request)
    {
        $requete = Document::with(['projet', 'ajoutePar'])
            ->when($request->filled('projet_id'), fn ($q) => $q->where('projet_id', $request->projet_id))
            ->latest();

        // Impression du registre : tous les documents du filtre (pas seulement la page de 15).
        $documents = $request->boolean('imprimer')
            ? $requete->get()
            : $requete->paginate(15)->withQueryString();

        $projets = Projet::orderBy('intitule')->get(['id', 'intitule', 'reference']);

        return view('documents.index', compact('documents', 'projets'));
    }

    public function store(Request $request, Projet $projet)
    {
        $validated = $request->validate([
            'titre' => ['required', 'string', 'max:255'],
            'type' => ['nullable', 'string', 'max:100'],
            'type_document_id' => ['nullable', 'exists:types_document,id'],
            'source' => ['nullable', 'string', 'max:255'],
            'strategie' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'fichier' => ['required', 'file', 'mimes:pdf,doc,docx,xls,xlsx', 'max:5120'],
        ]);

        $fichier = $request->file('fichier');
        $chemin = $fichier->store('documents/' . $projet->id, 'local');

        $projet->documents()->create([
            'titre' => $validated['titre'],
            'type' => $validated['type'] ?? (isset($validated['type_document_id']) ? \App\Models\TypeDocument::whereKey($validated['type_document_id'])->value('libelle') : null),
            'type_document_id' => $validated['type_document_id'] ?? null,
            'source' => $validated['source'] ?? null,
            'strategie' => $validated['strategie'] ?? null,
            'description' => $validated['description'] ?? null,
            'fichier' => $chemin,
            'taille' => $fichier->getSize(),
            'extension' => $fichier->getClientOriginalExtension(),
            'ajoute_par_id' => $request->user()?->id,
        ]);

        return back()->with('success', 'Document ajouté avec succès.');
    }

    public function download(Document $document)
    {
        if (! Storage::disk('local')->exists($document->fichier)) {
            return back()->with('error', "Le fichier demandé est introuvable sur le serveur.");
        }

        return Storage::disk('local')->download(
            $document->fichier,
            $document->titre . '.' . $document->extension
        );
    }

    /**
     * Ouvre le document dans le navigateur (aperçu PDF inline, ou ouverture
     * via l'application associée — Word, Excel...) plutôt que de forcer
     * un téléchargement.
     */
    public function open(Document $document)
    {
        if (! Storage::disk('local')->exists($document->fichier)) {
            return back()->with('error', "Le fichier demandé est introuvable sur le serveur.");
        }

        $mimeTypes = [
            'pdf' => 'application/pdf',
            'doc' => 'application/msword',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'xls' => 'application/vnd.ms-excel',
            'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ];

        $extension = strtolower($document->extension ?? '');
        $mime = $mimeTypes[$extension] ?? 'application/octet-stream';

        return Storage::disk('local')->response(
            $document->fichier,
            $document->titre . '.' . $document->extension,
            [
                'Content-Type' => $mime,
                'Content-Disposition' => 'inline; filename="' . $document->titre . '.' . $document->extension . '"',
            ]
        );
    }

    public function destroy(Document $document)
    {
        if (Storage::disk('local')->exists($document->fichier)) {
            Storage::disk('local')->delete($document->fichier);
        }

        $document->delete();

        return back()->with('success', 'Document supprimé avec succès.');
    }
}
