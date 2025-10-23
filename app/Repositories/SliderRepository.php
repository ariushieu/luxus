<?php

namespace App\Repositories;

use App\Models\Slider;
use Illuminate\Database\Eloquent\Collection;

class SliderRepository
{
    public function all(): Collection
    {
        return Slider::orderBy('display_order')->get();
    }

    public function getActive(): Collection
    {
        return Slider::where('is_active', true)
            ->orderBy('display_order')
            ->get();
    }

    public function findById(int $id): ?Slider
    {
        return Slider::find($id);
    }

    public function create(array $data): Slider
    {
        return Slider::create($data);
    }

    public function update(int $id, array $data): bool
    {
        $slider = $this->findById($id);
        if (!$slider) {
            return false;
        }
        return $slider->update($data);
    }

    public function delete(int $id): bool
    {
        $slider = $this->findById($id);
        if (!$slider) {
            return false;
        }
        return $slider->delete();
    }
}
