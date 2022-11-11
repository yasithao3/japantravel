<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Manager extends User
{
    use HasFactory;
    protected $table = "users";

    public function newQuery(): Builder
    {

        return parent::newQuery()->where("manager_id", null);
    }
}
