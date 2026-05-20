<?php /**
            * MHSTORE - Copyright 2022 - v1.1.0
            *
            *
            * LICENSE: MHSTORE
            * @package     MHSTORE
            * @author     MHSTORE <support 081902013748>
            * @copyright  2021 - 2023 MHstore
            * @license    http://www.mhgroup.my.id/  MHstore
            * @version    v1.1.0
            * @link       https://mhgroup.my.id 
            
            $result = json_decode(file_get_contents('https://lc.mhgroup.my.id/api/validate/host/'.$_SERVER['SERVER_NAME'].'/3'), true);

            if($result['status'] != 200) {
            $html = "<div align='center'>
    <table width='100%' border='0' style='padding:15px; border-color:#F00; border-style:solid; background-color:#FF6C70; font-family:Tahoma, Geneva, sans-serif; font-size:22px; color:white;'>

    <tr>

        <td><b>Anda tidak memiliki izin untuk menggunakan aplikasi ini. Pesan dari server adalah: <%returnmessage%> <br > Hubungi Developer Untuk Mendapatkan Licenci +6281902013748.</b></td >

    </tr>

    </table>

</div>";
            $search = '<%returnmessage%>';
            $replace = $result['message'];
            $html = str_replace($search, $replace, $html);


            die( $html );

            } */
            ?>
        