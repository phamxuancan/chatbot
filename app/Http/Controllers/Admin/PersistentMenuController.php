<?php

namespace App\Http\Controllers\Admin;

use App\Action;
use App\ActionValue;
use App\Constants;
use App\Keyword;

use App\PersistentMenu;
use App\PersistentMenuContainer;
use App\PersistentMenuGetStartedButton;
use Carbon\Carbon;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;

use App\FbPage;

class PersistentMenuController extends BaseController
{

    /**
     * Open List Facebook page
     */
    public function get(Request $request)
    {
        $action = $request->action;
        $page_id = session('page_id');
        $check_exit = DB::table('persistent_menus')
        ->where('page_id', '=', $page_id)
        ->where('type', '=', 1)
        ->first();

        if ($action == 'get_started') {


            return view(
                'persistent_get_started',['start_menu'=>$check_exit]
            );
        } else if ($action == 'menu') {
            $menuList = DB::table('persistent_menus')
            ->where('page_id', '=', $page_id)
            ->where('type', '=', 2)
            ->get();
            return view(
                'persistent_menu',
                array(
                    'menuList' => $menuList,
                )
            );
        } else {
            return view(
                'persistent'
            );
        }
    }

    public function update(Request $request)
    {
        $action = $request->action;
        $page_id = session('page_id');
        $input = Input::all();
        if ($action == 'get_started') {
            $check_exit = DB::table('persistent_menus')
            ->where('page_id', '=', $page_id)
            ->where('type', '=', 1)
            ->first();
            $content = $input['content'];
            if(empty($check_exit)){
                $last_id = DB::table('persistent_menus')->insert(
                    [
                        'title' => 'button_start',
                        'page_id' => $page_id,
                        'content' => $input['content'],
                        'type' => 1
                    ]
                );
            }else{
                DB::table('persistent_menus')
                ->where('id', $check_exit->id)
                ->update([
					'content' => $input['content'],
				]);
            }
            \Session::flash('success','Lưu thành công.');
            return redirect('persistent');
        } else if ($action == 'menu') {
dd($input);

        } else {


        }
        return $action . ' hello world';
    }


    protected function getCurrentPersistentMenu()
    {
        $page_id = 1;

        $persistentMenu = PersistentMenu::findByPage($page_id);

        return $persistentMenu;
    }

    protected function savePersistentMenu($persistentMenu, $getStartedButton)
    {

    }

    protected function convertToContainer($persistentMenu)
    {
        $persistentMenuContainer = new PersistentMenuContainer();

        if ($persistentMenu) {
            $content = $persistentMenu->content;

            if ($content) {
                $objContent = json_decode($content);
                $getStartedButton = $objContent->getStartedButton;
                $menuButtonList = $objContent->menuList;

                $persistentMenuContainer->getStartedButton = $getStartedButton;
                $persistentMenuContainer->menuList = $menuButtonList;
            }
        }

        return $persistentMenuContainer;
    }

    protected function convertToContent($persistentMenuContainer)
    {
        $result = '{}';
        if ($persistentMenuContainer) {
            $result = json_encode($persistentMenuContainer);
        }
        return $result;
    }

    public function updateMenu(Request $request)
    {
        $page_id = session('page_id');
        if ($request->isMethod('get')) {
                $menu_childs = DB::table('menu_childs')
                ->where('page_id','=',$page_id)
                ->where('status','=',1)
                ->get();
            return view('persistent_menu_create', array(
                'menu_childs'=> $menu_childs
            ));

        } else if ($request->isMethod('post')) {
            $input = Input::all();
            $last_id = DB::table('persistent_menus')->insertGetId(
                [
                    'title' => $input['title'],
                    'page_id' => $page_id,
                    'content' => $input['content'],
                    'type' => 2,
                    'isChild'=> $input['isChild'],
                    'created_at' =>  date('Y-m-d H:i:s'),
                    'updated_at' =>  date('Y-m-d H:i:s'),
                    'type_content'=> $input['type_reply']
                ]
            );
            if(!empty($last_id)){
                foreach($input['child_menu'] as $child_id){
                    DB::table('persistent_parent_childs')->insert(
                    [
                        'parent_id' => $last_id,
                        'child_id' => $child_id
                    ]
                );
                }
                
            }
            return redirect('persistent');
        }
    }
    public function active_persistent(){
       $this->callSendAPI();
    }
    private  function callSendAPI(){
       $data = '{
            "persistent_menu":[
              {
                "locale":"default",
                "composer_input_disabled": true,
                "call_to_actions":[
                  {
                    "title":"My Account",
                    "type":"nested",
                    "call_to_actions":[
                      {
                        "title":"Pay Bill",
                        "type":"postback",
                        "payload":"PAYBILL_PAYLOAD"
                      },
                      {
                        "type":"web_url",
                        "title":"Latest News",
                        "url":"https://www.messenger.com/",
                        "webview_height_ratio":"full"
                      }
                    ]
                  }
                ]
              }
            ]
          }';
          $fanpage_id = '1350006375032481';
            $request = array(
                'header' => array('Content-Type' => 'application/json')
            );

    //            $typing = array('recipient'=>array('id'=>$sender),"sender_action"=>"typing_on");
    //             $HttpSocket->post(
    //                'https://graph.facebook.com/v2.8/me/messages?access_token=EAAW0Hxf6ZCx8BAAZCWUSPz85BSoCRWn7ZAIcyPPor3wXDGHZAZCuU1sI7fGZCesEbyZBUmmvz1zZAQLWZC8Wdb7bxPXiuSJ5p5dHzNOihiUIEZBrZAMZC5504AyqF45pkycibiLkVblTBU6dkZBKbCCMmZCg59OJZBYuZAJ95VPZAaxcBM2M4XAZDZD',
    //                json_encode($typing),
    //                $request
    //            );
        try{
            $fanpage_info = DB::table('fanpages')->where('fanpage_id','=',$fanpage_id)->first();
            if(!empty($fanpage_info)){
                $access_token = $fanpage_info->page_accesstoken;
                $service_url = "https://graph.facebook.com/v2.8/me/messenger_profile?access_token=$access_token";
                $curl = curl_init($service_url);
                curl_setopt($curl, CURLOPT_URL,$service_url);
                curl_setopt($curl, CURLOPT_VERBOSE, 1);
                curl_setopt($curl, CURLOPT_TIMEOUT, 10);
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($curl, CURLOPT_POST, 1);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                curl_setopt($curl, CURLOPT_POSTFIELDS,$data);
                $curl_response = curl_exec($curl);
                curl_close($curl);
                // $response = $HttpSocket->post(
                //     'https://graph.facebook.com/v2.8/me/messenger_profile?access_token=EAAW0Hxf6ZCx8BAAZCWUSPz85BSoCRWn7ZAIcyPPor3wXDGHZAZCuU1sI7fGZCesEbyZBUmmvz1zZAQLWZC8Wdb7bxPXiuSJ5p5dHzNOihiUIEZBrZAMZC5504AyqF45pkycibiLkVblTBU6dkZBKbCCMmZCg59OJZBYuZAJ95VPZAaxcBM2M4XAZDZD',
                //     json_encode($messageData),
                //     $request
                // );
                $response_result = json_decode($curl_response);
                dd($response_result);
                if(isset($response_result->error)){
                    Log::error('Lỗi gửi tin nhắn' . json_encode($response_result) .'data send' .json_encode($data));
                    return 'false';
                }
                return json_encode($response_result);
            }
        }catch (Exception $e){
            Log::error('Khong gui dc message' . $e->getMessage());
            return 'false';
        }
    }
    public function list_persistent_child() {
        $page_id = session('page_id');
        $menu_childs = DB::table('menu_childs')
        ->where('page_id','=',$page_id)
        ->paginate(15);
        return view('list_persistent_menu', array(
            'menu_childs'=>$menu_childs
        ));
    }
    public function add_persistent(Request $request) {
        if ($request->isMethod('get')) {
            return view('add_persistent', array(

            ));
        }else{
            $input = Input::all();
            $page_id = session('page_id');
            $last_id = DB::table('menu_childs')->insert(
                [
                    'title' => $input['title'],
                    'page_id' => $page_id,
                    'content' => $input['content'],
                    'type' =>  $input['type_reply'],
                    'created_at' =>  date('Y-m-d H:i:s'),
                    'updated_at' =>  date('Y-m-d H:i:s')

                ]
            );
            return redirect('persistent_child');
        }   
    }
    public function publish(){
        $input = Input::all();
        $page_id = session('page_id');
        $id = $input['id'];
        $status = $input['status'];
        if($status == 1){
            $status = 0;
        }else{
              $status = 1;  
        }
        DB::table('menu_childs')
                ->where('id', $id)
                ->update([
					'status' => $status
                ]);
                return redirect('persistent_child');
    }
    public function publish_menu(){
        $input = Input::all();
        $page_id = session('page_id');
        $id = $input['id'];
        $status = $input['status'];
        if($status == 1){
            $status = 0;
        }else{
              $status = 1;  
        }
        DB::table('persistent_menus')
                ->where('id', $id)
                ->update([
					'status' => $status
                ]);
                return redirect('persistent?action=menu');
    }
}
