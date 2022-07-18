<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Home Page</h1>
    <br>
    <hr>
    <form action="/upload" method="post" enctype="multipart/form-data">
        <input type="file" name="transactions">
        <input type="file" name="transactions1">
        <button type="submit">Upload Transaction File</button>
    </form>
    <br>
    <hr>
    <br>
    <button><a href="/savetransaction">Save Transactions</a></button>
    <button><a href="/transactions">View Transactions</a></button>
</body>

</html>