<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Slider;

class HomeController extends Controller
{
    public function index()
    {
        $sliders = Slider::where('status', 1)->orderBy('serial', 'asc')->get();
        $categories = Category::where('status', 1)->with(['subCategories' => function ($query) {
            $query->where('status', 1)->with(['childCategories' => function ($query) {
                $query->where('status', 1);
            }]);
        }])->get();
        return view('frontend.home.home', compact('sliders', 'categories'));
    }
}
