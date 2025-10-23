<?php

namespace App\Services;

use App\Repositories\SliderRepository;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Slider;

class SliderService
{
    public function __construct(
        protected SliderRepository $sliderRepository,
        protected CloudinaryService $cloudinaryService
    ) {}

    public function getAllSliders(): Collection
    {
        return $this->sliderRepository->all();
    }

    public function getActiveSliders(): Collection
    {
        return $this->sliderRepository->getActive();
    }

    public function getSliderById(int $id): ?Slider
    {
        return $this->sliderRepository->findById($id);
    }

    public function createSlider(array $data, $image): Slider
    {
        // Upload to Cloudinary
        $uploadResult = $this->cloudinaryService->uploadImage($image, 'Luxus/sliders');

        $sliderData = [
            'title_vi' => $data['title_vi'] ?? null,
            'title_en' => $data['title_en'] ?? null,
            'subtitle_vi' => $data['subtitle_vi'] ?? null,
            'subtitle_en' => $data['subtitle_en'] ?? null,
            'button_text_vi' => $data['button_text_vi'] ?? null,
            'button_text_en' => $data['button_text_en'] ?? null,
            'button_link' => $data['button_link'] ?? null,
            'cloudinary_public_id' => $uploadResult['public_id'],
            'cloudinary_url' => $uploadResult['url'],
            'display_order' => $data['display_order'] ?? 0,
            'is_active' => $data['is_active'] ?? true,
        ];

        return $this->sliderRepository->create($sliderData);
    }

    public function updateSlider(int $id, array $data, $image = null): bool
    {
        $slider = $this->getSliderById($id);
        if (!$slider) {
            return false;
        }

        $updateData = [
            'title_vi' => $data['title_vi'] ?? $slider->title_vi,
            'title_en' => $data['title_en'] ?? $slider->title_en,
            'subtitle_vi' => $data['subtitle_vi'] ?? $slider->subtitle_vi,
            'subtitle_en' => $data['subtitle_en'] ?? $slider->subtitle_en,
            'button_text_vi' => $data['button_text_vi'] ?? $slider->button_text_vi,
            'button_text_en' => $data['button_text_en'] ?? $slider->button_text_en,
            'button_link' => $data['button_link'] ?? $slider->button_link,
            'display_order' => $data['display_order'] ?? $slider->display_order,
            'is_active' => $data['is_active'] ?? $slider->is_active,
        ];

        // Upload new image if provided
        if ($image) {
            // Delete old image
            $this->cloudinaryService->deleteImage($slider->cloudinary_public_id);

            // Upload new image
            $uploadResult = $this->cloudinaryService->uploadImage($image, 'Luxus/sliders');
            $updateData['cloudinary_public_id'] = $uploadResult['public_id'];
            $updateData['cloudinary_url'] = $uploadResult['url'];
        }

        return $this->sliderRepository->update($id, $updateData);
    }

    public function deleteSlider(int $id): bool
    {
        $slider = $this->getSliderById($id);
        if (!$slider) {
            return false;
        }

        // Delete image from Cloudinary
        $this->cloudinaryService->deleteImage($slider->cloudinary_public_id);

        return $this->sliderRepository->delete($id);
    }
}
