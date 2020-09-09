<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Balping\HashSlug\HasHashSlug;

class AmdClient extends Model
{
    use HasHashSlug;

    protected $table = "amd_clients";

    protected $guarded = [];

    public function requests() {
        return $this->hasMany('App\AmdRequest');
    }

    public function ersLocations() {
        return $this->hasMany('App\AmdErsLocation');
    }
}
