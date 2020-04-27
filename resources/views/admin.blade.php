<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
    <meta name="csrf-token" content="{{ csrf_token() }}">
     
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900%7CRoboto+Mono:500%7CMaterial+Icons" media="all">
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.css') }}">
    <title>Home | C Results Business Card</title>
    <style>
        .container.fill-height{
            align-items: unset;
        }
    </style>
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
         ]); ?>
     </script>
  </head>
  <body>
        <noscript>
        <strong>We're sorry but jerbit doesn't work properly without JavaScript enabled. Please enable it to continue.</strong>
        </noscript>
        <div class="crbcadmin"></div>
    <script src="{!! asset('admin/js/app.js') !!}"></script>

  </body>
</html>
