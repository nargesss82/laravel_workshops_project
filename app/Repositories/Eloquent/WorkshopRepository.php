<?php

namespace App\Repositories\Eloquent;
use App\Repositories\BaseRepository;
use App\Models\Workshop;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class WorkshopRepository extends BaseRepository
{
    public function __construct(Workshop $model)
    {
        parent::__construct($model);
    }


    public function assignTeacherToWorkshop(int $workshopId,int $teacherId)
    {
        $workshop=$this->model->findOrFail($workshopId);
        $workshop->teacher_id=$teacherId;
        $workshop->save();
        return $workshop->load('teacher');
    }

    public function allWithChapters():Collection
    {
        $query=Workshop::query();
        $query->with(['chapters']);

        return $query->get();
    }
    public function findWithChapters(int $id): Model
    {
        $query=Workshop::query();
        $query->with(['chapters']);

        return $query->findOrFail($id);
    }

    public function existsTitle(array $data):bool
    {
        $query = Workshop::where('title', $data['title']);

        if (isset($data['id'])) {
            $query->where('id', '<>', $data['id']);
        }

        return $query->exists();
    }

}
