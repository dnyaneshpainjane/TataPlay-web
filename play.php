<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" href="https://img.icons8.com/doodle/480/000000/circled-play.png" type="image/gif" sizes="16x16">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="//content.jwplatform.com/libraries/SAHhwvZq.js"></script>
    <script type='text/javascript' src='https://content.jwplatform.com/libraries/IDzF9Zmk.js'></script>
    <script type="text/javascript">jwplayer.key = 'Khpp2dHxlBJHC8MCmLnBuV2jK/DwDnJMniwF6EO9HC/riJ712ZmbHg==';</script>
    <title>Video Player</title>
    
</head>
<body>
    
    <div id="vplayer"></div>

    <script>var channel_id = "<?php if(isset($_GET['id'])){ print($_GET['id']); } ?>";</script>
<script src="js/jquery-3.5.1.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/owl.carousel.min.js"></script>
<script src="js/slider-radio.js"></script>
<script src="js/select2.min.js"></script>
<script src="js/smooth-scrollbar.js"></script>
<script src="js/jquery.magnific-popup.min.js"></script>
<script src="js/main.js"></script>
<script>
checksession();
function checksession()
{
    $.ajax({
        "url": "app/login.php",
        "type": "GET",
        "data": "status=1",
        "success": function(data)
        {
            try { data = JSON.parse(data); }catch(err){}
            if(data.status == "success")
            {
                load_tv_detail();
            }
            else
            {
                alert("Please Login To TataPlay Account First");
                window.location = "index.php";
            }
        },
        "error": function(resp, nmc, textStatus)
        {
            alert("Please Login To TataPlay Account First");
            window.location = "index.php";
        }
    });
}

function load_tv_detail()
{
    $.ajax({
        "url": "app/details.php",
        "type": "POST",
        "data":"id=" + channel_id,
        "beforeSend":function(xhr)
        {

        },
        "success":function(data)
        {
            try { data = JSON.parse(data); }catch(err){}
            if(data.status == "success")
            {
                $("#stv_title").html(data.data.title);
                $("#stv_category").html(data.data.category);
                $("#stv_language").html('Indian');
                setupdrmplayer(data.data.playurl, data.data.drmurl.widevine, data.data.logo);
                
            }
            else
            {
              $("#stv_title").html(data.msg);
              $("#stv_category").html("Error");
              $("#stv_language").html("404");
            }
            
        },
        "error":function(data)
        {
          $("#stv_title").html("No Data Found For This Channel");
          $("#stv_category").html("Error");
          $("#stv_language").html("404");
        }
    });
}
function setupplayer(playurl, poster)
{
    jwplayer("vplayer").setup({
        controls: true,
        displaytitle: false,
        fullscreen: "auto",
        primary: 'html5',
        stretching: "",
        image: poster,
        autostart: true,
        mute: false,
        skin: {
          name: 'Netflix',
        },
        captions: {
          color: '#FFF',
          fontSize: 14,
          backgroundOpacity: 0,
          edgeStyle: 'raised'
        },
        playlist: [{
          title: "Network Stream",
          //description: "",
          image: "",
          sources: [{
            file: playurl,
            label: '4K',
            'type': 'mpd',
            primary: 'html5',
          }, {}, {}, {}],
          captions: [{}, {}],
        }]
      });
}

function setupdrmplayer(playurl, drmurl, poster)
{
    jwplayer("vplayer").setup({
        controls: true,
        displaytitle: false,
        fullscreen: "auto",
        primary: 'html5',
        stretching: "",
        image: poster,
        autostart: true,
        mute: false,
        skin: {
          name: 'Netflix',
        },
        captions: {
          color: '#FFF',
          fontSize: 14,
          backgroundOpacity: 0,
          edgeStyle: 'raised'
        },
        playlist: [{
          title: "Network Stream",
          //description: "",
          image: "",
          sources: [{
            file: playurl,
            drm: {
              "widevine": {
                "url": drmurl
              }
            },
            label: '0',
            'type': 'mpd',
            primary: 'html5',
          }, {}, {}, {}],
          captions: [{}, {}],
        }]
      });

}
</script>
</html>