<?php

namespace App\Repositories\Eloquent;

use App\Models\Subchapter;
use App\Repositories\BaseRepository;

class SubchapterRepository extends BaseRepository
{

    public function __construct(Subchapter $model)
    {
        parent::__construct($model);
    }

    public function createForChapter(int $chapterId,array $data):Subchapter
    {
        $data['chapter_id'] = $chapterId;
        return $this->model->create($data);
    }

    public function getSubchaptersByChapterId(int $chapterId)
    {
        return $this->model->where('chapter_id', $chapterId)->orderBy('created_at', 'desc')->get();
    }

    public function existsSubchapterTitleInChapter(array $data):bool
    {
        $query = Subchapter::where('chapter_id', $data['chapter_id'])
            ->where('title', $data['title']);

        if (isset($data['id'])) {
            $query->where('id', '<>', $data['id']);
        }

        return $query->exists();
    }

}
