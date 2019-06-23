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
      return $this->notification->create($notification);
   }

   public function save($notification) {
      return $this->notification->save($notification); 
   }

   public function update($id, $notification) {
      Notification::find($id)->update($notification);
      //$this->notification->find($id)->update($notification);
   }

   public function getNotificationsByUserId($id, $pageSize) {
      // pegar todos as notificacoes não lidos ou que a data de expiração seja menor ou igual que a data de (hoje - 60 minutos)
      $serverHour = Carbon::now()->subMinute(60);
      return $this->notification
         ->where('to_user_id', '=' , $id)
         ->Where('expiration_date', null)
         ->orWhere('expiration_date', '>=' , $serverHour)
         ->orderBy('created_at', 'desc')
         ->paginate($pageSize);
   }
}