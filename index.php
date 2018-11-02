<?php
    $accessToken = "8uYL7S31MNpY8u5rl32AJrIJ8HKIIPsPFBHbcYgCklGSuzDRsK1pu2jT+scopLs0co8yiTpBrYg4uWruJCFkFg6M1metrmSKvi4ZRlSGc5bdKul2/CDCwuIjIzpSoDpvpyd7NNYFqgzhriwl75ZV4gdB04t89/1O/w1cDnyilFU=";//copy Channel access token ตอนที่ตั้งค่ามาใส่
    
    $content = file_get_contents('php://input');
    $arrayJson = json_decode($content, true);
    
    $arrayHeader = array();
    $arrayHeader[] = "Content-Type: application/json";
    $arrayHeader[] = "Authorization: Bearer {$accessToken}";
    
    //รับข้อความจากผู้ใช้
    $message = $arrayJson['events'][0]['message']['text'];
   // $message = 'ไป';
#ตัวอย่าง Message Type "Text"


##########################
    # check .."ไป"
    $str = strpos($message, "ไป");


    if($str !== false){ // ถ้ามีคำว่าไป
        $txt = trim($message);
        $explode_txt = explode("ไป",$txt);

        foreach ($explode_txt as $txt_ ) {
            if($txt_ != ""){
                $message = "ไป";
                $message = $message.$txt_;
            }else{
                $message = "ไปไหนดี";
            }
        }
    }


    # check .."งาน"
    $str = strpos($message, "งาน");

    if($str !== false){ // ถ้ามีคำว่าไป
        $message = "งานหนัก";
    }

    # check .."ป้อ"
    $str = strpos($message, "ป้ออ");
    $respond_por = ["ป้ออ","ป้ออ_2"];
    $respond_por_text = ['ว่าไงลูกก','ไงหน้าหี','กรี๊ดดดดดดดดดดดด'];
    if($str !== false){ // ถ้ามีคำว่าไป
        $message = $respond_por[array_rand($respond_por,1)];
    }
##########################

    // print_r($message);

    # TYPE
    $typeTxT = 'text';
    $typeLocation = ['location','title','address','latitude','longitude'];
    $typeImage    = 'image';

    #said
    $sayHi_1          = ['type'=>$typeTxT,'msg'=>'สวัสดีจ้าาา'];
    $sayHi              = ['type'=>$typeTxT,'msg'=>'สวัสดีจ้าาา'];
    $sayWhat_1      = ['type'=>$typeTxT,'msg'=>'อะไรล่าาา'];
    $sayWhat_2      = ['type'=>$typeTxT,'msg'=>'ไม่บอก'];
    $sayWho_1       = ['type'=>$typeTxT,'msg'=>'ไม่บอก อิอิ'];
    $sayWorkHard_1 = ['type'=>$typeTxT,'msg'=>'ทำงานเหนื่อยมั้ยฮะ' ];

    $sayWhere_1 = null;
    #ไป
    if(isset($txt_)){
        $sayWhere_1     = ['type'=>$typeTxT,'msg'=>'https://www.google.com/maps/search/?api=1&query='.$txt_];
    }
    $sayWhere_2     = ['type'=>$typeTxT,'msg'=>'อยากไปไหนพิมพ์ ไป ตามด้วยสถานที่ เช่น "ไปจุตจักร" '];

    #งาน

    #call 
    $callName_Toey_1     = ['type'=>'text','msg'=>'เต้ยไม่อยู่'];
    $callName_Tum_1     = ['type'=>'text','msg'=>'เดี๋ยวตั้มมาตอบ'];

    #Location
    $getLocationName     = ['type'=>$typeLocation[0],'msg'=>'อยากไปที่ไหน บอกมาสิ','title'];
    $getLocation     = ['type'=>$typeLocation[0],'msg'=>'https://www.google.com/maps/search/?api=1&query='];

    #Image
    $srcImages      =  [
                                'hachi_1'=>'https://www.picz.in.th/images/2018/10/23/kyFmXE.th.jpg',
                                'hachi_2'=>'https://www.picz.in.th/images/2018/10/23/kF1F4y.th.jpg',
                                'namtarn_1'=>'https://www.picz.in.th/images/2018/10/23/kyIcaR.th.jpg',
                                'pull_1'=>'https://www.picz.in.th/images/2018/10/23/kyIX4y.th.jpg',
                                'ping_1'=>'https://www.picz.in.th/images/2018/10/23/kyMQB1.th.jpg',
                                'por_1'=>'https://www.picz.in.th/images/2018/10/23/kF1YXE.md.jpg'
                                ];

    #Call Image
    $callHachi_1     = ['type'=>$typeImage,'msg'=>'ฮับ','originalContentUrl'=>$srcImages['hachi_1'],'previewImageUrl'=>$srcImages['hachi_1']];
    $callHachi_2    = ['type'=>$typeImage,'msg'=>'ฮับ','originalContentUrl'=>$srcImages['hachi_2'],'previewImageUrl'=>$srcImages['hachi_2']];
    $callNamtarn_1     = ['type'=>$typeImage,'msg'=>'ฮับ','originalContentUrl'=>$srcImages['namtarn_1'],'previewImageUrl'=>$srcImages['namtarn_1']];
    $callPull_1      = ['type'=>$typeImage,'msg'=>'ฮับ','originalContentUrl'=>$srcImages['pull_1'],'previewImageUrl'=>$srcImages['pull_1']];
    $callPing_1     = ['type'=>$typeImage,'msg'=>'ฮับ','originalContentUrl'=>$srcImages['ping_1'],'previewImageUrl'=>$srcImages['ping_1']];
   
   #Call Image Friend
    $callPor_1     = ['type'=>$typeImage,'msg'=>'ฮับ','originalContentUrl'=>$srcImages['por_1'],'previewImageUrl'=>$srcImages['por_1']];
    $callPor_2     = ['type'=>'text','msg'=> $respond_por_text[array_rand($respond_por_text,1)]];
    $msg    = array(
                            'สวัสดี'    =>   $sayHi,
                            'ดี'		=>   $sayHi,
                            'hi'        =>   $sayHi,
                            'อะไร'       =>   $sayWhat_1,
                            'อะไรอะ'      =>   $sayWhat_2,
                            'ใคร'        =>   $sayWho_1,
                            'ใครอะ'      =>   $sayWho_1,
                            'ใคร อะ'     =>   $sayWho_1,
                            'ใคร อ่ะ'    =>   $sayWho_1,
                            'ใครอ่ะ'    =>   $sayWho_1,
                            'เต้ย'       =>   $callName_Toey_1,
                            'ตั้ม'      =>   $callName_Tum_1,
                            'ไป'         =>   $sayWhere_2,
                            'ไปไหนดี' 	=>   $sayWhere_2,
                           // $message    =>    ($message == "ไปไหนดี") ? $sayWhere_2 : $sayWhere_1,
                            #Chihuahua
                            'ฮะจิ'       =>    $callHachi_1,
                            'อัจจิ'       =>  $callHachi_2,
                            'น้ำตาล' =>    $callNamtarn_1,
                            'พลูโต'    =>    $callPull_1,
                            'พี่พลู'  =>    $callPull_1,
                            'พู'          =>    $callPull_1,
                            'พลู'        =>    $callPull_1,
                            'ปิง'        =>    $callPing_1,
                            'ปิงปิง'   =>    $callPing_1,
                            #Friend
                            'งานหนัก' =>  $sayWorkHard_1,
                            'ป้ออ' =>  $callPor_1,
                            'ป้ออ_2' =>  $callPor_2
                          );

    $check_message_input = array(
                                        [
                                            'message'  => $msg,
                                        ]
                                     );

 // print_r(json_encode($check_message_input));

    //getMesssage($message,$arrayJson,$arrayHeader);

getResponse($message,$arrayJson,$arrayHeader,$check_message_input,$msg);


function getResponse($message,$arrayJson,$arrayHeader,$check_message_input,$msg)
{
    // $message = 'น้ำตาล';
    $arrayPostData['replyToken'] = $arrayJson['events'][0]['replyToken'];
    // print_r($check_message_input);
    foreach ($check_message_input as $check_msg) {

        $_MessageType = $check_msg['message'][$message]['type'];
        $_msg              = $check_msg['message'][$message]['msg'];
    // echo $_msg;
        if($_MessageType == "text"){

            $arrayPostData['messages'][0]['text']  = $_msg;

        }else if($_MessageType == "image"){

            $arrayPostData['messages'][0]['originalContentUrl'] = $check_msg['message'][$message]['originalContentUrl'];
            $arrayPostData['messages'][0]['previewImageUrl']  = $check_msg['message'][$message]['previewImageUrl'];

        }else if($_MessageType == "location"){
            $arrayPostData['messages'][0]['type']       = "location";
            $arrayPostData['messages'][0]['title']        = "สยามพารากอน";
            // $arrayPostData['messages'][0]['address']   =   "13.7465354,100.532752";
            // $arrayPostData['messages'][0]['latitude']    = "13.7465354";
            // $arrayPostData['messages'][0]['longitude'] = "100.532752";
        }

        #set Type
        $arrayPostData['messages'][0]['type'] = $_MessageType;

    }
 // print_r($arrayPostData);
   replyMsg($arrayHeader,$arrayPostData);

}




function getMesssage($message,$arrayJson,$arrayHeader){
    $arrayPostData['replyToken'] = $arrayJson['events'][0]['replyToken'];
        if($message == "สวัสดี"){
            $arrayPostData['messages'][0]['type'] = "text";
            $arrayPostData['messages'][0]['text'] = "สวัสดีจ้าาา";
        }
        #ตัวอย่าง Message Type "Sticker"
        else if($message == "อะไร" || $message == "อะไรอะ" ){
            $arrayPostData['messages'][0]['type'] = "text";
            $arrayPostData['messages'][0]['text'] = "ไม่รู้";
        }       
         else if($message == "ใครอะ" || $message == "ใครอ่ะ" ){ 
            $arrayPostData['messages'][0]['type'] = "text";
            $arrayPostData['messages'][0]['text'] = "ไม่บอก อิอิ";
        }
        #ตัวอย่าง Message Type "Image"
        else if($message == "รูปน้องแมว"){
            $image_url = "https://i.pinimg.com/originals/cc/22/d1/cc22d10d9096e70fe3dbe3be2630182b.jpg";
            $arrayPostData['messages'][0]['type'] = "image";
            $arrayPostData['messages'][0]['originalContentUrl'] = $image_url;
            $arrayPostData['messages'][0]['previewImageUrl'] = $image_url;
        }
        #ตัวอย่าง Message Type "Location"
        else if($message == "พิกัดสยามพารากอน"){
            $arrayPostData['messages'][0]['type'] = "location";
            $arrayPostData['messages'][0]['title'] = "สยามพารากอน";
            $arrayPostData['messages'][0]['address'] =   "13.7465354,100.532752";
            $arrayPostData['messages'][0]['latitude'] = "13.7465354";
            $arrayPostData['messages'][0]['longitude'] = "100.532752";
        }
        #ตัวอย่าง Message Type "Text + Sticker ใน 1 ครั้ง"
        else if($message == "ลาก่อน"){
            $arrayPostData['messages'][0]['type'] = "text";
            $arrayPostData['messages'][0]['text'] = "อย่าทิ้งกันไป";
            $arrayPostData['messages'][1]['type'] = "sticker";
            $arrayPostData['messages'][1]['packageId'] = "1";
            $arrayPostData['messages'][1]['stickerId'] = "131";
        }else if($message == "กินอะไรยัง"){
            $arrayPostData['messages'][0]['type'] = "text";
            $arrayPostData['messages'][0]['text'] = "ยังเลย";
        }else if($message == "เต้ย" || $message == "เต้ย ตื่นยัง" || $message == "ตื่นยัง"){
            $arrayPostData['messages'][0]['type'] = "text";
            $arrayPostData['messages'][0]['text'] = "เต้ยไม่อยู่ อิ้อิ้";
        }/*else{
            $arrayPostData['messages'][0]['type'] = "text";
            $arrayPostData['messages'][0]['text'] = "จุ๊ๆ";
        }*/

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