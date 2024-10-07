<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\RegistrationOpenResource;
use App\Models\RegistrationOpen;
use Illuminate\Http\Request;

class RegistrationOpenController extends Controller
{
    public function index()
    {
        return RegistrationOpenResource::collection(executeQuery(RegistrationOpen::query()->with('semester')));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'semester_id' => 'required|integer',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        $registrationOpen = RegistrationOpen::create($data);

        return new RegistrationOpenResource($registrationOpen);
    }

    public function show(RegistrationOpen $registrationOpen)
    {
        return new RegistrationOpenResource($registrationOpen);
    }

    public function update(Request $request, RegistrationOpen $registrationOpen)
    {
        $request->validate([
            'semester_id' => 'required|integer',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        $registrationOpen->semester_id = $request->semester_id;
        $registrationOpen->start_date = $request->start_date;
        $registrationOpen->end_date = $request->end_date;
        $registrationOpen->save();

        return new RegistrationOpenResource($registrationOpen);
    }

    public function destroy(RegistrationOpen $registrationOpen)
    {
        $registrationOpen->delete();

        return response()->json(['success' => true, 'message' => 'Successfully deleted.']);
    }
}
