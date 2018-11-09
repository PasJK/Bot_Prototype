<?php
    $accessToken = "8uYL7S31MNpY8u5rl32AJrIJ8HKIIPsPFBHbcYgCklGSuzDRsK1pu2jT+scopLs0co8yiTpBrYg4uWruJCFkFg6M1metrmSKvi4ZRlSGc5bdKul2/CDCwuIjIzpSoDpvpyd7NNYFqgzhriwl75ZV4gdB04t89/1O/w1cDnyilFU=";//copy Channel access token ตอนที่ตั้งค่ามาใส่

    $content = file_get_contents('php://input');
    $arrayJson = json_decode($content, true);

    $arrayHeader = array();
    $arrayHeader[] = "Content-Type: application/json";
    $arrayHeader[] = "Authorization: Bearer {$accessToken}";

    ######################  Set Text Variable ###########################
    $TXT_DIRECTION = "นำทาง";
    $TXT_FINDPLACE = "จะไป";

    ######################  Set Text ###########################
    //รับข้อความจากผู้ใช้
    $message = $arrayJson['events'][0]['message']['text'];

    // user id
    $userid  = $arrayJson['events'][0]['source']['userId'];
//  $message = "เชี้ยป้อ";

    ######################  Set Conditions ###########################

	if(strpos($message,"ป้ออ") !== false){
	    $message = 'tik';
	} else if(strpos($message,"เชี้ยป้อ") !== false){
        $message = 'tik_hard';
    }

	$txt  = null;
	$src  = null;
	$__Direction = null;


if( strpos($message,$TXT_DIRECTION) !== false )
	{
		$src = explode_text($TXT_DIRECTION,$message);
		if($src[0] != 'where'){

			$__DIRECTION = GetDirectionURL('findway',$src[0],$src[1]);
			$message = "direct";
		}else{
			$message = $src[0];
		}

	}
	else if( strpos($message,$TXT_FINDPLACE) !== false )
	{
		$src =  explode_text($TXT_FINDPLACE,$message);
        $__DIRECTION = GetDirectionURL('where','',$src[1]);
		$message = $src[0];
	}
    ######################  Set txt respond  ###########################

        $userRespond =  [   'U6955ed1ec27181615d917f122eb8de4c' => ['','อวบ','โล้น','โล้นน','ศพ','คนตาย'],
                            'U010bf9787588b308316956ec78c8d126' => ['','เต้ย','หน้าหี'],
                            'U893c6886f0d148be78b87bc5fff06aeb' => ['','ต๊อบ','น้อง','ควาย','ถอก','ไอ้เหาฉลาม']
                        ];

        $userHardRespond =  ['U6955ed1ec27181615d917f122eb8de4c' => ['โล้น','โล้นน','ศพ','คนตาย'],
                             'U010bf9787588b308316956ec78c8d126' => ['หน้าหี'],
                             'U893c6886f0d148be78b87bc5fff06aeb' => ['น้องงง','ควาย','ถอก','ไอ้เหาฉลาม']
                            ];


		$res_txt_por =  [
							'tik' =>[
			                        'เรียกไม',
			                        'ไงลูก',
                                    'ไง'.$userRespond[$userid][array_rand($userRespond[$userid],1)],
                                    'ว่าไง'.$userRespond[$userid][array_rand($userRespond[$userid],1)],
			                        'รำคานนน',
			                        'ไอโง่',
			                        'กรี๊ดดดดดดด',
			                        'กรี๊ดดดดดดดดดดดควยต๊อบดดดดดดดดดดด',
			                        'ครับ',
			                        'จ๋าา',
                                    'พวกหน้าหี'
			                        ],
                            'tik_hard' =>[
                                    'อะไรมึง',
                                    'ควยไรล่าาาา',
                                    'อะไรรร'.$userRespond[$userid][array_rand($userRespond[$userid],1)],
                                    'กรี๊ดดดดดด '.$userHardRespond[$userid][array_rand($userHardRespond[$userid],1)].'ด่า',
                                    ],
			                'findWay' => $__DIRECTION,
			                'direct'  => $__DIRECTION,
			                'where'	  =>'จะไปไหนดีล่ะ -- อยากไปไหนพิมพ์ จะไป ตามด้วยสถานที่ เช่น "จะไปจุตจักร" -- หรือนำทางพิมพ์ "นำทางจากเอกชัย8ไปสยาม"'
	               		];


getResponse($message,$arrayJson,$arrayHeader,$res_txt_por,$userid);


function getResponse($message,$arrayJson,$arrayHeader,$res_txt_por,$userid)
{
    // $message = 'น้ำตาล';
    $arrayPostData['replyToken'] = $arrayJson['events'][0]['replyToken'];
    $arrayPostData['messages'][0]['type'] = "text";
    if($message == 'tik'){
        $arrayPostData['messages'][0]['text'] = $res_txt_por['tik'][array_rand($res_txt_por['tik'],1)];
    }else if($message == 'tik_hard'){
        $arrayPostData['messages'][0]['text'] = $res_txt_por['tik_hard'][array_rand($res_txt_por['tik_hard'],1)];
    }else if($message == 'google'){
        $arrayPostData['messages'][0]['text'] = $res_txt_por['google'];
    }else if($message == 'findWay'){
        $arrayPostData['messages'][0]['text'] = $res_txt_por['findWay'];
    }else if($message == 'direct'){
        $arrayPostData['messages'][0]['text'] = $res_txt_por['direct'];
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
######## Function #########

//GET Direction URL
function GetDirectionURL($type,$origin,$destination){
    $url = null;

        if($type == 'findway'){
            $url = 'https://www.google.com/maps/dir/?api=1&origin='.trim($origin).'&destination='.trim($destination).'&travelmode=driving';
        }else if($type == 'where') {

            $url = 'https://www.google.com/maps/search/?api=1&query=' . $destination;
        }
    return $url;
}

//check Text
function explode_text($txt,$msg)
{ $res = [];
		if($txt == "นำทาง")
		{
			$ori  = null;
			$dest = null;
			$explode_ 	= explode($txt, $msg); //นำทางจากเอกชัย8ไปสยาม

			 if($explode_[1]===""){
			    $ori = 'where';
			 }else{
				$textSearch = explode("ไป",$explode_[1]); //จากเอกชัย8ไปสยาม => [0]=>จากเอกชัย8,[1]=>สยาม

				$ori 		= explode("จาก",$textSearch[0]); //จากเอกชัย8 => [0]=>จาก,[1]=>เอกชัย8
				$dest	= $textSearch[1]; //สยาม
			 }
			$res = [$ori[1],$dest];

		}else if($txt == "จะไป"){
		    $explode_ = explode($txt,$msg);
		    if($explode_[1]===""){
			    $m = 'where';
		    }else{
			    $t = trim($explode_[1]);
			    $m = 'findWay';
		    }
		    $res = [$m,$t];
		}
    return $res;
}


?>