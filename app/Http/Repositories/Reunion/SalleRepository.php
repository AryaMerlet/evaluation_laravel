<?php

namespace App\Http\Repositories\Reunion;

use App\Models\Reunion\Salle;
use Auth;

class SalleRepository
{
    /**
     * @var Salle
     */
    protected $salle;

    /**
     * Constructor
     *
     * @param  Salle  $salle
     */
    public function __construct(Salle $salle)
    {
        $this->salle = $salle;
    }

    /**
     * Save the model instance
     *
     * @param  Salle  $salle
     *
     * @return Salle
     */
    private function save(Salle $salle, array $inputs): Salle
    {
        $salle->name = $inputs['name'];
        $salle->capacity = $inputs['capacity'];
        $salle->surface = $inputs['surface'];
        $salle->equipments = $inputs['equipments'];
        $salle->save();

        return $salle;
    }

    /**
     * Store a new model instance
     *
     * @param  array<mixed>  $inputs
     *
     * @return Salle
     */
    public function store(array $inputs): Salle
    {
        $salle = new $this->salle;
        $salle->user_id_creation = Auth::id();

        $this->save($salle, $inputs);

        return $salle;
    }

    /**
     * Update the model instance
     *
     * @param  Salle  $salle
     * @param  array<mixed>  $inputs
     *
     * @return Salle
     */
    public function update(Salle $salle, array $inputs): Salle
    {
        $salle->user_id_modification = Auth::id();

        $this->save($salle, $inputs);

        return $salle;
    }

    /**
     * Delete the model instance
     *
     * @param  Salle  $salle
     *
     * @return bool|null
     */
    public function destroy(Salle $salle)
    {
        $salle->user_id_suppression = Auth::id();
        $salle->save();

        return $salle->delete();
    }

    /**
     * Undelete the model instance
     *
     * @param  Salle  $salle
     *
     * @return void
     */
    public function undelete(Salle $salle)
    {
        $salle->restore();
    }

    /**
     * Return a JSON for index datatable
     *
     * @return string|false|void — a JSON encoded string on success or FALSE on failure
     */
    public function json()
    {
        return json_encode(
            Salle::all()
        );
    }
}
