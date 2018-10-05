<?php 
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Validator;
class FanpageCommentReplyController extends Controller {
    public $table = 'fanpage_comment_replies';
	public function setup(Request $request)
	{
        $page_id = $this->checkSession($request);
        if($page_id){
            $comment_replies = DB::table('fanpage_comment_replies')->paginate(10);
            return view('FanpageCommentReply.setup',['comment_replies'=>$comment_replies]);
        }else{
            \Session::flash('error','Bạn hãy chọn fanpage.');
            return redirect('/');
        }
    }
    public function view_setup(Request $request){
        $page_id = $this->checkSession($request);
        if($page_id){
        $datas = array();
        if($request->isMethod('post')){
            $input = Input::all();
            if(!empty($input['fanpage_id'])){
                $fanpage_id = $input['fanpage_id'];
                $fanpage = DB::table('fanpages')->where('fanpage_id','=',$fanpage_id)->first();
                $access_tokenuser = $fanpage->user_accesstoken;
                try {
                    $conditions = array(
                        'fields' => "message,created_time,permalink_url,attachments",
                        'access_token' => $access_tokenuser
                    );
                    // $start_time = $this->request->data['FbCommentToPrivateReply']['start_time'];
                    // $end_time = $this->request->data['FbCommentToPrivateReply']['end_time'];
                    // if( !empty($start_time) ) {
                    //     $conditions['since'] = $start_time;
                    // }
                    // if( !empty($end_time) ) {
                    //     $conditions['until'] = $end_time;
                    // }
    
                    // $result = $Http->get(
                    //     'https://graph.facebook.com/v2.10/'.$fanpage_id.'/posts',
                    //     $conditions
                    // );
                    try {
                        $fb = new \Facebook\Facebook([
                            'app_id' => '1605420522864415',
                            'app_secret' => 'e3669956363ce410af6810360743c564',
                            'default_graph_version' => 'v2.10',
                            //'default_access_token' => '{access-token}', // optional
                            ]);
                        // Returns a `Facebook\FacebookResponse` object
                        $response = $fb->get(
                          '/'.$fanpage_id.'/published_posts',
                          $access_tokenuser
                        );
                        $array = $response->getDecodedBody();
                        $datas = $array['data'];
                      } catch(Facebook\Exceptions\FacebookResponseException $e) {
                        echo 'Graph returned an error: ' . $e->getMessage();
                        exit;
                      } catch(Facebook\Exceptions\FacebookSDKException $e) {
                        echo 'Facebook SDK returned an error: ' . $e->getMessage();
                        exit;
                      }
                } catch (Exception $e) {
                    CakeLog::info('Can not get posts info'.$e->getMessage(), 'user');
                }
            }else{
                \Session::flash('error','Bạn hãy chọn fanpage.');
            }
        }
        $fanpages = DB::table('fanpages')->get();
        return view('FanpageCommentReply.view_setup',['fanpages'=>$fanpages,'datas'=> $datas]);
    }else{
        return redirect('/');
    }
    }
    public function setting_post($id_post,Request $request){
        if($request->isMethod('post')){
            $input = Input::all();
            $input['post_id'] = $id_post;
            $validator = Validator::make($input, [
				'post_id' => 'unique:fanpage_comment_replies',
                'title' => 'required',
                'text_comment'=> 'required'
            ]);
			if($validator->fails()){
				return redirect('FanpageCommentReply/setting_post/'.$id_post)
				->withErrors($validator)
				->withInput();
			}else{
                $fanpage = explode("_",$id_post);
				DB::table('fanpage_comment_replies')->insert(
                    [
                        'post_id' => $id_post,
                        'title' => $input['title'],
                        'keywords' => $input['text_comment'],
                        'message' => $input['reply_comment'],
                        'fanpage_id' =>  $fanpage[0],
                        'is_giftcode'=> 0
                    ]
                );
				\Session::flash('success','Lưu thành công.');
			return redirect('FanpageCommentReply/setup');
			}
        }
        return view('FanpageCommentReply.setting_post',['id_post'=>$id_post]);
    }
    public function delete($id){
		if(!empty($id)){
			DB::table($this->table)->where('id', '=', $id)->delete();
			\Session::flash('success','Xóa thành công.');
			return redirect('FanpageCommentReply/setup');
		}
	}
	public function edit(Request $request,$id){
		if(!empty($id)){
			if($request->isMethod('post')){
            $input = Input::all();
            $is_giftcode = 0;
            if(isset($input['is_giftcode']) && ($input['is_giftcode'] == 'on' || $input['is_giftcode'])){
                $is_giftcode = 1;
            }
			DB::table($this->table)
            ->where('id', $id)
            ->update([
				'title' => $input['title'],
                'message' => $input['reply_comment'],
                'keywords' => $input['text_comment'],
                'is_giftcode'=> $is_giftcode
				]);
				\Session::flash('success','Lưu thành công.');
				return redirect('FanpageCommentReply/setup');
            }
            $page_id = $this->checkSession($request);
            $fanpage_replies = DB::table($this->table)->where('id', '=', $id)->first();
            $fanpage = DB::table('fanpages')->where('fanpage_id', '=', $page_id)->first();
            $categories = DB::table('category_comments')->get();
            $giftcodes = DB::table('fanpage_giftcodes')->where('fanpage_id', '=', $page_id)->get();
			return view("FanpageCommentReply.setup_comment",['giftcodes'=>$giftcodes,'categories'=>$categories,'fanpage_replies'=>$fanpage_replies,'id_post'=>$fanpage_replies->post_id,'fanpage'=>$fanpage]);
		}
    }
    public function setup_comment(Request $request){
        $page_id = $this->checkSession();
        if($page_id){
        $datas = array();
        if($request->isMethod('post')){
            $input = Input::all();
            $is_giftcode = 0;
            if(isset($input['is_giftcode']) && ($input['is_giftcode'] == 'on' || $input['is_giftcode'])){
                $is_giftcode = 1;
            }
                $validator = Validator::make($input, [
                    'title' => 'required',
                    'text_comment'=> 'required'
                    // 'reply_comment' =>'required'
                ]);
                if($validator->fails()){
                    return redirect('FanpageCommentReply/setup_comment')
                    ->withErrors($validator)
                    ->withInput();
                }else{
                    DB::table('fanpage_comment_replies')->insert(
                        [
                            'post_id' => 0,
                            'title' => $input['title'],
                            'keywords' => $input['text_comment'],
                            'message' => $input['reply_comment'],
                            'fanpage_id' =>  $page_id,
                            'is_giftcode'=> $is_giftcode,
                            'page_giftcode_id'=> $input['page_giftcode_id']
                        ]
                    );
                    \Session::flash('success','Lưu thành công.');
                    return redirect('FanpageCommentReply/setup');
                }
       
        }
        $fanpage = DB::table('fanpages')->where('fanpage_id', '=', $page_id)->first();
        $categories = DB::table('category_comments')->get();
        $giftcodes = DB::table('fanpage_giftcodes')->where('fanpage_id', '=', $page_id)->get();
        return view('FanpageCommentReply.setup_comment',['fanpage'=>$fanpage,'categories'=>$categories,'giftcodes'=>$giftcodes]);
     }else{
        \Session::flash('error','Bạn hãy chọn fanpage.');
            return redirect('/');
        }
    }
    public function test(){
        
        return json_encode(array('test'=>1));
    }
    public function checkSession(){
        return session('page_id');
    }
}
