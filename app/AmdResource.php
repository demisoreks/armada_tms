<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Balping\HashSlug\HasHashSlug;

class AmdResource extends Model
{
    use HasHashSlug;
    
    protected $table = "amd_resources";
    
    protected $guarded = [];
    
    public function request() {
        return $this->belongsTo('App\AmdRequest');
    }
}
