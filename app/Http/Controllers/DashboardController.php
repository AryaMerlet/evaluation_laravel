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

class DashboardController extends Controller
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

    private function adminDashboard()
    {
        // Define the current week period
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        // Get all salles
        $salles = Salle::all();

        // Calculate working hours per day (assuming 9AM-6PM = 9 hours)
        $workingHoursPerDay = 9;
        $workingDaysThisWeek = 5; // Mon-Fri
        $totalHoursAvailablePerSalle = $workingHoursPerDay * $workingDaysThisWeek;

        // Get all reservations for this week
        $weekReservations = Reservation::whereBetween('date', [$startOfWeek, $endOfWeek])->get();
        $totalReservations = $weekReservations->count();

        // Calculate utilization per salle
        $salleUtilization = collect();

        foreach ($salles as $salle) {
            $salleReservations = $weekReservations->where('salle_id', $salle->id);

            // Calculate hours booked for this salle
            $heuresReservees = 0;
            foreach ($salleReservations as $reservation) {
                $debut = Carbon::parse($reservation->heure_debut);
                $fin = Carbon::parse($reservation->heure_fin);
                $heuresReservees += $fin->diffInHours($debut);
            }

            // Calculate utilization percentage
            $pourcentageUtilisation = $totalHoursAvailablePerSalle > 0
                ? ($heuresReservees / $totalHoursAvailablePerSalle) * 100
                : 0;

            $salleUtilization->push((object)[
                'id' => $salle->id,
                'nom' => $salle->nom,
                'capacite' => $salle->capacite,
                'heuresDisponibles' => $totalHoursAvailablePerSalle,
                'heuresReservees' => $heuresReservees,
                'pourcentageUtilisation' => $pourcentageUtilisation
            ]);
        }

        // Sort by utilization percentage (descending)
        $salleUtilization = $salleUtilization->sortByDesc('pourcentageUtilisation');

        // Get most and least booked salles
        $mostBookedSalle = $salleUtilization->first();
        $leastBookedSalle = $salleUtilization->last();

        // Calculate average utilization
        $averageUtilization = $salleUtilization->avg('pourcentageUtilisation');

        return view('dashboard.index', compact(
            'salleUtilization',
            'totalReservations',
            'averageUtilization',
            'mostBookedSalle',
            'leastBookedSalle'
        ));
    }

    private function salarieDashboard()
    {
        $userId = Auth::id();
        $today = Carbon::today();

        // Get future and past reservations for the current user
        $futureReservations = Reservation::where('user_id', $userId)
            ->where(function($query) use ($today) {
                $query->where('date', '>', $today)
                    ->orWhere(function($query) use ($today) {
                        $query->where('date', $today)
                            ->where('heure_debut', '>', Carbon::now()->format('H:i:s'));
                    });
            })
            ->with('salle')
            ->orderBy('date')
            ->orderBy('heure_debut')
            ->get();

        $pastReservations = Reservation::where('user_id', $userId)
            ->where(function($query) use ($today) {
                $query->where('date', '<', $today)
                    ->orWhere(function($query) use ($today) {
                        $query->where('date', $today)
                            ->where('heure_debut', '<=', Carbon::now()->format('H:i:s'));
                    });
            })
            ->with('salle')
            ->orderByDesc('date')
            ->orderByDesc('heure_debut')
            ->get();

        return view('dashboard.index', compact('futureReservations', 'pastReservations'));
    }
}
