<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Register/Y</title>
  @vite(['resources/css/app.css', 'resources/js/main.ts'])
</head>

<body>
  <h1>登録画面</h1>
  <form action="" method="post">
    @csrf
    <label for="name">名前</label>
    <input type="text" name="name" id="name">
    <label for="email">メールアドレス</label>
    <input type="email" name="email" id="email">
    <label for="password">パスワード</label>
    <input type="password" name="password" id="password">
    <button type="submit" class="btn btn-ghost bg-pink">送信</button>
  </form>
  <a href="/login" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Login</a>
</body>

</html>