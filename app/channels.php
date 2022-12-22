<?php

include('_functions.php');

if(!isset($TPAUTH['entitlements']) || empty($TPAUTH['entitlements']))
{
    api_res('error', 403, 'Please Login To Use TataPlay Account', '');
}

$tPChannels = array();

if(isset($_GET['list']) && $_GET['list'] == 1 || $_GET['list'] == "1")
{
    if(file_exists('secure/channels'))
    {
        $getRKNL = @file_get_contents('secure/channels');
        $looCNL = @json_decode($getRKNL, true);
        if(!empty($looCNL))
        {
            foreach($looCNL as $vTVC)
            {
                $tPChannels[] = array('id' => $vTVC['id'],
                                      'title' => $vTVC['title'],
                                      'logo' => 'https://res.cloudinary.com/tatasky/image/fetch/f_auto,fl_lossy,q_auto/'.$vTVC['logo']);
            }
            api_res('success', 200, 'OK', $tPChannels);
        }
    }
    api_res('error', 555, 'Please Generate Channel List', array());
}

if(isset($_GET['search']) && !empty($_GET['search']))
{
    if(file_exists('secure/channels'))
    {
        $getRKNL = @file_get_contents('secure/channels');
        $looCNL = @json_decode($getRKNL, true);
        if(!empty($looCNL))
        {
            foreach($looCNL as $vTVC)
            {
                if(stripos($vTVC['title'], $_GET['search']) !== false)
                {
                    $tPChannels[] = array('id' => $vTVC['id'],
                                          'title' => $vTVC['title'],
                                          'logo' => 'https://res.cloudinary.com/tatasky/image/fetch/f_auto,fl_lossy,q_auto/'.$vTVC['logo']);
                }
            }
            api_res('success', 200, 'OK', $tPChannels);
        }
    }
    api_res('error', 404, 'Channels Not Found', array());
}


$tPChannelApi = 'https://tm.tapi.videoready.tv/content-detail/pub/api/v1/channels?limit=1000';
$tPChead = array('Accept-Language: en-US,en;q=0.9',
                'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/104.0.0.0 Safari/537.36',
                'device_details: {"pl":"web","os":"WINDOWS","lo":"en-us","app":"1.36.63","dn":"PC","bv":104,"bn":"CHROME","device_id":"'.$DEVICE_ID.'","device_type":"WEB","device_platform":"PC","device_category":"open","manufacturer":"WINDOWS_CHROME_104","model":"PC","sname":""}',
                'locale: ENG',
                'platform: web',
                'Referer: https://watch.tataplay.com/',
                'Origin: https://watch.tataplay.com');
$process = curl_init($tPChannelApi);
curl_setopt($process, CURLOPT_CUSTOMREQUEST, "GET");
curl_setopt($process, CURLOPT_HTTPHEADER, $tPChead);
curl_setopt($process, CURLOPT_HEADER, 0);
curl_setopt($process, CURLOPT_TIMEOUT, 10);
curl_setopt($process, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($process, CURLOPT_FOLLOWLOCATION, 1);
$tSout = curl_exec($process);
curl_close($process);
if(!empty($tSout))
{
    $chndata = @json_decode($tSout, true);
}

foreach($TPAUTH['entitlements'] as $userent)
{
    foreach($chndata['data']['list'] as $channels)
    {
        foreach($channels['entitlements'] as $chwisent)
        {
            if($userent['pkgId'] == $chwisent)
            {
                if(!empty($channels['id']) && !empty($channels['title']) && !empty($channels['image']) && !empty($channels['entitlements']) && !empty($channels['offerId']['epids']))
                {
                    $tPChannels[] = array('id' => $channels['id'],
                                          'title' => $channels['title'],
                                          'logo' => $channels['image'],
                                          'entitlements' => $channels['entitlements'],
                                          'epids' => $channels['offerId']['epids']);
                }
            }
        }
    }
}

if(!empty($tPChannels))
{
    @file_put_contents('secure/channels', json_encode($tPChannels));
    api_res('success', 200, 'Channels Generated Successfully', array());
}
else
{
    api_res('error', 500, 'Failed To Generate Channels', array());
}


?>