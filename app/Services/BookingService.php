<?php

namespace App\Services;

use App\Interfaces\BookingRepositoryInterface;
use App\Jobs\SendBookingNotificationJob;

class BookingService
{
    protected $bookingRepository;

    public function __construct(BookingRepositoryInterface $bookingRepository)
    {
        $this->bookingRepository = $bookingRepository;
    }

    public function getAllBookings(array $filters = [])
    {
        return $this->bookingRepository->all($filters);
    }

    public function getBookingById(int $id)
    {
        return $this->bookingRepository->find($id);
    }

    public function createBooking(array $data)
    {
        $booking = $this->bookingRepository->create($data);

        // Dispatch job to send email notification
        SendBookingNotificationJob::dispatch($booking);

        return $booking;
    }

    public function updateBooking(int $id, array $data)
    {
        return $this->bookingRepository->update($id, $data);
    }

    public function updateBookingStatus(int $id, string $status, ?string $adminNotes = null)
    {
        $data = ['status' => $status];

        if ($adminNotes) {
            $data['admin_notes'] = $adminNotes;
        }

        $booking = $this->bookingRepository->update($id, $data);

        // Send notification email when status changes
        SendBookingNotificationJob::dispatch($booking);

        return $booking;
    }

    public function deleteBooking(int $id)
    {
        return $this->bookingRepository->delete($id);
    }

    public function getPendingBookings()
    {
        return $this->bookingRepository->getPending();
    }

    public function getBookingsByStatus(string $status)
    {
        return $this->bookingRepository->getByStatus($status);
    }
}
