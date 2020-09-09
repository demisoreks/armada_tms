<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Balping\HashSlug\HasHashSlug;

class AmdErsVisit extends Model
{
    use HasHashSlug;

    protected $table = "amd_ers_visits";

    protected $guarded = [];

    public function ersVisitDetails() {
        return $this->hasMany('App\AmdErsVisitDetail');
    }
}
