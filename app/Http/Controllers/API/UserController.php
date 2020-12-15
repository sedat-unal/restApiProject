<?php
namespace App\Http\Controllers\API;
use http\Env\Response;
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
        $input['new_password'] = bcrypt($input['new_password']);
        $sql = DB::table('users')->where('email', $input['email'])->first();
        if($sql){
            $update = DB::table('users')->where('email', $input['email'])->update(['password' => $input['new_password']]);
            if ($update){
                $success['message'] = "User password changed successfully";
                $success['new_password'] = $input['new_password'];
                return response()->json(['success' => $success, $this->successStatus]);
            }else{
                return response()->json(['error' => 'While changing the password its error'], 400);
            }
        }else{
            return response()->json(['error' => 'This email is not registered in our system.'], 404);
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
        $success['message'] = "User successfully registered";
        $success['token'] =  $user->createToken('MyApp')->accessToken;
        $success['name'] =  $user->name;
        return response()->json(['success'=>$success], $this->successStatus);
    }
    /**
     * details api
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function details()
    {
        // Get all users or only one user details. http://127.0.0.1:8000/api/details?id=all or http://127.0.0.1:8000/api/details?id=number
        $id = $_GET['id'];
        if ($id == "all")
        {
            $queryAll = DB::table('users')->get();
            foreach ($queryAll as $row)
            {
                $users[] = $row;
            }
            return response()->json([$users], $this->successStatus);
        }
        $query = DB::table('users')->find($id);
        return response()->json([$query], $this->successStatus);
    }
}
