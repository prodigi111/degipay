<?php 
require '../../RGShenn.php';
require _DIR_('library/session/session');
require _DIR_('library/function/AtlanticCheckNick');

function err($x,$y,$z = null) {
    if($x == true) {
        return json_encode(['result' => true,'data' => $y,'target' => $z]);
    } else {
        return json_encode(['result' => false,'message' => $y]);
    }
}

if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && isset($data_user)) {
    if(!isset($_POST['target']) || !isset($_POST['category'])) exit(err(false,'No direct script access allowed!'));
    
    $c = isset($_POST['category']) ? strtoupper(filter($_POST['category'])) : '';
    $id = isset($_POST['target']) ? filter($_POST['target']) : '';
    $id2 = isset($_POST['target2']) ? filter($_POST['target2']) : '';
            
    if($c == 'MOBILE LEGEND')                   $res = $ACN->MobileLegends($id,$id2);
    else if($c == 'POINT BLANK')                $res = $ACN->PointBlank($id);
    else if($c == 'RAGNAROK M: ETERNAL LOVE')   $res = $ACN->RagnarokEternalLove($id);
    else if($c == 'FREE FIRE')                  $res = $ACN->FreeFire($id);
    else if($c == 'ARENA OF VALOR')             $res = $ACN->ArenaOfValor($id);
    else if($c == 'CALL OF DUTY MOBILE')        $res = $ACN->CallOfDuty($id);
    else if($c == 'PUBG MOBILE')                $res = $ACN->PUBG($id);
    else if($c == 'LAPLACE M')                  $res = $ACN->LaplaceM($id);
    else if($c == 'SPEED DRIFTERS')             $res = $ACN->SpeedDrifters($id);
    else if($c == 'LIFEAFTER CREDITS')          $res = $ACN->LifeAfter($id,$id2);
    else if($c == 'HAGO')                       $res = $ACN->HAGO($id);
    else if($c == 'VALORANT')                   $res = $ACN->Valorant($id);
    else exit(err(false,'The game is not registered, please contact the developer!'));
    
    if(isset($res['result'])) {
        if($res['result'] == true) {
            if(isset($res['data']['name'])) {
                exit(err(true,$res['data']['name'],$id.'='.$id2));
            } else {
                exit(err(false,'Player not found!'));
            }
        } else {
            exit(err(false,$res['message']));
        }
    } else {
        exit(err(false,'Connection Failed!'));
    }
} else {
	exit(err(false,'No direct script access allowed!'));
}