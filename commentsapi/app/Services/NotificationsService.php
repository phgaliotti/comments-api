<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use App\Repositories\NotificationRepository;
use Illuminate\Support\Arr;
use Carbon\Carbon;

class NotificationsService
{      
    protected $notificationRepository;
    public function __construct(NotificationRepository $notificationRepository)
	{
        $this->notificationRepository = $notificationRepository;
    }

    public function create($notification) {
        return $this->notificationRepository->new($notification); 
    }

    public function update($id, $notification){
        return $this->notificationRepository->update($id, $notification);
    }

    public function getNotificationsByUserId($pageSize, $id) {
        if (empty($pageSize)){
            $pageSize = 10;
        }

        return $this->notificationRepository->getNotificationsByUserId($id, $pageSize);
    }

    public function addExpirationDate($pendingNotifications){
        $now = Carbon::now()->addMinute(60);
        foreach ($pendingNotifications as $notification) {
            if ($notification->expiration_date == null){
                $this->update($notification->id, ['expiration_date' => $now]);
            }
        }
        return $pendingNotifications;
    }

    public function notifyOwnerPosting($commentingUser, $posting){
        $data = $this->buildDataMail($commentingUser, $posting);
        $notification = $this->convertToNotificationEntity($data);

        $this->create($notification);
        /*Mail::send($data->body, function($message, $data){
            $message->to($data->mailOwonerPosting)
                ->subject('You just received a comment! See now');
            $message->from('do-notreply@gmail.com');
        });*/
    }

    private function buildDataMail($commentingUser, $posting){
        $nameCommentingUser = $commentingUser->name;
        $nameOwnerPosting = $posting->user->name;
        $mailOwonerPosting = $posting->user->email;
        $to_user_id = $posting->user->id; 
        $from_user_id = $commentingUser->id;
        $body = "Hi," . $nameOwnerPosting . " the user ". $nameCommentingUser ." commented on your post " . $posting->title;
        
        Log::info("Notify :::: " . $body);
        return array("from_user_id" => $from_user_id, "to_user_id" => $to_user_id, "mailOwonerPosting" => $mailOwonerPosting, "body" => $body);
    }

    private function convertToNotificationEntity($data){
        $text = Arr::get($data, 'body');
        $from_user_id = Arr::get($data, 'from_user_id');
        $to_user_id = Arr::get($data, 'to_user_id');
        $read = false;

        $entity = array("text" => $text, "from_user_id" => $from_user_id, "to_user_id" => $to_user_id, "read" => $read);
        return $entity;
    }

}
