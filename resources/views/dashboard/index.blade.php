<x-app-layout>
  <div class="container-fluid py-4">
    <div class="container-fluid py-4">
      <div class="row">
          <div class="col-12">
              <div class="card mb-4">
                  <div class="card-header pb-0">
                      <h6>Dashboard</h6>
                  </div>
                  <div class="card-body">
                      @if(auth()->user()->role == 'admin')
                          <!-- Admin Dashboard View -->
                          <div class="admin-dashboard">
                              <h4>Utilisation des salles cette semaine</h4>

                              <!-- Summary Stats Cards -->
                              <div class="row mb-4">
                                  <div class="col-xl-3 col-md-6">
                                      <div class="card bg-primary text-white mb-4">
                                          <div class="card-body">
                                              <h5>{{ $totalReservations }}</h5>
                                              <p class="mb-0">Réservations totales</p>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="col-xl-3 col-md-6">
                                      <div class="card bg-success text-white mb-4">
                                          <div class="card-body">
                                              <h5>{{ number_format($averageUtilization, 1) }}%</h5>
                                              <p class="mb-0">Utilisation moyenne</p>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="col-xl-3 col-md-6">
                                      <div class="card bg-warning text-white mb-4">
                                          <div class="card-body">
                                              <h5>{{ $mostBookedSalle->nom ?? 'N/A' }}</h5>
                                              <p class="mb-0">Salle la plus réservée</p>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="col-xl-3 col-md-6">
                                      <div class="card bg-danger text-white mb-4">
                                          <div class="card-body">
                                              <h5>{{ $leastBookedSalle->nom ?? 'N/A' }}</h5>
                                              <p class="mb-0">Salle la moins réservée</p>
                                          </div>
                                      </div>
                                  </div>
                              </div>

                              <!-- Salle Utilization Chart -->
                              <div class="row mb-4">
                                  <div class="col-12">
                                      <div class="card">
                                          <div class="card-header">
                                              <h5>Pourcentage d'utilisation par salle cette semaine</h5>
                                          </div>
                                          <div class="card-body">
                                              <canvas id="salleUtilizationChart" height="100"></canvas>
                                          </div>
                                      </div>
                                  </div>
                              </div>

                              <!-- Salle Utilization Table -->
                              <div class="row">
                                  <div class="col-12">
                                      <div class="card">
                                          <div class="card-header">
                                              <h5>Détails d'utilisation des salles</h5>
                                          </div>
                                          <div class="card-body">
                                              <div class="table-responsive">
                                                  <table class="table table-striped">
                                                      <thead>
                                                          <tr>
                                                              <th>Nom de la salle</th>
                                                              <th>Capacité</th>
                                                              <th>Heures disponibles</th>
                                                              <th>Heures réservées</th>
                                                              <th>Utilisation</th>
                                                          </tr>
                                                      </thead>
                                                      <tbody>
                                                          @foreach($salleUtilization as $salle)
                                                          <tr>
                                                              <td>{{ $salle->name }}</td>
                                                              <td>{{ $salle->capacity }} personnes</td>
                                                              <td>{{ $salle->surface }} ²</td>
                                                              <td>{{ $salle->heuresDisponibles }} heures</td>
                                                              <td>{{ $salle->heuresReservees }} heures</td>
                                                              <td>
                                                                  <div class="d-flex align-items-center">
                                                                      <span class="me-2">{{ number_format($salle->pourcentageUtilisation, 1) }}%</span>
                                                                      <div class="progress w-100">
                                                                          <div class="progress-bar
                                                                              @if($salle->pourcentageUtilisation < 30) bg-danger
                                                                              @elseif($salle->pourcentageUtilisation < 70) bg-warning
                                                                              @else bg-success @endif"
                                                                              role="progressbar"
                                                                              style="width: {{ $salle->pourcentageUtilisation }}%"
                                                                              aria-valuenow="{{ $salle->pourcentageUtilisation }}"
                                                                              aria-valuemin="0"
                                                                              aria-valuemax="100">
                                                                          </div>
                                                                      </div>
                                                                  </div>
                                                              </td>
                                                          </tr>
                                                          @endforeach
                                                      </tbody>
                                                  </table>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      @else
                          <!-- Salarie Dashboard View -->
                          <div class="salarie-dashboard">
                              <ul class="nav nav-tabs" id="reservationTabs" role="tablist">
                                  <li class="nav-item" role="presentation">
                                      <button class="nav-link active" id="future-tab" data-bs-toggle="tab" data-bs-target="#future-reservations" type="button" role="tab">
                                          Réservations à venir
                                      </button>
                                  </li>
                                  <li class="nav-item" role="presentation">
                                      <button class="nav-link" id="past-tab" data-bs-toggle="tab" data-bs-target="#past-reservations" type="button" role="tab">
                                          Réservations passées
                                      </button>
                                  </li>
                              </ul>
                              <div class="tab-content pt-4" id="reservationTabContent">
                                  <!-- Future Reservations Tab -->
                                  <div class="tab-pane fade show active" id="future-reservations" role="tabpanel">
                                      @if(count($futureReservations) > 0)
                                          <div class="table-responsive">
                                              <table class="table table-hover">
                                                  <thead>
                                                      <tr>
                                                          <th>Salle</th>
                                                          <th>Date</th>
                                                          <th>Heure début</th>
                                                          <th>Heure fin</th>
                                                          <th>Capacité</th>
                                                          <th>Actions</th>
                                                      </tr>
                                                  </thead>
                                                  <tbody>
                                                      @foreach($futureReservations as $reservation)
                                                      <tr>
                                                          <td>{{ $reservation->salle->nom }}</td>
                                                          <td>{{ \Carbon\Carbon::parse($reservation->date)->format('d/m/Y') }}</td>
                                                          <td>{{ \Carbon\Carbon::parse($reservation->heure_debut)->format('H:i') }}</td>
                                                          <td>{{ \Carbon\Carbon::parse($reservation->heure_fin)->format('H:i') }}</td>
                                                          <td>{{ $reservation->salle->capacite }} personnes</td>
                                                          <td>
                                                              <a href="{{ route('reservation.show', $reservation->id) }}" class="btn btn-sm btn-info">
                                                                  <i class="fas fa-eye"></i>
                                                              </a>
                                                              <a href="{{ route('reservation.edit', $reservation->id) }}" class="btn btn-sm btn-warning">
                                                                  <i class="fas fa-edit"></i>
                                                              </a>
                                                              <form action="{{ route('reservation.destroy', $reservation->id) }}" method="POST" class="d-inline">
                                                                  @csrf
                                                                  @method('DELETE')
                                                                  <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir annuler cette réservation?')">
                                                                      <i class="fas fa-times"></i>
                                                                  </button>
                                                              </form>
                                                          </td>
                                                      </tr>
                                                      @endforeach
                                                  </tbody>
                                              </table>
                                          </div>
                                      @else
                                          <div class="alert alert-info">
                                              Vous n'avez pas de réservation à venir
                                          </div>
                                      @endif
                                      <div class="mt-3">
                                          <a href="{{ route('reservation.create') }}" class="btn btn-primary">
                                              <i class="fas fa-plus"></i> Nouvelle réservation
                                          </a>
                                      </div>
                                  </div>

                                  <!-- Past Reservations Tab -->
                                  <div class="tab-pane fade" id="past-reservations" role="tabpanel">
                                      @if(count($pastReservations) > 0)
                                          <div class="table-responsive">
                                              <table class="table table-hover">
                                                  <thead>
                                                      <tr>
                                                          <th>Salle</th>
                                                          <th>Date</th>
                                                          <th>Heure début</th>
                                                          <th>Heure fin</th>
                                                          <th>Capacité</th>
                                                      </tr>
                                                  </thead>
                                                  <tbody>
                                                      @foreach($pastReservations as $reservation)
                                                      <tr>
                                                          <td>{{ $reservation->salle->nom }}</td>
                                                          <td>{{ \Carbon\Carbon::parse($reservation->date)->format('d/m/Y') }}</td>
                                                          <td>{{ \Carbon\Carbon::parse($reservation->heure_debut)->format('H:i') }}</td>
                                                          <td>{{ \Carbon\Carbon::parse($reservation->heure_fin)->format('H:i') }}</td>
                                                          <td>{{ $reservation->salle->capacite }} personnes</td>
                                                      </tr>
                                                      @endforeach
                                                  </tbody>
                                              </table>
                                          </div>
                                      @else
                                          <div class="alert alert-info">
                                              Vous n'avez pas de réservation passée
                                          </div>
                                      @endif
                                  </div>
                              </div>
                          </div>
                      @endif
                  </div>
              </div>
          </div>
      </div>
  </div>
  @section('scripts')
      @if(auth()->user()->role == 'admin')
      <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
      <script>
          document.addEventListener('DOMContentLoaded', function() {
              const salleNames = @json($salleUtilization->pluck('nom'));
              const utilizationPercentages = @json($salleUtilization->pluck('pourcentageUtilisation'));

              const ctx = document.getElementById('salleUtilizationChart').getContext('2d');
              new Chart(ctx, {
                  type: 'bar',
                  data: {
                      labels: salleNames,
                      datasets: [{
                          label: 'Utilisation (%)',
                          data: utilizationPercentages,
                          backgroundColor: utilizationPercentages.map(value => {
                              if (value < 30) return '#dc3545';
                              if (value < 70) return '#ffc107';
                              return '#28a745';
                          }),
                          borderWidth: 1
                      }]
                  },
                  options: {
                      responsive: true,
                      plugins: {
                          legend: { display: false }
                      },
                      scales: {
                          y: {
                              beginAtZero: true,
                              max: 100,
                              title: { display: true, text: "Pourcentage d'utilisation" }
                          },
                          x: {
                              title: { display: true, text: "Salles" }
                          }
                      }
                  }
              });
          });
      </script>
      @endif
  @endsection
</x-layout>

