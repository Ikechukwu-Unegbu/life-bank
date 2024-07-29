<?php

namespace App\Http\Controllers;
use App\Http\Requests\CreateUserRequest;
use App\Models\User;
use App\Service\UserService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;


class UserController extends Controller
{

    public function __construct(
        public UserService $userService
    )
    {
        
    }


    public function store(CreateUserRequest $request)
    {
       try{
            $newUser = $this->userService->createUser($request);
            return response()->json([
                'user'=>$newUser,
                'message'=>'user user created'
            ], 200);
       }catch(\Exception $e){

       }
    }

 
    public function index(Request $request){
        try {
            $users = $this->userService->fetchAllUsers($request);
            return response()->json($users, 200);
        }
    
        catch (\Exception $e) {
            Log::error('Unexpected error while fetching users: ' . $e->getMessage());
            return response()->json([
                'error' => 'Unexpected error',
                'message' => 'An unexpected error occurred',
            ], 500);
        }
    }

}
