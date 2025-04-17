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
                        property="nom"
                        label="Nom du salle"
                        placeholder="Entrez le nom du salle"
                        :old="old('nom')"
                        :entity="$salle ?? null"
                        required
                        autofocus />

                    <div class="form-group d-flex justify-content-between mb-0">
                        <a href="{{ route('salle.index') }}" class="btn btn-secondary">Retour</a>
                        <button type="submit" class="btn btn-primary">{{ isset($salle) ? 'Mettre à jour' : 'Créer la salle' }}</button>
                    </div>
                </x-inputs.form>
            </div>
        </div>
    </div>
  </x-app-layout>
