<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{csrf_token()}}">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script>
    window.api_token = "{{ \Auth::user()->api_token ?? null}}";
  </script>
  <link href="{{ mix('css/app.css') }}" rel="stylesheet" type="text/css">
  <script src="/js/app.js" defer></script>
  <title>{{env('APP_NAME')}}</title>
</head>

<body>
  <div id="app">
    <header>
      <header-component appname="{{env('APP_NAME')}}"></header-component>
    </header>
    <br>
    <div class="container col-md-8 offset-md-2">
      @yield('content')
    </div>
    
  </div>
</body>

</html>