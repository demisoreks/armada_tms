<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Balping\HashSlug\HasHashSlug;

class AmdRequest extends Model
{
    use HasHashSlug;
    
    protected $table = "amd_requests";
    
    protected $guarded = [];
    
    public function status() {
        return $this->belongsTo('App\AmdStatus');
    }
    
    public function client() {
        return $this->belongsTo('App\AmdClient');
    }
    
    public function requestStatus() {
        return $this->hasMany('App\AmdRequestStatus');
    }
    
    public function requestOptions() {
        return $this->hasMany('App\AmdRequestOption');
    }
    
    public function requestStops() {
        return $this->hasMany('App\AmdRequestStop');
    }
    
    public function resources() {
        return $this->hasMany('App\AmdResource');
    }
    
    public function situationReports() {
        return $this->hasMany('App\AmdSituationReport');
    }
    
    public function region() {
        return $this->belongsTo('App\AmdRegion');
    }
}
