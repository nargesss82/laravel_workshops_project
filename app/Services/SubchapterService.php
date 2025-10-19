<?php

namespace App\Services;

use App\Models\Subchapter;
use App\Repositories\Eloquent\ChapterRepository;
use App\Repositories\Eloquent\SubchapterRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class SubchapterService
{
    protected $subchapterRepository;
    protected $chapterRepository;

    public function __construct(SubchapterRepository $subchapterRepository, ChapterRepository $chapterRepository)
    {
        $this->subchapterRepository = $subchapterRepository;
        $this->chapterRepository = $chapterRepository;
    }

    public function getAllSubchaptersByChapterId(int $chapterId)
    {
        return $this->subchapterRepository->getSubchaptersByChapterId($chapterId);
    }

    public function getSubchapterById(int $subchapterId)
    {
        return $this->subchapterRepository->find($subchapterId);
    }
    public function createSubchapter(int $chapterId,array $data)
    {
        $chapter=$this->chapterRepository->find($chapterId);
        if($chapter->isFree()){
            $data['is_free']=true;
            $data['price']=null;
        }else{
            $data['is_free']=false;
        }
        if(!$chapter){
            throw new \Exception("Chapter not found");
        }
        if(!$chapterId)
        {
            throw new \Exception("ChapterId not set");
        }
        if(!$data)
        {
            throw new \Exception("Data not set");
        }
        if($this->subchapterRepository->existsSubchapterTitleInChapter($data))
        {
            throw new \Exception("Subchapter already exists");
        }
        return $this->subchapterRepository->createForChapter($chapterId,$data);
    }
    public function updateSubchapter(int $subchapterId,array $data)
    {
        $chapterId=$data['chapter_id'];
        $chapter=$this->chapterRepository->find($chapterId);
        if($chapter->isFree()){
            $data['is_free']=true;
            $data['price']=null;
        }else{
            $data['is_free']=false;
        }
        if(!$subchapterId){
            throw new \Exception("SubchapterId not set");
        }
        if(!$data){
            throw new \Exception("Data not set");
        }
        if(isset($data['title'])){
            if ($this->subchapterRepository->existsSubchapterTitleInChapter($data)) {
                throw new \Exception('Subchapter title already exists');
            }
        }
        return $this->subchapterRepository->update($subchapterId,$data);
    }
    public function deleteSubchapter(int $subchapterId)
    {
        if(!$subchapterId){
            throw new \Exception("SubchapterId not set");
        }
        return $this->subchapterRepository->delete($subchapterId);
    }



}
