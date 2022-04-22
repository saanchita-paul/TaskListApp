<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;
use Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $rules = [
            'name' => 'unique:users|required',
            'email'    => 'unique:users|required',
            'password' => 'required',
            'role' => 'required',
        ];
    
        $input = $request->only('name', 'email','password', 'role');
        $validator = Validator::make($input, $rules);
    
        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->messages()]);
        }
        $name = $request->name;
        $email    = $request->email;
        $password = $request->password;
        $role = $request->role;
    
        $user = User::create(['name' => $name, 'email' => $email, 'role' => $role, 'password' => Hash::make($password)]);
        
        $token=$user->createToken('myapptoken')->plainTextToken;
            $response=[
                'message' => 'Registartion Successful',
                'user'=>$user,
                'token'=>$token
            ];
            return response($response,201);
    }

    public function login(Request $request)
        {
        if (!Auth::attempt($request->only('email', 'password'))) {
        return response()->json([
        'message' => 'Invalid login details'
                ], 401);
            }
        $user = User::where('email', $request['email'])->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
                'message' => 'You are successfully logged in',
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user details' => $user,
        ]);
        }

    public function logout(){
        auth()->user()->currentAccessToken()->delete();
        return response ([
            'message' =>'Successfully Logged Out'
        ]); 
    }
}
