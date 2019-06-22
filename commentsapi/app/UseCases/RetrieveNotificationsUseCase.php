<?php

namespace App\UseCases;

use App\Services\NotificationsService;

class RetrieveNotificationsUseCase
{
    protected $notificationsService;

    public function __construct(NotificationsService $notificationsService)
	{
        $this->notificationsService = $notificationsService;
    }
    
    public function execute($pageSize, $id) {
        return response()->json(['data' => $this->notificationsService->getNotificationsByUserId($pageSize, $id)]);
    }
}
