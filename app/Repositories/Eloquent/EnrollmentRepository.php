<?php

namespace App\Repositories\Eloquent;

use App\Models\Enrollment;
use App\Repositories\BaseRepository;

class EnrollmentRepository extends BaseRepository
{
    public function __construct(Enrollment $model)
    {
         parent::__construct($model);
    }

    public function exists(int $userId, int $workshopId, ?int $ignoreId = null): bool
    {
        $query = $this->model->where('user_id', $userId)
            ->where('workshop_id', $workshopId);

        if ($ignoreId) {
            $query->where('id', '<>', $ignoreId);
        }

        return $query->exists();
    }
    public function enrollStudent(int $userId, int $workshopId)
    {
        return $this->model->create([
            'user_id' => $userId,
            'workshop_id' => $workshopId
        ]);
    }
}
