<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Balping\HashSlug\HasHashSlug;

class AmdStatus extends Model
{
    use HasHashSlug;
    
    protected $table = "amd_status";
    
    protected $guarded = [];
    
    public function requests() {
        return $this->hasMany('App\AmdRequest');
    }
    
    public function requestStatus() {
        return $this->hasMany('App\AmdRequestStatus');
    }
}
