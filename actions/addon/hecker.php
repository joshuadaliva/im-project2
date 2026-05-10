<?php
require_once __DIR__ . "/../../includes/security.php";
app_secure_session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Access Denied</title>
    <link href="/im/assets/vendor/tailwind/tailwind.min.css" rel="stylesheet">
    <?= app_csrf_meta() ?>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="text-center">
        <h1 class="text-6xl font-bold text-red-600">Ginagawa mo dito lods?</h1>
        <h2 class="text-2xl font-semibold mt-4">Di ka po allowed dito</h2>
        <p class="mt-2 text-gray-600">Sorry, you do not have permission to access this page.</p>
        <a href="/im" class="mt-4 inline-block px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition">Go to Homepage</a>
    </div>
</body>
</html>