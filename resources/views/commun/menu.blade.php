<div class="l-navbar" id="nav-bar">
    <nav class="nav">
        <div>
            <a href="#" class="nav_logo">
                <i class="bx bx-layer nav_logo-icon"></i><span class="nav_logo-name">reservation</span>
            </a>
            <div class="nav_list">
                <a href="{{ route('salle.index')}}"
                  class="nav_link {{ session('level_menu_2') == 'salle' ? 'menu-active' : '' }}">
                  <i class="bx bx-user nav_icon" data-bs-toggle="tooltip" data-bs-custom-class="custom-tooltip"
                      data-bs-title="Salles"></i>
                  <span class="nav_name">Salles</span>
                </a>
                <a href="{{ route('reservation.index') }}"
                    class="nav_link {{ session('level_menu_2') == 'reservation' ? 'menu-active' : '' }}">
                    <i class="bx bx-calendar nav_icon" data-bs-toggle="tooltip" data-bs-custom-class="custom-tooltip"
                        data-bs-title="{{ Auth::user()->isA('admin') ? 'R' : 'Mes r' }}éservations"></i>
                    <span class="nav_name">{{ Auth::user()->isA('admin') ? 'R' : 'Mes r' }}éservations</span>
                </a>

                @if (Auth::user()->isA('admin'))

                @endif
            </div>
        </div>
        <a class="nav_link" href="{{ route('logout') }}"
            onclick="
              event.preventDefault();
              Swal.fire({
                title: '{{ __('Would you like to disconnect?') }}',
                text: '',
                icon: 'warning'
              }).then((result) => {
                if (result.value) {
                  document.getElementById('logout-form').submit();
                }else {
                  return false
                }
              });
            ">
            <i class="bx bx-log-out nav_icon" data-bs-toggle="tooltip" data-bs-custom-class="custom-tooltip"
                data-bs-title="{{ __('Logout') }}"></i>
            <span class="nav_name">{{ __('Logout') }}</span>
        </a>
    </nav>
</div>
