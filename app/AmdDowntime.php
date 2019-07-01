<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Balping\HashSlug\HasHashSlug;

class AmdDowntime extends Model
{
    use HasHashSlug;
    
    protected $table = "amd_downtimes";
    
    protected $guarded = [];
}
