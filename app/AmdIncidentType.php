<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Balping\HashSlug\HasHashSlug;

class AmdIncidentType extends Model
{
    use HasHashSlug;

    protected $table = "amd_incident_types";

    protected $guarded = [];

    public function incidents() {
        return $this->hasMany('App\AmdIncident');
    }
}
