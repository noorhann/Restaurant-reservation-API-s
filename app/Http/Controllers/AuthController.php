<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserSingleResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    /**
     * @param LoginRequest $request
     * @return  json()
     * Login Waiter using email and password
     */
    public function login(LoginRequest $request)
    {
        try {

            $credentials = $request->only(['email', 'password']);

            if (!$token = auth()->attempt($credentials)) {
                return apiResponse(
                    false,
                    'Wrong email or password',
                    422,
                );
            }


            $message = 'You Logged in successfully';
            $data['user'] = new UserSingleResource(auth()->user());
            $data['token'] = $token;
            
            return $this->respondWithToken($data, $message);
        
        }
        catch (\Throwable $th){
            Log::error($th);
        }
    }

    /**
     * @param StoreUserRequest $request
     * @return  json()
     * Create waiter 
     */
    public function create(StoreUserRequest $request)
    {
        try {
            $request['password'] = bcrypt($request->password);
            $user = User::create($request->all());
            $user['token'] = auth()->login($user);
            $message = 'waiter created successfully';
            return $this->respondWithToken($user, $message);

        } 
        catch (\Throwable $th) {
            Log::error($th);
        }
    }


    /**
     * @param Request $request
     * @return  json()
     * Logout waiter
     */
    public function logout(Request $request)
    {
        try {
            auth()->logout();
            return apiResponse(
                true, 
                'You have been logged out', 
                200
            );
        } 
        catch (\Throwable $th) {
            Log::error($th);
    
        }
    }

    /**
     * Get the token array structure.
     * @param  string $token
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($data, $message)
    {
        return apiResponse(
            true,
            $message,
            201,
            $data,
        );
    }
}
