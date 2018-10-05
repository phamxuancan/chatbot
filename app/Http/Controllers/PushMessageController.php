<?php 
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\PushMessage;
use Validator;
class PushMessageController extends Controller {

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
	public function list()
	{
		$page_id = $this->checkSession();
        if($page_id){
			$pushMessages = DB::table('push_messages')->where('fanpage_id','=',$page_id)->orderBy('pushed_time', 'asc')->orderBy('id', 'asc')->paginate(20);
			return view('PushMessage.list',[
				'pushMessages' => $pushMessages
			]);
		}else{
			\Session::flash('error','Bạn hãy chọn fanpage.');
			return redirect('/');
		}
	}
	public function list_user()
	{
		$users = DB::table('user_fanpages')->paginate(10);
		return view('PushMessage.list_user',[
			'users' => $users
		]);
	}
	public function add(Request $request){
		$page_id = $this->checkSession();
			if($page_id){
				if($request->isMethod('post')){
				$validator = Validator::make($request->all(), [
					'title' => 'required',
					'message' =>'required'
				]);
				if($validator->fails()){
					return redirect('PushMessage/add')
					->withErrors($validator)
					->withInput();
				}else{
					$input = Input::all();
					date('Y-m-d H:i:s',strtotime($input["schedule_time"]));
					$fanpage = new PushMessage;
					$fanpage->title = $input['title'];
					$fanpage->fanpage_id = $page_id;
					$fanpage->message = $input['message'];
					if(!empty($input["schedule_time"])){
						$fanpage->schedule_time = $input["schedule_time"];
						$fanpage->status = 3;
					}else{
						$fanpage->status = 0;
					}
					$fanpage->save();
					\Session::flash('success','Lưu thành công.');
				return redirect('PushMessage/list');
				}
			}
			$fanpage = DB::table('fanpages')->where('fanpage_id', '=', $page_id)->first();
			return view('PushMessage.add',['fanpage'=> $fanpage]);
		}else{
			\Session::flash('error','Bạn hãy chọn fanpage.');
			return redirect('/');
		}
	}
	public function delete($id){
		if(!empty($id)){
			DB::table('push_messages')->where('id', '=', $id)->delete();
			\Session::flash('success','Xóa thành công.');
			return redirect('PushMessage/list');
		}
	}
	public function edit(Request $request,$id){
		$date = date('Y-m-d H:i:s');
		$pushMessages = DB::table('push_messages')->where('schedule_time','<=', $date)->where('status','=' ,3)->first();
		dd($pushMessages);
		if(!empty($id)){
			$page_id = $this->checkSession();
			if($request->isMethod('post')){
			$input = Input::all();
			$array_save = [
				'title' => $input['title'],
				'fanpage_id' => $page_id,
				'message' => $input['message']
			];
			if(!empty($input["schedule_time"])){
				$array_save = array_merge($array_save,array('status'=>3,'schedule_time' => $input["schedule_time"] ));
			}
			DB::table('push_messages')
            ->where('id', $id)
            ->update($array_save);
				\Session::flash('success','Lưu thành công.');
				return redirect('PushMessage/list');
			}
			$fanpage = DB::table('push_messages')->where('id', '=', $id)->first();
			return view("PushMessage.add",['fanpage'=>$fanpage]);
		}
	}
	public function publish(Request $request,$id){
		if(!empty($id)){
			
			$input = Input::all();
			DB::table('push_messages')
            ->where('id', $id)
            ->update([
				'status' => 1,
				]);
				\Session::flash('success','Publish thành công.');
				return redirect('PushMessage/list');
			
		}
	}
	public function unpublish(Request $request,$id){
		if(!empty($id)){

			$input = Input::all();
			DB::table('push_messages')
            ->where('id', $id)
            ->update([
				'status' => 0,
				]);
				\Session::flash('success','UnPublish thành công.');
				return redirect('PushMessage/list');
			
		}
	}
	public function send($id){
		if(!empty($id)){
			$fanpage_push = DB::table('push_messages')->where('id','=',$id)->first();
			$fanpage = DB::table('fanpages')->where('fanpage_id','=',$fanpage_push->fanpage_id)->first();
			$page_accessToken = $fanpage->page_accesstoken;
			$users = DB::table('user_fanpages')->select('facebook_id')->where('fanpage_id','=',$fanpage_push->fanpage_id)->groupBy('facebook_id')->get();
			if(count($users) && !empty($page_accessToken)){
				$user_send = 0;
				foreach($users as $user){
					try{
					$messageData =array('recipient'=>array('id'=>$user->facebook_id),'message'=>array('text'=>$fanpage_push->message));
					$request = array(
						'header' => array('Content-Type' => 'application/json')
					);
					$service_url = "https://graph.facebook.com/v2.8/me/messages?access_token=$page_accessToken";
					$curl = curl_init($service_url);
					curl_setopt($curl, CURLOPT_URL,$service_url);
					curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
					curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
					curl_setopt($curl, CURLOPT_POST, 1);
					curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
					curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
					curl_setopt($curl, CURLOPT_POSTFIELDS,json_encode($messageData));
					$curl_response = curl_exec($curl);
					curl_close($curl);
					$response_result = json_decode($curl_response);
					if(isset($response_result->error)){
						Log::error('Lỗi gửi tin nhắn' . json_encode($response_result) .'data send' .json_encode($messageData));
					}else{
						$user_send++;
						var_dump($response_result);
						\Session::flash('success','Gửi thành công');
						// return redirect('PushMessage/list');
					}
				}catch (Exception $e){
					Log::error('Khong gui dc message' . $e->getMessage());
					\Session::flash('error','Gửi không thành công');
				}
				}
				DB::table('push_messages')
					->where('id', $id)
					->update([
					'status' => 2,
					'send_user' => $user_send,
					'pushed_time' => date('Y-m-d H:i:s')
				]);
				return redirect('PushMessage/list');
			}else{
				\Session::flash('error','Không có user nào hoặc chưa có page accesstoken!');
				return redirect('PushMessage/list');
			}
		}
	}
	public function checkSession(){
        return session('page_id');
    }
}
