<x-app-layout>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body style="margin-left: 20%">
    <x-app.navbar /> 
    <h3>Chat with a User</h3>
<ul>
@foreach($users as $user)
    <li>
        <a href="{{ route('chat.with', $user->id) }}">{{ $user->name }}</a>
    </li>
@endforeach
</ul>

</body>
</html>
</x-app-layout>