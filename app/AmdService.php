<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Balping\HashSlug\HasHashSlug;

class AmdService extends Model
{
    use HasHashSlug;
    
    protected $table = "amd_services";
    
    protected $guarded = [];
    
    public function option() {
        return $this->hasMany('App\AmdService');
    }
}
