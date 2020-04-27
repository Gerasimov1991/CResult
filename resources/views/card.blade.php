<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="{!! asset('company/css/fonts.css') !!}">
<style>
html, body{
    width: 344px;
}
p{
    margin: 0;
    padding: 0;
}
.card {
  box-shadow: 0 3px 1px -2px rgba(0,0,0,.2),0 2px 2px 0 rgba(0,0,0,.14),0 1px 5px 0 rgba(0,0,0,.12)!important;
  transition: 0.3s;
  position: relative;
  background-color: #D0D3D4;
}
.card:hover {
  box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
}
.container {
  padding: 20px;
  position: absolute;
  top: 0px;
  left: 0px;
}
</style>
</head>
<body style="font-family: {{$card->font_name}}">
<div class="card" style="height:208px;width:344">
  <img src="company/images/card/{!! $card->branch->preset_image !!}" alt="preset image" width="344px" height="160px">
  <div class="container">
  <p style="margin-top:{!!$card->margin_top!!}px;margin-bottom:5px;color:{{$card->main_color}};text-transform:uppercase;font-size:{{$card->name_font_size}}px;font-weight:{{$card->name_font_weight}}">{!! $card->name !!}</p>
  <p style="margin-bottom:{!!$card->margin_bottom!!}px;color:{{$card->sub_color}};text-transform:uppercase;font-size:{{$card->title_font_size}}px;font-weight:{{$card->title_font_weight}}">{!! $card->title !!}</p>

  <p style="color:{{$card->sub_color}}"><span style="color:{{$card->main_color}}">M:&nbsp;</span> {!! $card->mobile !!}</p>
  <p style="color:{{$card->sub_color}}"><span style="color:{{$card->main_color}}">D:&nbsp; </span> {!! $card->direct_dial !!}</p>
  <p style="color:{{$card->sub_color}}"><span style="color:{{$card->main_color}}">E:&nbsp; </span> {!! $card->email !!}</p>
  </div>
  @if($card->image != '')
<img src="company/images/card/{!! $card->image !!}" alt="avatar" height="{{$card->image_size}}" width="{{$card->image_size}}" style="position:absolute;top:{{$card->image_top_margin}}px;right:{{$card->image_top_margin}}px;z-index:10;"/>
  @endif
<p style="padding:5px 20px;margin:0px;font-size:{{$card->footer_font_size}}px"><span style="color:{{$card->main_color}};">A:&nbsp;</span> {!! $card->branch->address !!} <span style="color: {{$card->main_color}}">| W:&nbsp; </span> {!! $card->branch->website !!}</p>
</div>

<br>
<br>

<div class="card" style="height:208px;width:344">
    <img src="company/images/card/{!! $card->branch->front_image !!}" alt="preset image" width="344px" height="208px">

  </div>
</body>
</html>
