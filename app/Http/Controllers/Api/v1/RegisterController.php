<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegistUserRequest;
use App\Models\User;
use App\Services\ApiTokenCreateService;


class RegisterController extends Controller
{
    public function register(RegistUserRequest $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        $user = User::find($user->id);
        //TODO send confirm-email after registration
        $ApiTokenCreateService = new ApiTokenCreateService($user);

        return $ApiTokenCreateService->respondWithToken();
    }
}
