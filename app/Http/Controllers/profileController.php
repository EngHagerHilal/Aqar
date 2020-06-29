<?php

namespace App\Http\Controllers;

use App\notification;
use App\posts;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
class profileController extends Controller
{
    public function editMyProfile(){

            $notification=[];
        return view('editProfile',[
            'notification'=>count($notification),
            'notificationContent'=>$notification
        ]);
    }

    public function UpdateMyProfile(Request $request){
        $validatedData = $request->validate([
            'username'      =>  'required',
            'email'         =>  'required',
            'oldPass'       =>  'required',
            'phone'         =>  'required',

        ]);
        $credentials  = array('email' => $request->email, 'password' => $request->oldPass);

        if (Auth::attempt($credentials)){
            $dubleUserName=User::where([['name','=',$request->username],['id','!=',Auth::user()->id]])->get()->first();
            if($dubleUserName !=null){
                return redirect()->back()->withErrors(['username' => 'this username allredy existed']);
            }
            $dubleEmail=User::where([['email','=',$request->email],['id','!=',Auth::user()->id]])->get()->first();
            if($dubleEmail !=null){
                return redirect()->back()->withErrors(['email' => 'this email allredy existed']);
            }
            if($request->newPass != null)
            {
                $validatedData = $request->validate([
                    'newPass'               =>  'required|min:8',
                    'repeatNewPass'         =>  'required|same:newPass',
                ]);

                $update = \DB::table('users') ->where( 'id','=', Auth::user()->id )->limit(1)->update(
                    [
                        'name'              => $request->username,
                        'password'          => Hash::make($request->newPass),
                        'email'             => $request->email,
                        'phone'             => $request->phone,
                    ]
                );
                return redirect(route('myPosts'));
            }
            else{
                $update = \DB::table('users') ->where( 'id','=', Auth::user()->id ) ->limit(1) ->update(
                    [
                        'name'              => $request->username,
                        'password'          => Hash::make($request->oldPass),
                        'email'             => $request->email,
                        'phone'             => $request->phone,
                    ]
                );
                return redirect(route('myPosts'));
            }
        }
        return redirect()->back()->withErrors(['oldPass' => 'incorrect password']);
    }

    public function EditMyProfileAPI(Request $request){
        $validateRules = [
            'api_token' => 'required',
        ];
        $error = Validator::make($request->all(), $validateRules);
        if ($error->fails()) {
            return \Response::json(['errors' => $error->errors()->all()]);
        }
        $user = User::where('api_token', $request->api_token)->first();
        if ($user == null) {
            return \Response::json(['errors' => 'error login', 'message' => 'please login and active your account to access']);
        }

        if($user->email_verified_at==''){
            return \Response::json(['errors' => 'error access', 'message' => 'please active your account to access']);
        }
        else{
            return $user;
        }
    }

    public function UpdateMyProfileAPI(Request $request){
        $validateRules=[
            'api_token'     => 'required',
            'username'      =>  'required',
            'email'         =>  'required',
            'currentPass'   =>  'required',
            'phone'         =>  'required',
        ];
        $error= Validator::make($request->all(),$validateRules);
        if($error->fails()){
            return \Response::json(['errors'=>$error->errors()->all()]);
        }
        $credentials  = array('email' => $request->email, 'password' => $request->currentPass);
        $user = User::where('api_token', $request->api_token)->first();
        if($user->email_verified_at==''){
            return \Response::json(['errors' => 'error access', 'message' => 'please active your account to access']);
        }
        if (Auth::attempt($credentials, $request->has('remember'))){
            $dubleUserName=User::where([['name','=',$request->username],['id','!=',$user->id]])->first();
            if($dubleUserName ){
                return \Response::json(['errors'=>'try another username']);
            }
            $dubleEmail=User::where([['email','=',$request->email],['id','!=',$user->id]])->first();
            if($dubleEmail !=null){
                return \Response::json(['errors'=>'the email existed try another']);
            }
            if($request->newPass != null)
            {
                $validateRules=[
                    'newPass'               =>  'required|min:8',
                    'confirmedNewPass'      =>  'required|same:newPass',
                ];
                $error= Validator::make($request->all(),$validateRules);
                if($error->fails()){
                    return \Response::json(['errors'=>$error->errors()->all()]);
                }
                $update = \DB::table('users') ->where( 'id','=', $user->id )->limit(1)->update(
                    [
                        'name'              => $request->username,
                        'password'          => Hash::make($request->newPass),
                        'email'             => $request->email,
                        'phone'             => $request->phone,
                    ]
                );
                return \Response::json(['success'=>'profile updated']);
            }
            else{
                $update = \DB::table('users') ->where( 'id','=', $user->id ) ->limit(1) ->update(
                    [
                        'name'              => $request->username,
                        'email'             => $request->email,
                        'phone'             => $request->phone,
                    ]
                );
                return \Response::json(['success'=>'profile updated']);
            }
        }
        return \Response::json(['errors'=>'incorrect password']);
    }

}
