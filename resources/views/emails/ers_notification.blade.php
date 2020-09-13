<!DOCTYPE html>
<html>
    <head>
    </head>
    <body>
        <strong>Client Name:</strong> {{ $client_name }}<br />
        <strong>Location:</strong> {{ $location }}<br />
        <strong>Incident(s):</strong> {{ $incidents }}<br /><br />
        <a href="{{ $report_link }}">Click this link for full report.</a><br /><br />
        Regards,<br /><br />
        <strong>{{ config('app.name') }}</strong><br /><br />
    </body>
</html>
