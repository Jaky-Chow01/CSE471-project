<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Global Leaderboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Global Leaderboard</h1>
        <h2 class="text-center mb-4">Top 10 Donors by Lifetime Donations</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Rank</th>
                    <th>Name</th>
                    <th>Total Bags Donated</th>
                </tr>
            </thead>
            <tbody>
                @foreach($topDonors as $index => $donor)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $donor->name }}</td>
                    <td>{{ $donor->total_bags ?? 0 }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>