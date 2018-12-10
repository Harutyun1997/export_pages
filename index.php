<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="css/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="container">
    <div class="input-group mb-3">
        <label class="title" for="url">Enter url to index</label>
        <input type="text" id="url" class="form-control" placeholder="https://www.facebook.com"
               aria-label="Recipient's username"
               aria-describedby="button-addon2">
        <div class="input-group-append">
            <button class="btn btn-outline-secondary" type="button" id="index"><img
                        src="img/09b24e31234507.564a1d23c07b4.gif" alt="" id="img"> Index
            </button>
        </div>
        <p id="response"></p>
        <label class="title" for="word">Write a word</label>
        <input type="text" id="word"/>

        <table class="table table-hover">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Word</th>
                <th scope="col">Link</th>
            </tr>
            </thead>
            <tbody id="result">
            </tbody>
        </table>
        </table>

    </div>
    <script src="css/bootstrap/js/bootstrap.min.js"></script>
    <script src="script/jquery-3.0.0.min.js"></script>
    <script src="script/script.js"></script>
</body>
</html>