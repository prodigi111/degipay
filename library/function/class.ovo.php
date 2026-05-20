<?php
class OVO
{
    private $nomor;
    private $device;
    
    public function __construct($nomor,$device)
    {
        $this->nomor = $nomor;
        $this->device = $device;
    }

    public function sendRequest2FA()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.ovo.id/v1.0/api/auth/customer/login2FA',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{"deviceId":"'.$this->device.'","mobile":"'.$this->nomor.'"}',
            CURLOPT_HTTPHEADER => array(
                'App-Version: 3.37.0',
                'Os: Android',
                'Content-Type: application/json; charset=UTF-8',
                'Host: api.ovo.id',
                'User-Agent: okhttp/3.11.0'
                ),
            ));
        $result = curl_exec($curl);
        $reshttp = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        return ($reshttp == 200) ? ['result' => true,'message' => 'Berhasil OTP Telah dikirim.'] : ['result' => false,'message' => $result];
    }

    public function konfirmasiCode($verificationCode)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.ovo.id/v1.0/api/auth/customer/login2FA/verify',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
                "deviceId":"'.$this->device.'",
                "mobile":"'.$this->nomor.'",
                "verificationCode":"'.$verificationCode.'"}',
            CURLOPT_HTTPHEADER => array(
                'App-Version: 3.37.0',
                'Os: Android',
                'Content-Type: application/json; charset=UTF-8',
                'Host: api.ovo.id',
                'User-Agent: okhttp/3.11.0'),
                ));
        
        $result = json_decode(curl_exec($curl), true);
        curl_close($curl);
        if ($result['isSecurityCode'] == 'true') {
            return ['result' => true,'message' => 'OTP Valid.'];
        } else {
            return ['result' => false,'message' => 'Mohon mengirim otp lagi, karena sudah kadaluarsa'];
        }
    }

    public function konfirmasiSecurityCode($securityCode)
    {
        
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.ovo.id/v1.0/api/auth/customer/loginSecurityCode/verify',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
                "mobile":"'.$this->nomor.'",
                "securityCode":"'.$securityCode.'",
                "deviceUnixtime":1539175105,
                "appVersion":"3.37.0",
                "deviceId":"'.$this->device.'",
                "macAddress":"08:62:66:67:81:39",
                "osName":"Android",
                "osVersion":"5.0",
                "pushNotificationId":"FCM|e1-j8yB55QI:APA91bFan4mLCWogE4ols2OFSmz1YjgB71tKwZA0Y-IkwJSiKzG1ALJ6oxGuSQLYXLQWG8dujmdeWOdPn-gWWc_0fDcaO8BaPeZQbiF9wd3pfFU1NcYv54CUU80yPAZMS0nbNqfgHosJ"}',
            CURLOPT_HTTPHEADER => array(
                'App-Version: 3.37.0',
                'Os: Android',
                'Content-Type: application/json; charset=UTF-8',
                'Host: api.ovo.id',
                'User-Agent: okhttp/3.11.0'),
                ));
        
        $result = json_decode(curl_exec($curl), true);
        curl_close($curl);
        if (empty($result['token'])) {
            return ['result' => false, 'data' => null, 'message' => $result['message']];
        } else {
            return ['result' => true,'data' => $result['token'], 'message' => 'Berhasil login ke aplikasi OVO.'];
        }
    }

    public function seeMutation($token,$limit = 10)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.ovo.id/wallet/v2/transaction?page=1&limit='.$limit.'&productType=001',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'App-Version: 3.37.0',
                'Os: Android',
                'Content-Type: application/json; charset=UTF-8',
                'Host: api.ovo.id',
                'User-Agent: okhttp/3.11.0',
                'Authorization: '.$token),
            ));

        $result = json_decode(curl_exec($curl), true);
        curl_close($curl);

        $http = ($result['status'] == 200) ? true : false;
        $data = ($result['status'] == 200) ? $result['data'][0]['complete'] : $result['message'];
        return ['result' => $http,'data' => $data];
    }

    public function cekProfile($token)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.ovo.id/wallet/inquiry',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'App-Version: 3.37.0',
                'Os: Android',
                'Content-Type: application/json; charset=UTF-8',
                'Host: api.ovo.id',
                'User-Agent: okhttp/3.11.0',
                'Authorization: '.$token),
            ));
        $result = json_decode(curl_exec($curl), true);
        curl_close($curl);
        
        $http = ($result['status'] == 200) ? true : false;
        $data = ($result['status'] == 200) ? $result['data'] : $result['message'];
        return ['result' => $http,'data' => $data];
    }
    
    public function IsOVO($to, $amount=null)
    {
        if($amount){
			$nominal = $amount;
		}else{
			$nominal = '10000';
		}
		
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.ovo.id/v1.1/api/auth/customer/isOVO',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
                "mobile":"'.$to.'",
                "amount":"'.$nominal.'"}',
            CURLOPT_HTTPHEADER => array(
                'App-Version: 3.37.0',
                'Os: Android',
                'Content-Type: application/json; charset=UTF-8',
                'Host: api.ovo.id',
                'User-Agent: okhttp/3.11.0'),
            ));
        $result = json_decode(curl_exec($curl), true);
        curl_close($curl);
        
        if($result['code'] == "1053") {
            return ['result' => false,'data' => null,'message' => $result['message']];
        } else {
            return ['result' => true,'data' => $result];
        }
    }
    
    public function getBankList()
    {
		
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.ovo.id/v1.0/reference/master/ref_bank',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'App-Version: 3.37.0',
                'Os: Android',
                'Content-Type: application/json; charset=UTF-8',
                'Host: api.ovo.id',
                'User-Agent: okhttp/3.11.0'),
            ));
        $result = json_decode(curl_exec($curl), true);
        curl_close($curl);
        
        return ['result' => true,'data' => $result];
    }
    
    public function getNotifications($token)
    {
		
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.ovo.id/v1.0/notification/status/all?limit=5',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'App-Version: 3.37.0',
                'Os: Android',
                'Content-Type: application/json; charset=UTF-8',
                'Host: api.ovo.id',
                'User-Agent: okhttp/3.11.0',
                'Authorization: '.$token),
            ));
        $result = json_decode(curl_exec($curl), true);
        curl_close($curl);
        
        return ['result' => true,'data' => $result];
    }
    
    public function generateTrxId($token,$nominal)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.ovo.id/v1.0/api/auth/customer/genTrxId',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
                "actionMark":"TRANSFER_OVO",
                "amount":"'.$nominal.'"}',
            CURLOPT_HTTPHEADER => array(
                'App-Version: 3.37.0',
                'Os: Android',
                'Content-Type: application/json; charset=UTF-8',
                'Host: api.ovo.id',
                'User-Agent: okhttp/3.11.0',
                'Authorization: '.$token),
            ));
        $result = json_decode(curl_exec($curl), true);
        curl_close($curl);
        
        return ['result' => true,'data' => $result];
    }
    
    public function getTrxId()
    {
        return $this->trxId;
    }
    
    public function transferInquiry($token,$accountNo,$amount,$bankCode,$bankName,$message)
    {
    /**
     * transfer inquiry
     *
     * @param  string                                   $accountNo no rekening yang dituju
     * @param  int                                      $amount    jumlah yang akan ditransfer
     * @param  string                                   $bankCode  kode bank yang dituju
     * @param  string                                   $bankName  nama bank yang dituju
     * @param  string                                   $message
     * @return \Stelin\Response\TransferInquiryResponse
     */
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.ovo.id/transfer/inquiry',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
                "accountNo":"'.$accountNo.'",
                "amount":"'.$amount.'",
                "bankCode":"'.$bankCode.'",
                "bankName":"'.$bankName.'",
                "message":"'.$message.'"
            }',
            CURLOPT_HTTPHEADER => array(
                'App-Version: 3.37.0',
                'Os: Android',
                'Content-Type: application/json; charset=UTF-8',
                'Host: api.ovo.id',
                'User-Agent: okhttp/3.11.0',
                'Authorization: '.$token),
            ));
        $result = json_decode(curl_exec($curl), true);
        curl_close($curl);
        
        if($result['code'] == "401") {
            return ['result' => false,'data' => null,'message' => $result['message']];
        } else {
            return ['result' => true,'data' => $result];
        }
    }
    
    public function transferBank($token,$accountName, $accountNo, $accountNoDestination, $amount, $bankCode, $bankName, $message, $notes)
    {
    /**
     * transer antar bank
     *
     * @param  string                                  $accountName          nama akun
     * @param  string                                  $accountNo            No akun OVO Cash
     * @param  string                                  $accountNoDestination No rekening yang dituju
     * @param  int                                     $amount               jumlah yang akan ditransfer
     * @param  string                                  $bankCode             kode bank yang dituju
     * @param  string                                  $bankName             nama bank
     * @param  string                                  $message
     * @param  string                                  $notes
     * @return \Stelin\Response\TransferDirectResponse
     */
        if ($amount < 10000) {
            $echo = 'Minimal 10.000';
        }
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.ovo.id/transfer/inquiry',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
                "accountName":"'.$accountName.'",
                "accountNo":"'.$accountNo.'",
                "accountNoDestination":"'.$accountNoDestination.'",
                "amount":"'.$amount.'",
                "bankCode":"'.$bankCode.'",
                "bankName":"'.$bankName.'",
                "message":"'.$message.'",
                "notes":"'.$notes.'",
                "transactionId":"'.self::generateTrxId($token,$amount)->getTrxId().'"
            }',
            CURLOPT_HTTPHEADER => array(
                'App-Version: 3.37.0',
                'Os: Android',
                'Content-Type: application/json; charset=UTF-8',
                'Host: api.ovo.id',
                'User-Agent: okhttp/3.11.0',
                'Authorization: '.$token),
            ));
        $result = json_decode(curl_exec($curl), true);
        curl_close($curl);
        
        if($result['code'] == "401") {
            return ['result' => false,'data' => null,'message' => $result['message'] ?? $echo];
        } else {
            return ['result' => true,'data' => $result];
        }
    }
    
    public function transferOvo($token, $to_mobilePhone, $amount, $securityCode, $message = '')
    {
        if ($amount < 10000) {
            return 'Minimal 10.000';
        }
        $json = self::IsOVO($to_mobilePhone, $amount);
        if($json['data']['fullName']) {
            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.ovo.id/v1.0/api/customers/transfer',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
                "amount":"'.$amount.'",
                "trxId":"'.self::generateTrxId($token,$amount)->getTrxId().'",
                "to":"'.$to_mobilePhone.'",
                "message":"'.$message == '' ? 'Sent from OVOID' : $message.'"
            }',
            CURLOPT_HTTPHEADER => array(
                'App-Version: 3.37.0',
                'Os: Android',
                'Content-Type: application/json; charset=UTF-8',
                'Host: api.ovo.id',
                'User-Agent: okhttp/3.11.0',
                'Authorization: '.$token),
            ));
        $transfer = json_decode(curl_exec($curl), true);
        curl_close($curl);
        if (preg_match('/sorry unable to handle your request/', $transfer)) {
				$unlockTrxId = self::unlockAndValidateTrxId($token,$amount,$trxId,$securityCode);
				
				if($unlockTrxId['isAuthorized'] == 'true') {
			curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.ovo.id/v1.0/api/customers/transfer',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
                "amount":"'.$amount.'",
                "trxId":"'.self::generateTrxId($token,$amount)->getTrxId().'",
                "to":"'.$to_mobilePhone.'",
                "message":"'.$message == '' ? 'Sent from OVOID' : $message.'"
            }',
            CURLOPT_HTTPHEADER => array(
                'App-Version: 3.37.0',
                'Os: Android',
                'Content-Type: application/json; charset=UTF-8',
                'Host: api.ovo.id',
                'User-Agent: okhttp/3.11.0',
                'Authorization: '.$token),
            ));
        $result = json_decode(curl_exec($curl), true);
        curl_close($curl);
					return $result;
					exit();
				}else{
					return json_encode(array('message' => $unlockTrxId['message']));
					exit();
				}
			} else {
				return $transfer;
				exit();
			}
        } else {
			return $json;
			exit();
		}
    }
    
    public function unlockAndValidateTrxId($token,$amount,$trxId,$securityCode)
    {
		
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.ovo.id/v1.0/api/auth/customer/unlockAndValidateTrxId',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
                "trxId":"'.$trxId.'",
                "signature":"'.self::generateSignature($amount, $trxId, $this->device).'",
                "securityCode":"'.$securityCode.'"
            }',
            CURLOPT_HTTPHEADER => array(
                'App-Version: 3.37.0',
                'Os: Android',
                'Content-Type: application/json; charset=UTF-8',
                'Host: api.ovo.id',
                'User-Agent: okhttp/3.11.0',
                'Authorization: '.$token),
            ));
        $result = json_decode(curl_exec($curl), true);
        curl_close($curl);
        
        return $result;
    }
    
    public function generateSignature($amount,$trxId,$device)
    {
		
        $parameters = array($trxId,$amount,$device);
        
        return sha1(join('||', $parameters));
    }
    
    public function Logout($token)
    {
		
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.ovo.id/v1.0/api/auth/customer/logout',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'App-Version: 3.37.0',
                'Os: Android',
                'Content-Type: application/json; charset=UTF-8',
                'Host: api.ovo.id',
                'User-Agent: okhttp/3.11.0',
                'Authorization: '.$token),
            ));
        $result = json_decode(curl_exec($curl), true);
        curl_close($curl);
        
        return ['result' => true,'message' => 'Anda berhasil keluar dari aplikasi OVO.'];
    }

}