<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Bootstrap Icons CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">


    <style>
        /* Custom Styles */
        body {
            background-color: #f7f9fc; /* Light background */
            font-family: 'Arial', sans-serif;
        }

        .card {
            border-radius: 15px; /* Rounded corners */
            transition: all 0.3s ease;
        }

        .card-header {
            background-color: #ffffff;
            border-bottom: 1px solid #e0e0e0;
        }

        .card-body {
            background-color: #ffffff;
            padding: 20px;
        }

        .card-footer {
            background-color: #ffffff;
            border-top: 1px solid #e0e0e0;
            text-align: right;
        }

        .form-control, .btn {
            border-radius: 25px; /* Rounded input and button */
        }

        .post-card {
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); /* Soft shadow for posts */
            margin-bottom: 20px;
            /* transition: all 0.3s ease; */
        }

        .post-card:hover {
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
        }

        .post-card img {
            padding: 20px;
            /* transition: transform 0.3s ease; */
        }

        .post-card img:hover {
            /* transform: scale(1.1); */
        }

        .post-card .card-title {
            font-weight: bold;
        }

        .btn-outline-primary, .btn-outline-secondary {
            border-radius: 20px;
            padding: 8px 16px;
        }

        .btn-outline-primary:hover, .btn-outline-secondary:hover {
            background-color: #f0f0f0;
            border-color: #007bff;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .container {
            padding-top: 40px;
        }

        /* Typography */
        h4, h6 {
            font-weight: 600;
        }

        .text-muted {
            color: #7c7c7c !important;
        }
    </style>
</head>
<body>

<div class="container py-5">
    @yield('content')
</div>

<!-- Bootstrap 5 JS and dependencies -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
