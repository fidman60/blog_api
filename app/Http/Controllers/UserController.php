<?php

namespace App\Http\Controllers;

use App\Model\Country;
use App\Model\User;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class UserController extends Controller {

    public $successStatus = 200;
    private $userRepository;

    /**
     * UserController constructor.
     * @param int $successStatus
     */
    public function __construct(UserRepository $userRepository){
        $this->middleware('auth:api')->only(['get', 'uploadImage']);
        $this->userRepository = $userRepository;
    }


    public function get(){
        return response()->json(Auth::user());
    }

    public function uploadImage(Request $request){
        $validator = Validator::make($request->all(), [
            "image" => "required|image|mimes:jpeg,png,jpg|max:2048",
        ]);

        if ($validator->fails()) return response()->json(['error'=>$validator->errors()], 401);

        $image = $this->userRepository->saveImage(request()->image, Auth::id());

        if ($image){
            return response()->json(['image'=>$image]);
        }

        return response()->json(['error'=>"Image not uploaded correctly"], 500);
    }

    /**
     * login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(){
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
            $user = Auth::user();
            $success['token'] =  $user->createToken('BlogApp')->accessToken;
            $success['user'] = $user;
            return response()->json(['success' => $success], $this->successStatus);
        } else{
            return response()->json(['error'=>'Unauthorised'], 401);
        }
    }

    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fname' => 'required|string|min:2|max:30',
            'lname' => 'required|string|min:2|max:30',
            'gender' => 'required|boolean',
            'birth_date' => 'required|date',
            'country_id' => 'required|integer|exists:countries,id',
            'email' => 'required|unique:users,email|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        if ($validator->fails()) return response()->json(['error'=>$validator->errors()], 401);

        $input = $request->all();
        $input['birth_date'] = Carbon::parse($input['birth_date'])->format('Y-m-d');
        $input['password'] = bcrypt($input['password']);

        $user = new User($input);
        $user->save();

        $success['token'] =  $user->createToken('BlogApp')->accessToken;
        $success['fname'] =  $user->fname;
        return response()->json(['success'=>$success], $this->successStatus);
    }

}
