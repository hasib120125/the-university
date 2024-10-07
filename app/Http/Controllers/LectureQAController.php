<?php

namespace App\Http\Controllers;

use App\Http\Resources\LectureQAResource;
use App\Models\Lecture;
use App\Models\LectureQA;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LectureQAController extends Controller
{
    public function index(Request $request)
    {
        $query = LectureQA::where('lecture_id', $request->lecture_id);

        if ($request->lecture && $request->lecture !== '')
            $query->where('lecture_management_id', $request->lecture);

        if ($request->sort && $request->sort !== '') {
            if ($request->sort == '1')
                $query->orderBy('created_at', 'desc');
            elseif ($request->sort == '2')
                $query->orderBy('created_at');
        }

        if ($request->questionTitle && $request->questionTitle !== '') 
            $query->where('title', 'LIKE', '%' . $request->questionTitle . '%');

        return LectureQAResource::collection($query->with('student','management')->paginate($request->perpage ?? 0));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'lecture_id' => 'required|integer|exists:lectures,id',
            'lecture_management_id' => 'required|integer|exists:lecture_management,id',
            'type' => 'required|integer',
            'title' => 'required|string',
            'details' => 'nullable|string'
        ]);

        $student = Auth::guard('student')->user();
        $data['student_id'] = $student->id;

        return new LectureQAResource(LectureQA::create($data)->load('student','management'));
    }

    public function show(LectureQA $qas)
    {
        return new LectureQAResource($qas);
    }

    public function likeOrDislike(Request $request, LectureQA $qas)
    {
        $student = Auth::guard('student')->user();

        $liked_users = $qas->liked_users;
        
        if (in_array($student->id , $liked_users)) {
            $liked_users = array_diff( $liked_users, [$student->id]);

            $qas->update([
                'like'=> $qas->like - 1,
                'liked_users'=> $liked_users,
            ]);

        }else{
            $liked_users[] = $student->id;

            $qas->update([
                'like'=> $qas->like + 1,
                'liked_users'=> $liked_users,
            ]);
        }
        
        return new LectureQAResource($qas);
    }

}
