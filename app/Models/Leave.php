<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Support\Facades\Auth;

use function PHPUnit\Framework\isNull;

class Leave extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'leave_type',
        'leave_count',
        'status'
    ];

    public static function getData($postArray, $filters = [], $type = 'result', $orderColumn = '', $orderDirection = 'desc', $perPage = 10, $offset = 0, $searchedFor = '')
    {
        DB::connection()->enableQueryLog();
        $query = Leave::query();
        if (!empty($filters)) {
            foreach ($filters as $key => $val) {
                if ($key != 'name') {
                    if ($val != 'all') {
                        $query->Where($key, '=', $val);
                    }
                }
            }
        }
        $user = Auth::user();
        if (!$user->hasRole('manager')) {
            $query->where('user_id', $user->id);
            if ($type == 'result') {
                $query->select(
                    'leaves.id AS DT_RowId',
                    'leave_types.name AS leave_type',
                    'leave_count',
                    'status'
                )
                    ->skip($offset * $perPage)
                    ->take($perPage)
                    ->orderBy($orderColumn, $orderDirection);
            }
        } else {
            $query->join('users', 'leaves.user_id', 'users.id');
            if ($type == 'result') {
                $query->select(
                    'leaves.id AS DT_RowId',
                    'leave_types.name AS leave_type',
                    'leave_count',
                    'users.name AS employee_name',
                    'status'
                )
                    ->skip($offset * $perPage)
                    ->take($perPage)
                    ->orderBy($orderColumn, $orderDirection);
            }
        }
        $query->join('leave_types', 'leaves.leave_type', 'leave_types.id');
        if ($searchedFor != '') {
            $searchString = '%' . $searchedFor . '%';
            $query->orWhere('name', 'like', $searchString);
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

    public static function getAvailableLeaveCount($userId)
    {
        $result = user::query()->where(['id' => $userId])->select('init_holiday_count')->first();
        return $result;
    }
}
