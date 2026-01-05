<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisAgenda extends Model
{
    protected $guarded = [];

    public function agendas()
    {
        return $this->hasMany(AgendaKegiatan::class, 'jenis_agenda_id');
    }
}