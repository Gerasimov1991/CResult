<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
{{-- <link rel="stylesheet" href="{{ asset('./company/css/pdffonts.css') }}"> --}}
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@500&display=swap" rel="stylesheet">
<style>
 @font-face {
    font-family: "GilroyB";
    src: url({{ storage_path('fonts\Roboto-Bold.ttf') }}) format("truetype");    
}
@font-face {
    font-family: "GilroyE";    
    src: url({{ storage_path('fonts\Gilroy-Extrabold.otf') }}) format("truetype");    
}
@font-face {
    font-family: "GilroyR";    
    src: url({{ storage_path('fonts\Gilroy-Regular.otf') }}) format("truetype");    
}
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
<div class="card">
  <div style="height: 197px;position: relative;background: #000000;background: url(3.png) no-repeat;
  width: 100%;">
    @if(!empty($preset_image))
    <img src="company/images/card/{!! $preset_image !!}" alt="preset image" width="100%" height="197px">
    @else
    <img src="company/images/card/vcb.png" alt="preset image" width="100%" height="197px">
    @endif
    <div class="container">    
      <h2 style="margin:0px;"><b style="color:red;text-transform:uppercase;font-family:GilroyB;font-size: 14pt;line-height:19.8pt;letter-spacing: 1.5px;">{!! $name !!}</b></h2>    
      <p style="color:#ffffff;text-transform:uppercase;font-size:20px;font-size: 10pt;font-family:GilroyB;line-height:17pt;margin:0px;font-weight:600;">{!! $title !!}</p>

      <p style="color:white;margin-top:45px;font-family:GilroyR;margin-bottom: 0px;font-size: 10pt;line-height:11pt;"><span style="color:red;font-size: 7.4pt;">M:</span> {!! $mobile !!}</p>
      <p style="color:white;margin:0px;font-size: 10pt;font-family:GilroyR;line-height:11pt;"><span style="color:red;font-size: 7.4pt;">D:</span> {!! $direct_dial !!}</p>
      <p style="color:white;margin:0px;font-size: 10pt;font-family:GilroyR;line-height:11pt;"><span style="color:red;font-size: 7.4pt;">E:</span> {!! $email !!}</p>
    </div>
    @if(!empty($image))
    <img src="company/images/card/{!! image !!}" alt="avatar" height="120px" width="120px" class="avatar"/>
    @endif
  </div>  
  <p style="padding:0px; margin-top:7px;margin-left:30px;font-size: 6.5pt;font-family:GilroyR;"><span style="color:red;">A:</span> 242 Leach Hwy, Myaree WA 6154 <span style="color: red">| W: </span> summithomes.com.au</p>
</div>
</body>
</html>
