<?php
require_once "jssdk.php";
$jssdk = new JSSDK("wxd41b45bda434057f", "b1af6ce5e286987ea5d105ba9cc1af8e");
$signPackage = $jssdk->GetSignPackage();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.css">
    <link rel="stylesheet" type="text/css" href="theme.css">
	<script src="http://code.jquery.com/jquery-1.8.3.min.js"></script>
	<script src="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.js"></script>
  	<title>Will Cheng's Weather Forecast</title>
</head>
<body ontouchstart>
  <meta charset="UTF-8">
<div data-role="page" id="pageone" data-theme="a"  style="background:url(images/sunny-bg.png) 50% 0 no-repeat;background-size:cover">>
  <div data-role="content">
   <div class="loc-section">
       <p class='city-name' style="font-size:100px"><span id="city">北京</span></p>
       <p style="font-size:40px"><span id="ganmao">温差较大，较易发生感冒，请适当增减衣服。体质较弱的朋友请注意</span></p>
     <hr id="line">
   </div>
  </div>
  <div data-role="content">
   <div class="today-section">   
     	<p style="font-size:70px;font-weight: 700;"><span id="week">10日星期四</span></p>
       <p class="mb10" style="font-size:50px">实时温度: <span id="wendu"></span></p>
       <p class="mb10" style="font-size:50px"><span id="type"></span></p>
       <p class="mb10" style="font-size:50px"><span id="high1"></span>~<span id="low1"></span></p>
       <p style="font-size:45px"><span id="fx"></span> <span id="type"></span></p>
   </div>
  </div>
  <div data-role="content">
    <div class="ui-grid-b">
     <div class="ui-block-a wbg w30" align="center">
       <a href="#"><img src="images/biz_plugin_weather_qing.png"></a>
	   <p style="font-size:45px"><span id="week_next1"></span></p>
       <p style="font-size:45px"><span id="high1_next1"></span>~<span id="low1_next1"></span></p>
       <p style="font-size:40px"><span id="fx_next1"></span> <span id="type_next1"></span></p>
     </div>
     <div class="ui-block-b wbg w30" align="center">
       <a href="#"><img src="images/biz_plugin_weather_qing.png"></a>
       <p style="font-size:45px"><span id="week_next2"></span></p>
       <p style="font-size:45px"><span id="high1_next2"></span>~<span id="low1_next2"></span></p>
       <p style="font-size:40px"><span id="fx_next2"></span> <span id="type_next2"></span></p>
     </div>
     <div class="ui-block-c wbg w30" align="center">
       <a href="#"><img src="images/biz_plugin_weather_qing.png"></a>
       <p style="font-size:45px"><span id="week_next3"></span></p>
       <p style="font-size:45px"><span id="high1_next3"></span>~<span id="low1_next3"></span></p>
       <p style="font-size:40px"><span id="fx_next3"></span> <span id="type_next3"></span></p>
     </div>
    </div>
  </div>
</div> 

</body>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=MjT4vAKqG0RCws1mKeNyuGuT7SbFqmTH"></script>
<script type="text/javascript" src="https://map.qq.com/api/js?v=2.exp&key=2T2BZ-VMVK6-LAFSZ-EKYSG-ZTKW5-HOBHJ"></script>



<script>
  /*
   * 注意：
   * 1. 所有的JS接口只能在公众号绑定的域名下调用，公众号开发者需要先登录微信公众平台进入“公众号设置”的“功能设置”里填写“JS接口安全域名”。
   * 2. 如果发现在 Android 不能分享自定义内容，请到官网下载最新的包覆盖安装，Android 自定义分享接口需升级至 6.0.2.58 版本及以上。
   * 3. 常见问题及完整 JS-SDK 文档地址：http://mp.weixin.qq.com/wiki/7/aaa137b55fb2e0456bf8dd9148dd613f.html
   *
   * 开发中遇到问题详见文档“附录5-常见错误及解决办法”解决，如仍未能解决可通过以下渠道反馈：
   * 邮箱地址：weixin-open@qq.com
   * 邮件主题：【微信JS-SDK反馈】具体问题
   * 邮件内容说明：用简明的语言描述问题所在，并交代清楚遇到该问题的场景，可附上截屏图片，微信团队会尽快处理你的反馈。
   */
  wx.config({
    debug: false,
    appId: '<?php echo $signPackage["appId"];?>',
    timestamp: <?php echo $signPackage["timestamp"];?>,
    nonceStr: '<?php echo $signPackage["nonceStr"];?>',
    signature: '<?php echo $signPackage["signature"];?>',
    jsApiList: [
      // 所有要调用的 API 都要加到这个列表中
    'getLocation',
    'openLocation',
    'scanQRCode',
    
    ]
  });
  var latitude = 0.0;
    var longitude = 0.0;


    wx.ready(function () {
      
      wx.checkJsApi({
        jsApiList: ['getLocation'] ,// 需要检测的JS接口列表，所有JS接口列表见附录2,
        success: function(res) {
            // 以键值对的形式返回，可用的api值true，不可用为false
            // 如：{"checkResult":{"chooseImage":true},"errMsg":"checkJsApi:ok"}
            //alert(JSON.stringify(res));
        }});

        // 在这里调用 API
      	
        wx.getLocation({
            type: 'wgs84', // 默认为wgs84的gps坐标，如果要返回直接给openLocation用的火星坐标，可传入'gcj02'
            success: function (res) {
                latitude = res.latitude; // 纬度，浮点数，范围为90 ~ -90
                longitude = res.longitude; // 经度，浮点数，范围为180 ~ -180。
                var speed = res.speed; // 速度，以米/每秒计
                var accuracy = res.accuracy; // 位置精度
              	//return json;
              
              	
              	
              	var locationString = res.latitude + "," + res.longitude;
              	//alert(locationString);
              	var url = 'http://apis.map.qq.com/ws/geocoder/v1/?location='+latitude+','+longitude+'&key=2T2BZ-VMVK6-LAFSZ-EKYSG-ZTKW5-HOBHJ'
				//alert(url);
              
              var map = new BMap.Map("city");
              var point = new BMap.Point(longitude,latitude);
               map.centerAndZoom(point,12);

               function myFun(result){
	                  var cityName = result.name;
	                  map.setCenter(cityName);
                 	  //document.getElementById("city").innerHTML = cityName;
	                  //alert("当前定位城市:"+cityName);
                 
                 	$.getJSON('http://wthrcdn.etouch.cn/weather_mini?city='+cityName, function(data) {
        
      				 	var ganmao = data["data"]["ganmao"];
                      	$("#city").text(data["data"]["city"]);
                      	$("#wendu").text(data["data"]["wendu"]+"°C");	
                      	$("#ganmao").text(data["data"]["ganmao"]);
                      	$("#type").text(data["data"]["forecast"]["0"]["type"]);
                      	$("#fx").text(data["data"]["forecast"]["0"]["fengxiang"]);
                      	var high1 = data["data"]["forecast"]["0"]["high"];
                      	$("#high1").text(high1.substr(2, high1.length));
                      	var low1 = data["data"]["forecast"]["0"]["low"];
                        $("#low1").text(low1.substr(2, low1.length));
                      	$("#week").text(data["data"]["forecast"]["0"]["date"]);
                    	
                      
                     	 $("#week_next1").text(data["data"]["forecast"]["1"]["date"]);
                      		var high2 = data["data"]["forecast"]["1"]["high"];
                      		var low2 = data["data"]["forecast"]["1"]["low"];
                         $("#high1_next1").text(high2.substr(2, high2.length));
                         $("#low1_next1").text(low2.substr(2, low2.length));
                         $("#fx_next1").text(data["data"]["forecast"]["1"]["fengxiang"]);
                         $("#type_next1").text(data["data"]["forecast"]["1"]["type"]);
                         $("#week_next2").text(data["data"]["forecast"]["2"]["date"]);
                      		var high3 = data["data"]["forecast"]["2"]["high"];
                      		var low3 = data["data"]["forecast"]["2"]["low"];
                         $("#high1_next2").text(high3.substr(2, high3.length));
                         $("#low1_next2").text(low3.substr(2, low3.length));
                         $("#fx_next2").text(data["data"]["forecast"]["2"]["fengxiang"]);
                         $("#type_next2").text(data["data"]["forecast"]["2"]["type"]);
                         $("#week_next3").text(data["data"]["forecast"]["3"]["date"]);
                      		var high4 = data["data"]["forecast"]["3"]["high"];
                      		var low4 = data["data"]["forecast"]["3"]["low"];
                         $("#high1_next3").text(high4.substr(2, high4.length));
                         $("#low1_next3").text(low4.substr(2, low4.length));
                         $("#fx_next3").text(data["data"]["forecast"]["3"]["fengxiang"]);
                         $("#type_next3").text(data["data"]["forecast"]["3"]["type"]);
        
        				
                    
        
        				//$(".mypanel").html(text);
    				});
                 
                 	
                 
                  }
               var myCity = new BMap.LocalCity();
               myCity.get(myFun);
              
              
              
              



            	

              
            }
        });


      
      
    });

    function openLocation() {
        wx.ready(function () {
            wx.openLocation({
                latitude: latitude, // 纬度，浮点数，范围为90 ~ -90
                longitude: longitude, // 经度，浮点数，范围为180 ~ -180。
                name: '', // 位置名
                address: '', // 地址详情说明
                scale: 15, // 地图缩放级别,整形值,范围从1~28。默认为最大
                infoUrl: '' // 在查看位置界面底部显示的超链接,可点击跳转
            });
        });
    }


    function scanQRCode() {
        wx.ready(function () {
            wx.scanQRCode({
                needResult: 0, // 默认为0，扫描结果由微信处理，1则直接返回扫描结果，
                scanType: ["qrCode","barCode"], // 可以指定扫二维码还是一维码，默认二者都有
                success: function (res) {
                    var result = res.resultStr; // 当needResult 为 1 时，扫码返回的结果
                }
            });
        });
    }
  
</script>
</html>
