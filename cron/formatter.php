<?php
class BeautyFormatter
{
    private function space($x) {
        return preg_replace('/\s+/',' ',$x);
    }
    
    private function status($x) {
        $available = ['available','active','normal'];
        return in_array(strtolower($x),$available) ? 'available' : 'empty';
    }
    
    public function check($x) {
        $y = strtolower($x);
        if(in_array($y,['failed','gagal','error','refund'])) $str = 'error';
        if(in_array($y,['pending','processing','proses'])) $str = 'processing';
        if(in_array($y,['success','sukses','berhasil'])) $str = 'success';
        return (!isset($str)) ? 'processing' : $str;
    }
    
    public function DigiflazzService($data) {
        for($i = 0; $i <= count($data)-1; $i++) {
            $subCat = preg_replace("/[^A-Z]+/",'',$data[$i]['code']);
            $Type = 'not-filtered';
            $oType = $data[$i]['category'];
            if(in_array($oType,['PULSA']) && $data[$i]['tipe'] == 'Umum') $Type = 'pulsa-reguler';
            if(in_array($oType,['PULSA']) && $data[$i]['tipe'] == 'Pulsa Transfer') $Type = 'pulsa-transfer';
            if(in_array($oType,['PULSA']) && $data[$i]['tipe'] == 'Pulsa Gift') $Type = 'pulsa-gift';
            if(in_array($oType,['VOUCHER BLANK']) && in_array($data[$i]['brand'], ['TELKOMSEL', 'INDOSAT', 'AXIS', 'SMART', 'TRI', 'XL','SMARTFREN'])) $Type = 'voucher-data';
            if(in_array($oType,['CHINA TOPUP','MALAYSIA TOPUP','PHILIPPINES TOPUP','SINGAPORE TOPUP','THAILAND TOPUP','VIETNAM TOPUP'])) $Type = 'pulsa-internasional'; 
            if(in_array($oType, ['TV']) && in_array($data[$i]['brand'], ['DECODER GOL','NEX PARABOLA','MATRIX GARUDA','ORANGE TV','NEX & GARUDA','K-VISION DAN GOL','TRANSVISION'])) $Type = 'voucher-tv'; 
            if(in_array($oType, ['AKTIVASI VOUCHER']) && in_array($data[$i]['brand'], ['TELKOMSEL','INDOSAT','AXIS','TRI'])) $Type = 'inject-voucher';
            if(in_array($oType,['DATA'])) $Type = 'paket-internet';
            if(in_array($oType,['MASA AKTIF'])) $Type = 'masa-aktif';
            if(in_array($oType,['AKTIVASI PERDANA'])) $Type = 'aktivasi-perdana'; 
            if(in_array($oType,['PAKET SMS & TELPON'])) $Type = 'paket-telepon';
            if(in_array($oType,['PLN'])) $Type = 'token-pln';
            if(in_array($oType,['E-MONEY'])) $Type = 'e-money';
            if(in_array($oType, ['VOUCHER']) && in_array($data[$i]['brand'], ['DOTA AUTO CHESS CANDY (GLOBAL)','GOOGLE PLAY US REGION','GOOGLE PLAY INDONESIA'])) $Type = 'voucher-game';
            if(in_array($oType, ['VOUCHER']) && in_array($data[$i]['brand'], ['TELKOMSEL', 'INDOSAT', 'AXIS', 'SMART', 'TRI', 'XL'])) $Type = 'voucher-data';
            if(in_array($oType, ['VOUCHER']) && in_array($data[$i]['brand'], ['WAVE GAME','GRAB', 'ITUNES US REGION', 'WIFI ID', 'ALFAMART VOUCHER', 'INDOMARET', 'ANCOL', 'CARREFOUR / TRANSMART', 'JUNGLELAND', 'H&M', 'VIDIO'])) $Type = 'voucher';
            if(in_array($oType,['GAMES'])) $Type = 'games';
            if(in_array($oType, ['GAMES']) && in_array($data[$i]['brand'], ['GARENA'])) $Type = 'voucher-game';
            if(in_array($oType,['PASCABAYAR'])) $Type = 'pascabayar';
            
            $kategori = strtr($data[$i]['tipe'], [
                'Disney+ Hotstar' => 'Disney Hotstar',
                'Customer' => 'Umum'
            ]);
            
            $out[$i]['brand']    = $data[$i]['brand'];
            $out[$i]['category'] = $data[$i]['brand'];
            $out[$i]['kategori'] = $kategori;
            $out[$i]['otype']    = $oType;
            $out[$i]['type']     = $Type;
            $out[$i]['name']     = $this->space($data[$i]['name']);
            $out[$i]['note']     = $this->space($data[$i]['note']);
            $out[$i]['code']     = $data[$i]['code'];
            $out[$i]['price']    = $data[$i]['price'];
            $out[$i]['status']   = $this->status($data[$i]['status']);
            $out[$i]['prepost']   = strtolower($data[$i]['type']);
        }
        return $out;
    }
}

$BFormat = new BeautyFormatter;