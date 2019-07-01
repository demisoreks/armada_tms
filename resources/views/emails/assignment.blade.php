<!DOCTYPE html>
<html>
    <head>
    </head>
    <body>
        Dear <strong>{{ $name }}</strong>,<br /><br />
        A new task has been assigned to you.<br /><br />
        Location: {{ $location }}<br />
        Date: {{ $date }}<br />
        Time: {{ $time }}<br /><br />
        Kindly log in to view full details and journey management plan.<br /><br />
        Regards,<br /><br />
        <strong>{{ config('app.name') }}</strong><br /><br />
    </body>
</html>
