<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Balping\HashSlug\HasHashSlug;

class AmdUser extends Model
{
    use HasHashSlug;
    
    protected $table = "amd_users";
    
    protected $guarded = [];
    
    public function employee() {
        return $this->hasOne('App\AccEmployee');
    }
    
    public function region() {
        return $this->belongsTo('App\AmdRegion');
    }
}
