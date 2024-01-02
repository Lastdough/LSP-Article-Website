<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <!-- Add Bootstrap CSS -->
    <!-- <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"> -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">

</head>

<body>
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="bg-white p-8 rounded shadow-md w-1/4">
            <h1 class="text-2xl font-semibold mb-4">Login</h1>
            <form method="POST" action="authenticate.php">
                <div class="mb-4">
                    <label for="username" class="block text-gray-700">Username:</label>
                    <input type="text" id="username" name="username" placeholder="Enter your username" class="form-input w-full px-4 py-2 border rounded focus:ring focus:ring-blue-200" required>
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-gray-700">Password:</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" class="form-input w-full px-4 py-2 border rounded focus:ring focus:ring-blue-200" required>
                </div>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
                    Login
                </button>
            </form>
        </div>
    </div>
</body>

</html>

