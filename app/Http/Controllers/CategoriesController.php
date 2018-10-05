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
class CategoriesController extends Controller {

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
		$categories = DB::table('category_comments')->paginate(10);
		return view('Categories.list',[
			'categories' => $categories
		]);
	}
	public function add(Request $request){
		if($request->isMethod('post')){
			$validator = Validator::make($request->all(), [
				'title' => 'required|unique:category_comments'
			]);
			if($validator->fails()){
				return redirect('Categories/add')
				->withErrors($validator)
				->withInput();
			}else{
				$input = Input::all();
				DB::table('category_comments')->insert(
                    [
                        'title' => $input['title'],
                        'type' => 'comment',
                        'user_id' => Auth::id()
                    ]
                );
				\Session::flash('success','Lưu thành công.');
			return redirect('Categories/list');
			}
		}
		return view('Categories.add');
	}
	public function delete($id){
		if(!empty($id)){
			DB::table('category_comments')->where('id', '=', $id)->delete();
			\Session::flash('success','Xóa thành công.');
			return redirect('Categories/list');
		}
	}
	public function edit(Request $request,$id){
		if(!empty($id)){
			if($request->isMethod('post')){
			$input = Input::all();
			DB::table('category_comments')
            ->where('id', $id)
            ->update([
				'title' => $input['title'],
				'fanpage_id' => $input['fanpage_id'],
				'message' => $input['message']
				]);
				\Session::flash('success','Lưu thành công.');
				return redirect('Categories/list');
			}
			$category = DB::table('category_comments')->where('id', '=', $id)->first();
			return view("Categories.add",['category'=>$category]);
		}
	}
}
