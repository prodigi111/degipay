<?php
require '../../connect.php';

$http_req = json_decode(file_get_contents('php://input'), true);
if(!isset($http_req['data']) && !isset($http_req['type'])) die();
file_put_contents('whatsapp.json', json_encode($http_req, JSON_PRETTY_PRINT));

$type = $http_req['type'];
$data = $http_req['data'];

if($type == 'chat') {
    
    $fromNumber      = $data['from'];
    $chat_text       = $data['message']['pesan'];
    $chat_lower      = strtolower($chat_text);
    $chat_from       = (isset($data['group']['name'])) ? 'group' : 'person';
    $group_id        = ($chat_from == 'group') ? str_replace('@g.us','',$data['group']['id']) : '?';
    $explodeTagar    = explode('#', $chat_text);
    
    if(count($explodeTagar) == 3 && $fromNumber == filter_phone('62', conf('Whatsapp', c4))) {
        require 'bot/admin-order.php';
    }
    
}

if(isset($output)) print json_encode($output); 
