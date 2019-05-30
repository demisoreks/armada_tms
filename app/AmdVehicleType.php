<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Balping\HashSlug\HasHashSlug;

class AmdVehicleType extends Model
{
    use HasHashSlug;
    
    protected $table = "amd_vehicle_types";
    
    protected $guarded = [];
    
    public function vehicles() {
        return $this->hasMany('App\AmdVehicle');
    }
}
