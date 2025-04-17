<?php

namespace App\Http\Controllers\Reunion;

use App\Http\Controllers\Controller;
use App\Http\Requests\Reunion\ReservationModelRequest;
use App\Http\Services\Reunion\ReservationService;
use App\Models\Reunion\Reservation;
use App\Models\Reunion\Salle;
use App\Notifications\ReservationNotification;
use Carbon\Exceptions\InvalidFormatException;
use Carbon\Exceptions\NotLocaleAwareException;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\Translation\Exception\InvalidArgumentException as ExceptionInvalidArgumentException;

class ReservationController extends Controller
{
    private const ABILITY = 'reservation';

    private const PATH_VIEWS = 'reservation';

    /**
     * @var ReservationService
     */
    private $service;

    /**
     * Constructor
     *
     * @param  ReservationService  $service
     */
    public function __construct(ReservationService $service)
    {
        $this->middleware('auth');
        $this->service = $service;
        Session::put('level_menu_1', 'Reunions');
        Session::put('level_menu_2', self::ABILITY);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response|RedirectResponse|View|void
     */
    public function index()
    {
        /**
         * @var \App\Models\User
         */
        $user = Auth::user();

        if ($this->can(self::ABILITY . '-retrieve')) {
            if ($user->isan('admin')) {
                $reservations = Reservation::with('user', 'salle')
                    ->orderBy('date', 'DESC')
                    ->orderBy('heure_debut', 'DESC')
                    ->paginate(10);
            } else {
                $reservations = Reservation::where('user_id', $user->id )
                    ->with('user', 'salle')
                    ->orderBy('date', 'DESC')
                    ->orderBy('heure_debut', 'DESC')
                    ->paginate(10);
            }

            return view(self::PATH_VIEWS . '.index', compact('reservations'));
        }

        return redirect()->route('home');
    }

    /**
     * @return View|Factory|null
     *
     * @throws BindingResolutionException
     * @throws RouteNotFoundException
     * @throws InvalidFormatException
     * @throws NotLocaleAwareException
     * @throws ExceptionInvalidArgumentException
     */
    public function create()
    {
        $salles = Salle::all();

        return $this->model(null, 'create', $salles);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ReservationModelRequest  $request
     *
     * @return RedirectResponse|void
     */
    public function store(ReservationModelRequest $request)
    {
        if ($this->can(self::ABILITY . '-create')) {
            $user = Auth::user();
            $data = $request->all();

            $reservation = $this->service->store($data);
            Session::put('ok', 'Création effectuée');
            $user->notify(new ReservationNotification($reservation, 'created'));

            return redirect(self::PATH_VIEWS);
        }

        return redirect()->route('home');
    }

    /**
     * @param  Reservation  $reservation
     *
     * @return View|Factory|null
     *
     * @throws BindingResolutionException
     * @throws RouteNotFoundException
     * @throws InvalidFormatException
     * @throws NotLocaleAwareException
     * @throws ExceptionInvalidArgumentException
     */
    public function show(Reservation $reservation)
    {
        $salles = Salle::all();

        return $this->model($reservation, 'retrieve', $salles);
    }

    /**
     * @param  Reservation  $reservation
     *
     * @return View|Factory|null
     *
     * @throws BindingResolutionException
     * @throws RouteNotFoundException
     * @throws InvalidFormatException
     * @throws NotLocaleAwareException
     * @throws ExceptionInvalidArgumentException
     */
    public function edit(Reservation $reservation)
    {
        $salles = Salle::all();

        return $this->model($reservation, 'update', $salles);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ReservationModelRequest  $request
     * @param  Reservation  $reservation
     *
     * @return RedirectResponse|void
     */
    public function update(ReservationModelRequest $request, Reservation $reservation)
    {
        if ($this->can(self::ABILITY . '-update')) {
            $this->service->update($reservation, $request->all());
            Session::put('ok', 'Mise à jour effectuée');

            return redirect(route(self::PATH_VIEWS . '.index'));
        }

        return redirect()->route('home');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Reservation  $reservation
     *
     * @return RedirectResponse|void
     */
    public function destroy(Reservation $reservation)
    {
        if ($this->can(self::ABILITY . '-delete')) {
            $user = Auth::user();
            $this->service->destroy($reservation);
            Session::put('ok', 'Suppression effectuée');
            $user->notify(new ReservationNotification($reservation, 'created'));

            return redirect(route(self::PATH_VIEWS . '.index'));
        }

        return redirect()->route('home');
    }

    /**
     * Restaure un élément supprimé
     *
     * @example Penser à utiliser un bind dans le web.php
     *          Route::bind('reservation_id', function ($reservation_id) {
     *              return Reservation::onlyTrashed()->find($reservation_id);
     *          });
     *
     * @param  Reservation  $reservation
     *
     * @return RedirectResponse|void
     */
    public function undelete(Reservation $reservation)
    {
        if ($this->can(self::ABILITY . '-delete')) {
            $this->service->undelete($reservation);
            Session::put('ok', 'Restauration effectuée');

            return redirect(route(self::PATH_VIEWS . '.index'));
        }

        return redirect()->route('home');
    }

    /**
     * Renvoie la liste des Reservation au format JSON pour leur gestion
     *
     * @return string|false|void — a JSON encoded string on success or FALSE on failure
     */
    public function json()
    {
        if ($this->can(self::ABILITY . '-retrieve')) {
            return $this->service->json();
        }

        return null;
    }

    /**
     * Rempli un tableau avec les données nécessaires aux vues
     *
     * @param  Reservation|null  $reservation
     * @param  string  $ability
     * @param  Collection<int, Salle>|array<string, mixed>  $salles
     *
     * @return array<string, mixed>
     */
    private function data(?Reservation $reservation, string $ability, $salles): array
    {
        return [
            'reservation' => $reservation,
            'salles' => $salles,
            'disabled' => $ability === 'retrieve',
        ];
    }

    /**
     * @param  Reservation|null  $reservation
     * @param  string  $ability
     * @param  Collection<int, Salle>|array<string, mixed>  $salles
     *
     * @return View|Factory|null
     *
     * @throws BindingResolutionException
     * @throws RouteNotFoundException
     * @throws InvalidFormatException
     * @throws NotLocaleAwareException
     * @throws ExceptionInvalidArgumentException
     */
    private function model(?Reservation $reservation, string $ability, $salles)
    {
        if ($this->can(self::ABILITY . '-' . $ability)) {
            return view(
                self::PATH_VIEWS . '.model',
                $this->data($reservation, $ability, $salles)
            );
        }

        return null;
    }
}
