<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\SemesterResource;
use App\Http\Resources\SettingResource;
use App\Models\Semester;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        return SettingResource::collection(executeQuery(Setting::query()->with('semester')));
    }


    public function update(Request $request, Setting $setting)
    {
        $request->validate([
            'credit_rate' => 'required|numeric',
            'current_semester_id' => 'required|integer',
            'university_name' => 'required|string',
            'home_video' => 'nullable',
            'university_address' => 'nullable|string',
            'phone_number' => 'nullable|string',
            'audio_image' => 'nullable',
        ]);

        if($request->hasFile('home_video')) {
            if(Storage::exists($setting->home_video))
                Storage::delete($setting->home_video);

            $setting->home_video = $request->file('home_video')->store('home_video');
        }

        if($request->hasFile('audio_image')) {
            if(Storage::exists($setting->audio_image))
                Storage::delete($setting->audio_image);

            $setting->audio_image = $request->file('audio_image')->store('audio_image');
        }

        $setting->credit_rate = $request->credit_rate;
        $setting->university_name = $request->university_name;
        $setting->current_semester_id = $request->current_semester_id;
        $setting->university_address = $request->university_address;
        $setting->phone_number = $request->phone_number;
        $setting->save();

        return new SettingResource($setting);
    }

    public function currentSemester()
    {
        $setting = Setting::first();
        $semester = Semester::where('id', $setting->current_semester_id)->first();

        return new SemesterResource($semester);
    }
}
