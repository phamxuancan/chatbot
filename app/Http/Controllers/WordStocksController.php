<?php 
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\PushMessage;
use Validator;
use Auth;
class WordStocksController extends Controller {

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
		$words = DB::table('word_comment_stocks')->join('category_comments', 'word_comment_stocks.category_id', '=', 'category_comments.id')->paginate(20);
		$categories = DB::table('category_comments')->get();
		$input = Input::all();
		$cate_id = $qword = '';
		if(isset($input['category_id'])){
			$cate_id = $input['category_id'];
		}
		if(isset($input['qword'])){
			$qword = $input['qword'];
		}
		if(!empty($cate_id) && empty($qword)){
			$words = DB::table('word_comment_stocks')->join('category_comments', 'word_comment_stocks.category_id', '=', 'category_comments.id') ->where('category_id', '=', $cate_id)->paginate(20);
		}
		if(empty($cate_id) && !empty($qword)){
			$words = DB::table('word_comment_stocks')->join('category_comments', 'word_comment_stocks.category_id', '=', 'category_comments.id')->where('word', '=', $qword)->paginate(20);
		}
		if(!empty($cate_id) && !empty($qword)){
			$words = DB::table('word_comment_stocks')->join('category_comments', 'word_comment_stocks.category_id', '=', 'category_comments.id')->where('word', '=', $qword)->where('category_id', '=', $cate_id)->paginate(20);
		}
		return view('WordStocks.list',[
			'words' => $words,'categories'=>$categories
		]);
	}
	public function add(Request $request){
			if($request->isMethod('post')){
			$validator = Validator::make($request->all(), [
				'word' => 'required|unique:word_comment_stocks'
			]);
			if($validator->fails()){
				return redirect('WordStocks/add')
				->withErrors($validator)
				->withInput();
			}else{
				$input = Input::all();
				DB::table('word_comment_stocks')->insert(
                    [
                        'word' => $input['word'],
                        'category_id' => $input['category_id'],
                        'user_id' => Auth::id()
                    ]
                );
				\Session::flash('success','Lưu thành công.');
			return redirect('WordStocks/list');
			}
		}
		$categories = DB::table('category_comments')->get();
		return view('WordStocks.add',['categories'=> $categories]);
	}
	public function delete($id){
		if(!empty($id)){
			DB::table('word_comment_stocks')->where('id', '=', $id)->delete();
			\Session::flash('success','Xóa thành công.');
			return redirect('WordStocks/list');
		}
	}
	public function edit(Request $request,$id){
		if(!empty($id)){
			if($request->isMethod('post')){
			$input = Input::all();
			DB::table('word_comment_stocks')
            ->where('id', $id)
            ->update([
				'word' => $input['word'],
				'category_id' => $input['category_id'],
				'user_id' => Auth::id()
				]);
				\Session::flash('success','Lưu thành công.');
				return redirect('WordStocks/list');
			}
			$word = DB::table('word_comment_stocks')->where('id', '=', $id)->first();
			$category = DB::table('category_comments')->where('id', '=', $word->category_id)->first();
			$categories = DB::table('category_comments')->get();
			return view("WordStocks.add",['word'=>$word,'categories'=> $categories,'category'=>$category]);
		}
	}
	public function checkSession(){
        return session('page_id');
	}
	public function getWordByCategory(Request $request){
		$input = Input::all();
		$cate_id = $qword = '';
		if(isset($input['category_id'])){
			$cate_id = $input['category_id'];
		}
		if(isset($input['qword'])){
			$qword = $input['qword'];
		}
		if(!empty($cate_id) && empty($qword)){
			$words = DB::table('word_comment_stocks')->where('category_id', '=', $cate_id)->get();
		}
		if(empty($cate_id) && !empty($qword)){
			$words = DB::table('word_comment_stocks')->where('word', '=', $qword)->get();
		}
		if(!empty($cate_id) && !empty($qword)){
			$words = DB::table('word_comment_stocks')->where('word', '=', $qword)->where('category_id', '=', $cate_id)->get();
		}

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
