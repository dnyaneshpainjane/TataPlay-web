<?php

$streamenvproto = "http";
if($_SERVER['HTTPS'] == "on")
{
    $streamenvproto = "https";
}

$local_ip = getHostByName(php_uname('n'));
if($_SERVER['SERVER_ADDR'] !== "127.0.0.1"){ $plhoth = $_SERVER['HTTP_HOST']; }else{ $plhoth = $local_ip; }

$playlistLink = $streamenvproto.'://'.$plhoth.str_replace(" ", "%20", str_replace(basename($_SERVER['PHP_SELF']), '', $_SERVER['PHP_SELF']).'playlist.php?v='.time().'&e=.m3u');

?>

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Settings | TataPlay Online</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
<link rel="shortcut icon" href="../favicon.ico"/>
<style>
body
{
    background-color: #6b00dd;
}
.card
{
    background-color: #220046;
}
.tata-play-head
{
    border-bottom: 1px solid #C0C0C0;
    padding-bottom: 10px;
}
#tplabel
{
    color: #FFFFFF;
    font-weight: bold;
    margin-bottom: 3px;
}

</style>
</head>
<body>
    
<div class="card mt-4 ms-3 me-3">
  <div class="card-body">
      <p class="tata-play-head">
          <img src="../img/tata-sky-logo.png" alt="TataPlay Online" />
      </p>
      <a href="../dashboard.php" class="btn btn-light"><?php echo htmlentities('<-'); ?> Channels List</a>&nbsp;&nbsp;<a onclick="logouttataplay()" class="btn btn-danger">Logout TataPlay</a>
      <div class="mt-3">
          <input type="text" class="form-control" placeholder="Enter Playlist Here" value="<?php print(trim(strip_tags($playlistLink))); ?>" autocomplete="off" readonly=""/>
      </div>
  </div>
</div>

<script src="../js/jquery-3.5.1.min.js" onload=""></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
<script>
    checksession();
    function checksession()
    {
        $.ajax({
            "url": "login.php",
            "type": "GET",
            "data": "status=1",
            "success": function(data)
            {
                try { data = JSON.parse(data); }catch(err){}
                if(data.status == "success")
                {
                    
                }
                else
                {
                    window.location = "../index.php";
                }
            },
            "error": function(resp, nmc, textStatus)
            {
                window.location = "../index.php";
            }
        });
    }
    function logouttataplay()
    {
        if(confirm('Sure To Logout ?'))
        {
            $.ajax({
            "url": "logout.php",
            "type": "GET",
            "data": "",
            "success": function(data)
            {
                try { data = JSON.parse(data); }catch(err){}
                if(data.status == "success")
                {
                    window.location = "../index.php";
                }
                else
                {
                    
                }
            },
            "error": function(resp, nmc, textStatus)
            {
                alert("Failed To Logout");
            }
        });
        }
    }
</script>
</body>
</html>