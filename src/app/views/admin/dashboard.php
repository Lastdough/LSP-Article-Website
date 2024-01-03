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
    <aside class="bg-white min-h-screen shadow-md">
        <nav class="text-sm">
            <div class="flex h-screen flex-col justify-between pt-2 pb-6">
                <div>
                    <ul class="mt-5 space-y-2 tracking-wide">
                        <li>
                            <a href="/LSPWebsite/admin/dashboard" aria-label="authorname" class="relative flex items-center space-x-4 bg-gradient-to-r from-sky-600 to-cyan-400 px-4 py-3 text-black">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24">
                                    <path d="M480-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47ZM160-240v-32q0-34 17.5-62.5T224-378q62-31 126-46.5T480-440q66 0 130 15.5T736-378q29 15 46.5 43.5T800-272v32q0 33-23.5 56.5T720-160H240q-33 0-56.5-23.5T160-240Z" />
                                </svg>
                                <h2 class="text-2xl font-bold">Author Name</h2>
                            </a>
                        </li>
                        <li class="min-w-max">
                            <a href="/LSPWebsite/admin/dashboard" aria-label="dashboard" class="relative flex items-center space-x-4 bg-gradient-to-r from-sky-600 to-cyan-400 px-4 py-3 text-black">
                                <svg class="-ml-1 h-6 w-6" viewBox="0 0 24 24" fill="none">
                                    <path d="M6 8a2 2 0 0 1 2-2h1a2 2 0 0 1 2 2v1a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2V8ZM6 15a2 2 0 0 1 2-2h1a2 2 0 0 1 2 2v1a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2v-1Z" class="fill-current text-cyan-400 dark:fill-slate-600"></path>
                                    <path d="M13 8a2 2 0 0 1 2-2h1a2 2 0 0 1 2 2v1a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2V8Z" class="fill-current text-cyan-200 group-hover:text-cyan-300"></path>
                                    <path d="M13 15a2 2 0 0 1 2-2h1a2 2 0 0 1 2 2v1a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-1Z" class="fill-current group-hover:text-sky-300"></path>
                                </svg>
                                <span class="-mr-1 font-medium">Dashboard</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="w-max -mb-3">
                    <a href="/LSPWebsite/admin/logout" class="group flex items-center space-x-4 rounded-md px-4 py-3 text-red-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:text-red-800" height="24" viewBox="0 -960 960 960" width="24" fill="currentColor">
                            <path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h280v80H200v560h280v80H200Zm440-160-55-58 102-102H360v-80h327L585-622l55-58 200 200-200 200Z" />
                        </svg>
                        <span class="group-hover:text-red-800 font-medium">Log Out</span>
                    </a>
                </div>
            </div>
        </nav>
    </aside>
    <main class="flex">
        <div class="p-6 container mx-auto">
            <div class="flex justify-between items-center pb-4">
                <h2 class="text-2xl font-bold">Articles</h2>
                <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700 transition-colors">Add Article</button>
            </div>

            <div class="flex">
                <table class="bg-white">
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
                    </tbody>
                </table>
            </div>
        </div>
    </main>

</body>

</html>