<?php

namespace App\Repositories;

use App\Models\Posting;

class PostingRepository 
{
	private $posting;

	public function __construct(Posting $posting) {
		$this->posting = $posting;
    }
    

	public function findById($id) {
		return $this->posting->find($id);
	}    

}
