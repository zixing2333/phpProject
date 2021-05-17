<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

// 应用公共文件
function mailto($to, $title, $content) {
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug  = 0;                      //0为关闭调试
        $mail->isSMTP();                                            //Send using SMTP
        $mail->CharSet    = 'utf-8';
        $mail->Host       = 'smtp.163.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'zixing2333@163.com';                     //SMTP username
        $mail->Password   = 'EPEHNSCSJFERLGUV';                               //SMTP password 授权码
        $mail->SMTPSecure = 'ssl';        //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port       = 465;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

        //Recipients
        $mail->setFrom('zixing2333@163.com', 'zixing2333');
        $mail->addAddress($to);     //Add a recipient

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = $title;
        $mail->Body    = $content;

        return $mail->send();
    } catch (Exception $e) {
        \exception($mail->ErrorInfo, 1001);
    }
}

//span标签转换成a标签
function replace($data) {
    return str_replace('span', 'a', $data);
}

//字符串转成数组，以|分割
function strToArray($data) {
    return explode('|',$data);
}