<?php
// !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
// Все файлы сохранять в кодировке UTF-8 !!!!!!!!!!!!!!!!
// !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

// зарезервированные имена переменных:
// $authorized - содержит статус авторизации пользователя

// эта строчка обязательна к подключению всеми скриптами
require_once($_SERVER['DOCUMENT_ROOT'] . "/prerequisites.php");

// если нужна проверка авторизации пользователя, подключаем следующий файл
// require_once(INCLUDE_PATH . "utils/auth.php"); // при неавторизованном пользователе будет произведён переход на стартовую страницу

// проверка, что пользователь авторизован:
// if($authorized) { пользователь авторизован }

// если хотим отобразить определённую страницу, то пишем:
// $tplEngine->assign("page","merchant"); // merchant - имя файла *.tpl, который будет показан на месте главного контента
// $tplEngine->display("index.tpl");

// AJAX:
// все имена файлов, отвечающих за взаимодействие через AJAX - начинаются с x_, например: x_auth.php - авторизация через AJAX.

// если надо отослать ответ на AJAX-запрос, то пишем
// echo json_encode($json_data); // $json_data - подготовленный массив данных, например, array('status' => 'ok', 'data' => 1234);



?>