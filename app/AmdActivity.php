<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Balping\HashSlug\HasHashSlug;

class AmdActivity extends Model
{
    use HasHashSlug;
    
    protected $table = "amd_activities";
    
    protected $guarded = [];
    
    public function employee() {
        return $this->belongsTo('App\AccEmployee');
    }
}
