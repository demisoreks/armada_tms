<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Balping\HashSlug\HasHashSlug;

class AmdState extends Model
{
    use HasHashSlug;
    
    protected $table = "amd_states";
    
    protected $guarded = [];
    
    public function region() {
        return $this->belongsTo('App\AmdRegion');
    }
}
