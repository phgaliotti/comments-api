<?php

namespace App\Repositories;


use Illuminate\Support\Facades\Log;
use App\Notification;
use Carbon\Carbon;

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

     public function getNotificationsByUserId($id, $pageSize) {
      //$serverHour = (new DateTime())->modify('-60 minute')->format('Y-m-d');
      // pegar todos os comentários não lidos ou que a data de expiração seja menor ou igual que a data de (hoje - 60 minutos)
      $serverHour = Carbon::now()->subMinute(60);
      $responseTeste =  $this->notification
         ->where('to_user_id', '=' , $id)
         ->Where('read', '=' , false)
         ->orWhere('expiration_date', '<=' , $serverHour)
         ->orderBy('created_at', 'desc')
         ->paginate($pageSize);
         dd($responseTeste);
         return responseTeste;
     }
}