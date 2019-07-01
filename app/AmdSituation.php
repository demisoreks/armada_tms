<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Balping\HashSlug\HasHashSlug;

class AmdSituation extends Model
{
    use HasHashSlug;
    
    protected $table = "amd_situations";
    
    protected $guarded = [];
    
    public function situationReports() {
        return $this->hasMany('App\AmdSituationReport');
    }
}
