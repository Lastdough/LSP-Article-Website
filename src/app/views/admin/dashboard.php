<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Include Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">

</head>

<body class="bg-gray-200 flex">

    <body class="bg-gray-200">

        <nav class="bg-white p-4 shadow">
            <div class="container mx-auto flex justify-between">
                <a href="/LSPWebsite/admin/dashboard" aria-label="authorname" class="relative flex items-center space-x-4 text-black">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24">
                        <path d="M480-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47ZM160-240v-32q0-34 17.5-62.5T224-378q62-31 126-46.5T480-440q66 0 130 15.5T736-378q29 15 46.5 43.5T800-272v32q0 33-23.5 56.5T720-160H240q-33 0-56.5-23.5T160-240Z" />
                    </svg>
                    <h2 class="text-2xl font-bold">Welcome! Author Name</h2>
                </a>
                <a href="/LSPWebsite/admin/logout" class="inline-block bg-red-500 text-white px-4 py-2 rounded hover:bg-red-700 transition-colors">Log Out</a>
            </div>
        </nav>

        <div class="container mx-auto mt-8">
            <div class="bg-white p-6 rounded shadow-md">
                <div class="flex justify-between items-center pb-4">
                    <h2 class="text-2xl font-bold">Articles</h2>
                    <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700 transition-colors">Add Article</button>
                </div>

                <!-- Articles Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white">
                        <thead class="bg-gray-800 text-white">
                            <tr>
                                <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Date</th>
                                <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Title</th>
                                <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Description</th>
                                <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Status</th>
                                <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            <!-- Sample Article Row -->
                            <tr>
                                <td class="text-left py-3 px-4">12 July 2021</td>
                                <td class="text-left py-3 px-4">Another article</td>
                                <td class="text-left py-3 px-4">Lorem Lorem</td>
                                <td class="text-left py-3 px-4">PUBLISHED</td>
                                <td class="flex items-center py-3 px-4">
                                    <button class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-700 transition-colors mr-2">Edit</button>
                                    <button class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-700 transition-colors">Delete</button>
                                </td>
                            </tr>
                            <!-- Repeat rows for each article -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </body>

</html>