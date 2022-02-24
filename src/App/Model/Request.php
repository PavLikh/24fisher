<?php

declare(strict_types=1);

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Request extends Model {

    protected $table = 'request';

    public $timestamps = false;
}
