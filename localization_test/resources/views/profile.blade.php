<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

<h1>{{__('profile.welcome')}}</h1>
<a href="">{{__('profile.About')}}</a>
<a href="">{{__('profile.Contact')}}</a>
<a href="">{{__('profile.List')}}</a>

<br><br>
<h1>{{__('welcome')}}</h1>
<a href="">{{__('About')}}</a>
<a href="">{{__('Contact')}}</a>
<a href="">{{__('List')}}</a>
<br><br>

@if(App::getLocale() == 'fren')
    <form action="submit_form.php" method="post">
        <label for="username">{{__('name')}}</label>
        <input type="text" id="username" name="username"><br><br>

        <label for="email">{{__('Email')}}</label>
        <input type="email" id="email" name="email"><br><br>

        <label for="password">{{__('Password')}}</label>
        <input type="password" id="password" name="password"><br><br>

        <input type="submit" value="{{__('submit')}}">
    </form>
@endif
</body>
</html>
