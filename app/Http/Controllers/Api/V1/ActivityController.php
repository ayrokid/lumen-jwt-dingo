<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ActivityController extends Controller
{
    public function __construct()
    {
        //
    }

    public function main()
    {
        $response = [];
        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'user not found'], 500);
        }
        $response['level'] = $user->level;

        // cek jadwal mengaji hari ini
        $schedule = DB::table('schedules')->where('user_id', $user->id);

        $reminder = $schedule->where('to_date', date('Y-m-d'))->get();
        if ($schedule) {
            $response['reminder_status'] = true;
        } else {
            $response['reminder_status'] = false;
        }
        $response['mengaji'] = [
            'total' => $schedule->count(),
        ];

        // cek jadwal mengajar hari ini
        $response['mengajar'] = [
            'total' => 0,
        ];

        $request_in = $schedule->where('status', 'new')->get();
        if ($request_in->count() > 0) {
            $response['request_out_status'] = true;
        } else {
            $response['request_out_status'] = false;
        }

        $request_out = $schedule->where('status', 'pending')->get();
        if ($request_out->count() > 0) {
            $response['request_in_status'] = true;
        } else {
            $response['request_in_status'] = false;
        }

        return response()->json($response);
    }
}
