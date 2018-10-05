<?php 
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Fanpage;
use Validator;
class FanpageController extends Controller {

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
	public function checkSession(){
		$page_id = session('page_id');
		return $page_id;
	}
	public function index(Request $request)
	{
        $action = $request->action;
        if ($action == 'select') {
            $id = $request->id;
            session(['facebookPage' => $id]);
            session(['page_id' => $request->fanpage_id]);
            return redirect('keyword');
        } else {

            $facebookPages =  DB::table('fanpages')->paginate(100);

            return view('Fanpage.fbpage', array(
                'facebookPages' => $facebookPages
            ));
        }
	}
	public function list()
	{
		$fanpages = DB::table('fanpages')->paginate(10);
		return view('Fanpage.list',[
			'fanpages' => $fanpages
		]);
	}
	public function add_pages(Request $request){
		if($request->isMethod('post')){
			$validator = Validator::make($request->all(), [
				'name' => 'required',
				'fanpage_id' => 'required',
			]);
			if($validator->fails()){
				return redirect('Fanpage/add_pages')
				->withErrors($validator)
				->withInput();
			}else{
				$input = Input::all();
				DB::table('fanpages')->insert(
					[
						'name' => $input['name'],
						'fanpage_id' => $input['fanpage_id'],
						'page_accesstoken' => $input['page_access_token'],
					]
				);
				\Session::flash('success','Lưu thành công.');
			return redirect('/');
			}
		}
		return view('Fanpage.add_page');
	}
	public function delete($id){
		if(!empty($id)){
			DB::table('fanpages')->where('id', '=', $id)->delete();
			\Session::flash('success','Xóa thành công.');
			return redirect('/');
		}
	}
	public function edit(Request $request,$id){
		if(!empty($id)){
			if($request->isMethod('post')){
			$input = Input::all();
			DB::table('fanpages')
            ->where('id', $id)
            ->update([
				'name' => $input['name'],
				'fanpage_id' => $input['fanpage_id'],
				'page_accesstoken' => $input['page_access_token']
				]);
				\Session::flash('success','Lưu thành công.');
				return redirect('/');
			}
			$fanpage = DB::table('fanpages')->where('id', '=', $id)->first();
			return view("Fanpage.add_page",['fanpage'=>$fanpage]);
		}
	}
	public function hello($id){

		$fanpage_info = DB::table('fanpages')->where('fanpage_id','=',$id)->first();
		$access_token = $fanpage_info->page_accesstoken;
		$service_url = "https://graph.facebook.com/v2.8/me/messenger_profile?access_token=$access_token";
		$data = array(
			"get_started"=>array(
				"payload"=> "Bắt đầu"
			)
		);
            $curl = curl_init($service_url);
            curl_setopt($curl, CURLOPT_URL,$service_url);
            curl_setopt($curl, CURLOPT_VERBOSE, 1);
            curl_setopt($curl, CURLOPT_TIMEOUT, 10);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            curl_setopt($curl, CURLOPT_POSTFIELDS,json_encode($data));
            $curl_response = curl_exec($curl);
			curl_close($curl);
			\Session::flash('success','Thành công.');
			return redirect('/'); 
	}
	public function choose(Request $request,$id){
		$page_id = session('page_id');
		$fanpage_info = DB::table('fanpages')->where('fanpage_id','=',$id)->first();
		if(!empty($fanpage_info)){
			$request->session()->put('page_id',$id);
			\Session::flash('success','Lưu thành công.');
			// $request->session()->forget('key');
			return redirect('Fanpage/list'); 
		}
	}
}
