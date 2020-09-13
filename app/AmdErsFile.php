<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Balping\HashSlug\HasHashSlug;

class AmdErsFile extends Model
{
    use HasHashSlug;

    protected $table = "amd_ers_files";

    protected $guarded = [];
}
