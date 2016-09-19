<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Operation extends Model
{
    public $primaryKey = 'operation_id';

    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'partner');
    }

    public function date()
    {
        $time = strtotime($this->created_at);
        $formatted = date('l, h:i a', $time);
        $translated = str_replace(
            [
                'Monday',
                'Tuesday',
                'Wednesday',
                'Thursday',
                'Friday',
                'Saturday',
                'Sunday',
            ],
            [
                'Lunes',
                'Martes',
                'Miércoles',
                'Jueves',
                'Viernes',
                'Sábado',
                'Domingo',
            ],
            $formatted);

        return $translated;
    }
}
