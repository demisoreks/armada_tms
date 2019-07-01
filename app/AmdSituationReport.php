<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Balping\HashSlug\HasHashSlug;

class AmdSituationReport extends Model
{
    use HasHashSlug;
    
    protected $table = "amd_situation_reports";
    
    protected $guarded = [];
    
    public function situation() {
        return $this->belongsTo('App\AmdSituation');
    }
    
    public function request() {
        return $this->belongsTo('App\AmdRequest');
    }
    
    public function user() {
        return $this->belongsTo('App\AmdUser');
    }
}
