<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends User
{
    use HasFactory;
    protected $table = "users";

    public function newQuery(): Builder
    {
        return parent::newQuery()->whereNotNull("users.manager_id");
    }

    public static function getData($postArray, $filters = [], $type = 'result', $orderColumn = '', $orderDirection = 'desc', $perPage = 10, $offset = 0, $searchedFor = '')
    {
        DB::connection()->enableQueryLog();
        $query = Employee::query();
        $query->leftJoin('users AS manager', 'users.manager_id', 'manager.id');
        if (!empty($filters)) {
            foreach ($filters as $key => $val) {
                if ($key != 'name') {
                    if ($val != 'all') {
                        $query->Where($key, '=', $val);
                    }
                }
            }
        }
        if ($searchedFor != '') {
            $searchString = '%' . $searchedFor . '%';
            $query->orWhere('name', 'like', $searchString);
        }
        if ($type == 'result') {
            $query->select(
                'users.id AS DT_RowId',
                'users.name AS employee_name',
                'users.email',
                'manager.name AS manager_name'
            )
                ->skip($offset * $perPage)
                ->take($perPage)
                ->orderBy($orderColumn, $orderDirection);
        }
        if ($type == 'count') {
            $result = $query->count();
            return $result;
        }
        $result = $query->get()->toArray();
        if ($type == 'result') {
            return $result;
        }
    }
}
