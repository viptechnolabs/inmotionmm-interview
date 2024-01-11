<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use ResponseTrait;

    public function __invoke(Request $request)
    {

        try {
            // Request params
            $email = $request->input('email');
            $password = $request->input('password');

            // Attempt authentication
            $authenticated = auth()->attempt(['email' => $email, 'password' => $password]);

            if (!$authenticated) {
                throw new \Exception('Invalid credentials');
            }

            // Retrieve authenticated user
            $user = $request->user();

            // Token generation
            $token = $user->createToken('api_token')->plainTextToken;

            // Return user data with additional information
            return (new UserResource($user))
                ->additional([
                    'token' => $token,
                    'message' => 'You are successfully logged in',
                    'status' => true,
                ]);
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), statusCode: false);
        }
    }
}
