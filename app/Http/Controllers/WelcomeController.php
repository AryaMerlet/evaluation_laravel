<?php

namespace App\Http\Controllers;

use App\Models\Reunion\Reservation;
use App\Models\Reunion\Salle;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\RedirectResponse;
use InvalidArgumentException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

class WelcomeController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\View
     *
     * @throws BindingResolutionException
     * @throws RouteNotFoundException
     * @throws InvalidArgumentException
     */
    public function index()
    {
        if (Auth::user()->role == 'admin') {
            return $this->adminDashboard();
        } else {
            return $this->salarieDashboard();
        }
    }
}
