<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\ProjectService;
use App\Services\CategoryService;

class ProjectController extends Controller
{
    public function __construct(
        protected ProjectService $projectService,
        protected CategoryService $categoryService
    ) {}

    public function index()
    {
        $projects = $this->projectService->getAllActiveProjects();
        $categories = $this->categoryService->getActiveCategories();

        return view('projects.index', compact('projects', 'categories'));
    }

    public function byCategory(string $slug)
    {
        $category = $this->categoryService->getCategoryBySlug($slug);
        $projects = $this->projectService->getProjectsByCategory($category->id);
        $categories = $this->categoryService->getActiveCategories();

        return view('projects.index', compact('projects', 'categories', 'category'));
    }

    public function show(string $slug)
    {
        $project = $this->projectService->getProjectBySlug($slug);
        $relatedProjects = $this->projectService->getProjectsByCategory($project->category_id, 4);

        return view('projects.show', compact('project', 'relatedProjects'));
    }
}
