function load_channels(page)
{
    $.ajax({
        "url": "app/channels.php",
        "type": "GET",
        "data": "page=" + page,
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
                    mmc = mmc + '<ul class="card__list">';
                    mmc = mmc + '<li>' + v.category +'</li>';
                    mmc = mmc + '<li>' + v.language +'</li>';
                    mmc = mmc + '</ul>';
                    mmc = mmc + '</div>';
                    mmc = mmc + '</div>';
                });
                $("#tv_catalogue").append(mmc);
                $("#uwznazoia").fadeIn();
            }
            else
            {
                if(data.code == 404)
                {
                    $("#uwznazoia").fadeOut();
                }
                else
                {
                    $("#tv_catalogue").attr("class", "");
                    $("#tv_catalogue").html('<div align="center" style="font-weight: bold; color: #FFFFFF; text-align: center !important; margin-top: 40px;">NO CHANNELS FOUND</div>');
                    $("#uwznazoia").fadeOut();
                }   
            }
        },
        "error":function(data)
        {
            $("#tv_catalogue").attr("class", "");
            $("#tv_catalogue").html('<div align="center" style="font-weight: bold; color: #FFFFFF; text-align: center !important; margin-top: 40px;">NO CHANNELS FOUND</div>');
            $("#uwznazoia").fadeOut();
        }
    });
}

function loadmorechannels(e)
{
    let page = $(e).attr("data-page");
    let next_page = Number(page) + Number(1);
    load_channels(next_page);
}

function dosearchnow()
{
  let query = $("#tv_search_box").val();
  if(query !== "")
  {
  $.ajax({
    "url":"app/channels_action.php",
    "type":"GET",
    "data":"action=search&q=" + query,
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
                    mmc = mmc + '<ul class="card__list">';
                    mmc = mmc + '<li>' + v.category +'</li>';
                    mmc = mmc + '<li>' + v.language +'</li>';
                    mmc = mmc + '</ul>';
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

function openpbmodal(e)
{
    let id = $(e).attr("data-tvid");
    window.location = "play.php?id=" + id;
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
                $("#stv_language").html(data.data.language);
                if(data.data.type == "HLS")
                {
                  let window_link = "potplayer://" + data.data.playurl;
                  $("#window_ottplayer").attr("href", window_link);

                  let mx_intent = "intent:" + data.data.playurl + "#Intent;package=com.mxtech.videoplayer.ad;S.title=LiveTV_PlayBack;end";
                  $("#andr_mxfree").attr("href", mx_intent);

                  let mx_pro = "intent:" + data.data.playurl +"#Intent;package=com.mxtech.videoplayer.pro;S.title=LiveTVPlayBack;end";
                  $("#andr_mxpro").attr("href", mx_pro);

                  setupplayer(data.data.playurl, data.data.logo);

                  $("#external_player_interface").fadeIn();
                }
                if(data.data.type == "DRM")
                {
                  $("#external_player_interface").hide();
                    setupdrmplayer(data.data.playurl, data.data.drmurl, data.data.logo);
                }
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

$('#tv_cats').on('change', function() {
  let cat = this.value;
  let lang = $("#tv_langs").val();
  $.ajax({
    "url":"app/channels_action.php",
    "type":"GET",
    "data":"action=sort&c=" + cat + "&l=" + lang,
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
                    mmc = mmc + '<ul class="card__list">';
                    mmc = mmc + '<li>' + v.category +'</li>';
                    mmc = mmc + '<li>' + v.language +'</li>';
                    mmc = mmc + '</ul>';
                    mmc = mmc + '</div>';
                    mmc = mmc + '</div>';
                });
                $("#tv_catalogue").html(mmc);
            }
    },
    "error":function(data)
    {

    }
  });
});

$('#tv_langs').on('change', function() {
  let cat = $("#tv_cats").val();
  let lang = this.value;
  $.ajax({
    "url":"app/channels_action.php",
    "type":"GET",
    "data":"action=sort&c=" + cat + "&l=" + lang,
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
                    mmc = mmc + '<ul class="card__list">';
                    mmc = mmc + '<li>' + v.category +'</li>';
                    mmc = mmc + '<li>' + v.language +'</li>';
                    mmc = mmc + '</ul>';
                    mmc = mmc + '</div>';
                    mmc = mmc + '</div>';
                });
                $("#tv_catalogue").html(mmc);
            }
    },
    "error":function(data)
    {

    }
  });
});


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