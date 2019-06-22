<?php

namespace App\Http\Controllers;


use App\UseCases\RetrieveNotificationsUseCase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class NotificationsRestController extends Controller
{
    protected $retrieveNotificationsUseCase;

    public function __construct(RetrieveNotificationsUseCase $retrieveNotificationsUseCase)
	{
        $this->retrieveNotificationsUseCase = $retrieveNotificationsUseCase;
    }

    public function getNotificationByUserId(Request $request) {
        $pageSize = $request->input('pageSize');
        $id = $request->route('id');
        return $this->retrieveNotificationsUseCase->execute($pageSize, $id);
    }
}
