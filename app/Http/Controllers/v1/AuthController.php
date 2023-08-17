<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use function auth;

class AuthController extends Controller
{
    /**
     * @param UserRegisterRequest $request
     * @return JsonResponse
     */
    public function register(UserRegisterRequest $request): JsonResponse
    {
        $user = User::create([
            'name'  => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password'))
        ]);

        $token = $user->createToken(uniqid(true) . time())->plainTextToken;

        return $this->success(['user'  => $user, 'token' => $token],"Success",Response::HTTP_CREATED);
    }


    /**
     * @param UserLoginRequest $request
     * @return array|JsonResponse
     */
    public function login(UserLoginRequest $request): array|JsonResponse
    {
        // Check login existance
        $user = User::where('email', $request->input('email'))->first();


        // Check password matching
        if (!$user || !Hash::check($request->input('password'), $user->getAuthPassword())) {
            return $this->error(null,'Bad credentials', Response::HTTP_FORBIDDEN);
        }

        $token = $user->createToken(uniqid(true) . time())->plainTextToken;

        return $this->success(['user'  => $user,'token' => $token]);
    }


    public function logout(): array
    {
        auth()->user()->tokens()->delete();
        return [
            'message' => 'Logged out'
        ];
    }
}
