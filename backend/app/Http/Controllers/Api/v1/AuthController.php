<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Mail\ResetPasswordMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function __construct(User $user)
    {
        $this->middleware(['auth:sanctum'])->only('details', 'updateProfile', 'updatePassword');
        $this->user = $user;
    }
    /**
     * Registration
     */
    public function register(UserRequest $request)
    {
         try {

            $postData = $request->all(); ;
            $user = new User($postData);
            $user->password = bcrypt($postData['password']);
            $user->save();

            return response()->json(['status' => true,'data' => $user], Response::HTTP_OK);
        }catch (\Exception $e){
            return response()->json(['status' => false,'message' => $e->getMessage()],Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    /**
     * Login
     */
    public function login(Request $request)
    {
        $key = $value = '';
        if (request('user_email')) {
            $key = 'email';
            $value = request('user_email');
        } else if (request('user_name')) {
            $key = 'user_name';
            $value = request('user_name');
        }

        $data = [
            $key => $value,
            'password' => $request->password
        ];

        if (auth()->attempt($data)) {
            $token = auth()->user()->createToken('user')->plainTextToken;
             $this->user->setLastLoginAndIP(request());
            return response()->json([
                'status' => true,
                'user' => new UserResource(auth()->user()),
                'token' => $token
            ], Response::HTTP_OK);

        } else {
            return response()->json(['status' => false,'message' => 'Unauthorised'], Response::HTTP_UNAUTHORIZED);
        }
    }

    public function details()
    {
        $user = Auth::user();
        return response()->json(['user' => new UserResource($user)]);
    }
    public function updateProfile(Request $request)
    {
        //dd($request);
        $user = Auth::user();
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->address = $request->address;
        $user->zipcode = $request->zipcode;
        $user->country = $request->country;
        $user->update();

        return response()->json(['status'=>true,'user' => $user],Response::HTTP_OK);
    }
    public function updatePassword(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'old_password' => 'required',
                'password' => 'required|string|min:8',
                'confirm_password' => 'required|same:password'
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => false,'message' => $validator->errors()], Response::HTTP_UNAUTHORIZED);
            }
            if (!(Hash::check($request->old_password, Auth::user()->password))) {
                return response()->json([
                    'status' => false,
                    'message' => ['old_password_not_matched' => 'Old password not match']
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }
            if (strcmp($request->old_password, $request->password) == 0) {
                return response()->json([
                    'status' => false,
                    'message' => ['new_password_same' => 'New password same as current password']
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }
            $user = Auth::user();
            $user->password = bcrypt($request->get('password'));
            $user->update();

            $token = auth()->user()->createToken('user')->plainTextToken;
            return response()->json([
                'status' => true,
                'message' => 'Password change successfully',
                'user' => auth()->user(),
                'token' => $token
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
             ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function passwordForget(Request $request)
    {
        try {
            $user =  User::where('email', $request->email)->first();
            if (filled($user)) {
                return response()->json([
                    'status' => false,
                    'message' => ['user_not_found' => 'User not found']
                ], Response::HTTP_NOT_FOUND);
            }
            DB::table('password_resets')->insert([
                'email' => $request->email,
                'token' => Str::random(60),
                'created_at' => Carbon::now()
            ]);
            $tokenData = DB::table('password_resets')->where('email', $request->email)->first();
            $this->sendEmail($tokenData);
            return response()->json(['success' => true,'message' => 'Please check your mail token send']);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function changePassword(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'password_reset_token' => 'required',
                'email' => 'required',
                'password' => 'required',
                'confirm_password' => 'required|same:password'
            ]);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], Response::HTTP_UNAUTHORIZED);
            }
            $table = DB::table('password_resets')->where('token', $request->password_reset_token)->orderBy('created_at', 'DESC')->first();
            if ($table) {
                $user = User::where('email', $request->email)->first();
                if ($user) {
                    $user->password = bcrypt($request['password']);
                    $user->update();
                    $token = auth()->user()->createToken('user')->plainTextToken;
                    return response()->json([
                        'status' => true,
                        'user' => auth()->user(),
                        'token' => $token
                    ], Response::HTTP_OK);
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => 'Password reset token not valid',
                     ], Response::HTTP_INTERNAL_SERVER_ERROR);
                }
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => [$e],
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    protected function sendEmail($user)
    {
        $details = [
            'title' => 'User Reset Password Token',
            'body' => "you reset Password token is  " . $user->token . ".",
            'data' => $user,
        ];

        Mail::to($user->email)->send(new ResetPasswordMail($details));
    }
}
