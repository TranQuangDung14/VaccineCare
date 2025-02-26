<?php

namespace App\Http\Controllers\Zalo;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ZaloAuthController extends Controller
{
    public function handleCallback(Request $request)
    {
        // Lấy code từ Zalo
        $code = $request->query('code');

        if (!$code) {
            return response()->json(['error' => 'Authorization failed'], 400);
        }

        // Gửi request lấy Access Token
        $client = new Client();
        $response = $client->post('https://oauth.zalo.me/oauth/access_token', [
            'form_params' => [
                'app_id' => env('ZALO_APP_ID'),
                'app_secret' => env('ZALO_APP_SECRET'),
                'code' => $code,
                'grant_type' => 'authorization_code',
            ]
        ]);

        $body = json_decode($response->getBody(), true);

        // Lưu Access Token và Refresh Token vào database
        if (isset($body['access_token'])) {
            // Lưu vào database
            DB::table('oauth_tokens')->updateOrInsert(
                ['user_id' => auth()->id()],
                [
                    'access_token' => $body['access_token'],
                    'refresh_token' => $body['refresh_token'],
                    'expires_at' => now()->addSeconds($body['expires_in']),
                    'refresh_expires_at' => now()->addMonths(3),
                ]
            );

            return redirect('/dashboard')->with('success', 'Đăng nhập Zalo thành công!');
        }

        return response()->json(['error' => 'Failed to get access token'], 400);
    }
}
