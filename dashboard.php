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
	<title>Dashboard | TataPlay Online</title>

</head>

<body>
	<!-- header (relative style) -->
	<header class="header header--static">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="header__content">

						<a href="dashboard.php" class="">
							<img src="img/tata-sky-logo.png" hieght="80" width="100" alt="Watch TataPlay Channels Live Here" />
						</a>

						<ul class="header__nav">
						    <li class="header__nav-item">
								<a class="header__nav-link" href="app/index.php"> Settings </a>
							</li>
						</ul>

						<div class="header__actions">
							<form class="header__form">
								<input autocomplete="off" class="header__form-input" onkeyup="dosearchnow()" type="text" id="tv_search_box" placeholder="I'm looking for...">
								<button onclick="dosearchnow()" class="header__form-btn" type="button"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M21.71,20.29,18,16.61A9,9,0,1,0,16.61,18l3.68,3.68a1,1,0,0,0,1.42,0A1,1,0,0,0,21.71,20.29ZM11,18a7,7,0,1,1,7-7A7,7,0,0,1,11,18Z"/></svg></button>
								<button type="button" class="header__form-close"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M14.3345 0.000183105H5.66549C2.26791 0.000183105 0.000488281 2.43278 0.000488281 5.91618V14.0842C0.000488281 17.5709 2.26186 20.0002 5.66549 20.0002H14.3335C17.7381 20.0002 20.0005 17.5709 20.0005 14.0842V5.91618C20.0005 2.42969 17.7383 0.000183105 14.3345 0.000183105ZM5.66549 1.50018H14.3345C16.885 1.50018 18.5005 3.23515 18.5005 5.91618V14.0842C18.5005 16.7653 16.8849 18.5002 14.3335 18.5002H5.66549C3.11525 18.5002 1.50049 16.7655 1.50049 14.0842V5.91618C1.50049 3.23856 3.12083 1.50018 5.66549 1.50018ZM7.07071 7.0624C7.33701 6.79616 7.75367 6.772 8.04726 6.98988L8.13137 7.06251L9.99909 8.93062L11.8652 7.06455C12.1581 6.77166 12.6329 6.77166 12.9258 7.06455C13.1921 7.33082 13.2163 7.74748 12.9984 8.04109L12.9258 8.12521L11.0596 9.99139L12.9274 11.8595C13.2202 12.1524 13.2202 12.6273 12.9273 12.9202C12.661 13.1864 12.2443 13.2106 11.9507 12.9927L11.8666 12.9201L9.99898 11.052L8.13382 12.9172C7.84093 13.2101 7.36605 13.2101 7.07316 12.9172C6.80689 12.6509 6.78269 12.2343 7.00054 11.9407L7.07316 11.8566L8.93843 9.99128L7.0706 8.12306C6.77774 7.83013 6.77779 7.35526 7.07071 7.0624Z"/></svg></button>
							</form>

							<button class="header__search" type="button">
								<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M21.71,20.29,18,16.61A9,9,0,1,0,16.61,18l3.68,3.68a1,1,0,0,0,1.42,0A1,1,0,0,0,21.71,20.29ZM11,18a7,7,0,1,1,7-7A7,7,0,0,1,11,18Z"/></svg>
							</button>

						</div>
					</div>
				</div>
			</div>
		</div>
	</header>
	<!-- end header -->

	<br/><br/>
	
	<!-- catalog -->
	<div class="catalog">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="catalog__nav">
						
					</div>

					<div class="row row--grid" id="tv_catalogue"></div>


				</div>
			</div>		

		</div>
	</div>
	<!-- end catalog -->

	<!-- footer -->
	<footer class="footer">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="footer__content">
						<div class="footer__links">
							<a href="https://watch.tataplay.com/" target="_blank">TataPlay Official Website</a>
						</div>
						<small class="footer__copyright"> This Application Is Made Only For Personal Entertainment Purposes. Please Do Not Violate Any Kind of Laws.</small>
					</div>
				</div>
			</div>
		</div>
	</footer>
	<!-- end footer -->

	
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
                load_channels('1');
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
function load_channels(page)
{
    $.ajax({
        "url": "app/channels.php",
        "type": "GET",
        "data": "list=1",
        "beforeSend":function(xhr)
        {

        },
        "success":function(data)
        {
            let mmc = "";
            try { data = JSON.parse(data); }catch(err){}
            if(data.status == "success")
            {
                $("#expage").attr("data-page", page);
                $.each(data.data, function(k,v){
                    mmc = mmc + '<div class="col-6 col-sm-4 col-lg-3 col-xl-2">';
                    mmc = mmc + '<div class="card" onclick="openpbmodal(this)" data-tvid="' + v.id +'">';
                    mmc = mmc + '<a class="card__cover">';
                    mmc = mmc + '<img style="pointer-events: none;" src="' + v.logo +'" alt="' + v.title +'"/>';
                    mmc = mmc + '<h3 class="card__title"><a>' + v.title +'</a></h3>';
                    mmc = mmc + '</div>';
                    mmc = mmc + '</div>';
                });
                $("#tv_catalogue").append(mmc);
                
            }
            else
            {
                if(data.code == 555)
                {
                    genChannels();
                }
                else
                {
                    alert("No Channels Found");
                    $("#tv_catalogue").attr("class", "");
                    $("#tv_catalogue").html('<div align="center" style="font-weight: bold; color: #FFFFFF; text-align: center !important; margin-top: 40px;">NO CHANNELS FOUND</div>');
                    
                }   
            }
        },
        "error":function(data)
        {
            alert("No Channels Found");
            $("#tv_catalogue").attr("class", "");
            $("#tv_catalogue").html('<div align="center" style="font-weight: bold; color: #FFFFFF; text-align: center !important; margin-top: 40px;">NO CHANNELS FOUND</div>');
            
        }
    });
}
function genChannels()
{
     $.ajax({
        "url": "app/channels.php",
        "type": "GET",
        "data": "",
        "beforeSend":function(xhr)
        {

        },
        "success":function(data)
        {
            try { data = JSON.parse(data); }catch(err){}
            if(data.status == "success")
            {
                load_channels('1');
            }
            else
            {
                alert("Failed To Generate Subscribed Channel List");
            }
        },
        "error":function(data)
        {
            alert("Failed To Generate Subscribed Channel List");
        }
    });
}

function openpbmodal(e)
{
    let id = $(e).attr("data-tvid");
    let player_window = "play.php?id=" + id;
    window.open(player_window, '_blank');
}


function dosearchnow()
{
  let query = $("#tv_search_box").val();
  if(query !== "")
  {
      $.ajax({
          "url":"app/channels.php",
          "type":"GET",
          "data":"search=" + query,
          "beforeSend":function(xhr)
          {
          },
          "success":function(data)
          {
              let mmc = "";
              try { data = JSON.parse(data); }catch(err){}
              if(data.status == "success")
              {
                $.each(data.data, function(k,v){
                    mmc = mmc + '<div class="col-6 col-sm-4 col-lg-3 col-xl-2">';
                    mmc = mmc + '<div class="card" onclick="openpbmodal(this)" data-tvid="' + v.id +'">';
                    mmc = mmc + '<a class="card__cover">';
                    mmc = mmc + '<img style="pointer-events: none;" src="' + v.logo +'" alt="' + v.title +'"/>';
                    mmc = mmc + '<h3 class="card__title"><a>' + v.title +'</a></h3>';
                    mmc = mmc + '</div>';
                    mmc = mmc + '</div>';
                });
                $("#tv_catalogue").html(mmc);
                $("#uwznazoia").fadeOut();
            }
        },
        "error":function(data)
        {

        }
    });
}
else
{
  load_channels('1');
}
}
</script>

</body>
</html>