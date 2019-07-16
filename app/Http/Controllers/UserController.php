<?php

namespace App\Http\Controllers;

use App\Model\Country;
use App\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class UserController extends Controller {

    public $successStatus = 200;

    /**
     * UserController constructor.
     * @param int $successStatus
     */
    public function __construct(){
        $this->middleware('auth:api')->only(['get']);
    }


    public function get(){
        return response()->json(Auth::user());
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
            'city' => 'required|string|min:2|max:30',
            'age' => 'required|integer',
            'country_id' => 'required|integer',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        if ($validator->fails()) return response()->json(['error'=>$validator->errors()], 401);

        $input = $request->all();
        $counry = Country::find($input['country_id']);
        if (!$counry) return response()->json(['error'=>'Sorry, country not found'], 401);
        $input['password'] = bcrypt($input['password']);
        $user = new User($input);
        $user->save();

        $success['token'] =  $user->createToken('BlogApp')->accessToken;
        $success['fname'] =  $user->fname;
        return response()->json(['success'=>$success], $this->successStatus);
    }

}
