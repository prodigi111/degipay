<?php
function conf($code,$number) {
    global $call;
    $code=strtolower($code);$number=strtolower($number);
    if(stristr($number,'c')) {
        return $call->query("SELECT $number FROM conf WHERE code = '$code'")->fetch_assoc()[$number];
    } else {
        return $call->query("SELECT c$number FROM conf WHERE code = '$code'")->fetch_assoc()['c'.$number];
    }
}

function fee($level,$code,$number) {
    global $call;
    $code=strtolower($code);$number=strtolower($number);
    if(stristr($number,'c') AND $level == 'Basic') {
        return $call->query("SELECT $number FROM conf WHERE code = '$code'")->fetch_assoc()[$number];
    } else {
        return $call->query("SELECT c$number FROM conf WHERE code = '$code'")->fetch_assoc()['c'.$number];
    }
}

function sessResult($sts,$msg) {
    $alert = ($sts == 'true') ? 'success' : 'danger';
    return '<div class="alert alert-'.$alert.' alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.$msg.'</div>';
}

function price($level,$price,$x,$req = 'price') {
    if($x == 'X') {
        if(conf('trxmanual', 2) == '+') {
            $profit = (strtolower($level) == 'basic') ? conf('trxmanual',3) : conf('trxmanual',4);
            return ($req == 'price') ? ($price+$profit) : $profit;
        } else if(conf('trxmanual',2) == '%') {
            $profit = (strtolower($level) == 'basic') ? $price*conf('trxmanual',3) : $price*conf('trxmanual',4);
            return ($req == 'price') ? ($price+$profit) : $profit;
        } else {
            return ($req == 'price') ? 0 : 0;
        }
    } else {
        if(conf('trxmove', 2) == '+') {
            $profit = (strtolower($level) == 'basic') ? conf('trxmove',3) : conf('trxmove',4);
            return ($req == 'price') ? ($price+$profit) : $profit;
        } else if(conf('trxmove',2) == '%') {
            $profit = (strtolower($level) == 'basic') ? $price*conf('trxmove',3) : $price*conf('trxmove',4);
            return ($req == 'price') ? ($price+$profit) : $profit;
        } else {
            return ($req == 'price') ? 0 : 0;
        }
    }
}

function point($price,$profit,$x) {
    if($x == 'X') {
        if(conf('trxmanual',5) == '+') {
            return ($profit < conf('trxmanual',6)) ? $profit : conf('trxmanual',6);
        } else if(conf('trxmanual',5) == '%') {
            $point = $price * conf('trxmanual',6);
            return ($profit < $point) ? $profit : $point;
        } else {
            return 0;
        }
    } else {
        if(conf('trxmove',5) == '+') {
            return ($profit < conf('trxmove',6)) ? $profit : conf('trxmove',6);
        } else if(conf('trxmove',5) == '%') {
            $point = $price * conf('trxmove',6);
            return ($profit < $point) ? $profit : $point;
        } else {
            return 0;
        }
    }
}

function select_opt($type,$value,$name) {
    $selected = ($type == $value) ? ' class="text-primary" style="font-weight:600" selected' : '';
    return '<option value="'.$value.'"'.$selected.'>'.$name.'</option>';
}

function exServices($value,$text) {
    $brand = strtr(strtoupper($value),[
        'TRI' => 'THREE'
    ]);
    $ex = explode(ucfirst(strtolower($brand)), (ucfirst(strtolower($text))));
    return $ex['1'];
}

function thisPage($path = NULL, $type = NULL) {
    $pathf = explode('/', $_SERVER['REQUEST_URI']);
    if(count($pathf) >= 3) {
        $pathfi = $type ? $pathf[1].'/'.str_replace('.php', '', $pathf[2]) : 'Third Page';
    } else {
        $pathfi = str_replace('.php', '', $pathf[1]);
    }
    return ($pathfi === $path) ? true : false;
}