<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Balping\HashSlug\HasHashSlug;

class AmdVendor extends Model
{
    use HasHashSlug;
    
    protected $table = "amd_vendors";
    
    protected $guarded = [];
    
    public function vehicles() {
        return $this->hasMany('App\AmdVehicle');
    }
}
