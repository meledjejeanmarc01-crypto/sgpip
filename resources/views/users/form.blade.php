<div class="row g-3">

    <div class="col-md-6">
        <label class="form-label">Nom complet <span class="text-danger">*</span></label>
        <input type="text" name="name" value="{{ old('name', $user->name ?? '') }}" class="form-control @error('name') is-invalid @enderror" required>
        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">Email <span class="text-danger">*</span></label>
        <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}" class="form-control @error('email') is-invalid @enderror" required>
        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">Mot de passe {{ $user ? '(laisser vide pour ne pas changer)' : '' }} {!! $user ? '' : '<span class="text-danger">*</span>' !!}</label>
        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" {{ $user ? '' : 'required' }}>
        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">Confirmation du mot de passe</label>
        <input type="password" name="password_confirmation" class="form-control">
    </div>

    <div class="col-md-6">
        <label class="form-label">Rôle</label>
        <select name="role_id" class="form-select">
            <option value="">-- Aucun --</option>
            @foreach($roles as $role)
                <option value="{{ $role->id }}" {{ (string) old('role_id', $user->role_id ?? '') === (string) $role->id ? 'selected' : '' }}>{{ $role->nom }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-md-6">
        <label class="form-label">Structure</label>
        <select name="structure_id" class="form-select">
            <option value="">-- Aucune --</option>
            @foreach($structures as $structure)
                <option value="{{ $structure->id }}" {{ (string) old('structure_id', $user->structure_id ?? '') === (string) $structure->id ? 'selected' : '' }}>{{ $structure->nom }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-12">
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" name="statut" value="1" id="statut" {{ old('statut', $user->statut ?? true) ? 'checked' : '' }}>
            <label class="form-check-label" for="statut">Compte actif</label>
        </div>
    </div>

    <div class="col-12 d-flex gap-2">
        <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Enregistrer</button>
        <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">Annuler</a>
    </div>

</div>
