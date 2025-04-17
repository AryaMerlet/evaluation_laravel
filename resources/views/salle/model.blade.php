<x-app-layout>
  @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
  @endif
    <x-slot:title>{{ isset($salle) ? 'Modifier la salle' : 'Créer une nouvelle salle' }}</x-slot:title>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card shadow-lg" style="max-width: 600px; width: 100%;">
            <div class="card-header text-center">
                <h3>{{ isset($salle) ? 'Modifier la salle' : 'Créer une nouvelle salle' }}</h3>
            </div>
            <div class="card-body">
                <x-inputs.form
                    :property="'salle'"
                    :entity="$salle ?? null"
                    :action="isset($salle) ? route('salle.update', $salle->id) : route('salle.store')"
                    method="{{ isset($salle) ? 'PUT' : 'POST' }}">

                    <x-inputs.input-text
                        property="name"
                        label="Nom du salle"
                        placeholder="Entrez le nom de la salle"
                        :old="old('name')"
                        :entity="$salle?? null"
                        required
                        autofocus />

                    <x-inputs.input-text
                    property="capacity"
                    label="Capacité en personnes de la salle"
                    placeholder="Entrez la capacité de la salle"
                    :old="old('capacity')"
                    :entity="$salle ?? null"
                    required />

                    <x-inputs.input-text
                    property="surface"
                    label="Superficie de la salle"
                    placeholder="Entrez la superficie de la salle"
                    :old="old('surface')"
                    :entity="$salle ?? null"
                    required  />

                    <x-inputs.input-text
                    property="equipments"
                    label="Equipement de la salle"
                    placeholder="Entrez les équipements de la salle"
                    :old="old('equipments')"
                    :entity="$salle ?? null"
                    required />

                    <div class="form-group d-flex justify-content-between mb-0">
                        <a href="{{ route('salle.index') }}" class="btn btn-secondary">Retour</a>
                        <button type="submit" class="btn btn-primary">{{ isset($salle) ? 'Mettre à jour' : 'Créer la salle' }}</button>
                    </div>
                </x-inputs.form>
            </div>
        </div>
    </div>
  </x-app-layout>
