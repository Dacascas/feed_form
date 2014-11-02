<?php
/**
 * Created by PhpStorm.
 * User: Админ
 * Date: 02.11.2014
 * Time: 12:35-14.00
 */

$m = [];

if(count($_POST) > 0){
    if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
        $m[] = "Пожалуйста, введите действительный адрес электронной почты";
    } else if(!filter_var($_POST['phone'], FILTER_VALIDATE_REGEXP, $options = array(
        'options' => array(
            'default' => 0,
            'regexp' => '/^\+380\([\d]{2}\)[\d]{3}-[\d]{2}-[\d]{2}$/'
        )
    ))){
        $m[] = "Введите телефон в правильном формате +380(__)___-__-__";
    } else if(strlen($_POST['comment']) < 10){
        $m[] = "Ваше обращение должно состоять как минимум из 10 символов";
    }
    if(count($m) == 0){
        //send feedback
        $m[] = 'Спасибо, Ваше обращение удачно отправлено';
    }
}

require_once('html.php');