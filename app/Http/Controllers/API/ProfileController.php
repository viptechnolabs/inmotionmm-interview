<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\PinCodeSearchRequest;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\UserSearchRequest;
use App\Http\Resources\CityResource;
use App\Http\Resources\UserResource;
use App\Models\City;
use App\Repositories\CartRepository;
use App\Repositories\UserRepository;
use App\Traits\ResponseTrait;

class ProfileController extends Controller
{
    use ResponseTrait;

    public function show()
    {
        $user = auth('sanctum')->user();

        return (new UserResource($user))
            ->additional([
                'message' => 'User Details',
                'status' => true
            ]);
    }

    public function logout()
    {
        $user = auth()->user();
        $user->currentAccessToken()->delete();

        return $this->success(message: 'Logout successfully.');
    }
}
