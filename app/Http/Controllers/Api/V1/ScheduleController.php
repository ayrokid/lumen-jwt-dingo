<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ScheduleResource;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ScheduleController extends Controller
{
    public function index()
    {
        /*
        $mentor = DB::select("SELECT
        users.id, first_name, last_name, photo,
        COUNT(CASE WHEN is_like = 'Y' THEN 1 ELSE 0 END) as islike,
        COUNT(CASE WHEN is_like = 'N' THEN 1 ELSE 0 END) as unlike
        FROM users
        LEFT JOIN review_mentor ON user_id_mentor=users.id AND mentor = 'Y'
        GROUP BY users.id ");

        return response()->json([
        'data' => $mentor,
        ]);
         */
        $mentor = User::leftJoin('review_mentor', 'user_id_mentor', '=', 'users.id')
            ->where('mentor', 'Y')
            ->groupBy('users.id')
            ->select('users.id', 'users.first_name', 'users.last_name', 'users.photo',
                DB::raw("SUM(CASE WHEN is_like = 'Y' THEN 1 ELSE 0 END) as islike "),
                DB::raw("SUM(CASE WHEN is_like = 'N' THEN 1 ELSE 0 END) as unlike ")
            )
            ->get();
        return ScheduleResource::collection($mentor);
    }

    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'location' => 'required',
            'date' => 'date_format:"Y-m-d"|required',
            'hour_from' => 'date_format:"H:i"|required',
            'hour_to' => 'date_format:"H:i"|required',
            'notes' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->errorBadRequest($validator);
        }

        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'user not found'], 500);
        }

        $attributes = [
            'user_id' => $user->id,
            'location' => $request->get('location'),
            'to_date' => $request->get('date'),
            'hour_from' => $request->get('hour_from'),
            'hour_to' => $request->get('hour_to'),
            'notes' => $request->get('notes'),
            'status' => 'new',
        ];
        $schedule = Schedule::create($attributes);

        if ($schedule) {
            return response()->json([
                'status' => true,
                'message' => 'Schedule berhasil dibuat',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'aktu/Lokasi not required',
            ]);
        }
    }
}
