<?php
namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public $successStatus = 200;

    public function post_ResetPassword(Request $request){
        $input = $request->all();
        $input['old_password'] = bcrypt($input['old_password']);
        $input['new_password'] = bcrypt($input['new_password']);
        $sql = DB::table('users')->where('email', $input['email'])->first();
        if($sql){
            $update = DB::update('UPDATE users SET users.password = "'. $input['new_password'] .'" WHERE users.email = "'. $input['email'] .'" ');
            if ($update){
                $success['message'] = "User password changed successfully";
                $success['new_password'] = $input['new_password'];
                return response()->json(['success' => $success, $this->successStatus]);
            }
        }
    }

    public function post_Login(){
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
            $user = Auth::user();
            $success['message'] = "User login successfully";
            $success['token'] = $user->createToken('MyApp')->accessToken;
            return response()->json(['success' => $success, $this->successStatus]);
        }
        else{
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }

    public function post_Register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['message'] = "User registrated successfully";
        $success['token'] =  $user->createToken('MyApp')->accessToken;
        $success['name'] =  $user->name;
        return response()->json(['success'=>$success], $this->successStatus);
    }
    /**
     * details api
     *
     * @return \Illuminate\Http\Response
     */
    public function details()
    {
        $user = Auth::user();
        return response()->json(['success' => $user], $this-> successStatus);
    }
}
