<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Balping\HashSlug\HasHashSlug;

class AmdVehicle extends Model
{
    use HasHashSlug;
    
    protected $table = "amd_vehicles";
    
    protected $guarded = [];
    
    public function region() {
        return $this->belongsTo('App\AmdRegion');
    }
    
    public function vehicleType() {
        return $this->belongsTo('App\AmdVehicleType');
    }
    
    public function vendor() {
        return $this->belongsTo('App\AmdVendor');
    }
}
