<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Resources\FeatureResource;
use App\Http\Resources\FooterTopResource;
use App\Http\Resources\GalleryResource;
use App\Http\Resources\NewsResource;
use App\Http\Resources\OfflineSeminarResource;
use App\Http\Resources\PopUpResource;
use App\Http\Resources\SampleLectureResource;
use App\Http\Resources\SettingResource;
use App\Http\Resources\SliderResource;
use App\Http\Resources\SocialResource;
use App\Http\Resources\StaticPageResource;
use App\Models\Department;
use App\Models\Feature;
use App\Models\FooterTop;
use App\Models\Gallery;
use App\Models\News;
use App\Models\OfflineSeminar;
use App\Models\Popup;
use App\Models\RegistrationOpen;
use App\Models\SampleLecture;
use App\Models\Setting;
use App\Models\Slider;
use App\Models\Social;
use App\Models\StaticPage;
use App\Models\Student;
use App\Models\Subject;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function sliders()
    {
        $slidrs = Slider::all();

        return SliderResource::collection($slidrs);
    }

    public function getFeatures()
    {
        $features = Feature::where('status', 1)->get();

        return FeatureResource::collection($features);
    }

    public function getNews()
    {
        $news = News::latest()->take(4);

        return NewsResource::collection($news);
    }

    public function socialsLinks()
    {
        $socials = Social::where('status', 1)->get();

        return SocialResource::collection($socials);
    }

    public function staticPage(StaticPage $page)
    {
        return new StaticPageResource($page);
    }

    public function settings()
    {
        $setting = Setting::first();

        return new SettingResource($setting);
    }

    public function statistics()
    {
        return [
            'total_student' => number_format(Student::where('active', 1)->count()),
            'total_subjects' => number_format(Subject::count()),
            'total_departments' => number_format(Department::count()),
            'registration_open' => RegistrationOpen::whereDate('start_date', '<=' , Carbon::now())
                                            ->whereDate('end_date', '>=' , Carbon::now())->first()
        ];
    }

    public function recentGalleries()
    {
        $galleries = Gallery::with('images')->whereHas('images')->latest()->take(3)->get();

        return GalleryResource::collection($galleries);
    }

    public function popups()
    {
        $popups = Popup::get();

        return PopUpResource::collection($popups);
    }

    public function sampleLecture()
    {
        return SampleLectureResource::collection(executeQuery(SampleLecture::query()->latest()));
    }

    public function offlineSeminars()
    {
        return OfflineSeminarResource::collection(executeQuery(OfflineSeminar::query()->latest()));
    }

    public function footerTop()
    {
        return FooterTopResource::collection(executeQuery(FooterTop::query()));
    }
}
