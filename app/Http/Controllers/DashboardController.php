<?php

namespace App\Http\Controllers;

use App\Models\Reunion\Reservation;
use App\Models\Reunion\Salle;
use Auth;
use Carbon\Carbon;
use Illuminate\Contracts\Container\BindingResolutionException;
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
        $user = Auth::user();

        if ($user->isan('admin')) {
            return $this->adminDashboard();
        }

        return $this->salarieDashboard();
    }

    /**
     * Summary of adminDashboard
     * @return \Illuminate\Contracts\View\View
     */
    private function adminDashboard()
    {
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        $salles = Salle::all();

        $workingHoursPerDay = 9;
        $workingDaysThisWeek = 5;
        $totalHoursAvailablePerSalle = $workingHoursPerDay * $workingDaysThisWeek;

        $weekReservations = Reservation::whereBetween('date', [$startOfWeek, $endOfWeek])->get();
        $totalReservations = $weekReservations->count();

        $salleUtilization = collect();

        foreach ($salles as $salle) {
            $salleReservations = $weekReservations->where('salle_id', $salle->id);

            $heuresReservees = 0;
            foreach ($salleReservations as $reservation) {
                $debut = Carbon::parse($reservation->heure_debut);
                $fin = Carbon::parse($reservation->heure_fin);
                $heuresReservees += $fin->diffInHours($debut);
            }

            $pourcentageUtilisation = $heuresReservees / $totalHoursAvailablePerSalle * 100;

            $salleUtilization->push((object) [
                'id' => $salle->id,
                'nom' => $salle->name,
                'capacite' => $salle->capacity,
                'heuresDisponibles' => $totalHoursAvailablePerSalle,
                'heuresReservees' => $heuresReservees,
                'pourcentageUtilisation' => $pourcentageUtilisation,
            ]);
        }

        $salleUtilization = $salleUtilization->sortByDesc('pourcentageUtilisation');

        $mostBookedSalle = $salleUtilization->first();
        $leastBookedSalle = $salleUtilization->last();
        $averageUtilization = $salleUtilization->avg('pourcentageUtilisation');

        return view('dashboard.index', [
            'salleUtilization' => $salleUtilization,
            'totalReservations' => $totalReservations,
            'averageUtilization' => $averageUtilization,
            'mostBookedSalle' => $mostBookedSalle,
            'leastBookedSalle' => $leastBookedSalle,
            'futureReservations' => collect(), // Pour éviter les erreurs
            'pastReservations' => collect(),   // Pour éviter les erreurs
        ]);
    }

    /**
     * Summary of salarieDashboard
     * @return \Illuminate\Contracts\View\View
     */
    private function salarieDashboard()
    {
        $userId = Auth::id();
        $today = Carbon::today();

        $futureReservations = Reservation::where('user_id', $userId)
            ->where(function ($query) use ($today) {
                $query->where('date', '>', $today)
                    ->orWhere(function ($query) use ($today) {
                        $query->where('date', $today)
                            ->where('heure_debut', '>', Carbon::now()->format('H:i:s'));
                    });
            })
            ->with('salle')
            ->orderBy('date')
            ->orderBy('heure_debut')
            ->get();

        $pastReservations = Reservation::where('user_id', $userId)
            ->where(function ($query) use ($today) {
                $query->where('date', '<', $today)
                    ->orWhere(function ($query) use ($today) {
                        $query->where('date', $today)
                            ->where('heure_debut', '<=', Carbon::now()->format('H:i:s'));
                    });
            })
            ->with('salle')
            ->orderByDesc('date')
            ->orderByDesc('heure_debut')
            ->get();

        return view('dashboard.index', [
            'futureReservations' => $futureReservations,
            'pastReservations' => $pastReservations,
            'salleUtilization' => collect(),         // Pour compatibilité vue
            'totalReservations' => 0,
            'averageUtilization' => 0,
            'mostBookedSalle' => null,
            'leastBookedSalle' => null,
        ]);
    }
}
