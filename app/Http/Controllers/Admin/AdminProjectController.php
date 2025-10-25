<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectImage;
use App\Models\Category;
use App\Services\ProjectService;
use App\Services\CloudinaryService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class AdminProjectController extends Controller
{
    public function __construct(
        protected ProjectService $projectService,
        protected CloudinaryService $cloudinaryService
    ) {}

    /**
     * Display listing of projects with pagination
     */
    public function index()
    {
        $projects = Project::with(['category', 'images', 'primaryImage'])
            ->withCount('images')
            ->latest()
            ->paginate(20);

        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show form to create new project
     */
    public function create()
    {
        $categories = Category::where('is_active', true)->get();
        return view('admin.projects.create', compact('categories'));
    }

    /**
     * Store new project with images uploaded to Cloudinary/{category_slug}/ folder
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title_vi' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description_vi' => 'nullable|string',
            'description_en' => 'nullable|string',
            'client_name' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'area' => 'nullable|numeric',
            'completed_at' => 'nullable|date',
            'is_active' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
            'images.*' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:5120', // 5MB max
        ]);

        // Generate unique slug from Vietnamese name
        $validated['slug'] = Str::slug($validated['title_vi']) . '-' . time();

        // Handle checkbox for is_active
        $validated['is_active'] = $request->has('is_active') && $request->is_active == '1';

        // Handle checkbox for is_featured
        $validated['is_featured'] = $request->has('is_featured') && $request->is_featured == '1';

        // Create project via service
        $project = $this->projectService->createProject($validated);

        // Upload images if provided
        if ($request->hasFile('images')) {
            $uploadedCount = 0;
            $failedCount = 0;

            foreach ($request->file('images') as $index => $imageFile) {
                try {
                    $this->projectService->addProjectImage(
                        $project->id,
                        $imageFile,
                        ['is_primary' => $index === 0] // First image is primary
                    );
                    $uploadedCount++;
                    Log::info("Image {$index} uploaded successfully for project {$project->id}");
                } catch (\Exception $e) {
                    $failedCount++;
                    Log::error("Failed to upload image {$index} for project {$project->id}: " . $e->getMessage());
                }
            }

            if ($failedCount > 0) {
                return redirect()->route('admin.projects.index')
                    ->with('warning', "Dự án đã được tạo! Đã tải lên {$uploadedCount} ảnh, {$failedCount} ảnh thất bại.");
            }
        }

        return redirect()->route('admin.projects.index')
            ->with('success', 'Dự án đã được tạo thành công!');
    }

    /**
     * Show form to edit existing project
     */
    public function edit(Project $project)
    {
        $project->load(['category', 'images']);
        $categories = Category::where('is_active', true)->get();

        return view('admin.projects.edit', compact('project', 'categories'));
    }

    /**
     * Update existing project data
     */
    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title_vi' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description_vi' => 'nullable|string',
            'description_en' => 'nullable|string',
            'client_name' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'area' => 'nullable|numeric',
            'completed_at' => 'nullable|date',
            'is_active' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
        ]);

        // Handle checkbox for is_active
        $validated['is_active'] = $request->has('is_active') && $request->is_active == '1';

        // Handle checkbox for is_featured
        $validated['is_featured'] = $request->has('is_featured') && $request->is_featured == '1';

        // Update slug if title changed
        if ($validated['title_vi'] !== $project->title_vi) {
            $validated['slug'] = Str::slug($validated['title_vi']) . '-' . $project->id;
        }

        // Update via service
        $this->projectService->updateProject($project->id, $validated);

        return redirect()->route('admin.projects.edit', $project)
            ->with('success', 'Dự án đã được cập nhật thành công!');
    }

    /**
     * Delete project and cascade delete all images from Cloudinary
     */
    public function destroy(Project $project)
    {
        try {
            // Delete all images from Cloudinary first
            foreach ($project->images as $image) {
                $this->cloudinaryService->deleteImage($image->cloudinary_public_id);
            }

            // Delete project (will cascade delete images via DB)
            $this->projectService->deleteProject($project->id);

            return redirect()->route('admin.projects.index')
                ->with('success', 'Dự án đã được xóa thành công!');
        } catch (\Exception $e) {
            return redirect()->route('admin.projects.index')
                ->with('error', 'Lỗi khi xóa dự án: ' . $e->getMessage());
        }
    }

    /**
     * Upload additional image to existing project
     * Image will be uploaded to Cloudinary/{category_slug}/ folder
     */
    public function uploadImage(Request $request, Project $project)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,jpg,png,webp|max:5120',
            'is_primary' => 'nullable|boolean',
        ]);

        try {
            // If setting as primary, unset other primary images
            if ($request->boolean('is_primary')) {
                ProjectImage::where('project_id', $project->id)
                    ->update(['is_primary' => false]);
            }

            // Upload via service (category-based folder)
            $this->projectService->addProjectImage(
                $project->id,
                $request->file('image'),
                ['is_primary' => $request->boolean('is_primary')]
            );

            return back()->with('success', 'Ảnh đã được tải lên thành công!');
        } catch (\Exception $e) {
            return back()->with('error', 'Lỗi khi tải ảnh: ' . $e->getMessage());
        }
    }

    /**
     * Delete image from project and Cloudinary
     */
    public function deleteImage($imageId)
    {
        try {
            $image = ProjectImage::findOrFail($imageId);

            // Prevent deleting the only image or primary image if there are others
            $projectImagesCount = ProjectImage::where('project_id', $image->project_id)->count();

            if ($projectImagesCount === 1) {
                return back()->with('error', 'Không thể xóa ảnh duy nhất của dự án!');
            }

            if ($image->is_primary && $projectImagesCount > 1) {
                return back()->with('error', 'Vui lòng chọn ảnh chính khác trước khi xóa ảnh này!');
            }

            // Delete from Cloudinary
            $this->cloudinaryService->deleteImage($image->cloudinary_public_id);

            // Delete from database
            $image->delete();

            return back()->with('success', 'Ảnh đã được xóa thành công!');
        } catch (\Exception $e) {
            return back()->with('error', 'Lỗi khi xóa ảnh: ' . $e->getMessage());
        }
    }
}
