<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Add Borrower</title>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-4">Add Borrower</h2>
        <form action="add_borrower.php" method="POST">
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Borrower Name</label>
                <input type="text" name="name" id="name" required class="mt-1 block w-full border border-gray-300 rounded-md p-2">
            </div>
            <div class="mb-4">
                <label for="contact_info" class="block text-sm font-medium text-gray-700">Contact Info</label>
                <input type="text" name="contact_info" id="contact_info" required class="mt-1 block w-full border border-gray-300 rounded-md p-2">
            </div>
            <div class="mb-4">
                <label for="user_id" class="block text-sm font-medium text-gray-700">Select User</label>
                <select name="user_id" id="user_id" required class="mt-1 block w-full border border-gray-300 rounded-md p-2">
                    <?php
                    require("./database/config.php");
                    $sql = "SELECT user_id, name FROM Users";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='{$row['user_id']}'>{$row['name']}</option>";
                        }
                    }
                    $conn->close();
                    ?>
                </select>
            </div>
            <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded">Add Borrower</button>
        </form>
    </div>
</body>
</html>