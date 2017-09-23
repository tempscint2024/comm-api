<?php

namespace App\Http\Controllers\api\v1;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthenticateController extends Controller
{
    public function registerUser (Request $request) {

        $validator = Validator::make($request->all(), [
            'firstName' => 'required|string',
            'lastName' => 'required|string',
            'email' => 'required|email',
            'phoneNumber' => 'required|string|max:20',
            'sex' => 'required|string|max:1',
            'dateOfBirth' => 'required|date',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors()->all();

            return response()->json([
                "errors" => $errors
            ], 400) ;
        }
        $user  = new User();
        $user->firstName = $request->get('firstName');
        $user->lastName = $request->get('lastName');
        $user->email = $request->get('email');
        $user->sex = $request->get('sex');
        $user->phoneNumber = $request->get('phoneNumber');
        $user->dateOfBirth = $request->get('dateOfBirth');
        $user->slug =  str_slug($request->get('name')." ".rand(10000,900000)." ".rand(10000,900000)." ".rand(10000,900000));
        $user->password = bcrypt($request->get('password')) ;

        $user->save();

        return $this->login($request);

    }

    public function registerMerchant () {

    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required'
        ]);

        if ($validator->fails()) {

            $errors['errors'] = $validator->errors()->all();

            return response()->json($errors, 401) ;
        }

        // grab credentials from the request
        $credentials = $request->only('email', 'password');



        try {
            // attempt to verify the credentials and create a token for the user

            if (!$token = JWTAuth::attempt($credentials)) {

                return response()->json([
                    'error' => 'Invalid Credentials',
                    "meta" => [
                        "status" =>  "INVALID_CREDENTIALS"
                    ]
                ],
                    401);
            }



        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(
                [
                    'error' => 'Error when trying to create a token',
                    "meta" => [
                        "status" =>  "COULD_NOT_CREATE_TOKEN"
                    ]
                ],
                500);
        }

        $user = User::all()->where('email', $request->get('email'))->first();

        $refreshTokenExpiry = Carbon::now()->addWeek()->timestamp;
        $tokenExpiry = Carbon::now()->addHour(1)->timestamp;


        return response()->json(
            [
                'message' => 'A token was generated',
                'auth' => [
                    'token' => $token,
                    'token_exp' => $tokenExpiry,
                    'refresher_exp' => $refreshTokenExpiry
                ],
                'user' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'slug' => $user->slug
                ],
                "meta" => [
                    "status" =>  "TOKEN_GENERATED"
                ]
            ],
            200
        );

    }

}
