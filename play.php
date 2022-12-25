<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link rel="stylesheet" href="css/bootstrap-reboot.min.css"/>
	<link rel="stylesheet" href="css/bootstrap-grid.min.css"/>
	<link rel="stylesheet" href="css/owl.carousel.min.css"/>
	<link rel="stylesheet" href="css/slider-radio.css"/>
	<link rel="stylesheet" href="css/select2.min.css"/>
	<link rel="stylesheet" href="css/magnific-popup.css"/>
	<link rel="stylesheet" href="css/main.css"/>
	<link rel="shortcut icon" href="favicon.ico"/>
	<title>Play TV | TataPlay Online</title>
	<script type='text/javascript' src='https://content.jwplatform.com/libraries/IDzF9Zmk.js'></script>
    <script type="text/javascript">jwplayer.key = 'Khpp2dHxlBJHC8MCmLnBuV2jK/DwDnJMniwF6EO9HC/riJ712ZmbHg==';</script>
</head>

<body>
	<!-- header (hidden style) -->
	<header class="header header--hidden">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="header__content">
						<button class="header__menu" type="button">
							<span></span>
							<span></span>
							<span></span>
						</button>

						<a href="dashboard.php" class="">
							<img src="img/tata-sky-logo.png" hieght="80" width="100" alt="Watch TataPlay Channels Live Here" />
						</a>

						<ul class="header__nav">
						    <li class="header__nav-item">
								<a class="header__nav-link" href="dashboard.php"> <?php echo htmlentities('<--'); ?> Go Back </a>
							</li>
							<li class="header__nav-item">
								<a class="header__nav-link" href="app/index.php"> Playlist | Logout </a>
							</li>
						</ul>

						<div class="header__actions">

						</div>
					</div>
				</div>
			</div>
		</div>
	</header>
	<!-- end header -->

	<!-- details -->
	<section class="section section--head section--head-fixed section--gradient section--details-bg">
		<div class="section__bg" data-bg="img/netimi.jpg"></div>
		<div class="container">
			<!-- article -->
			<div class="article">
				<div class="row">
					<div class="col-12 col-xl-8">
						
						<!-- article content -->
						<div class="article__content">
							<h1 id="stv_title"></h1>
							<ul class="list">
								<li id="stv_category"></li>
								<li id="stv_language"></li>
							</ul>
						</div>
						<!-- end article content -->

					</div>

					<!-- video player -->
					<div class="col-12 col-xl-15">
						
						<!--Player Here-->
						<div class="container">
    						<div id="vplayer" style="height: auto; text-align: center;"></div>
    					</div>
						<!--//Player Here-->
	
					</div>
					<!-- end video player -->
				</div>
			</div>
		</div>
		</div>
	</section>
	<!--//details-->

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
  jwplayer("vplayer").setup(
    {
        sources:
        [
            { file:playurl}
        ],
        autostart: false,
        width:"100%",
        image: poster,
        height:"auto",
        stretching:"uniform",
        duration:"",
        preload:"metadata",
        androidhls:"true",
        hlshtml:"false",
        primary:"html5",
        startparam:"start",
        playbackRateControls:[0.25,0.5,0.75,1,1.25,1.5,2],
        logo:
        {
            file:poster,
            link:"",
            position:"top-right",
            margin:"5",
            hide:true
        }
    });
}

function setupdrmplayer(playurl, drmurl, poster)
{
  jwplayer("vplayer").setup(
   {
  "playlist": [
    {
      "sources": [
        {
          "default": false,
          "type": "mpd",
          "file": playurl,
          "drm": {
            "widevine": {
              "url": drmurl
            }
          },
          "label": "0"
        }
      ]
    }
  ],
  "logo":
    {
        "file": poster,
        "hide": true,
        "position": 'top-right'
    },
  "primary": "html5",
  "hlshtml": true,
  "image": poster,
  "autostart": false,
  "playbackRateControls":[0.25,0.5,0.75,1,1.25,1.5,2],
    });
}
</script>
</body>
</html>