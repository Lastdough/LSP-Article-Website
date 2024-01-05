<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        <?php include "src\public\css\output.css" ?>
    </style>
</head>


<!-- TODO : Margin Bottom -->

<body class="bg-gray-200">

    <nav class="bg-white p-4 shadow">
        <div class="container mx-auto flex justify-between">
            <a href="/LSPWebsite/admin/dashboard" aria-label="authorname" class="relative flex items-center space-x-4 text-black">
                <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24">
                    <path d="M480-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47ZM160-240v-32q0-34 17.5-62.5T224-378q62-31 126-46.5T480-440q66 0 130 15.5T736-378q29 15 46.5 43.5T800-272v32q0 33-23.5 56.5T720-160H240q-33 0-56.5-23.5T160-240Z" />
                </svg>
                <h2 class="text-2xl font-bold">Welcome! <?= $adminName ?></h2>
            </a>
            <a href="/LSPWebsite/admin/logout" class="inline-block bg-red-500 text-white px-4 py-2 rounded hover:bg-red-700 transition-colors">Log Out</a>
        </div>
    </nav>

    <div class="container mx-auto mt-8">
        <div class="bg-white p-6 rounded shadow-md">
            <div class="flex justify-between items-center pb-4">
                <h2 class="text-2xl font-bold">Articles</h2>
                <?php if (isset($_SESSION['message'])) : ?>
                    <div id="messagePopup" class="fixed bottom-5 right-5 bg-green-500 text-white p-4 rounded-lg shadow-lg z-50">
                        <?= htmlspecialchars($_SESSION['message']); ?>
                    </div>
                    <?php unset($_SESSION['message']);
                    ?>
                <?php endif; ?>
                <div class="flex space-x-4">
                    <!-- Search Form -->
                    <form action="/LSPWebsite/admin/dashboard" method="get" class="flex items-center space-x-1">
                        <input type="text" name="search" placeholder="Search articles..." class="py-2 px-4 border rounded-lg text-gray-700 focus:outline-none focus:border-blue-500" />
                        <button type="submit" class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400 transition-colors">Search</button>
                    </form>
                    <a href="/LSPWebsite/admin/article-create" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700 transition-colors">Add Article</a>
                </div>
            </div>

            <!-- Articles Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-800 text-white">
                        <tr>
                            <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Title</th>
                            <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Created At</th>
                            <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Updated At</th>
                            <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Status</th>
                            <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        <?php foreach ($articles as $article) : ?>
                            <tr>
                                <td class="text-left py-3 px-4"><?= htmlspecialchars($article['title']) ?></td>
                                <td class="text-left py-3 px-4"><?= htmlspecialchars(date("d M Y H:i", strtotime($article['created_at']))) ?></td>
                                <td class="text-left py-3 px-4"><?= htmlspecialchars(date("d M Y H:i", strtotime($article['updated_at']))) ?></td>
                                <td class="text-left py-3 px-4"><?= htmlspecialchars($article['publish_state']) ?></td>
                                <td class="flex items-center py-3 px-4">
                                    <!-- Edit Button -->
                                    <a href="/LSPWebsite/admin/article-edit?id=<?= $article['article_id'] ?>" class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-700 transition-colors mr-2">Edit</a>

                                    <!-- Delete Button -->
                                    <form action="/LSPWebsite/admin/article-delete" onsubmit="return confirm('Are you sure you want to delete this article?');">
                                        <input type="hidden" name="article_id" value="<?= $article['article_id'] ?>">
                                        <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-700 transition-colors">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        window.onload = function() {
            var messagePopup = document.getElementById('messagePopup');
            if (messagePopup) {
                setTimeout(function() {
                    messagePopup.style.display = 'none';
                }, 3000);
            }
        };
    </script>

</body>

</html>