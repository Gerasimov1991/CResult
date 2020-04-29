<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
 /* @font-face {
    font-family: "GilroyB";
    src: url({{ storage_path('fonts\Gilroy-Bold.otf') }}) format("truetype");    
}
@font-face {
    font-family: "GilroyR";    
    src: url({{ storage_path('fonts\Gilroy-Regular.otf') }}) format("truetype");    
} */
  .card {
    font-family: Arial, Helvetica, sans-serif;
  box-shadow: 0 3px 1px -2px rgba(0,0,0,.2),0 2px 2px 0 rgba(0,0,0,.14),0 1px 5px 0 rgba(0,0,0,.12)!important;
  transition: 0.3s;
  width: 378px;
  height: 245px;
  position: relative;
  background-color: white;
}

.card:hover {
  box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
}

.container {
  padding: 0px;
  position: absolute;
  top: 47px;
  left: 32px;  
}
.avatar{
    position: absolute;
    top:36px;
    right: 36px;
    z-index: 10;
}
</style>
</head>
<body>  
  <div class="card" style="width: 452px;height: 336px;background-color: white;border: 1px solid #dedede;position: relative;">
    <div style="margin: 9px auto;width:434px;background:#DEE2E8;">
      <div style="height: 227px;position: relative;width: 434px;margin:auto;background:#1A2629;">
        <div class="container">
          <h2 style="margin:0px;"><b style="color:#E84533;text-transform:uppercase;font-family:GilroyB;font-size: 14pt;line-height:20pt;letter-spacing: 2px;">{!! $name !!}</b></h2>
          <p style="color:#ffffff;text-transform:uppercase;font-size: 10pt;font-family:GilroyB sans-serif;line-height:14pt;margin:0px;letter-spacing: 0.6px;">{!! $title !!}</p>
          
          <p style="color:white;margin-top:45px;font-family:GilroyR sans-serif;margin-bottom: 0px;font-size: 10pt;line-height:11pt;letter-spacing: 0.6px;"><span style="color:#E84533;font-size: 7.4pt;">M:</span> {!! $mobile !!}</p>
          <p style="color:white;margin:0px;font-size: 10pt;font-family:GilroyR sans-serif;line-height:11pt;letter-spacing: 0.6px;"><span style="color:#E84533;font-size: 7.4pt;">D:</span> {!! $direct_dial !!}</p>
          <p style="color:white;margin:0px;font-size: 10pt;font-family:GilroyR sans-serif;line-height:11pt;letter-spacing: 1px;"><span style="color:#E84533;font-size: 7.4pt;">E:</span> {!! $email !!}</p>
        </div> 
      </div>
      
      <div style="height: 54px;position: absolute;top:226px; width: 434px;background:#DEE2E8;">
        <p style="padding:0px; margin-top:12px;margin-left:54px;font-size: 6.5pt;font-family:GilroyR sans-serif;letter-spacing: 0.8px;"><span style="color:red;">A:</span>242 Leach Hwy, Myaree WA 6154 <span style="color: red">| W: </span> summithomes.com.au</p>
      </div>
    </div> 
    <div style="width: 1px;height: 22px;background: #000;position: absolute;top: 0px;left: 31px;"></div>
    <div style="width: 1px;height: 22px;background: #000;position: absolute;top: 0px;right: 31px;"></div>
    <div style="width: 1px;height: 22px;background: #000;position: absolute;top: 278px;left: 31px;"></div>
    <div style="width: 1px;height: 22px;background: #000;position: absolute;top: 278px;right: 31px;"></div>
    <div style="width: 1px;height: 22px;background: #fff;position: absolute;top: 0px;left: 30px;"></div>
    <div style="width: 1px;height: 22px;background: #fff;position: absolute;top: 0px;right: 30px;"></div>
    <div style="width: 22px;height: 1px;background: #000;position: absolute;top: 31px;left: 0px;"></div>
    <div style="width: 22px;height: 1px;background: #000;position: absolute;top: 269px;left: 0px;"></div>
    <div style="width: 22px;height: 1px;background: #000;position: absolute;top: 269px;right: 0px;"></div>
    <div style="width: 22px;height: 1px;background: #000;position: absolute;top: 31px;right: 0px;"></div>
  </div>  
  <div style="height:600px;">

  </div>
  <div>
    @if(!empty($preset_image))
      <img src="company/images/card/{!! $preset_image !!}" alt="preset image">   
    @endif
  </div>
</body>
</html>
