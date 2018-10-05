<?php namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
class UserController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Welcome Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('welcome');
	}
	public function login(Request $request){
		if($request->isMethod('post')){
			$input = Input::all();
			if (Auth::attempt(['email' => $input['email'], 'password' => $input['password']])) {
				// The user is active, not suspended, and exists.
				return redirect('/');
			}else{
				\Session::flash('error','Sai email hoặc password');
			}
			
		}
		return view('login');
	}
	public function creatUser(){
		$array = array(
			'name' =>'admin',
			'email' =>'chatbot@chatbot.com',
			'password' => Hash::make('Chatbot@123')
		);
		DB::table('users')->insert($array);
	}
	public function logout(){
		Auth::logout();
		return redirect('login');
	}
}
