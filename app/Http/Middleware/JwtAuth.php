<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpFoundation\Response;

class JwtAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

        public function handle(Request $request, Closure $next): Response
        {
            // কুকি থেকে সবগুলো টোকেন খুঁজুন
            $cookies = $request->cookies->all();
            $token = null;

            foreach ($cookies as $key => $value) {
                // যদি কুকির নাম `token_user_` দিয়ে শুরু হয়, তাহলে সেটি টোকেন হিসেবে ধরুন
                if (str_starts_with($key, 'token_user_')) {
                    $token = $value;
                    break;
                }
            }

            // যদি কোনো টোকেন না পাওয়া যায়
            if (!$token) {
                return response(['status' => 'failed', 'message' => 'Unauthorized'], 401);
            }

            try {
                $key = env('JWT_KEY'); // .env ফাইল থেকে JWT_KEY রিড করা
                $decoded = JWT::decode($token, new Key($key, 'HS256'));

                // টোকেন বৈধ হলে ব্যবহারকারীর ডেটা রিকুয়েস্টে যোগ করা
                // $request->user = (object) ['id' => $decoded->userid];
                $request->attributes->set('user', (object) ['id' => $decoded->userid]);
            } catch (Exception $e) {
                // টোকেন যদি অবৈধ হয়
                return response(['status' => 'failed', 'message' => 'Invalid Token'], 401);
            }

            return $next($request);
        }



}
