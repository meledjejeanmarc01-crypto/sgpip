<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nom', 'prenom', 'email', 'password', 'role', 'actif',
    ];

    /** Cache des projets gérés (voir idsProjetsGeres). */
    private ?array $idsProjetsGeres = null;

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'actif' => 'boolean',
        ];
    }

    public function getNomCompletAttribute(): string
    {
        return "{$this->prenom} {$this->nom}";
    }

    public function isAdministrateur(): bool
    {
        return $this->role === 'administrateur';
    }

    public function hasRole(string|array $roles): bool
    {
        return in_array($this->role, (array) $roles, true);
    }

    // RG17 : projets gérés par l'utilisateur.
    public function projetsGeres()
    {
        return $this->belongsToMany(Projet::class, 'projet_user')->withTimestamps();
    }

    public function rapports()
    {
        return $this->hasMany(Rapport::class, 'utilisateur_id');
    }

    public function isGestionnaire(): bool
    {
        return $this->role === 'gestionnaire_projet';
    }

    public function isConsultant(): bool
    {
        return $this->role === 'consultant';
    }

    /*
    |--------------------------------------------------------------------------
    | Droits d'accès (matrice dans config/acces.php)
    |--------------------------------------------------------------------------
    */

    /** Le rôle de l'utilisateur peut-il consulter les pages de ce module ? */
    public function peutVoir(string $module): bool
    {
        return $this->autoriseModule($module, 'voir');
    }

    /** Le rôle de l'utilisateur peut-il créer / modifier / supprimer dans ce module ? */
    public function peutModifier(string $module): bool
    {
        return $this->autoriseModule($module, 'modifier');
    }

    private function autoriseModule(string $module, string $action): bool
    {
        $roles = config("acces.modules.{$module}.{$action}");

        // Module absent de la matrice : refusé par défaut.
        if ($roles === null) {
            return false;
        }

        return $roles === '*' || in_array($this->role, (array) $roles, true);
    }

    /**
     * Identifiants des projets que l'utilisateur gère (RG17), lus une seule fois par requête.
     *
     * @return int[]
     */
    public function idsProjetsGeres(): array
    {
        return $this->idsProjetsGeres ??= $this->projetsGeres()
            ->pluck('projets.id')
            ->map(fn ($id) => (int) $id)
            ->all();
    }

    /**
     * L'utilisateur peut-il modifier ce projet, ou un élément rattaché à ce projet
     * (activité, financement, document…) ?
     *  - administrateur : tous les projets ;
     *  - gestionnaire   : uniquement les projets qu'il gère ;
     *  - consultant     : aucun.
     * Un élément sans projet ($projet = null, ex. une dépense non rattachée) n'est
     * limité que par le droit de modifier le module (voir peutModifier()).
     */
    public function peutModifierProjet(?Projet $projet): bool
    {
        if ($this->isAdministrateur()) {
            return true;
        }

        if (! $this->isGestionnaire()) {
            return false;
        }

        return $projet === null || in_array((int) $projet->getKey(), $this->idsProjetsGeres(), true);
    }

    /**
     * Pour les boutons des listes : l'utilisateur peut-il modifier cet élément, qui peut ne pas avoir de projet ?
     * Un élément sans projet (ex. une dépense non rattachée) n'est modifiable que par l'administrateur.
     */
    public function peutModifierElement(?Projet $projet): bool
    {
        return $projet ? $this->peutModifierProjet($projet) : $this->isAdministrateur();
    }
}
