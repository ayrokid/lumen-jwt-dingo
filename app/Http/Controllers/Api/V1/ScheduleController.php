<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ScheduleResource;
use App\Models\User;
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
}
