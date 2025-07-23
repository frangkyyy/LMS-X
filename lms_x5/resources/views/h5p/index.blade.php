<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>H5P Laravel</title>
    <link rel="stylesheet" href="{{ asset('h5p/h5p-core/styles/h5p.css') }}">
    <script src="{{ asset('h5p/h5p-core/js/h5p.js') }}"></script>
</head>
<body>

<h1>Konten Interaktif H5P</h1>

<div class="h5p-content">
    <iframe src="{{ asset('h5p/content/index.html') }}" width="800" height="600" frameborder="0"></iframe>
</div>

</body>
</html>
