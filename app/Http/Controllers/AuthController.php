<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function getUserProfile($id)
    {
        try {
            $user = User::findOrFail($id);
            return response()->json([
                'message' => 'user profile retried successfully!',
                'user' => $user

            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),

            ]);
        }
    }
    public function register(Request $request)
    {
        try {
            $fields =  $request->validate([
                'firstname' => "required",
                'lastname' => 'required',
                'username' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required|confirmed',
                'dp' => 'string'
            ]);

            $user =  User::create($fields);

            $token = $user->createToken($request->username);


            return response()->json([
                'message' => "Successfully Registered the user!",
                'user' => $user,
                'token' => $token->plainTextToken

            ]);
        } catch (ValidationException $e) {

            return response()->json([
                'message' => $e->getMessage(),
                'error' => '422'

            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'error' => '422'
            ]);
        }
    }
    public function login(Request $request)
    {
        try {

            $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);

            $user = User::where('email', $request->email)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json([
                    'message' => "The provided credentials are incorrect.",
                ]);
            }

            $token = $user->createToken($user->username);

            return response()->json([
                'message' => "Successfully Logged in!",
                'user' => $user,
                'token' => $token->plainTextToken

            ]);
        } catch (ValidationException $e) {

            return response()->json([
                'message' => $e->getMessage(),
                'error' => '422'

            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'error' => '404'
            ]);
        }
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json([
                'message' => 'Cannot found  the user with this email address',
            ]);
        }
        $user->password = Hash::make($request->password);
        $token = $user->createToken($user->username);
        $user->save();

        return response()->json([
            'message' => "Successfully reset the password!",
            'user' => $user,
            'token' => $token->plainTextToken
        ]);
    }
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json([
            'message' => "Successfully Logout!",

        ]);
    }
}
