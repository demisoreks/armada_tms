<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Balping\HashSlug\HasHashSlug;

class AmdErsVisitDetail extends Model
{
    use HasHashSlug;

    protected $table = "amd_ers_visit_details";

    protected $guarded = [];

    public function ersVisit() {
        return $this->belongsTo('App\AmdErsVisit');
    }
}
