<?php

namespace App\Http\Controllers;

use App\Http\Resources\LectureQAReplyResource;
use App\Http\Resources\LectureQAResource;
use App\Models\LectureQA;
use App\Models\LectureQAReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LectureQAReplyController extends Controller
{
    public function index(Request $request,LectureQA $lectureQa)
    {
        return new LectureQAResource($lectureQa->load(['student','management','replies' => function($q) use($request) {
            $q->with('admin', 'student')->skip($request->take ?? 0)->take($request->perpage ?? 0);
        }]));
    }

    public function store(Request $request, LectureQA $lectureQa)
    {
        $data = $request->validate([
            'reply' => 'required|string'
        ]);

        $user = Auth::user();
        if(Auth::guard('admin')->check()){
            $data['user_type'] = 1;
        }else{
            $data['user_type'] = 2;
        }
        $data['user_id'] = $user->id;

        return new LectureQAReplyResource($lectureQa->replies()->create($data)->load('admin', 'student'));
    }

    public function show(LectureQA $lectureQa, LectureQAReply $reply)
    {
        return new LectureQAReplyResource($reply->load('admin', 'student'));
    }

    public function likeOrDislike(Request $request, LectureQA $qas, LectureQAReply $reply)
    {
        $student = Auth::guard('student')->user();
        $liked_users = $reply->liked_users;

        if (in_array($student->id , $liked_users)) {
            $liked_users = array_diff( $liked_users, [$student->id]);

            $reply->update([
                'like'=> $reply->like - 1,
                'liked_users'=> $liked_users,
            ]);

        }else{
            $liked_users[] = $student->id;

            $reply->update([
                'like'=> $reply->like + 1,
                'liked_users'=> $liked_users,
            ]);
        }

        return new LectureQAReplyResource($reply);
    }
}
