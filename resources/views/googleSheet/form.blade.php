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
 <div class="container w-50">
    <h3 class="text-center">Insert Data In To Google Sheet</h3>
    <form action="{{ url('google-sheet/store') }}" method="POST">
        @csrf()
        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" class="form-control" placeholder="Username" required>
        </div>

        <div class="form-group">
            <label>Project Name</label>
            <input type="text" name="project" class="form-control" placeholder="Project Name" required>
        </div>

        <div class="form-group">
            <label>Date</label>
            <input type="date" name="date" class="form-control" placeholder="date" required>
        </div>

        <div class="form-group">
            <label>Time</label>
            <input type="time" name="time" class="form-control" placeholder="Time" required>
        </div>

        <div class="form-group">
           <button class="btn btn-success" type="submit">Create Record</button>
        </div>
    </form>         
 </div>
</body>
</html>