<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Balping\HashSlug\HasHashSlug;

class AmdOption extends Model
{
    use HasHashSlug;
    
    protected $table = "amd_options";
    
    protected $guarded = [];
    
    public function service() {
        return $this->belongsTo('App\AmdService');
    }
    
    public function requestOptions() {
        return $this->hasMany('App\AmdRequestOption');
    }
    
    public function requirements() {
        return $this->hasMany('App\AmdRequirement');
    }
}
