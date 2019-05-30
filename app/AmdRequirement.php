<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Balping\HashSlug\HasHashSlug;

class AmdRequirement extends Model
{
    use HasHashSlug;
    
    protected $table = "amd_requirements";
    
    protected $guarded = [];
    
    public function option() {
        return $this->belongsTo('App\AmdOption');
    }
}
