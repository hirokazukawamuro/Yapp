<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome/Y</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/main.ts'])
</head>

<body class="antialiased">
    <div>
        <span class="">すべての笑いが、ここに。</span>
    </div>
    <div>
        <a href="/register" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Register</a>
        <a href="/login" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Login</a>
    </div>

</body>

</html>