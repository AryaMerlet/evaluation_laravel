<x-app-layout>
  <x-slot:title>Liste des Réservations</x-slot:title>

  <div class="container py-4">
      <div class="d-flex justify-content-between align-items-center mb-3">
          <h2 class="mb-0">Liste des Réservations</h2>
          @can('reservation-create')
              <a href="{{ route('reservation.create') }}" class="btn btn-primary text-white">
                  <i class="fas fa-plus text-white" aria-hidden="true"></i> Créer une réservation
              </a>
          @endcan
      </div>

      <div class="card shadow">
          <div class="card-body">
              <div class="table-responsive">
                  <table id="ReservationsTable" class="table table-striped table-hover">
                      <thead>
                          <tr>
                              <th>Salarié</th>
                              <th>Nom de la salle</th>
                              <th>date de réservation</th>
                              <th>Heure de la réservation</th>
                              @auth
                                  @can('reservation-update')
                                      <th>Actions</th>
                                  @endcan
                              @endauth
                          </tr>
                      </thead>
                      <tbody>
                          @forelse($reservations as $reservation)
                              <tr>
                                  <td>{{ $reservation->user->first_name .' '. $reservation->user->last_name }}</td>
                                  <td>{{ $reservation->salle->name }}</td>
                                  <td>{{ \Carbon\Carbon::parse($reservation->date)->format('d/m/Y') }}</td>
                                  <td>{{ \Carbon\Carbon::parse($reservation->heure_debut)->format('H:i') .' - '. \Carbon\Carbon::parse($reservation->heure_fin)->format('H:i') }}</td>
                                  @auth
                                    <td class="d-flex">
                                      @can('reservation-update')
                                        <!-- Edit Button -->
                                        <x-grid.button-action ability="reservation-update"
                                            url="{{ route('reservation.edit', $reservation->id) }}" titre="Modifier"
                                            icone="fas fa-edit" couleur="warning" />
                                      @endcan
                                      <!-- Delete Button -->
                                      @can('reservation-delete')
                                          <form method="POST" action="{{ route('reservation.destroy', $reservation->id) }}"
                                              class="d-inline delete-form">
                                              @csrf
                                              @method('DELETE')
                                              <button type="button" class="btn btn-outline-danger btn-inline"
                                                  data-bs-toggle="tooltip" title="Supprimer"
                                                  onclick="confirmSuppression(event, this)">
                                                  <i class="fa-regular fa-trash-can fa-fw" aria-hidden="true"></i>
                                              </button>
                                          </form>
                                      @endcan
                                    </td>
                                  @endauth
                              </tr>
                          @empty
                              <tr>
                                  <td colspan="5" class="text-center">Aucune réservation trouvée.</td>
                              </tr>
                          @endforelse
                      </tbody>
                  </table>
              </div>
          </div>
      </div>

      <div class="row">
          <div class="col">
              <div class="mt-3">
                  {{ $reservations->links() }}
              </div>
          </div>
      </div>

      <script>
          function confirmSuppression(event, button) {
              event.preventDefault();

              Swal.fire({
                  title: 'Êtes-vous sûr de vouloir supprimer cette reservation ?',
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#d33',
                  cancelButtonColor: '#6c757d',
                  confirmButtonText: 'Oui, supprimer',
                  cancelButtonText: 'Annuler'
              }).then((result) => {
                  if (result.isConfirmed) {
                      button.closest('form').submit();
                  }
              });
          }
      </script>
</x-app-layout>
