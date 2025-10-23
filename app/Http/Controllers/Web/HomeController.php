<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\ProjectService;
use App\Services\CategoryService;
use App\Services\SettingService;
use App\Services\SliderService;

class HomeController extends Controller
{
    public function __construct(
        protected ProjectService $projectService,
        protected CategoryService $categoryService,
        protected SettingService $settingService,
        protected SliderService $sliderService
    ) {}

    public function index()
    {
        $sliders = $this->sliderService->getActiveSliders();
        $featuredProjects = $this->projectService->getFeaturedProjects(6);
        $categories = $this->categoryService->getActiveCategories();
        $settings = $this->settingService->getSettingsByGroup('home');

        return view('home', compact('sliders', 'featuredProjects', 'categories', 'settings'));
    }
}
