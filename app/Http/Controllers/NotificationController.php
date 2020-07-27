<?php

namespace App\Http\Controllers;


use App\Http\Requests;

use App\Models\Notification;

use Response;


class NotificationController extends Controller
{
  public function notifications(){

    $notifications = Notification::with('order.offers','shop','client')->latest()->paginate(20);

  //  dd($notifications[0]->order->offers[0]->title);

    return view('admin.notifications.index', compact('notifications'));

  }

  public function show($id){

    $notification = Notification::where('id',$id)->first();

    $notification->read = 1;

    $notification->save();


    $data = array(
        'status'  => 1
        );

   return response()->json($data);


  }

  public function unread(){

    $notifications = Notification::where('read',0)->latest()->limit(5)->get();

    $unseen_number = count(Notification::where('read',0)->get());

    $all_notifications = [];

    if($unseen_number>0){

    foreach($notifications as $notification){
              //<li class="header">لديك <span class="new_orders_count">0</span> طلبات جديدة</li>

                      $all_notification = '<li class="header">'

                      .$notification->content.' <span class="new_orders_count"> '

                      .$notification->$unseen_number .'</span> منذ'

                      .$notification->created_at->diffForHumans() .' </li>';

                      array_push($all_notifications, $all_notification);
            }

              //<span class="notification-date"><time class="entry-date updated" datetime="2004-07-24T18:18">'. $notification->created_at->diffForHumans() .'</time></span>

              }

              $data = array(
                  'notification'  => $all_notifications,
                  'number'=> $unseen_number
                  );


            return response()->json($data);

      }


}
