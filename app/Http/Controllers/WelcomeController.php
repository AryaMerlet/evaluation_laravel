<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Contracts\Container\BindingResolutionException;
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
