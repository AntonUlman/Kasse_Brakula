{{-- resources/views/pdf/profits.blade.php --}}
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
<h2>Übersicht - Kasse</h2>
<table>
    <thead>
    <tr>
        <th>Datum</th>
        <th>Täglicher Gewinn</th>
        <th>Beteiligte Benutzer</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($profitsByDate as $profit)
        <tr>
            <td>{{ $profit['date'] }}</td>
            <td>{{ $profit['daily_profit'] }}€</td>
            <td>{{ implode(', ', $profit['users_involved']->toArray()) }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
@if (empty($profitsByDate))
    <p class="text-center">Keine Daten verfügbar.</p>
@endif
</body>
</html>
