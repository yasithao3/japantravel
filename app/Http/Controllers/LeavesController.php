<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use Illuminate\Http\Request;
use App\Http\Requests\EmployeeR;
use App\Models\LeaveType;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\LeavesR;

use function PHPUnit\Framework\isNull;

class LeavesController extends Controller
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
        $fetchDataLink = route('fetch-leaves');
        $editLink = '';
        $addNewLink = url('/apply-leaves');
        return view('leaves.list', compact('editLink', 'fetchDataLink', 'addNewLink'));
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
        $dataRowCount = Leave::getData($data, $filters, 'count');
        $dataResult = Leave::getData($data, $filters, 'result', 'leaves.id', 'desc', $data['length'], $data['start'] == 1 ? 0 : $data['start'], $data['search']['value']);
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
        $actionHeading = 'Apply Leave';
        $updateUrl = '';
        $saveUrl = url('/apply-leaves');
        $leaveTypes = LeaveType::all();
        return view('leaves.crud', compact('formMode', 'updateUrl', 'saveUrl', 'actionHeading', 'leaveTypes'));
    }

    /**
     * Store a newly created resource in storage.
     * @return JsonResponse
     */
    public function store(LeavesR $request)
    {
        $postArray = $request->all();
        $userId = auth()->user()->id;
        $availableLeaveCount = Leave::getAvailableLeaveCount($userId);
        if ($availableLeaveCount->init_holiday_count >= $postArray['leave_count']) {
            $userArray = [
                "user_id" => $userId,
                "leave_type" => $postArray['leave_type'],
                "leave_count" => $postArray['leave_count'],
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ];
            $leave = Leave::create($userArray);
            if (auth()->user()->manager_id == null) {
                $leave->update(['status' => 'APPROVED']);
            }
            $notify = array();
            $notify["renderType"] = "message";
            $notify["redirect"] = url('leaves');
            $notify["status"] = "success";
            $notify["message"] = "Leave request saved successfully";
            $response["notify"] = $notify;
        } else {
            $notify = array();
            $notify["renderType"] = "message";
            $notify["redirect"] = '';
            $notify["status"] = "error";
            $notify["message"] = "Available leave count not enough!";
            $response["notify"] = $notify;
        }
        return response()->json($response);
    }
    /**
     * Store a newly created resource in storage.
     * @return JsonResponse
     */
    public function reveiewLeaveRequests(Request $request)
    {
        $postArray = $request->all();
        // dd($postArray);
        $leave = Leave::find($postArray['action_id']);
        $userId = $leave->user_id;
        $availableLeaveCount = Leave::getAvailableLeaveCount($userId);
        if ($availableLeaveCount->init_holiday_count >= $leave->leave_count) {
            $updateArray = [
                "status" => $postArray['approval_status'],
                "updated_at" => date('Y-m-d H:i:s'),
            ];
            $leave->update($updateArray);
            $notify = array();
            $notify["renderType"] = "message";
            $notify["redirect"] = url('leaves');
            $notify["status"] = "success";
            $notify["message"] = "Leave request reviwed successfully";
            $response["notify"] = $notify;
        } else {
            $notify = array();
            $notify["renderType"] = "message";
            $notify["redirect"] = '';
            $notify["status"] = "error";
            $notify["message"] = "Available leave count not enough!";
            $response["notify"] = $notify;
        }
        return response()->json($response);
    }
}
