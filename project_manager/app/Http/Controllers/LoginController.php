<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator;
use App\Login;
use Illuminate\Http\RedirectResponse;

class LoginController extends Controller
{
	//routes from login page and home,forgot password and register
	public function index(){
		return view('login');
	}
	//function that checks db data;
	public function check_user($req){
			$password = $req->post('password');
			$pin = hash("sha256",$password,false);
			$username = $req->post('username');
			$user_exist = Login::where('username',$username)->where('password',$pin)->get();
			if(empty($user_exist)){
				return false;
			}
			else{
				return $user_exist;
			}

	}
	//login function accessed as api.
	public function login(Request $request){
		try{
			$validator = Validator::make($request->all(), [
            	'username' => 'required',
            	'password' => 'required|min:8',
        	]);
			if(!$validator->fails()){
				$checked = $this->check_user($request);
				if($checked){
					session(['username' => $request->post('username'),'type'=>$checked[0]->type]);
					$data =array("message"=>200, "type" => $checked[0]->type);

					return response()->json($data);
				}
				else{
					$data =["message"=>404];
					return response()->json($data);
				}
			}
			else{
				return response()->json(["message"=>403]);
			}
		}
		catch(Exception $e){
			report($e);
		}
	}
	function check_email($email){

	}
	public function forgot_password(Request $request){
		try{
			$validator = Validator::make($request->all(),[
				'user_email'=>'required|email'
			]);
			if($validator->fails()){
				$data = ["message"=>"invalid email or action"];
				return response()->json($error);
			}
			else{
				$check_user_email = $this->check_user($request->post('user_email'));
				if($check_user_email){

				}
				else{

				}
			}
		}
		catch(Exception $e){
			report($e);
		}
	}
}
