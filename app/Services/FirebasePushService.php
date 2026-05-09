<?php

namespace App\Services;

use App\Models\MobileDeviceToken;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class FirebasePushService
{
    public function sendToUser(int $idUsuario, string $title, string $body, array $data = []): void
    {
        $tokens = MobileDeviceToken::where('id_usuario', $idUsuario)->pluck('token')->toArray();
        if (empty($tokens)) {
            return;
        }

        $credentials = config('firebase.credentials');
        if (!$credentials) {
            return;
        }

        $messaging = (new Factory())->withServiceAccount($credentials)->createMessaging();

        $message = CloudMessage::new()
            ->withNotification(Notification::create($title, $body))
            ->withData(array_map(fn($v) => (string)$v, $data));

        try {
            $messaging->sendMulticast($message, $tokens);
        } catch (\Throwable $e) {
            \Log::error("FCM send error: " . $e->getMessage());
        }
    }
}

