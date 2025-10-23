<?php

namespace App\Repositories;

use App\Interfaces\QuoteRepositoryInterface;
use App\Models\Quote;

class QuoteRepository implements QuoteRepositoryInterface
{
    public function all(array $filters = [])
    {
        $query = Quote::query();

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['project_type'])) {
            $query->where('project_type', $filters['project_type']);
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    public function find(int $id)
    {
        return Quote::findOrFail($id);
    }

    public function create(array $data)
    {
        return Quote::create($data);
    }

    public function update(int $id, array $data)
    {
        $quote = $this->find($id);
        $quote->update($data);
        return $quote;
    }

    public function delete(int $id)
    {
        $quote = $this->find($id);
        return $quote->delete();
    }

    public function getByStatus(string $status)
    {
        return Quote::where('status', $status)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getPending()
    {
        return Quote::pending()->orderBy('created_at', 'asc')->get();
    }
}
