<?php

namespace App\Http\Controllers\Admin;

use App\Models\Popup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PopUpResource;

class PopUpController extends Controller
{
    public function index()
    {
        $popup = Popup::all();

        return PopUpResource::collection($popup);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'top' => 'required|integer',
            'left' => 'required|integer',
            'content' => 'required',
        ]);

        $popup = new Popup();
        $popup->title = $request->title;
        $popup->top = $request->top;
        $popup->left = $request->left;
        $popup->content = $request->input('content');
        $popup->save();

        return new PopUpResource($popup);
    }

    public function show(Popup $popup)
    {
        return new PopUpResource($popup);
    }

    public function update(Request $request, Popup $popup)
    {
        $request->validate([
            'title' => 'required|string',
            'top' => 'required|integer',
            'left' => 'required|integer',
            'content' => 'required',
        ]);

        $popup->title = $request->title;
        $popup->top = $request->top;
        $popup->left = $request->left;
        $popup->content = $request->input('content');
        $popup->save();

        return new PopUpResource($popup);
    }

    public function destroy(Popup $popup)
    {
        $popup->delete();

        return response()->json(['success' => true, 'message' => 'Successfully deleted.']);
    }
}
