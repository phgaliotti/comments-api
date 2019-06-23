<?php

namespace App\UseCases;

use App\Services\NotificationsService;
use Illuminate\Support\Arr;

class RetrieveNotificationsUseCase
{
    protected $notificationsService;

    public function __construct(NotificationsService $notificationsService)
	{
        $this->notificationsService = $notificationsService;
    }
    
    public function execute($pageSize, $id) {
        $pendingNotifications = $this->notificationsService->getNotificationsByUserId($pageSize, $id);
        $this->notificationsService->addExpirationDate($pendingNotifications);

        return response()->json(['data' => $pendingNotifications]);
    }
}
