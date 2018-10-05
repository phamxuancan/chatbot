<?php 
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Validator;
use Auth;
class GiftcodeFanpagesController extends Controller {

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
			$giftcodes = DB::table('fanpage_giftcodes')->where('fanpage_id','=',$page_id)->paginate(10);
			return view('GiftcodeFanpages.list',[
				'giftcodes' => $giftcodes
			]);
		}else{
			\Session::flash('error','Bạn hãy chọn fanpage.');
			return redirect('/');
		}
	}
	public function add(Request $request){
		$page_id = $this->checkSession();
			if($request->isMethod('post')){
				$input = Input::all();
				$list_code = file_get_contents($_FILES['giftcode']['tmp_name']);
				$giftcodes = explode("\n", $list_code);
				if(!empty($giftcodes)){
					$last_id = DB::table('fanpage_giftcodes')->insert(
                        [
                            'title' => $input['title'],
                            'description' => $input['description'],
                            'start_time' => $input['start_time'],
                            'end_time' => $input['end_time'],
							'fanpage_id' =>  $page_id,
							'count_code' =>  count($giftcodes)
                        ]
					);
					foreach( $giftcodes as $code ){
						DB::table('giftcodes')->insert(
							[
								'fanpage_giftcode_id' => $last_id,
								'giftcode' => $code,
								'facebook_id' => 0,
							]
						);
					}
					\Session::flash('success','Thêm giftcode thành công.');
					return redirect('GiftcodeFanpages/list');
				}else{
					\Session::flash('error','Giftcode không có.');
				}
			}
		$fanpage = DB::table('fanpages')->where('fanpage_id', '=', $page_id)->first();
		return view('GiftcodeFanpages.add',['fanpage'=>$fanpage]);
	}
	public function delete($id){
		if(!empty($id)){
			DB::table('fanpage_giftcodes')->where('id', '=', $id)->delete();
			\Session::flash('success','Xóa thành công.');
			return redirect('GiftcodeFanpages/list');
		}
	}
	public function edit(Request $request,$id){
		if(!empty($id)){
			if($request->isMethod('post')){
			$input = Input::all();
			DB::table('fanpage_giftcodes')
            ->where('id', $id)
            ->update([
					'title' => $input['title'],
					'description' => $input['description'],
					'start_time' => $input['start_time'],
					'end_time' => $input['end_time'],
				]);
				\Session::flash('success','Lưu thành công.');
				return redirect('GiftcodeFanpages/list');
			}
			$fanpage_giftcodes = DB::table('fanpage_giftcodes')->where('id', '=', $id)->first();
			$page_id = $this->checkSession();
			$fanpage = DB::table('fanpages')->where('fanpage_id', '=', $page_id)->first();
			return view("GiftcodeFanpages.add",['fanpage'=>$fanpage,'fanpage_giftcodes'=>$fanpage_giftcodes]);
		}
	}
	public function checkSession(){
        return session('page_id');
	}
	public function getWordByCategory(Request $request){
		$input = Input::all();
		$cate_id = $input['category_id'];
		$words = DB::table('word_comment_stocks')->where('category_id', '=', $cate_id)->get();
		$response_data = '';
		if(!empty($words)){
			foreach( $words as $word ){
				$response_data .= "<tr>
					<td><input type='checkbox' value='$word->word' class='custom-control-input'></td>
					<td>$word->word</td>
				</tr>";
			}
		}
		return $response_data;
	}
}
