<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReservacionTelemonitoreo extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */

    public function reservacion() {
        return $this->belongsTo(Reservacion::class, 'id_reservacion', 'id');
    }
    protected $table = 'reservaciones_telemonitoreo';
}