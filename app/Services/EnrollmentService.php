<?php

namespace App\Services;

use App\Repositories\Eloquent\UserRepository;

use App\Repositories\Eloquent\WorkshopRepository;
use App\Repositories\Eloquent\EnrollmentRepository;


class EnrollmentService
{
    protected $workshopRepository;
    protected $userRepository;
    protected $enrollmentRepository;
    public function __construct(EnrollmentRepository $enrollmentRepository,WorkshopRepository $workshopRepository,UserRepository $userRepository)
    {
        $this->enrollmentRepository = $enrollmentRepository;
        $this->workshopRepository = $workshopRepository;
        $this->userRepository = $userRepository;
    }

    public function getAllEnrollments(){
        return $this->enrollmentRepository->all();
    }
    public function getEnrollmentById($id){
        return $this->enrollmentRepository->find($id);
    }

    private function checkForEnrollment(?int $userId, ?int $workshopId, ?int $ignoreEnrollmentId = null): void
    {
        if (is_null($userId) || is_null($workshopId)) {
            return; // چیزی برای بررسی وجود نداره
        }

        $user = $this->userRepository->find($userId);
        $workshop = $this->workshopRepository->find($workshopId);

        if (!$user->isStudent()) {
            throw new \Exception('User must be a student to enroll');
        }
        if (!$workshop->isActive()) {
            throw new \Exception('Workshop is not active');
        }
        if ($this->enrollmentRepository->exists($userId, $workshopId, $ignoreEnrollmentId)) {
            throw new \Exception('Student already enrolled in this workshop');
        }
    }

    public function createEnrollment(int $userId,int $workshopId){
        $this->checkForEnrollment($userId,$workshopId);
        return $this->enrollmentRepository->enrollStudent($userId,$workshopId);
    }

    public function updateEnrollment(?int $userId, ?int $workshopId, int $enrollmentId)
    {
        if (!$enrollmentId) {
            throw new \Exception('Enrollment id not found');
        }

        $enrollment = $this->enrollmentRepository->find($enrollmentId);
        if (!$enrollment) {
            throw new \Exception('Enrollment not found');
        }

        // فقط در صورتی که user_id ارسال شده باشه
        if (!is_null($userId)) {
            $this->checkForEnrollment($userId, $workshopId ?? $enrollment->workshop_id, $enrollmentId);
            $enrollment->user_id = $userId;
        }

        // فقط در صورتی که workshop_id ارسال شده باشه
        if (!is_null($workshopId)) {
            $this->checkForEnrollment($userId ?? $enrollment->user_id, $workshopId, $enrollmentId);
            $enrollment->workshop_id = $workshopId;
        }

        $enrollment->save();

        return $enrollment;
    }


    public function deleteEnrollment (int $enrollmentId)
    {
        if(!$enrollmentId){
            throw new \Exception("Enrollment id not found");
        }
        return $this->enrollmentRepository->delete($enrollmentId);
    }
}
