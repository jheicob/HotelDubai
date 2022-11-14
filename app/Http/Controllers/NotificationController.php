<?php

namespace App\Http\Controllers;

use App\Models\RoomNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        try{

            $user = Auth::user();

            $notifications = RoomNotification::filter($request)
                        ->where('view',false)
                        ->get();

            return $notifications;
        }catch(\Exception $e){
            return custom_response_exception($e, __('errors.server.title'), 500);
        }
    }

    public function clear($id,Request $request)
    {
        try{
            $user = Auth::user();

            $notifications = RoomNotification::filter($request)
                        ->where('view',false)
                        ->where('id',$id)
                        ->first();
            if($notifications == '') return;
            $notifications->update(['view' =>1]);

            return $notifications;
        }catch(\Exception $e){
            return custom_response_exception($e, __('errors.server.title'), 500);
        }
    }
}
