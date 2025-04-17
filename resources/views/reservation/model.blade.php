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
                        property="salle"
                        label="salle"
                        placeholder="Sélectionner le nom de la salle"
                        :old="old('reservations->salle->nom')"
                        :entity="$reservation ?? null"
                        :values="$reservations"
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
                            <select id="heure_debut_heure" name="heure_debut_heure"
                                class="form-control @error('heure_debut_heure') is-invalid @enderror" required>
                                @for ($i = 0; $i < 24; $i++)
                                    <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}"
                                        {{ old('heure_debut_heure', isset($reservation) ? \Carbon\Carbon::parse($reservation->heure_debut)->format('H') : (request('heure_debut') ? \Carbon\Carbon::parse(request('heure_debut'))->format('H') : '')) == str_pad($i, 2, '0', STR_PAD_LEFT) ? 'selected' : '' }}>
                                        {{ str_pad($i, 2, '0', STR_PAD_LEFT) }}
                                    </option>
                                @endfor
                            </select>
                            <span class="mx-2">:</span>
                            <select id="heure_debut_minute" name="heure_debut_minute"
                                class="form-control @error('heure_debut_minute') is-invalid @enderror" required>
                                <option value="0"
                                    {{ old('heure_debut_minute', isset($reservation) ? \Carbon\Carbon::parse($reservation->heure_debut)->format('i') : (request('heure_debut') ? \Carbon\Carbon::parse(request('heure_debut'))->format('i') : '')) == '00' ? 'selected' : '' }}>
                                    00</option>
                                <option value="15"
                                    {{ old('heure_debut_minute', isset($reservation) ? \Carbon\Carbon::parse($reservation->heure_debut)->format('i') : (request('heure_debut') ? \Carbon\Carbon::parse(request('heure_debut'))->format('i') : '')) == '15' ? 'selected' : '' }}>
                                    15</option>
                                <option value="30"
                                    {{ old('heure_debut_minute', isset($reservation) ? \Carbon\Carbon::parse($reservation->heure_debut)->format('i') : (request('heure_debut') ? \Carbon\Carbon::parse(request('heure_debut'))->format('i') : '')) == '30' ? 'selected' : '' }}>
                                    30</option>
                                <option value="45"
                                    {{ old('heure_debut_minute', isset($reservation) ? \Carbon\Carbon::parse($reservation->heure_debut)->format('i') : (request('heure_debut') ? \Carbon\Carbon::parse(request('heure_debut'))->format('i') : '')) == '45' ? 'selected' : '' }}>
                                    45</option>
                            </select>
                        </div>
                        @error('heure_debut_heure')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        @error('heure_debut_minute')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="heure_fin">Heure de fin</label>
                        <div class="d-flex">
                            <select id="heure_fin_heure" name="heure_fin_heure"
                                class="form-control @error('heure_fin_heure') is-invalid @enderror" required>
                                @for ($i = 0; $i < 24; $i++)
                                    <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}"
                                        {{ old('heure_fin_heure', isset($reservation) ? \Carbon\Carbon::parse($reservation->heure_fin)->format('H') : (request()->heure_fin ? substr(request()->heure_fin, 0, 2) : '')) == str_pad($i, 2, '0', STR_PAD_LEFT) ? 'selected' : '' }}>
                                        {{ str_pad($i, 2, '0', STR_PAD_LEFT) }}
                                    </option>
                                @endfor
                            </select>
                            <span class="mx-2">:</span>
                            <select id="heure_fin_minute" name="heure_fin_minute"
                                class="form-control @error('heure_fin_minute') is-invalid @enderror" required>
                                <option value="0"
                                    {{ old('heure_fin_minute', isset($reservation) ? \Carbon\Carbon::parse($reservation->heure_fin)->format('i') : (request()->heure_fin ? substr(request()->heure_fin, 3, 2) : '00')) == '00' ? 'selected' : '' }}>
                                    00</option>
                                <option value="15"
                                    {{ old('heure_fin_minute', isset($reservation) ? \Carbon\Carbon::parse($reservation->heure_fin)->format('i') : (request()->heure_fin ? substr(request()->heure_fin, 3, 2) : '00')) == '15' ? 'selected' : '' }}>
                                    15</option>
                                <option value="30"
                                    {{ old('heure_fin_minute', isset($reservation) ? \Carbon\Carbon::parse($reservation->heure_fin)->format('i') : (request()->heure_fin ? substr(request()->heure_fin, 3, 2) : '00')) == '30' ? 'selected' : '' }}>
                                    30</option>
                                <option value="45"
                                    {{ old('heure_fin_minute', isset($reservation) ? \Carbon\Carbon::parse($reservation->heure_fin)->format('i') : (request()->heure_fin ? substr(request()->heure_fin, 3, 2) : '00')) == '45' ? 'selected' : '' }}>
                                    45</option>
                            </select>
                        </div>
                        @error('heure_fin_heure')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        @error('heure_fin_minute')
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
  </x-app-layout>
