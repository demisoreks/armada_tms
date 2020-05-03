<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Balping\HashSlug\HasHashSlug;

class AmdErsClient extends Model
{
    use HasHashSlug;
    
    protected $table = "amd_ers_clients";
    
    protected $guarded = [];
}
