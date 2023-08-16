<?php

namespace App\Http\Controllers\API\V1;

 
use App\Http\Resources\Admin\V1\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use SebastianBergmann\Comparator\Factory;
use Illuminate\Support\Str;
/**
 * Class UsersAPIController
 * @package App\Http\Controllers\API\Admin
 */
class UsersAPIController extends AppBaseController
{
     
    public function __construct(){
        $this->middleware('auth:api', ['except' => ['login', 'register', 'logout']]);
    } 

    public function index(Request $request)
    {

        $query = User::query();

        if ($request->get('skip') && $request->get('limit')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        } 

        $users = $query->get();
 
        return $this->sendResponse(
            UserResource::collection($users),
            __('lang.api.retrieved', ['model' => __('users.plural')])
        );
    }

    public function login()
    { 
  
        $credentials = request(['email', 'password']);
 
        if (! $token = Auth::guard('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
 
        return $this->respondWithToken($token);
    }

    public function respondWithToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer', 
            'user' => Auth::guard('api')->user()
        ]);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
        //array_merge($validator->validated(), 
        $user =  User::create([
            'name' => $request->name,
            'email'=> $request->email,
            'password'=>  Hash::make($request->password),
            'phone' => $request->phone, 
        ]);
 
        return $this->sendResponse(new UserResource($user), "saved successfully");
        
    }

    public function logout(){
        
       // auth()->logout();
        return response()->json([
            'message' => "Logout successfully"
        ]);
    }
 

}
