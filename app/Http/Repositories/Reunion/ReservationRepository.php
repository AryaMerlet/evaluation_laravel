<?php
namespace App\Http\Repositories\Reunion;

use App\Models\Reunion\Reservation;
use Illuminate\Support\Facades\Auth;

class ReservationRepository
{
    /**
     * @var Reservation
     */
    protected $reservation;

    /**
     * Constructor
     *
     * @param  Reservation  $reservation
     */
    public function __construct(Reservation $reservation)
    {
        $this->reservation = $reservation;
    }

    /**
     * Store a new model instance
     *
     * @param  array<string, mixed>  $inputs
     *
     * @return Reservation
     */
    public function store(array $inputs): Reservation
    {
        $reservation = new $this->reservation();
        /** @var int|null $userId */
        $userId = Auth::id();
        $reservation->user_id_creation = $userId;
        $this->save($reservation, $inputs);
        return $reservation;
    }

    /**
     * Update the model instance
     *
     * @param  Reservation  $reservation
     * @param  array<string, mixed>  $inputs
     *
     * @return Reservation
     */
    public function update(Reservation $reservation, array $inputs): Reservation
    {
        /** @var int|null $userId */
        $userId = Auth::id();
        $reservation->user_id_modification = $userId;
        $this->save($reservation, $inputs);
        return $reservation;
    }

    /**
     * Delete the model instance
     *
     * @param  Reservation  $reservation
     *
     * @return bool|null
     */
    public function destroy(Reservation $reservation)
    {
        /** @var int|null $userId */
        $userId = Auth::id();
        $reservation->user_id_suppression = $userId;
        $reservation->save();
        return $reservation->delete();
    }

    /**
     * Undelete the model instance
     *
     * @param  Reservation  $reservation
     *
     * @return void
     */
    public function undelete(Reservation $reservation)
    {
        $reservation->restore();
    }

    /**
     * Return a JSON for index datatable
     *
     * @return string|false — a JSON encoded string on success or FALSE on failure
     */
    public function json()
    {
        return json_encode(
            Reservation::all()
        );
    }

    /**
     * Save the model instance
     *
     * @param  Reservation  $reservation
     * @param  array<string, mixed>  $inputs
     *
     * @return Reservation
     */
    private function save(Reservation $reservation, array $inputs): Reservation
    {
        $reservation->heure_debut = $inputs['heure_debut'];
        $reservation->heure_fin = $inputs['heure_fin'];
        $reservation->salle_id = $inputs['salle_id'];

        /** @var int|null $userId */
        $userId = Auth::id();
        $reservation->user_id = $userId;

        $reservation->date = $inputs['date'];
        $reservation->motif = $inputs['motif'];
        $reservation->save();
        return $reservation;
    }
}
