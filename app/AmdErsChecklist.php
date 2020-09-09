<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Balping\HashSlug\HasHashSlug;

class AmdErsChecklist extends Model
{
    use HasHashSlug;

    protected $table = "amd_ers_checklist";

    protected $guarded = [];
}
