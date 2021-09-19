<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApiLoginRequest;
use App\Http\Requests\ApiRegisterRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ApiUserController extends Controller
{
    //
    public function register(Request $request)
    {
        $user = User::whereEmail($request->email)->first();
        if ($user) {
            return response()->json(['email' => 'email đã có người sử dụng'], 401);
        }
        $user = new User();
        $user->fill($request->all());
        $user->password = Hash::make($request->password);

        $user->save();
        return response()->json($user);
    }

    public function login(ApiLoginRequest $request)
    {

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = User::whereEmail($request->email)->first();
            $user->token = $user->createToken('app')->accessToken;
            return response()->json($user);
            
        }
        return response()->json(['email' => 'Sai ten tai khoan hoac mat khau'], 401);
    }

    public function userInfo(Request $request)
    {
        return response()->json($request->user('api'));
    }

    public function getNumberUsers()
    {
        $user_number = User::all()->count();

        return response()->json(['user_number' => $user_number]);
    }

    public function getAllUsers()
    {
        $user_list = User::latest()->paginate(10);
        return response()->json(['user_list' => $user_list]);
    }

    public function changeRoleUser(Request $request)
    {
        $user = User::find($request->user_id);
        $user->role_id = $request->role_id;
        $user->save();
        return response()->json(['message' => 'thay đổi quyền thành công']);
    }

    public function updateInfo(Request $request, $id)
    {
        $error_array = [];
        $user = User::find($id);
        $old_email = $user->email;
        
        if ($request->is_change_pass == true) {
            if (Auth::attempt(['email'=>$old_email,'password' => $request->old_password])) {
                $user->password = Hash::make($request->new_password);
            } else {
                array_push($error_array, "password không chính xác");
            }
        }
        if ($request->email != $user->email) {
            $count = User::where('email', $request->email)->count();
            if ($count > 0) {
                array_push($error_array, "email đã tồn tại");
            } else {
                $user->email = $request->email;
            }
        } 
        $user->name = $request->name;
        $user->phone_number = $request->phone_number;
        $user->gender = $request->gender;
        $user->save();

        if(count($error_array)==0){
            return response()->json(['message'=>['thay đổi thông tin thành công']]);
        }
        return response()->json(["message"=>$error_array]);
    }

    public function getUserInfoById($id){
        $user =User::find($id);
        return response()->json($user);
    }
}
