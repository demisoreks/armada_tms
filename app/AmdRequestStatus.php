<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Balping\HashSlug\HasHashSlug;

class AmdRequestStatus extends Model
{
    use HasHashSlug;
    
    protected $table = "amd_request_status";
    
    protected $guarded = [];
    
    public function status() {
        return $this->belongsTo('App\AmdStatus');
    }
    
    public function request() {
        return $this->belongsTo('App\AmdRequest');
    }
}
