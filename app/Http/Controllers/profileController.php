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
        $validateRules=[
            'username'      =>  'required',
            'email'         =>  'required',
            'oldPass'       =>  'required',

        ];
        $error= Validator::make($request->all(),$validateRules);
        if($error->fails()){
            return redirect()->back()->withErrors(['errors' => $error->errors()->all()]);

            return \Response::json(['errors'=>$error->errors()->all()]);
        }
        $credentials  = array('email' => $request->email, 'password' => $request->oldPass);

        if (Auth::attempt($credentials, $request->has('remember'))){
            $dubleUserName=User::where([['name','=',$request->username],['id','!=',Auth::user()->id]])->get()->first();
            if($dubleUserName !=null){
                return redirect()->back()->withErrors(['username' => 'this username allredy existed']);
                return \Response::json(['errors'=>'try another username']);
            }
            $dubleEmail=User::where([['email','=',$request->email],['id','!=',Auth::user()->id]])->get()->first();
            if($dubleEmail !=null){
                return redirect()->back()->withErrors(['email' => 'this email allredy existed']);

                return \Response::json(['errors'=>'the email allredy existed']);
            }
            if($request->newPass != null)
            {
                $validateRules=[
                    'newPass'               =>  'required|min:8',
                    'repeatNewPass'         =>  'required|same:newPass',
                ];
                $error= Validator::make($request->all(),$validateRules);
                if($error->fails()){
                    return redirect()->back()->withErrors(['passwords' => 'the passwords must matches']);
                    return \Response::json(['errors'=>$error->errors()->all()]);
                }
                $update = \DB::table('users') ->where( 'id','=', Auth::user()->id )->limit(1)->update(
                    [
                        'name'              => $request->username,
                        'password'          => Hash::make($request->newPass),
                        'email'             => $request->email,
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
                    ]
                );
                return redirect(route('myPosts'));

            }
        }
        return redirect()->back()->withErrors(['password' => 'incorrect password']);

        return \Response::json(['errors'=>'incorrect password']);

        return redirect(route('postDetails',['post_id'=>$request->id]));
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
        ];
        $error= Validator::make($request->all(),$validateRules);
        if($error->fails()){
            return redirect()->back()->withErrors(['errors' => $error->errors()->all()]);

            return \Response::json(['errors'=>$error->errors()->all()]);
        }
        $credentials  = array('email' => $request->email, 'password' => $request->currentPass);
        $user = User::where('api_token', $request->api_token)->first();
        if($user->email_verified_at==''){
            return \Response::json(['errors' => 'error access', 'message' => 'please active your account to access']);
        }
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
                return \Response::json(['errors'=>'the email allredy existed try another']);
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
                    ]
                );
                return \Response::json(['success'=>'profile updated']);
            }
            else{
                $update = \DB::table('users') ->where( 'id','=', $user->id ) ->limit(1) ->update(
                    [
                        'name'              => $request->username,
                        'email'             => $request->email,
                    ]
                );
                return \Response::json(['success'=>'profile updated']);
            }
        }
        return \Response::json(['errors'=>'incorrect password']);
    }

}
