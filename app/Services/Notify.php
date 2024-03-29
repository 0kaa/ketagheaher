<?php

namespace App\Services;

class Notify
{

    public static function getTokens($device_id, $user_id)
    {

        $deviceTokenRepository = \App::make('App\Repositories\DeviceTokenRepositoryInterface');

        if ($user_id != null) {
            $tokens = $deviceTokenRepository->whereHas('user', ['is_notify' => 1], [['user_id', $user_id], ['is_loggedin', 1]])->pluck('firebase_token');
        }
        return $tokens;
    }


    // public static function NotifyMob($send_to, $message, $title, $type = 'admin-message', $store_id = null, $order_id = null, $delegate_id = null, $user_id = null){
    // $title_ar, $title_en: title of notification
    // $msg_ar, $msg_en: body of notification
    // $user_id: reciever of notification
    // $type: receiver user type (user - estate_manager)
    // $data: id of created element, updated element, ..... to route to it
    // $not_type: notificfation type (created_reply_not, rent_expire_not, ...)
    public static function NotifyMob($msg_ar, $msg_en, $user_id, $device_id, $data = null)
    {
        // dd($user_id);
        $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
        $tokenList = null;
        if ($device_id == null) {
            $tokenList = SELF::getTokens($device_id, $user_id);
            // dd($tokenList);
        }

        $notification = [
            'body' => \App::getLocale() == 'ar' ? $msg_ar : $msg_en,
            'data' => $data,
            'user_id' => $user_id,
            'image' => asset('admin/logo2.png'),
            'sound' => true,
        ];
        $extraNotificationData = [
            'data' => $data,
            'user_id' => $user_id,
            "click_action" => "FLUTTER_NOTIFICATION_CLICK",
            "sound" => "default",
            "badge" => "8",
            "color" => "#ffffff",
            "priority" => "high",
        ];

        $fcmNotification = [
            'registration_ids' => $tokenList, //multple token array
            'notification' => $notification,
            'data' => $extraNotificationData,
        ];

        // dump($fcmNotification);

        $headers = [
            'Authorization: key=AAAA7xUVf3A:APA91bGqrKwhhpR37H-pNxEQG8Z75SJ2g3VdWiHBbVHI0okzu9CgWt5fV8BlNZSR4zAWyubfjzrfvw346A9XhmzdtLC0VdQMjaAmcsXv6tYe8PSLQ5V4lQHmEQQ4ZeCBfSD8G9Qk_Pzh',
            'Content-Type: application/json'
        ];

        // dump($fcmNotification);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $fcmUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
        $result = curl_exec($ch);

        // dd(json_decode($result));
        return $result;
        curl_close($ch);
    }
}
