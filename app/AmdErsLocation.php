<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Balping\HashSlug\HasHashSlug;

class AmdErsLocation extends Model
{
    use HasHashSlug;

    protected $table = "amd_ers_locations";

    protected $guarded = [];

    public function client() {
        return $this->belongsTo('App\AmdClient');
    }
}
