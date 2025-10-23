<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\ProjectService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    protected $projectService;

    public function __construct(ProjectService $projectService)
    {
        $this->projectService = $projectService;
    }

    /**
     * Get all active projects (Public)
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $filters = [
                'category_id' => $request->query('category_id'),
                'status' => $request->query('status'),
            ];

            $projects = $this->projectService->getActiveProjects($filters);

            return response()->json([
                'success' => true,
                'data' => $projects,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch projects',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get featured projects (Public)
     */
    public function featured(): JsonResponse
    {
        try {
            $projects = $this->projectService->getFeaturedProjects(6);

            return response()->json([
                'success' => true,
                'data' => $projects,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch featured projects',
            ], 500);
        }
    }

    /**
     * Get project by slug (Public)
     */
    public function show(string $slug): JsonResponse
    {
        try {
            $project = $this->projectService->getProjectBySlug($slug);

            return response()->json([
                'success' => true,
                'data' => $project,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Project not found',
            ], 404);
        }
    }

    /**
     * Get projects by category (Public)
     */
    public function byCategory(int $categoryId): JsonResponse
    {
        try {
            $projects = $this->projectService->getProjectsByCategory($categoryId);

            return response()->json([
                'success' => true,
                'data' => $projects,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch projects',
            ], 500);
        }
    }
}
