<?php

namespace App\Http\Services\Reunion;

use App\Http\Repositories\Reunion\ReservationRepository;;
use App\Models\Reunion\Reservation;
use Auth;
use DB;
use Log;

class ReservationService
{
    /**
     * @var ReservationRepository
     */
    protected $repository;

    /**
     * Constructor
     * @param  ReservationRepository  $repository
     */
    public function __construct(ReservationRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Store a new model instance
     * @param  array<mixed>  $inputs
     * @return  Reservation
     */
    public function store(array $inputs): Reservation
    {
        //
        // Règles de gestion à appliquer avant l'enregistrement en base
        //

        return $this->repository->store($inputs);
    }

    /**
     * Update the model instance
     * @param  Reservation  $reservation
     * @param  array<mixed>  $inputs
     * @return  Reservation
     */
    public function update(Reservation $reservation, array $inputs): Reservation
    {
        //
        // Règles de gestion à appliquer avant l'enregistrement en base
        //

        return $this->repository->update($reservation, $inputs);
    }

    /**
     * Delete the model instance
     * @param  Reservation  $reservation
     * @return bool|null
     */
    public function destroy(Reservation $reservation)
    {
        //
        // Règles de gestion à appliquer avant l'enregistrement en base
        //

        return $this->repository->destroy($reservation);
    }

    /**
     * Undelete the model instance
     * @param  Reservation  $reservation
     * @return void
     */
    public function undelete(Reservation $reservation)
    {
        //
        // Règles de gestion à appliquer avant l'enregistrement en base
        //

        $this->repository->undelete($reservation);
    }

    /**
     * Return a JSON for index datatable
     * @return string|false|void — a JSON encoded string on success or FALSE on failure
     */
    public function json()
    {
        //
        // Règles de gestion à appliquer avant l'enregistrement en base
        //

        return $this->repository->json();
    }
}
