<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Balping\HashSlug\HasHashSlug;

class AmdIncident extends Model
{
    use HasHashSlug;

    protected $table = "amd_incidents";

    protected $guarded = [];

    public function incidentType() {
        return $this->belongsTo('App\AmdIncidentType');
    }

    public function request() {
        return $this->belongsTo('App\AmdRequest');
    }
}
