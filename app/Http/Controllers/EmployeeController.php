<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Manager;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Requests\EmployeeR;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

class EmployeeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $fetchDataLink = route('fetch-employees');
        $editLink = url('/edit-employee');
        $addNewLink = url('/create-employee');
        return view('employee.list', compact('editLink', 'fetchDataLink', 'addNewLink'));
    }

    public function fetchList(Request $request)
    {
        $data = $request->all();
        $filters = [];
        if (!empty($data['columns'])) {
            for ($i = 0; $i < count($data['columns']); $i++) {
                if ($data['columns'][$i]['search']['value'] != '') {
                    $filters[$data['columns'][$i]['name']] = $data['columns'][$i]['search']['value'];
                }
            }
        }
        $dataRowCount = Employee::getData($data, $filters, 'count');
        $dataResult = Employee::getData($data, $filters, 'result', 'users.id', 'desc', $data['length'], $data['start'] == 1 ? 0 : $data['start'], $data['search']['value']);
        // dd($dataResult);
        $dTblArray = array(
            "draw" => $request->input('draw') + 1,
            "recordsTotal" => $dataRowCount,
            "recordsFiltered" => $dataRowCount,
            'data' => (array)$dataResult,
        );
        return response()->json($dTblArray);
    }

    public function create(Request $request)
    {
        $formMode = 'create';
        $actionHeading = 'Create Employee';
        $updateUrl = url('/edit-employee');
        $saveUrl = url('/create-employee');
        $managers = Manager::all();
        return view('employee.crud', compact('formMode', 'updateUrl', 'saveUrl', 'actionHeading', 'managers'));
    }


    /**
     * Store a newly created resource in storage.
     * @return JsonResponse
     */
    public function store(EmployeeR $request)
    {
        $postArray = $request->all();
        $userArray = [
            "name" => $postArray['name'],
            "email" => $postArray['email'],
            "password" => Hash::make('password'), // password,
            "manager_id" => $postArray['manager_id'],
            "init_holiday_count" => $postArray['init_holiday_count'],
            "created_at" => date('Y-m-d H:i:s'),
            "updated_at" => date('Y-m-d H:i:s'),
        ];
        $user = User::create($userArray);
        $user->assignRole('employee');
        $notify = array();
        $notify["renderType"] = "message";
        $notify["redirect"] = url('employees');
        $notify["status"] = "success";
        $notify["message"] = "Created successfully";
        $response["notify"] = $notify;
        return response()->json($response);
    }
}
