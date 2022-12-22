<?php

include('_functions.php');

if(!isset($TPAUTH['entitlements']) || empty($TPAUTH['entitlements']))
{
    api_res('error', 403, 'Please Login To Use TataPlay Account', '');
}

unlink('secure/_sessionData');

unlink('secure/channels');

api_res('success', 200, 'Logged Out Successfully', '');

?>