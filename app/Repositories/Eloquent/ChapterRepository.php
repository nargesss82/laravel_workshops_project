<?php

namespace App\Repositories\Eloquent;

use App\Repositories\BaseRepository;
use App\Models\Chapter;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class ChapterRepository extends BaseRepository
{

    public function __construct(Chapter $model)
    {
        parent::__construct($model);
    }

    public function createForWorkshop(int $workshopId,array $data):Chapter
    {
        $data['workshop_id'] = $workshopId;
        return $this->model->create($data);
    }


    public function allWithSubchapters():Collection
    {
        $query=Chapter::query();
        $query->with(['subChapters']);

        return $query->get();
    }
    public function findWithSubchapters(int $id): Model
    {
        $query=Chapter::query();
        $query->with(['subChapters']);

        return $query->findOrFail($id);
    }

    public function existsChapterTitleInWorkshop(array $data):bool
    {
        $query = Chapter::where('workshop_id', $data['workshop_id'])
            ->where('title', $data['title']);

        if (isset($data['id'])) {
            $query->where('id', '<>', $data['id']);
        }

        return $query->exists();
    }



}
