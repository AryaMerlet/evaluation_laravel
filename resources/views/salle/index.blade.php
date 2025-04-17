<x-app-layout>
  <x-slot:title>Liste des Salles</x-slot:title>

  <div class="container py-4">
      <div class="d-flex justify-content-between align-items-center mb-3">
          <h2 class="mb-0">Liste des Salles</h2>
          @can('salle-create')
              <a href="{{ route('salle.create') }}" class="btn btn-primary text-white">
                  <i class="fas fa-plus text-white" aria-hidden="true"></i> Créer une salle
              </a>
          @endcan
      </div>

      <div class="card shadow">
          <div class="card-body">
              <div class="table-responsive">
                  <table id="SallesTable" class="table table-striped table-hover">
                      <thead>
                          <tr>
                              <th>Nom</th>
                              <th>Capacité</th>
                              <th>Surface</th>
                              <th>Equipement</th>
                              @auth
                                  @can('salle-update')
                                      <th>Actions</th>
                                  @endcan
                              @endauth
                          </tr>
                      </thead>
                      <tbody>
                          @forelse($salles as $salle)
                              <tr>
                                  <td>{{ $salle->name }}</td>
                                  <td>{{ $salle->capacity }} personnes</td>
                                  <td>{{ $salle->surface }} m²</td>
                                  <td>{{ $salle->equipments }}</td>

                                  @auth
                                    @can('salle-update')
                                      <td class="d-flex">

                                        <!-- Edit Button -->
                                        <x-grid.button-action ability="salle-update"
                                            url="{{ route('salle.edit', $salle->id) }}" titre="Modifier"
                                            icone="fas fa-edit" couleur="warning" />
                                    @endcan
                                      <!-- Delete Button -->
                                      @can('salle-delete')
                                          <form method="POST" action="{{ route('salle.destroy', $salle->id) }}"
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
                                  <td colspan="5" class="text-center">Aucune salle trouvée.</td>
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
                  {{ $salles->links() }}
              </div>
          </div>
          <div class="col">

              @can('salle-delete')
                  <div class="d-flex justify-content-end mt-3">
                      <a href="{{ route('salle.corbeille') }}" class="btn btn-outline-danger">
                          <i class="fa fa-trash me-2" aria-hidden="true"></i> {{ __('Voir la corbeille') }}
                      </a>
                  </div>
              @endcan
          </div>
      </div>

      <script>
          function confirmSuppression(event, button) {
              event.preventDefault();

              Swal.fire({
                  title: 'Êtes-vous sûr de vouloir supprimer cette salle ?',
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
