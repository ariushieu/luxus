<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AdminCategoryController extends Controller
{
    public function __construct(
        protected CategoryService $categoryService
    ) {}

    /**
     * Display listing of categories with project count
     */
    public function index()
    {
        $categories = Category::withCount('projects')
            ->latest()
            ->paginate(20);

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show form to create new category
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store new category with unique slug validation
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name_vi' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories,slug',
            'description_vi' => 'nullable|string',
            'description_en' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        // Normalize slug
        $validated['slug'] = Str::slug($validated['slug']);

        // Create via service
        $this->categoryService->createCategory($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Danh mục đã được tạo thành công!');
    }

    /**
     * Show form to edit existing category
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update existing category
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name_vi' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories', 'slug')->ignore($category->id)
            ],
            'description_vi' => 'nullable|string',
            'description_en' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        // Normalize slug
        $validated['slug'] = Str::slug($validated['slug']);

        // Update via service
        $this->categoryService->updateCategory($category->id, $validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Danh mục đã được cập nhật thành công!');
    }

    /**
     * Delete category (only if no projects exist)
     */
    public function destroy(Category $category)
    {
        // Check if category has projects
        if ($category->projects()->count() > 0) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'Không thể xóa danh mục đang có dự án! Vui lòng xóa hoặc chuyển dự án sang danh mục khác.');
        }

        try {
            $this->categoryService->deleteCategory($category->id);

            return redirect()->route('admin.categories.index')
                ->with('success', 'Danh mục đã được xóa thành công!');
        } catch (\Exception $e) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'Lỗi khi xóa danh mục: ' . $e->getMessage());
        }
    }
}
