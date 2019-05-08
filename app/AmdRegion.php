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
}
