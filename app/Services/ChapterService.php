<?php

namespace App\Services;

use App\Models\Chapter;
use App\Repositories\Eloquent\ChapterRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class ChapterService
{
    protected $chapterRepository;
    public function __construct(ChapterRepository $chapterRepository)
    {
        $this->chapterRepository = $chapterRepository;
    }

    public function getAllChapters(bool $withSubchapters=false):Collection
    {
        if($withSubchapters){
            return $this->chapterRepository->allWithSubchapters();
        }
        return $this->chapterRepository->all();
    }
    public function getChapterById(int $id,bool $withSubchapters=false): Model
    {
        if($withSubchapters){
            return $this->chapterRepository->findWithSubchapters($id);
        }
        return $this->chapterRepository->find($id);
    }
    public function createChapter(int $workshopId,array $data): Model
    {
        if(!$workshopId){
            throw new \Exception("Workshop id not set");
        }
        if(!$data){
            throw new \Exception("Chapter data not set");
        }
        if ($this->chapterRepository->existsChapterTitleInWorkshop($data)) {
            throw new \Exception("Chapter title already exists in this workshop");
        }

        return $this->chapterRepository->createForWorkshop($workshopId,$data);
    }
    public function updateChapter(int $id, array $data): Model
    {
        if(!$data){
            throw new \Exception("Chapter data not set");
        }
        if(!$id){
            throw new \Exception("Chapter id not set");
        }
        if($this->chapterRepository->existsChapterTitleInWorkshop($data))
        {
            throw new \Exception("Chapter title already exists in this workshop");
        }
        return $this->chapterRepository->update($id,$data);
    }
    public function deleteChapter(int $id): bool
    {
        if(!$id){
            throw new \Exception("Chapter id not set");
        }
        return $this->chapterRepository->delete($id);
    }


}
