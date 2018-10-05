<?php

namespace App\Http\Controllers\Bot;

use App\Constants;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\Drivers\Facebook\Extensions\ButtonTemplate;
use BotMan\Drivers\Facebook\Extensions\ElementButton;

class WebHookController extends BaseController
{
    protected $localVerifyToken = 'myToken123';
    protected $pageToken = '';

    protected $config = [
        "facebook" => [
            "token" => "EAALx206BKSUBACIOq7OK7uqlGuMhoW7umn3lRqkDZAjowLEaBgVmlJQUgcw3NZBqxTIFyPZB9wKWl1gODa8U8JWSAcUG4Mqln593PcuTWK1sWIhbXU9ZAglKXTzS1ooCFjELBZCpQykSoc6reqGVzrxPO8VZB7C1NaoFUQkXYiu79o40IbexY8",
        ]
    ];


    public function verify(Request $request)
    {
        $hubVerifyToken = $request->input('hub_verify_token');
        if ($hubVerifyToken == $this->localVerifyToken) {
            $hubChallenge = $request->input('hub_challenge');
            return $hubChallenge;
        } else {
            return 'Bad verify token!';
        }

    }

    public function postMessage(Request $request)
    {
    /*    $sam = '{"object":"page","entry":[{"id":"1350006375032481","time":1538576128186,"messaging":
            [{"sender":{"id":"1516870241740065"},"recipient":{"id":"1350006375032481"},"timestamp":1538576127576,
            "message":{"mid":"3Hzqru_yNpFsgoTdXdhixKGzbtQMiHPb5wo0VlnGueqPdmVeV8pFFzcniFJjqK6A7h9Iaj7mDC4s5i6-KqgzQw","seq":62160,
                "text":"tu moi"}}]}]}';*/
        // $input = json_decode($sam, true);
        $input = json_decode(file_get_contents('php://input'), true);
        $fanpage_id = isset($input['entry'][0]['id']) ? $input['entry'][0]['id'] : NULL;
        $message_chat = isset($input['entry'][0]['messaging'][0]['message']['text']) ? $input['entry'][0]['messaging'][0]['message']['text'] : NULL;
        $attachments = isset($input['entry'][0]['messaging'][0]['message']['attachments']) ? $input['entry'][0]['messaging'][0]['message']['attachments'] : NULL;
        $payload = isset($input['entry'][0]['messaging'][0]['postback']) ? $input['entry'][0]['messaging'][0]['postback'] : NULL;
        $bat_dau = isset($input['entry'][0]['messaging'][0]['postback']['payload']) ? $input['entry'][0]['messaging'][0]['postback']['payload'] : NULL;
        $quick_reply = isset($input['entry'][0]['messaging'][0]['message']['quick_reply']['payload']) ? $input['entry'][0]['messaging'][0]['message']['quick_reply']['payload'] : NULL;
		
        $sender = isset($input['entry'][0]['messaging'][0]['sender']['id']) ? $input['entry'][0]['messaging'][0]['sender']['id'] : NULL;
        if(!empty($sender)){
            $facebook_id = $input['entry'][0]['messaging'][0]['sender']['id'];
            $user_pages = DB::table('user_fanpages')->where('facebook_id','=',$facebook_id)->first();
            if(empty($user_pages)){
                    DB::table('user_fanpages')->insert(
                    [
                        'fanpage_id' => $fanpage_id,
                        'facebook_id' =>  $sender,
                    ]
                );
            }
           
        }
		Log::info('bot log: ' .json_encode($input));
        if(!empty($input['entry'][0]['changes'][0]['value']['comment_id'])){
			$from_id = isset($input['entry'][0]['changes'][0]['value']['from']['id'])? $input['entry'][0]['changes'][0]['value']['from']['id']:$input['entry'][0]['changes'][0]['value']['sender_id'];
             if($from_id != $input['entry'][0]['id']){
            //if($input['entry'][0]['changes'][0]['value']['sender_id'] != $input['entry'][0]['id']){
                
            $this->action_exe($input);
            return json_encode(array(
                'code' => 1,
                'message' => 'OK',
                    'data' => array(
                        'total' => 1
                    )
                ));
            }
        }
        
		if(!empty($fanpage_id)){
            try{
                $way_repay = 0;
                if(!empty($bat_dau) && $bat_dau == "Bắt đầu" ){
                    $message_text = 'Xin chào bạn đến với fanpage, chúng tôi có thể giúp gì cho bạn!';
                    // insert facebook Id
                }else{
                    // if chat content is text
                    if(!empty($message_chat)){
                        $keywords = DB::table('keywords')
                            ->join('actions', 'keywords.action_id', '=', 'actions.id')
                            ->join('action_values', 'action_values.action_id', '=', 'actions.id')
                            ->select('actions.type as type_rp','action_values.*')
                            ->where('keywords.name','=' ,$message_chat)
                            ->where('keywords.page_id','=' ,$fanpage_id)
                            ->first();
                        if(empty($keywords)){
                            $message_text = "Không hiểu từ khóa,làm ơn viết lại yêu cầu";
                        }else{
                            if($keywords->type_rp == 1){//phản hồi text
                                $message_text = $keywords->value;
                            }else{
                                $this->sendButtonToUser($sender,$keywords,$fanpage_id); 
                            }
                        }
                    }
                }
                // dd($keywords);
                if(!empty($sender)){
                    if($way_repay == 0){
                        $this->sendMessageToUser($sender,$message_text,$fanpage_id); 
                    }
                }
                   
                
            }catch (Exception $e){
                Log::error('error sendmessage'. $e->getMessage());
            }
        }else{
            Log::error('missing fanpage id');
            return 'missing fanpage id';
        }
    }
      public function sendButtonToUser($sender,$keywords,$fanpage_id){
            $action_id = $keywords->action_id;
            $action_values = DB::table('action_values')
                            ->where('action_id','=' ,$action_id)
                            ->get();
            $array_bt = array();
            if(count($action_values)){
                foreach($action_values as $value){
                       $data = array(
                        "type"=>"postback",
                        "payload" =>"DEVELOPER_DEFINED_PAYLOAD",
                        "title" => $value->value
                       ); 
                       array_push($array_bt,$data);
                }
                $messageData = array(
                    "recipient" => array('id'=>$sender),
                    "message" => array(
                        "attachment" => array(
                            "type" => "template",
                            "payload" => array(
                                  "template_type" =>"button",
                                  "text" =>$keywords->value,
                                  "buttons" => $array_bt
                              )
                          )
                    )
                );
              $this->callSendAPI($messageData,$sender,$fanpage_id);
            }else{
                $this->sendMessageToUser($sender,$keywords->value,$fanpage_id); 
            }
          
      }
    private function action_exe($input) {
        // $input = json_decode('{"entry":[{"changes":[{"field":"feed","value":{"item":"comment","sender_name":"Teck Interesting","comment_id":"1837218602977920_1984836431549469","sender_id":"1350006375032481","post_id":"1350006375032481_1837218602977920","verb":"add","parent_id":"1350006375032481_1837218602977920","created_time":1528256345,"post":{"type":"status","updated_time":"2018-06-06T03:39:05+0000","promotion_status":"inactive","permalink_url":"https:\/\/www.facebook.com\/techrelax\/posts\/1837218602977920","id":"1350006375032481_1837218602977920","status_type":"mobile_status_update","is_published":true},"message":"binh lua"}}],"id":"1350006375032481","time":1528256346}],"object":"page"}',true);
    // var_dump($input);die;
    $fanpage_id = isset($input['entry'][0]['id']) ? $input['entry'][0]['id'] : NULL;
    $comment_id = $input['entry'][0]['changes'][0]['value']['comment_id'];
    $comment_text  = $input['entry'][0]['changes'][0]['value']['message'];
    //$facebook_id  = $input['entry'][0]['changes'][0]['value']['sender_id'];
	$facebook_id = isset($input['entry'][0]['changes'][0]['value']['from']['id'])? $input['entry'][0]['changes'][0]['value']['from']['id']:$input['entry'][0]['changes'][0]['value']['sender_id'];
    //$facebook_id  = $input['entry'][0]['changes'][0]['value']['from']['id'];
    $post_id = $input['entry'][0]['changes'][0]['value']['post_id'];
    $fanpage_info = DB::table('fanpages')->where('fanpage_id','=',$fanpage_id)->first();
    $comment_info = DB::table('fanpage_comment_replies')->where('fanpage_id','=',$fanpage_id)->get();
    Log::info("Từ khóa : ".$comment_text."Thongtin post" . json_encode($comment_info));
    if(!empty($fanpage_info)){
        $message = "Chào mừng bạn đến với fanpage.";
        $reply = false;
        if(!empty($comment_info)){
            foreach($comment_info as $comment){
                $keywords = $comment->keywords;  
                $array_key = explode(",",$keywords);
                Log::info('array game : ' . json_encode($array_key));
                foreach($array_key as $word){
                    if(strpos($comment_text,$word) !== false){
                        $reply  = true;
                        break;
                    }
                }
                if($reply){
                     $message = $comment->message; 
                     $check_gift = $comment;   
                     break;
                }
                
            }
        }
        if($reply == true){
            $access_token = $fanpage_info->page_accesstoken;
            $type = 'comments';
            if(!empty($check_gift->is_giftcode)){
                $type = 'private_replies';
                $my_code = DB::table('giftcodes')->where(
                    [
                        ['fanpage_giftcode_id', '=', $check_gift->page_giftcode_id],
                        ['facebook_id', '=', $facebook_id]
                    ])->first();
                if(empty($my_code)){
                $giftcode_page = DB::table('fanpage_giftcodes')->where(
                    [
                        ['id', '=', $check_gift->page_giftcode_id],
                        ['start_time', '<', date('Y-m-d')],
                        ['end_time', '>', date('Y-m-d')]
                    ])->first();
                    if(!empty($giftcode_page)){
                        $code = DB::table('giftcodes')->where(
                            [
                                ['fanpage_giftcode_id', '=', $check_gift->page_giftcode_id],
                                ['facebook_id', '=', 0]
                            ])->first();
                            if(!empty($code)){
                                $message = "Giftcode cua ban la : $code->giftcode ";
                                DB::table('giftcodes')
                                ->where('id', $code->id)
                                ->update([
                                    'facebook_id' => $facebook_id
                                    ]);
                            }else{
                                $message = 'Giftcode đã hết bạn hay liên hệ với admin page';
                            }
                        
                    }else{
                        $message = 'Giftcode không tồn tại hoặc đã hết hạn sự kiện';
                    }
                }else{
                    $message = 'Bạn đã nhận giftcode của sự kiện này rồi. Giftcode của bạn là :' . $my_code->giftcode;
                }
               
            }
            $url = 'https://graph.facebook.com/v2.10/' . $comment_id . '/' . $type . '?access_token=' . $access_token;
            $inbox_message =json_encode(array( 'message' =>  $message));
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_URL,$url);
            curl_setopt($curl, CURLOPT_VERBOSE, 1);
            curl_setopt($curl, CURLOPT_TIMEOUT, 10);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            curl_setopt($curl, CURLOPT_POSTFIELDS,$inbox_message);
            $curl_response = curl_exec($curl);
            curl_close($curl);
            // decode sang dạng array
            Log::info('respone nhes : '. $curl_response);
            $input = json_decode($curl_response, true);
            if( isset($input['error']) ) {
                Log::info("Lỗi reply comment on fanpage comment ID". $comment_id);
                return false;
            }else{
                Log::info("Reply success". $comment_id);
                return true;
            }
        }else{
            Log::info("Reply error : Comment sai từ khóa post Id :". $post_id . " / comment :". $comment_text);
            return false;  
        }
    }else{
        Log::info("Reply error : chưa cấu hình fanpage". $fanpage_id);
        return false;
    }
}
    private function sendMessageToUser($sender,$message_text,$fanpage_id){
        $messageData =array('recipient'=>array('id'=>$sender),'message'=>array('text'=>$message_text));
        $this->callSendAPI($messageData,$sender,$fanpage_id);
    }
    private  function callSendAPI($messageData,$sender='',$fanpage_id){
        try{
            $request = array(
                'header' => array('Content-Type' => 'application/json')
            );

    //            $typing = array('recipient'=>array('id'=>$sender),"sender_action"=>"typing_on");
    //             $HttpSocket->post(
    //                'https://graph.facebook.com/v2.8/me/messages?access_token=EAAW0Hxf6ZCx8BAAZCWUSPz85BSoCRWn7ZAIcyPPor3wXDGHZAZCuU1sI7fGZCesEbyZBUmmvz1zZAQLWZC8Wdb7bxPXiuSJ5p5dHzNOihiUIEZBrZAMZC5504AyqF45pkycibiLkVblTBU6dkZBKbCCMmZCg59OJZBYuZAJ95VPZAaxcBM2M4XAZDZD',
    //                json_encode($typing),
    //                $request
    //            );

            $fanpage_info = DB::table('fanpages')->where('fanpage_id','=',$fanpage_id)->first();
            if(!empty($fanpage_info)){
                $access_token = $fanpage_info->page_accesstoken;
                $service_url = "https://graph.facebook.com/v2.8/me/messages?access_token=$access_token";
                $curl = curl_init($service_url);
                curl_setopt($curl, CURLOPT_URL,$service_url);
                curl_setopt($curl, CURLOPT_VERBOSE, 1);
                curl_setopt($curl, CURLOPT_TIMEOUT, 10);
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($curl, CURLOPT_POST, 1);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                curl_setopt($curl, CURLOPT_POSTFIELDS,json_encode($messageData));
                $curl_response = curl_exec($curl);
                curl_close($curl);
                // $response = $HttpSocket->post(
                //     'https://graph.facebook.com/v2.8/me/messages?access_token=EAAW0Hxf6ZCx8BAAZCWUSPz85BSoCRWn7ZAIcyPPor3wXDGHZAZCuU1sI7fGZCesEbyZBUmmvz1zZAQLWZC8Wdb7bxPXiuSJ5p5dHzNOihiUIEZBrZAMZC5504AyqF45pkycibiLkVblTBU6dkZBKbCCMmZCg59OJZBYuZAJ95VPZAaxcBM2M4XAZDZD',
                //     json_encode($messageData),
                //     $request
                // );
                $response_result = json_decode($curl_response);
                dd($response_result);
                if(isset($response_result->error)){
                    Log::error('Lỗi gửi tin nhắn' . json_encode($response_result) .'data send' .json_encode($messageData));
                    return false;
                }
                return true;
            }
        }catch (Exception $e){
            Log::error('Khong gui dc message' . $e->getMessage());
            return false;
        }
    }
}
