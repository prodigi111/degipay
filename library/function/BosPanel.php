<?php
class BosPanel
{
    private $base = 'https://bospanel.com/api/v2';
    private $token;
    
    public function __construct($punten) {
        $this->token = $punten['token'];
    }
    
    public function Service() {
        $data = $this->connect($this->base,array(
            'api_token' => $this->token,
            'action' => 'packages'
        ));
        
        if(!$data) {
            return ['result' => false,'data' => null,'message' => 'Service Data Failed.'];
        } else {
            for($i = 0; $i <= count($data)-1; $i++) {
                $out[] = [
                    'name' => ucwords($data[$i]['name']),
                    'note' => $data[$i]['note'],
                    'code' => $data[$i]['id'],
                    'tipe' => $data[$i]['type'],
                    'type' => 'sosmed',
                    'min' => $data[$i]['min'],
                    'max' => $data[$i]['max'],
                    'price' => $data[$i]['rate'],
                    'refill' => '-',
                    'status' => $data[$i]['id'] ? 'available' : 'empty',
                    'category' => strtoupper($data[$i]['category_name']),
                ];
            }
            return ['result' => true,'data' => $out,'message' => 'Service Data successfully obtained.'];
        }
    }

    public function Order($service,$target,$quantity,$custom_comments=null,$custom_link=null) {
        if($custom_comments){
			$custom = $custom_comments;
		}else{
			$custom = '';
		}
		if($custom_link){
			$link = $custom_link;
		}else{
			$link = '';
		}
        $data = $this->connect($this->base.'/order',array(
            'api_id' => $this->uid,
            'api_key' => $this->key,
            'service' => $service,
            'target' => $target,
            'quantity' => $quantity,
            'custom_comments' => $custom,
            'custom_link' => $link
        ));
        
        if($data['status'] == false) {
            return ['result' => false,'data' => null,'message' => $data['data']];
        } else {
            return ['result' => true,'data' => ['trxid' => $data['data']['id'],'balance' => $data['data']['price']],'message' => 'Order Data successfully obtained.'];
        }
    }
    
    public function Status($id) {
        $data = $this->connect($this->base.'/status',array(
            'api_id' => $this->uid,
            'api_key' => $this->key,
            'id' => $id
        ));
        
        if($data['status'] == true) {
            $status = 'processing';
            if($data['data']['status'] == 'Success') $status = 'success';
            if($data['data']['status'] == 'Error') $status = 'error';
            if($data['data']['status'] == 'Partial') $status = 'partial';
            return ['result' => true,'data' => ['trxid' => $data['data']['id'],'start_count' => $data['data']['start_count'],'status' => $status,'remains' => $data['data']['remains']],'message' => 'Status Order successfully obtained.'];
        } else {
            return ['result' => false,'data' => null,'message' => $data['data']];
        }
    }

    public function Refill($id) {
        $data = $this->connect($this->base.'/refill',array(
            'api_id' => $this->uid,
            'api_key' => $this->key,
            'id_order' => $id
        ));
        
        if($data['status'] == false) {
            return ['result' => false,'data' => null,'message' => $data['data']];
        } else {
            return ['result' => true,'data' => ['id_refill' => $data['data']['id_refill']],'message' => 'Refill Order successfully obtained.'];
        }
    }

    public function StatusRefill($id,$target,$reff) {
        $data = $this->connect($this->base.'/refill_status',array(
            'api_id' => $this->uid,
            'api_key' => $this->key,
            'id_refill' => $id
        ));
        
        if($data['status'] == true) {
            $status = 'processing';
            if($data['data']['status'] == 'Success') $status = 'success';
            if($data['data']['status'] == 'Error') $status = 'error';
            if($data['data']['status'] == 'Partial') $status = 'partial';
            return ['result' => true,'data' => ['status' => $status],'message' => 'Status Refill successfully obtained.'];
        } else {
            return ['result' => false,'data' => null,'message' => $data['data']];
        }
    }
    
    public function Profil($id,$target,$reff) {
        $data = $this->connect($this->base.'/profile',array(
            'api_id' => $this->uid,
            'api_key' => $this->key
        ));
        
        if($data['status'] == true) {
            return ['result' => true,'data' => ['username' => $data['data']['username'], 'balance' => $data['data']['balance']],'message' => 'Profile successfully obtained.'];
        } else {
            return ['result' => false,'data' => null,'message' => $data['data']];
        }
    }
    
    // END POINT CONNECTION

    private function connect($end_point,$post) {
        $_post = Array();
		if (is_array($post)) {
			foreach ($post as $name => $value) {
				$_post[] = $name.'='.urlencode($value);
			}
		}
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $end_point);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        if (is_array($post)) {
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
		}
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        $chresult = curl_exec($ch);
        return json_decode($chresult, true);
    }
}