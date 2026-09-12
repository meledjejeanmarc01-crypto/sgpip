{{-- MODAL BAILLEUR --}}
<div class="modal fade" id="modalBailleur" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('projets.bailleurs.attach', $projet) }}" method="POST">
                @csrf
                <div class="modal-header"><h5 class="modal-title">Associer un bailleur</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <div class="mb-2">
                        <label class="form-label">Bailleur</label>
                        <select name="bailleur_id" class="form-select" required>
                            <option value="">-- Sélectionner --</option>
                            @foreach($bailleurs as $b)
                                <option value="{{ $b->id }}">{{ $b->nom }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row g-2">
                        <div class="col-6"><label class="form-label">Montant prévu</label><input type="number" step="0.01" min="0" name="montant_prevu" class="form-control"></div>
                        <div class="col-6"><label class="form-label">Montant financé</label><input type="number" step="0.01" min="0" name="montant_finance" class="form-control"></div>
                    </div>
                    <div class="mt-2"><label class="form-label">Observation</label><textarea name="observation" rows="2" class="form-control"></textarea></div>
                </div>
                <div class="modal-footer"><button type="submit" class="btn btn-primary">Associer</button></div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL BUDGET --}}
<div class="modal fade" id="modalBudget" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('projets.budgets.store', $projet) }}" method="POST">
                @csrf
                <div class="modal-header"><h5 class="modal-title">Nouveau budget</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <div class="row g-2 mb-2">
                        <div class="col-6"><label class="form-label">Montant prévu</label><input type="number" step="0.01" min="0" name="montant_prevu" class="form-control" required></div>
                        <div class="col-6"><label class="form-label">Exercice</label><input type="number" name="exercice" class="form-control" value="{{ date('Y') }}" required></div>
                    </div>
                    <div class="mb-2"><label class="form-label">Source de financement</label><input type="text" name="source_financement" class="form-control"></div>
                    <div class="mb-2"><label class="form-label">Date</label><input type="date" name="date" class="form-control"></div>
                    <div class="mb-2"><label class="form-label">Observation</label><textarea name="observation" rows="2" class="form-control"></textarea></div>
                </div>
                <div class="modal-footer"><button type="submit" class="btn btn-primary">Ajouter</button></div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL DECAISSEMENT --}}
<div class="modal fade" id="modalDecaissement" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('projets.decaissements.store', $projet) }}" method="POST">
                @csrf
                <div class="modal-header"><h5 class="modal-title">Nouveau décaissement</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <div class="mb-2">
                        <label class="form-label">Bailleur</label>
                        <select name="bailleur_id" class="form-select">
                            <option value="">-- Non précisé --</option>
                            @foreach($bailleurs as $b)
                                <option value="{{ $b->id }}">{{ $b->nom }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row g-2 mb-2">
                        <div class="col-6"><label class="form-label">Montant</label><input type="number" step="0.01" min="0" name="montant" class="form-control" required></div>
                        <div class="col-6"><label class="form-label">Date</label><input type="date" name="date" class="form-control" required></div>
                    </div>
                    <div class="mb-2"><label class="form-label">Référence</label><input type="text" name="reference" class="form-control"></div>
                    <div class="mb-2"><label class="form-label">Observation</label><textarea name="observation" rows="2" class="form-control"></textarea></div>
                </div>
                <div class="modal-footer"><button type="submit" class="btn btn-primary">Ajouter</button></div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL DEPENSE --}}
<div class="modal fade" id="modalDepense" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('projets.depenses.store', $projet) }}" method="POST">
                @csrf
                <div class="modal-header"><h5 class="modal-title">Nouvelle dépense</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <div class="mb-2"><label class="form-label">Libellé</label><input type="text" name="libelle" class="form-control" required></div>
                    <div class="row g-2 mb-2">
                        <div class="col-6"><label class="form-label">Montant</label><input type="number" step="0.01" min="0" name="montant" class="form-control" required></div>
                        <div class="col-6"><label class="form-label">Date</label><input type="date" name="date" class="form-control" required></div>
                    </div>
                    <div class="mb-2"><label class="form-label">Nature</label><input type="text" name="nature" class="form-control"></div>
                    <div class="mb-2"><label class="form-label">Référence</label><input type="text" name="reference" class="form-control"></div>
                    <div class="mb-2"><label class="form-label">Observation</label><textarea name="observation" rows="2" class="form-control"></textarea></div>
                </div>
                <div class="modal-footer"><button type="submit" class="btn btn-primary">Ajouter</button></div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL ACTIVITE --}}
<div class="modal fade" id="modalActivite" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('projets.activites.store', $projet) }}" method="POST">
                @csrf
                <div class="modal-header"><h5 class="modal-title">Nouvelle activité</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <div class="mb-2"><label class="form-label">Intitulé</label><input type="text" name="intitule" class="form-control" required></div>
                    <div class="mb-2"><label class="form-label">Description</label><textarea name="description" rows="2" class="form-control"></textarea></div>
                    <div class="row g-2 mb-2">
                        <div class="col-6"><label class="form-label">Début</label><input type="date" name="date_debut" class="form-control"></div>
                        <div class="col-6"><label class="form-label">Fin</label><input type="date" name="date_fin" class="form-control"></div>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Statut</label>
                        <select name="statut" class="form-select">
                            <option value="planifiee">Planifiée</option>
                            <option value="en_cours">En cours</option>
                            <option value="terminee">Terminée</option>
                            <option value="suspendue">Suspendue</option>
                        </select>
                    </div>
                    <div class="mb-2"><label class="form-label">Taux d'avancement (%)</label><input type="number" name="taux_avancement" min="0" max="100" step="0.01" value="0" class="form-control"></div>
                </div>
                <div class="modal-footer"><button type="submit" class="btn btn-primary">Ajouter</button></div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL INDICATEUR --}}
<div class="modal fade" id="modalIndicateur" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('projets.indicateurs.store', $projet) }}" method="POST">
                @csrf
                <div class="modal-header"><h5 class="modal-title">Nouvel indicateur</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <div class="mb-2"><label class="form-label">Nom</label><input type="text" name="nom" class="form-control" required></div>
                    <div class="mb-2"><label class="form-label">Description</label><textarea name="description" rows="2" class="form-control"></textarea></div>
                    <div class="row g-2 mb-2">
                        <div class="col-4"><label class="form-label">Unité</label><input type="text" name="unite" class="form-control"></div>
                        <div class="col-4"><label class="form-label">Valeur cible</label><input type="number" step="0.01" name="valeur_cible" class="form-control"></div>
                        <div class="col-4"><label class="form-label">Valeur réalisée</label><input type="number" step="0.01" name="valeur_realisee" class="form-control"></div>
                    </div>
                    <div class="mb-2"><label class="form-label">Date de mesure</label><input type="date" name="date_mesure" class="form-control"></div>
                    <div class="mb-2"><label class="form-label">Observation</label><textarea name="observation" rows="2" class="form-control"></textarea></div>
                </div>
                <div class="modal-footer"><button type="submit" class="btn btn-primary">Ajouter</button></div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL DOCUMENT --}}
<div class="modal fade" id="modalDocument" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('projets.documents.store', $projet) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header"><h5 class="modal-title">Nouveau document</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <div class="mb-2"><label class="form-label">Titre</label><input type="text" name="titre" class="form-control" required></div>
                    <div class="mb-2"><label class="form-label">Type</label><input type="text" name="type" class="form-control" placeholder="Rapport, contrat, plan..."></div>
                    <div class="mb-2"><label class="form-label">Fichier</label><input type="file" name="fichier" class="form-control" accept=".pdf,.doc,.docx,.xls,.xlsx" required></div>
                    <div class="mb-2"><label class="form-label">Description</label><textarea name="description" rows="2" class="form-control"></textarea></div>
                    <div class="form-text">Formats acceptés : PDF, DOC, DOCX, XLS, XLSX (5 Mo max).</div>
                </div>
                <div class="modal-footer"><button type="submit" class="btn btn-primary">Téléverser</button></div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL RAPPORT --}}
<div class="modal fade" id="modalRapport" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('projets.rapports.store', $projet) }}" method="POST">
                @csrf
                <div class="modal-header"><h5 class="modal-title">Nouveau rapport</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <div class="mb-2"><label class="form-label">Titre</label><input type="text" name="titre" class="form-control" required></div>
                    <div class="mb-2">
                        <label class="form-label">Type</label>
                        <select name="type" class="form-select" required>
                            <option value="avancement">Avancement</option>
                            <option value="financier">Financier</option>
                            <option value="physique">Physique</option>
                            <option value="suivi">Suivi</option>
                            <option value="annuel">Annuel</option>
                            <option value="trimestriel">Trimestriel</option>
                            <option value="mensuel">Mensuel</option>
                            <option value="synthese">Synthèse</option>
                            <option value="execution">Exécution</option>
                        </select>
                    </div>
                    <div class="mb-2"><label class="form-label">Fréquence</label><input type="text" name="frequence" class="form-control" placeholder="Mensuelle, trimestrielle..."></div>
                    <div class="mb-2"><label class="form-label">Date de génération</label><input type="date" name="date_generation" class="form-control" value="{{ date('Y-m-d') }}"></div>
                    <div class="mb-2"><label class="form-label">Contenu / données</label><textarea name="donnees" rows="3" class="form-control"></textarea></div>
                </div>
                <div class="modal-footer"><button type="submit" class="btn btn-primary">Ajouter</button></div>
            </form>
        </div>
    </div>
</div>
