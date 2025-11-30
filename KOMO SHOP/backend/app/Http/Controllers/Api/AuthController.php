<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller {
    public function register(Request $request) {
        $data = $request->validate([
            'name'=>'required|string',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:6'
        ]);
        $user = User::create([
            'name'=>$data['name'],
            'email'=>$data['email'],
            'password'=>Hash::make($data['password'])
        ]);
        // For SPA with Sanctum, you'd issue token or use session cookie flow
        return response()->json(['user'=>$user], 201);
    }
    public function login(Request $request) {
        $creds = $request->validate([ 'email'=>'required|email', 'password'=>'required' ]);
        $user = User::where('email', $creds['email'])->first();
        if (!$user || !Hash::check($creds['password'], $user->password)) {
            return response()->json(['message'=>'Invalid credentials'], 401);
        }
        // Example: create token (personal access token) - requires Laravel Passport or Sanctum setup
        $token = $user->createToken('api-token')->plainTextToken ?? null;
        return response()->json(['user'=>$user, 'token'=>$token]);
    }
    public function logout(Request $request) {
        // revoke token or logout session
        if ($request->user()) {
            $request->user()->currentAccessToken()->delete();
        }
        return response()->json(['message'=>'Logged out']);
    }
}
