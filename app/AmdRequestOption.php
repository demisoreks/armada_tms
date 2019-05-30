<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Balping\HashSlug\HasHashSlug;

class AmdRequestOption extends Model
{
    use HasHashSlug;
    
    protected $table = "amd_request_options";
    
    protected $guarded = [];
    
    public function request() {
        return $this->belongsTo('App\AmdRequest');
    }
    
    public function option() {
        return $this->belongsTo('App\AmdOption');
    }
}
