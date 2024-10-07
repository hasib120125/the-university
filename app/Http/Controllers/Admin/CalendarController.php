<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\CalendarResource;
use App\Models\Calendar;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function index()
    {
        return CalendarResource::collection(executeQuery(Calendar::query()));
    }

    public function show(Calendar $calendar)
    {
        return new CalendarResource($calendar);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'type' => 'required|string',
            'description' => 'required|string'
        ]);

        $data['date'] = $request->date;
        $calendar = Calendar::create($data);

        return new CalendarResource($calendar);
    }

    public function update(Request $request, Calendar $calendar)
    {
        $request->validate([
            'title' => 'required|string',
            'type' => 'required|string',
            'description' => 'required|string'
        ]);

        $calendar->title = $request->title;
        $calendar->type = $request->type;
        $calendar->date = $request->date;
        $calendar->description = $request->description;
        $calendar->save();

        return new CalendarResource($calendar);
    }

    public function destroy(Calendar $calendar)
    {
        $calendar->delete();

        return response()->json(['success' => true, 'message' => 'Successfully deleted.']);
    }
}
