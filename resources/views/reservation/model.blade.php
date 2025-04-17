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
    <x-slot:title>{{ isset($reservation) ? 'Modifier la reservation' : 'Créer une nouvelle réservation' }}</x-slot:title>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card shadow-lg" style="max-width: 600px; width: 100%;">
            <div class="card-header text-center">
                <h3>{{ isset($reservation) ? 'Modifier la reservation' : 'Créer une nouvelle réservation' }}</h3>
            </div>
            <div class="card-body">
                <x-inputs.form
                    :property="'reservation'"
                    :entity="$reservation ?? null"
                    :action="isset($reservation) ? route('reservation.update', $reservation->id) : route('reservation.store')"
                    method="{{ isset($reservation) ? 'PUT' : 'POST' }}">

                    <x-inputs.input-select2
                    property="salle_id"
                    label="Salle"
                    :values="$salles"
                    itemValue="id"
                    itemLabel="name"
                    :entity="$reservation ?? null"
                    :selected="old('salle_id', $reservation->salle_id ?? null)"
                    required />

                    <div class="form-group mb-3">
                      <label for="date">Date prévue</label>
                      <input type="date" id="date" name="date"
                          class="form-control @error('date') is-invalid @enderror"
                          value="{{ old('date', isset($reservation) && $reservation->date ? \Carbon\Carbon::parse($reservation->date)->format('Y-m-d') : (request('date') ? \Carbon\Carbon::parse(request('date'))->format('Y-m-d') : '')) }}"
                          required>
                      @error('date')
                          <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>

                    <div class="form-group mb-3">
                      <label for="heure_debut">Heure de début</label>
                      <div class="d-flex">
                        <input type="time" id="heure_debut" name="heure_debut"
                        class="form-control @error('heure_debut') is-invalid @enderror"
                        value="{{ old('heure_debut', isset($reservation) ? \Carbon\Carbon::parse($reservation->heure_debut)->format('H:i') : (request('heure_debut') ? request('heure_debut') : '')) }}"
                        required lang="fr">
                      </div>
                      @error('heure_debut')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>

                    <div class="form-group mb-3">
                      <label for="heure_fin">Heure de fin</label>
                      <div class="d-flex">
                        <input type="time" id="heure_fin" name="heure_fin"
                        class="form-control @error('heure_fin') is-invalid @enderror"
                        value="{{ old('heure_fin', isset($reservation) ? \Carbon\Carbon::parse($reservation->heure_fin)->format('H:i') : (request('heure_fin') ? request('heure_fin') : '')) }}"
                        required lang="fr">
                      </div>
                      @error('heure_fin')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>


                    <x-inputs.input-text
                        property="motif"
                        label="motif de la reservation"
                        placeholder="Entrez le nom du reservation"
                        :old="old('nom')"
                        :entity="$reservation ?? null"
                        autofocus />

                    <div class="form-group d-flex justify-content-between mb-0">
                        <a href="{{ route('reservation.index') }}" class="btn btn-secondary">Retour</a>
                        <button type="submit" class="btn btn-primary">{{ isset($reservation) ? 'Mettre à jour' : 'Créer la réservation' }}</button>
                    </div>
                </x-inputs.form>
            </div>
        </div>
    </div>

    <script>
      document.addEventListener('DOMContentLoaded', function() {
        const timeInputs = document.querySelectorAll('input[type="time"]');
        timeInputs.forEach(input => {

          input.setAttribute('lang', 'fr');

          if (typeof input.timeFormat !== 'undefined') {
            input.timeFormat = 'HH:mm';
          }
        });
      });
    </script>
  </x-app-layout>

