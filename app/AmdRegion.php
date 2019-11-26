<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Balping\HashSlug\HasHashSlug;

class AmdRegion extends Model
{
    use HasHashSlug;
    
    protected $table = "amd_regions";
    
    protected $guarded = [];
    
    public function users() {
        return $this->hasMany('App\AmdUser');
    }
    
    public function vehicles() {
        return $this->hasMany('App\AmdVehicle');
    }
    
    public function states() {
        return $this->hasMany('App\AmdState');
    }
    
    public function requests() {
        return $this->hasMany('App\AmdRequest');
    }
}
