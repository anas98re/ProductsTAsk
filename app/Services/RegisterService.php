<?php

namespace App\Services;

use App\Repository\Eloquent\RegisterRepository;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterService extends JsonResponeService
{
    private $RegisterRepository;

    public function __construct(RegisterRepository $RegisterRepository)
    {
        $this->RegisterRepository = $RegisterRepository;
    }

    public function registerService($request)
    {
        try {
            DB::beginTransaction();

            $data = $request->all();
            $data['is_active'] = 1;
            $data['password'] = Hash::make($data['password']);

            if ($request->hasFile('avatar')) {
                $fileHandled = $request->file('avatar')->store('Users_Avatar', 'public');
                $data['avatar'] = $fileHandled;
            }

            $response = $this->RegisterRepository->create($data);
            $token = $response->createToken('MyAuthApp')->plainTextToken;
            DB::commit();

            $response['token'] = $token;
            return $response;
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    public function loginService($request)
    {
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('MyAuthApp')->plainTextToken;

            return response()->json(['token' => $token, 'user' => $user]);
        } else {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
    }
}
