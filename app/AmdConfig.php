<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Balping\HashSlug\HasHashSlug;

class AmdConfig extends Model
{
    use HasHashSlug;
    
    protected $table = "amd_config";
    
    protected $guarded = [];
}
