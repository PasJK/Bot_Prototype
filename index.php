<?php
    $accessToken = "8uYL7S31MNpY8u5rl32AJrIJ8HKIIPsPFBHbcYgCklGSuzDRsK1pu2jT+scopLs0co8yiTpBrYg4uWruJCFkFg6M1metrmSKvi4ZRlSGc5bdKul2/CDCwuIjIzpSoDpvpyd7NNYFqgzhriwl75ZV4gdB04t89/1O/w1cDnyilFU=";//copy Channel access token ตอนที่ตั้งค่ามาใส่
    
    $content = file_get_contents('php://input');
    $arrayJson = json_decode($content, true);
    
    $arrayHeader = array();
    $arrayHeader[] = "Content-Type: application/json";
    $arrayHeader[] = "Authorization: Bearer {$accessToken}";
    
    //รับข้อความจากผู้ใช้
    $message = $arrayJson['events'][0]['message']['text'];
	// $message = "ไป";

	$pos_por = strpos($message,"ป้ออ");

	$pos_where = strpos($message,"ไป");

	if($pos_por !== false){
	    $message = 'tik';
	}

	$txt = null;
	if($pos_where !== false){
	    $explode_ = explode('ไป',$message);

	    if($explode_[0]===""){
		    $message = 'where';
	    }else{
		    $txt = $explode_[1];
		    $message = 'google';
	    }
	}

		$res_txt_por =  [
							'tik' =>[
			                        'เรียกไม',
			                        'ไงลูก',
			                        'ไง',
			                        'ว่าไง',
			                        'รำคานนน',
			                        'ไอโง่',
			                        'กรี๊ดดดดดดด',
			                        'กรี๊ดดดดดดดดดดดควยต๊อบดดดดดดดดดดด'
			                        ],
			                'google' => 'https://www.google.com/maps/search/?api=1&query='.$txt,
			                'where'	 =>'จะไปไหนดีล่ะ -- อยากไปไหนพิมพ์ ไป ตามด้วยสถานที่ เช่น "ไปจุตจักร"'
	               		];


getResponse($message,$arrayJson,$arrayHeader,$res_txt_por);


function getResponse($message,$arrayJson,$arrayHeader,$res_txt_por)
{
    // $message = 'น้ำตาล';
    $arrayPostData['replyToken'] = $arrayJson['events'][0]['replyToken'];
    $arrayPostData['messages'][0]['type'] = "text";
    if($message == 'tik'){
        $arrayPostData['messages'][0]['text'] = $res_txt_por['tik'][array_rand($res_txt_por['tik'],1)];
    }else if($message == 'google'){
        $arrayPostData['messages'][0]['text'] = $res_txt_por['google'];
    }else if($message == 'where'){
        $arrayPostData['messages'][0]['text'] = $res_txt_por['where'];
    }
	print_r($arrayPostData);

   replyMsg($arrayHeader,$arrayPostData);

}



function replyMsg($arrayHeader,$arrayPostData){
        $strUrl = "https://api.line.me/v2/bot/message/reply";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$strUrl);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $arrayHeader);    
        curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($arrayPostData));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);
        curl_close ($ch);
    }
   exit;





?>