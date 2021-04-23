<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Read Data From Google Sheet</title>
</head>
<body>
 <div class="container">
    <h3 class="text-center">Read Data From Google Sheet</h3>
    <table class="table table-bordered table-sm table-striped">
        <thead class="bg-info">
            <tr>
                <th>{{ $result[0][0] }}</th>
                <th>{{ $result[0][1] }}</th>
                <th>{{ $result[0][2] }}</th>
                <th>{{ $result[0][3] }}</th>
                <th>{{ $result[0][4] }}</th>
            </tr>
        </thead>
        <?php unset($result[0])?>
    <tbody>
       @foreach($result as $key => $value)
            <tr>
                @foreach($value as $v)
                    <td>{{ $v }}</td>
                @endforeach
            </tr>    
        @endforeach
    </tbody>
    </table>
    <a href="google-sheet/form" class="btn btn-success">Add New</a>       
 </div>
</body>
</html>