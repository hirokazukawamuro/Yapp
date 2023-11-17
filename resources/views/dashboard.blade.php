<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Home/Y</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
  <!-- Styles -->
  @vite(['resources/css/app.css', 'resources/js/main.ts'])
</head>

<body class="antialiased">
  <header>
    <form action="{{route('user.logout')}}" method="post">
      @csrf
      <button class="btn btn-ghost bg-pink">ログアウト</button>
    </form>
  </header>
  <div id="app"></div>


</body>

</html>