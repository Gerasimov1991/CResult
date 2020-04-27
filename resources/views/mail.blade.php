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
    <h3>Dear {!! $name !!}</h3>
    <h4>Thanks for place this new order. Please see below order summary and proof document attached.</h4>

    <br>

<h3 style="">Quantity ordered: {!! $package_details !!}</h3>
<h3 style="color:tomato">Cost: ${!! number_format($package_price,0) !!} AUD</h3>

<br><br>

<h3>C Result Print</h3>

</body>
</html>
