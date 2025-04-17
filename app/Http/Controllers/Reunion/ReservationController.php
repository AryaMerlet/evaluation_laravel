<?php

namespace App\Http\Controllers\Reunion;

use App\Http\Requests\Reunion\ReservationModelRequest;
use App\Http\Services\Reunion\ReservationService;
use App\Models\Reunion\Reservation;
use Carbon\Exceptions\InvalidFormatException;
use Carbon\Exceptions\NotLocaleAwareException;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use InvalidArgumentException;
use Session;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\Translation\Exception\InvalidArgumentException as ExceptionInvalidArgumentException;

class ReservationController extends Controller
{
    /**
     * @var ReservationService
     */
    private $service;
    private const ABILITY = 'reservation';
    private const PATH_VIEWS = 'reservation';

    /**
     * Constructor
     * @param   ReservationService $service
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
        if ($this->can(self::ABILITY . '-retrieve')) {
            return view(self::PATH_VIEWS . '.index');
        }
    }

    /**
     * @return View|Factory|null
     * @throws BindingResolutionException
     * @throws RouteNotFoundException
     * @throws InvalidFormatException
     * @throws NotLocaleAwareException
     * @throws ExceptionInvalidArgumentException
     * @throws InvalidArgumentException
     */
    public function create()
    {
        return $this->model(null, 'create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ReservationModelRequest  $request
     * @return RedirectResponse|void
     */
    public function store(ReservationModelRequest $request)
    {
        if ($this->can(self::ABILITY . '-create')) {
            $data = $request->all();

            $reservation = $this->service->store($data);
            Session::put('ok', 'Création effectuée');

            return redirect(self::PATH_VIEWS);
        }
    }

    /**
     * @param Reservation $reservation
     * @return View|Factory|null
     * @throws BindingResolutionException
     * @throws RouteNotFoundException
     * @throws InvalidFormatException
     * @throws NotLocaleAwareException
     * @throws ExceptionInvalidArgumentException
     * @throws InvalidArgumentException
     */
    public function show(Reservation $reservation)
    {
        return $this->model($reservation, 'retrieve');
    }

    /**
     * @param Reservation $reservation
     * @return View|Factory|null
     * @throws BindingResolutionException
     * @throws RouteNotFoundException
     * @throws InvalidFormatException
     * @throws NotLocaleAwareException
     * @throws ExceptionInvalidArgumentException
     * @throws InvalidArgumentException
     */
    public function edit(Reservation $reservation)
    {
        return $this->model($reservation, 'update');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ReservationModelRequest  $request
     * @param  Reservation $reservation
     * @return RedirectResponse|void
     */
    public function update(ReservationModelRequest $request, Reservation $reservation)
    {
        if ($this->can(self::ABILITY . '-update')) {
            $this->service->update($reservation, $request->all());
            Session::put('ok', 'Mise à jour effectuée');

            return redirect(route(self::PATH_VIEWS . '.index'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Reservation $reservation
     * @return RedirectResponse|void
     */
    public function destroy(Reservation $reservation)
    {
        if ($this->can(self::ABILITY . '-delete')) {
            $this->service->destroy($reservation);
            Session::put('ok', 'Suppression effectuée');

            return redirect(route(self::PATH_VIEWS . '.index'));
        }
    }

    /**
     * Restaure un �l�ment supprim�
     *
     * @example Penser � utiliser un bind dans le web.php
     *          Route::bind('reservation_id', function ($reservation_id) {
     *              return Reservation::onlyTrashed()->find($reservation_id);
     *          });
     * @param  Reservation $reservation
     * @return RedirectResponse|void
     */
    public function undelete(Reservation $reservation)
    {
        if ($this->can(self::ABILITY . '-delete')) {
            $this->service->undelete($reservation);
            Session::put('ok', 'Restauration effectuée');

            return redirect(route(self::PATH_VIEWS . '.index'));
        }
    }

    /**
     * Renvoie la liste des Reservation au format JSON pour leur gestion
     * @return string|false|void � a JSON encoded string on success or FALSE on failure
     */
    public function json()
    {
        if ($this->can(self::ABILITY . '-retrieve')) {
            return $this->service->json();
        }
    }

    /**
     * Rempli un tableau avec les données nécessaires aux vues
     *
     * @param Reservation $reservation|null
     * @param string $ability
     *
     * @return array<string, mixed>
     *
     * @throws InvalidArgumentException
     */
    private function data(?Reservation $reservation, string $ability): array
    {
        return [
            'reservation' => $reservation,
            // variables � ajouter
            'disabled' => $ability === 'retrieve'
        ];
    }

    /**
     * @param Reservation $reservation|null
     * @param string $ability
     * @return View|Factory|null
     * @throws BindingResolutionException
     * @throws RouteNotFoundException
     * @throws InvalidFormatException
     * @throws NotLocaleAwareException
     * @throws ExceptionInvalidArgumentException
     * @throws InvalidArgumentException
     */
    private function model(?Reservation $reservation, string $ability)
    {
        if ($this->can(self::ABILITY . '-' . $ability)) {
            return view(
                self::PATH_VIEWS . '.model',
                $this->data($reservation, $ability)
            );
        }

        return null;
    }
}
