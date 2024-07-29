<?php 
namespace App\Service;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserService{
    

    public function createUser(Request $request)
    {
        $hashedPassword = Hash::make($request->validated()['password']);
        return User::create([
            'name'=>$request->validated()['name'],
            'email'=>$request->validated()['email'],
            'password'=>$hashedPassword
        ]);
    }

    public function fetchAllUsers(Request $request)
    {
        $perPage = $request->input('per_page', 20);

        if (!is_numeric($perPage) || $perPage <= 0) {
            return response()->json([
                'error' => 'Invalid per_page parameter',
                'message' => 'The per_page parameter must be a positive integer',
            ], 400);
        }

        $users = User::orderBy('name', 'asc')->paginate($perPage);
        return $users;
    }
}