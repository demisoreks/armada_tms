<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Balping\HashSlug\HasHashSlug;

class AmdRequestStop extends Model
{
    use HasHashSlug;
    
    protected $table = "amd_request_stops";
    
    protected $guarded = [];
    
    public function request() {
        return $this->belongsTo('App\AmdRequest');
    }
}
