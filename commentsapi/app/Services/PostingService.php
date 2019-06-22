<?php

namespace App\Services;

use App\Repositories\PostingRepository;

class PostingService
{
    
    protected $postingRepository;

    public function __construct(PostingRepository $postingRepository) {
        $this->postingRepository = $postingRepository;
    }
    

    public function findById($id) {
        return $this->postingRepository->findById($id);
    }

}
