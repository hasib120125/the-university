<?php

namespace App\Http\Controllers\Front;

use App\Models\SubMenu;
use App\Rules\Recaptcha;
use App\Models\Faq;
use App\Models\Menu;
use App\Models\Page;
use App\Mail\ContactUsMail;
use Illuminate\Http\Request;
use App\Http\Resources\FaqResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\MenuResource;
use App\Http\Resources\PageResource;
use Illuminate\Support\Facades\Mail;

class PageController extends Controller
{
    public function faqPage()
    {
        $faqs = Faq::where('status', 1)->get();

        return FaqResource::collection($faqs);
    }

    public function parentMenu($slug)
    {
        $menu = Menu::where('slug', $slug)->first();

        return new MenuResource($menu);
    }

    public function getCustomPageContent(Request $request, $menuId)
    {
        $pages = Page::where('menu_id', $menuId)->get();

        return PageResource::collection($pages);
    }

    public function show(Menu $menu, SubMenu $subMenu)
    {
        $page = Page::where('menu_id', $menu->id)->where('sub_id', $subMenu->id)->first();

        return new PageResource($page);
    }

    public function contactUsMail(Request $request, Recaptcha $recaptcha){

        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required',
            'recaptcha' => ['required', $recaptcha],
        ]);

        $messageData = [
            'name' => $request->name,
            'email' => $request->email,
            'body' => $request->message
        ];

        Mail::to(config('mail.to.admin'))->send(new ContactUsMail($messageData));
    }
}
