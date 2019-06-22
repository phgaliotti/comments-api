<?php

namespace App\Repositories;


use Illuminate\Support\Facades\Log;
use App\Notification;

class NotificationRepository 
{
	private $notification;

	public function __construct(Notification $notification) {
		$this->notification = $notification;
    }
    
    public function new($notification) {
        Log::info("vai notificar NotificationRepository");
        return $this->notification->create($notification);
     }

     public function getById($id) {
        return $this->notification->find($id);
     }
}