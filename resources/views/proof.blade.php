<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
.card {
  box-shadow: 0 3px 1px -2px rgba(0,0,0,.2),0 2px 2px 0 rgba(0,0,0,.14),0 1px 5px 0 rgba(0,0,0,.12)!important;
  transition: 0.3s;
  width: 750px;
  position: relative;
  background-color: #D0D3D4;
}

.card:hover {
  box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
}

.container {
  padding: 36px;
  position: absolute;
  top: 0px;
  left: 0px;
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
  @if(!empty($preset_image))
  <img src="company/images/card/{!! $preset_image !!}" alt="preset image" width="100%" height="330px">
  @else
  <img src="company/images/card/vcb.png" alt="preset image" width="100%" height="330px">
  @endif
  <div class="container">
  <h2 style="margin:0px;"><b style="color:red;text-transform:uppercase">{!! $name !!}</b></h2>
  <p style="color:red;text-transform:uppercase;font-size:20px;">{!! $title !!}</p>
  <br>
  <p style="color:white"><span style="color:red">M:</span> {!! $mobile !!}</p>
  <p style="color:white"><span style="color:red">D:</span> {!! $direct_dial !!}</p>
  <p style="color:white"><span style="color:red">E:</span> {!! $email !!}</p>
  </div>
  @if(!empty($image))
  <img src="company/images/card/{!! image !!}" alt="avatar" height="120px" width="120px" class="avatar"/>
  @endif
  <p style="padding:36px 36px; margin:0px;"><span style="color:red;">A:</span> {!! $address !!} <span style="color: red">| W: </span> www.agiletechsolution.net</p>
</div>
<h3 style="">Quantity ordered: {!! $details !!}</h3>
<h3 style="color:tomato">Cost: ${!! $price !!} AUD</h3>
</body>
</html>
