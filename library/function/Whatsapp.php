 <?php
class Whatsapp
{

    public $base_url = 'https://wa.sifren.my.id/'; // masukan link


    private function connect($x, $n = '')
    { 
   
       $curl = curl_init(); 
         curl_setopt($curl, CURLOPT_URL , $this->base_url . $n);
         curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
         curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
         curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST'); 
         curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($x));  
         curl_setopt($curl, CURLOPT_HTTPHEADER, array(
         'Content-Type: application/json'));
        $response = curl_exec($curl);
        curl_close($curl); 
        
    }

    public function sendMessage($phone, $msg)
    {
        return $this->connect([
            'api_key' => conf('WhatsApp',2),
            'sender' => conf('WhatsApp',3),
            'number' => $phone,
            'message' => $msg 
            ] , 'send-message');
    }

    public function sendPicture($phone, $caption, $url, $filetype)
    {
        return $this->connect([
            'api_key' => conf('WhatsApp',2),
            'sender' => conf('WhatsApp',3),
            'number' => $phone,
            'media_type' => 'image',
            'caption' => $Message,
            'url' => $url
        ], 'send-media');
    }

    public function sendDocument($phone, $filetype, $filename, $url )
    {
        return $this->connect([

            'number' => $phone,
            'filetype' => $filetype,
            'filename' => $filename,
            'url' => $url
        ], 'v2/send-media');
    }

    public function sendAudio($phone, $voice, $url, $filetype)
    {
        return $this->connect([

            'number' => $phone,
            'filetype' => $filetype,
            'voice' => $voice,
            'url' => $url
        ], 'v2/send-media');
    }
}