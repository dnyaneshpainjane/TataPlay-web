<?php

include('_functions.php');

if(!isset($TPAUTH['entitlements']) || empty($TPAUTH['entitlements']))
{
    api_res('error', 403, 'Please Login To Use TataPlay Account', '');
}

$id = ''; $vUData = array();
$playurl = ''; $licurl = '';
$chnSerialID = ''; $ls_session = '';

if(isset($_REQUEST['id']))
{
    $id = $_REQUEST['id'];
}

if(empty($id))
{
    api_res('error', 400, 'Channel ID Missing', '');
}

if(file_exists('secure/streams/'.$id))
{
    $licenseURL = "";
    $iJChData = @file_get_contents('secure/streams/'.$id);
    if(stripos($iJChData, '///') !== false)
    {
        $nIGS = explode('///', $iJChData);
        if(isset($nIGS[0]))
        {
            $iscac_time = base64_decode($nIGS[0]);
        }
        if(isset($nIGS[1]))
        {
            $iscac_data = base64_decode($nIGS[1]);
        }
        if(time() < $iscac_time)
        {
            $thsac = @json_decode($iscac_data, true);
            if(isset($thsac['data']['playurl']))
            {
                $licenseURL = $thsac['data']['playurl'];
            }
            if(!empty($licenseURL))
            {
                http_response_code(307);
                header("Location: $licenseURL");
                exit();
            }
        }
    }
}

//-----------------------------------------------------------------------//

$chnDetailsAPI = 'https://tm.tapi.videoready.tv/content-detail/pub/api/v4/channels/'.$id.'?platform=WEB';
$chnDlHeads = array('Accept-Language: en-US,en;q=0.9',
                    'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/104.0.0.0 Safari/537.36',
                    'device_details: {"pl":"web","os":"WINDOWS","lo":"en-us","app":"1.36.63","dn":"PC","bv":104,"bn":"CHROME","device_id":"'.$DEVICE_ID.'","device_type":"WEB","device_platform":"PC","device_category":"open","manufacturer":"WINDOWS_CHROME_104","model":"PC","sname":"'.$TPAUTH['subscriberNAME'].'"}',
                    'Referer: https://watch.tataplay.com/',
                    'Origin: https://watch.tataplay.com',
                    'Authorization: bearer '.$TPAUTH['access_token'],
                    'profileId: '.$TPAUTH['profileID'],
                    'platform: web',
                    'locale: ENG',
                    'kp: false');
$process = curl_init($chnDetailsAPI);
curl_setopt($process, CURLOPT_CUSTOMREQUEST, "GET");
curl_setopt($process, CURLOPT_HTTPHEADER, $chnDlHeads);
curl_setopt($process, CURLOPT_HEADER, 0);
curl_setopt($process, CURLOPT_TIMEOUT, 10);
curl_setopt($process, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($process, CURLOPT_FOLLOWLOCATION, 1);
$chnOut = curl_exec($process);
curl_close($process);
if(!empty($chnOut))
{
    $vUData = @json_decode($chnOut, true);
}
if(isset($vUData['message']) && stripos($vUData['message'], 'success') !== false)
{
    if(isset($vUData['data']['channelMeta']['id']))
    {
        $chnSerialID = $vUData['data']['channelMeta']['id'];
    }
    
    if(isset($vUData['data']['detail']['dashWidewinePlayUrl']))
    {
        $playurl = $vUData['data']['detail']['dashWidewinePlayUrl'];
    }
    if(isset($vUData['data']['detail']['dashWidewineLicenseUrl']))
    {
        $licurl = $vUData['data']['detail']['dashWidewineLicenseUrl'];
    }
    
    if(!empty($licurl))
    {
        $epid = fetchepid($id);
        if(empty($epid))
        {
            api_res('error', 500, 'Failed To Get DRM Token', '');
        }
        $jwtpay = genjwtpayload($epid);
        $sherlocation = 'https://tm.tapi.videoready.tv/auth-service/v1/oauth/token-service/token';
        $sherheads = array('Accept-Language: en-US,en;q=0.9',
                           'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/104.0.0.0 Safari/537.36',
                           'content-type: application/json',
                           'device_details: {"pl":"web","os":"WINDOWS","lo":"en-us","app":"1.36.63","dn":"PC","bv":104,"bn":"CHROME","device_id":"'.$DEVICE_ID.'","device_type":"WEB","device_platform":"PC","device_category":"open","manufacturer":"WINDOWS_CHROME_104","model":"PC","sname":"'.$TPAUTH['subscriberNAME'].'"}',
                           'kp: false',
                           'locale: ENG',
                           'platform: web',
                           'profileId: '.$TPAUTH['profileID'],
                           'Referer: https://watch.tataplay.com/',
                           'x-device-id: '.$DEVICE_ID,
                           'x-device-platform: PC',
                           'x-device-type: WEB',
                           'x-subscriber-id: '.$TPAUTH['subscriberID'],
                           'x-subscriber-name: '.$TPAUTH['subscriberNAME'],
                           'Authorization: bearer '.$TPAUTH['access_token'],
                           'Origin: https://watch.tataplay.com');
        $sherposts = $jwtpay;
        $process = curl_init($sherlocation);
        curl_setopt($process, CURLOPT_POST, 1);
        curl_setopt($process, CURLOPT_POSTFIELDS, $sherposts);
        curl_setopt($process, CURLOPT_HTTPHEADER, $sherheads);
        curl_setopt($process, CURLOPT_HEADER, 0);
        curl_setopt($process, CURLOPT_ENCODING, '');
        curl_setopt($process, CURLOPT_TIMEOUT, 10);
        curl_setopt($process, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($process, CURLOPT_FOLLOWLOCATION, 1);
        $vrswvx = curl_exec($process);
        curl_close($process);
        $mksaz= @json_decode($vrswvx, true);
        if(isset($mksaz['data']['token']))
        {
            $ls_session = 'ls_session='.$mksaz['data']['token'];
            $licurl = $licurl.'&'.$ls_session;
        }
    }
    
    if(!empty($chnSerialID) && !empty($playurl) && !empty($licurl))
    {
        $tv_details = array('id' => $chnSerialID,
                            'title' => $vUData['data']['channelMeta']['name'],
                            'logo' => 'https://res.cloudinary.com/tatasky/image/fetch/f_auto,fl_lossy,q_auto/'.$vUData['data']['channelMeta']['logo'],
                            'category' => $vUData['data']['channelMeta']['genre'][0],
                            'language' => '',
                            'is_drm' => 1,
                            'drm_type' => 'widevine',
                            'playurl' => $playurl,
                            'drmurl' => array('widevine' => $licurl,
                                              'playready' => ''));
        $savioutata = base64_encode(time() + 86400).'///'.base64_encode(json_encode($tv_details));
        @file_put_contents('secure/streams/'.$chnSerialID, $savioutata);
        http_response_code(307);
        header("Location: $playurl");
        exit();
        
    }
    
}


?>