<?php

namespace App\Console\Commands;
use Illuminate\Support\Facades\DB;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
class MessagePush extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $date = date('Y-m-d H:i:s');
        $fanpage_push = DB::table('push_messages')->where('schedule_time','<=',$date)->where('status','=' ,3)->first();
        if(!empty($fanpage_push)){
            $page_id = $fanpage_push->fanpage_id;
            $fanpage = DB::table('fanpages')->where('fanpage_id','=',$page_id)->first();
			$page_accessToken = $fanpage->page_accesstoken;
			$users = DB::table('user_fanpages')->select('facebook_id')->where('fanpage_id','=',$page_id)->groupBy('facebook_id')->get();
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
					->where('fanpage_id', $page_id)
					->update([
					'status' => 2,
					'send_user' => $user_send,
					'pushed_time' => date('Y-m-d H:i:s')
				]);
				return redirect('PushMessage/list');
			}else{
				Log::info('Không có user cho push');
			}
	
        }
    }
}
