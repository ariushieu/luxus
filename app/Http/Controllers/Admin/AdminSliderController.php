<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\SliderService;
use Illuminate\Http\Request;

class AdminSliderController extends Controller
{
    public function __construct(protected SliderService $sliderService) {}

    public function index()
    {
        $sliders = $this->sliderService->getAllSliders();
        return view('admin.sliders.index', compact('sliders'));
    }

    public function create()
    {
        return view('admin.sliders.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title_vi' => 'nullable|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'subtitle_vi' => 'nullable|string|max:255',
            'subtitle_en' => 'nullable|string|max:255',
            'button_text_vi' => 'nullable|string|max:100',
            'button_text_en' => 'nullable|string|max:100',
            'button_link' => 'nullable|url|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
            'display_order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        try {
            $this->sliderService->createSlider($validated, $request->file('image'));
            return redirect()->route('admin.sliders.index')
                ->with('success', 'Slider đã được tạo thành công!');
        } catch (\Exception $e) {
            return back()->with('error', 'Lỗi: ' . $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        $slider = $this->sliderService->getSliderById($id);
        if (!$slider) {
            return redirect()->route('admin.sliders.index')
                ->with('error', 'Không tìm thấy slider!');
        }
        return view('admin.sliders.edit', compact('slider'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title_vi' => 'nullable|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'subtitle_vi' => 'nullable|string|max:255',
            'subtitle_en' => 'nullable|string|max:255',
            'button_text_vi' => 'nullable|string|max:100',
            'button_text_en' => 'nullable|string|max:100',
            'button_link' => 'nullable|url|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'display_order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        try {
            $this->sliderService->updateSlider($id, $validated, $request->file('image'));
            return redirect()->route('admin.sliders.index')
                ->with('success', 'Slider đã được cập nhật!');
        } catch (\Exception $e) {
            return back()->with('error', 'Lỗi: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $this->sliderService->deleteSlider($id);
            return redirect()->route('admin.sliders.index')
                ->with('success', 'Slider đã được xóa!');
        } catch (\Exception $e) {
            return back()->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }
}
