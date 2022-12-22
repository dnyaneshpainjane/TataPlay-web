<?php

include('_functions.php');

if(!isset($TPAUTH['entitlements']) || empty($TPAUTH['entitlements']))
{
    api_res('error', 403, 'Please Login To Use TataPlay Account', '');
}

header("Content-Type: application/vnd.apple.mpegurl");
$playfilename = 'tataplay_'.md5(time().'lkdncwkdcewjdcjpoj').'.m3u';
header("Content-Disposition: inline; filename=$playfilename");

$streamenvproto = "http";

if($_SERVER['HTTPS'] == "on")
{
    $streamenvproto = "https";
}

$local_ip = getHostByName(php_uname('n'));
if($_SERVER['SERVER_ADDR'] !== "127.0.0.1"){ $plhoth = $_SERVER['HTTP_HOST']; }else{ $plhoth = $local_ip; }


if(file_exists('secure/channels'))
{
    $getRKNL = @file_get_contents('secure/channels');
    $looCNL = @json_decode($getRKNL, true);
    if(!empty($looCNL))
    {
        $inus_data = '#EXTM3U'.PHP_EOL;
        foreach($looCNL as $vTVC)
        {
            $inus_data .= '#EXTINF:-1 tvg-id="'.$vTVC['id'].'" tvg-name="'.$vTVC['title'].'" tvg-country="IN" tvg-logo="'.$vTVC['logo'].'" tvg-chno="'.$vTVC['id'].'" group-title="",'.$vTVC['title'].PHP_EOL;
            $inus_data .= '#KODIPROP:inputstream=inputstream.adaptive'.PHP_EOL;
            $inus_data .= '#KODIPROP:inputstreamaddon=inputstream.adaptive'.PHP_EOL;
            $inus_data .= '#KODIPROP:inputstream.adaptive.manifest_type=mpd'.PHP_EOL;
            $inus_data .= '#KODIPROP:inputstream.adaptive.license_type=com.widevine.alpha'.PHP_EOL;
            $inus_data .= '#KODIPROP:inputstream.adaptive.license_key='.$streamenvproto."://".$plhoth.str_replace(basename($_SERVER['PHP_SELF']), '', $_SERVER['PHP_SELF']).'wvproxy.php?id='.$vTVC['id'].PHP_EOL;
            $inus_data .= $streamenvproto."://".$plhoth.str_replace(basename($_SERVER['PHP_SELF']), '', $_SERVER['PHP_SELF']).'manifestproxy.mpd?id='.$vTVC['id'].'&e=.mpd'.PHP_EOL;
        }
        print($inus_data);
        exit();
    }
}
else
{
    http_response_code(404); exit();
}

?>