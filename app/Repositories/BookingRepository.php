<?php

namespace App\Repositories;

use App\Interfaces\BookingRepositoryInterface;
use App\Models\Booking;

class BookingRepository implements BookingRepositoryInterface
{
    public function all(array $filters = [])
    {
        $query = Booking::query();

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['from_date'])) {
            $query->whereDate('booking_time', '>=', $filters['from_date']);
        }

        if (isset($filters['to_date'])) {
            $query->whereDate('booking_time', '<=', $filters['to_date']);
        }

        return $query->orderBy('booking_time', 'desc')->get();
    }

    public function find(int $id)
    {
        return Booking::findOrFail($id);
    }

    public function create(array $data)
    {
        return Booking::create($data);
    }

    public function update(int $id, array $data)
    {
        $booking = $this->find($id);
        $booking->update($data);
        return $booking;
    }

    public function delete(int $id)
    {
        $booking = $this->find($id);
        return $booking->delete();
    }

    public function getByStatus(string $status)
    {
        return Booking::where('status', $status)
            ->orderBy('booking_time', 'desc')
            ->get();
    }

    public function getPending()
    {
        return Booking::pending()->orderBy('booking_time', 'asc')->get();
    }
}
