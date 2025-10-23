<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
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

    public function index(Request $request): JsonResponse
    {
        try {
            $filters = [
                'category_id' => $request->query('category_id'),
                'status' => $request->query('status'),
            ];

            $projects = $this->projectService->getAllProjects($filters);
            return response()->json(['success' => true, 'data' => $projects]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function store(StoreProjectRequest $request): JsonResponse
    {
        try {
            $project = $this->projectService->createProject($request->validated());
            return response()->json(['success' => true, 'data' => $project], 201);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function show(int $id): JsonResponse
    {
        try {
            $project = $this->projectService->getProjectById($id);
            return response()->json(['success' => true, 'data' => $project]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Project not found'], 404);
        }
    }

    public function update(UpdateProjectRequest $request, int $id): JsonResponse
    {
        try {
            $project = $this->projectService->updateProject($id, $request->validated());
            return response()->json(['success' => true, 'data' => $project]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            $this->projectService->deleteProject($id);
            return response()->json(['success' => true, 'message' => 'Project deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Upload project images
     */
    public function uploadImage(Request $request, int $projectId): JsonResponse
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120', // 5MB
            'alt_text_vi' => 'nullable|string',
            'alt_text_en' => 'nullable|string',
            'is_primary' => 'nullable|in:true,false,1,0',
            'display_order' => 'nullable|integer',
        ]);

        try {
            $imageData = [
                'alt_text_vi' => $request->alt_text_vi,
                'alt_text_en' => $request->alt_text_en,
                'is_primary' => filter_var($request->is_primary, FILTER_VALIDATE_BOOLEAN),
                'display_order' => $request->display_order ?? 0,
            ];

            $image = $this->projectService->addProjectImage(
                $projectId,
                $request->file('image'),
                $imageData
            );

            return response()->json(['success' => true, 'data' => $image], 201);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Delete project image
     */
    public function deleteImage(int $imageId): JsonResponse
    {
        try {
            $this->projectService->deleteProjectImage($imageId);
            return response()->json(['success' => true, 'message' => 'Image deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
