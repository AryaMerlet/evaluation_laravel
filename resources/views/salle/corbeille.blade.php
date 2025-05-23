<x-app-layout>
  <x-slot:title>Corbeille des Salles</x-slot:title>

  <div class="container py-4">
      <div class="d-flex justify-content-between align-items-center mb-3">
          <h2 class="mb-0">Corbeille des Salles</h2>
          <a href="{{ route('salle.index') }}" class="btn btn-secondary">
              <i class="fas fa-arrow-left"></i> Retour à la liste
          </a>
      </div>
      @if (session('success'))
          <div class="alert alert-success">
              {{ session('success') }}
          </div>
      @endif

      <div class="card shadow">
          <div class="card-body">
              <table class="table table-striped table-hover">
                  <thead>
                      <tr>
                          <th>Nom</th>
                          <th>Capacité</th>
                          <th>Surface</th>
                          <th>Equipement</th>
                          <th>Actions</th>
                      </tr>
                  </thead>
                  <tbody>
                      @forelse($deletedSalles as $salle)
                          <tr>
                              <td>{{ $salle->nom }}</td>
                              <td>{{ $salle->capacity }} personnes</td>
                              <td>{{ $salle->surface }} m²</td>
                              <td>{{ $salle->equipments }}</td>
                              <td>
                                  <button type="button" class="btn btn-outline-info btn-inline"
                                      data-bs-toggle="tooltip" title="Restaurer"
                                      onclick="confirmRestauration('{{ route('salle.undelete', $salle->id) }}')">
                                      <i class="fas fa-undo"></i> Restaurer
                                  </button>
                              </td>
                          </tr>
                      @empty
                          <tr>
                              <td colspan="5" class="text-center">Aucun salle trouvée dans la corbeille.</td>
                          </tr>
                      @endforelse
                  </tbody>
              </table>
          </div>
      </div>

      <div class="mt-3">
          {{ $deletedSalles->links() }}
      </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
      function confirmRestauration(url) {
          Swal.fire({
              title: 'Êtes-vous sûr de vouloir restaurer ce salle ?',
              text: "L'élément sera restauré dans la liste des Salles.",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#28a745',
              cancelButtonColor: '#6c757d',
              confirmButtonText: 'Oui, restaurer',
              cancelButtonText: 'Annuler'
          }).then((result) => {
              if (result.isConfirmed) {
                  window.location.href = url;
              }
          });
      }
  </script>
</x-app-layout>
