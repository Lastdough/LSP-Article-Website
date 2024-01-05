<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Article Website</title>
    <style>
        <?php include "src\public\css\output.css" ?>
    </style>
</head>

<body class="bg-gray-200">
    <!-- Navbar -->
    <nav class="bg-gray-800 text-white p-4">
        <div class="container mx-auto flex justify-between items-center">
            <a href="/" class="text-lg font-semibold">LSP Article Website</a>
            <div>
                <a href="/LSPWebsite/admin/dashboard" class="hover:text-gray-300 px-3">Dashboard</a>
            </div>
        </div>
    </nav>


    <div class="container mx-auto mt-5 flex gap-4">
        <!-- Main content -->
        <div class="flex-grow">
            <div class="container mx-auto mt-5">
                <div class="flex flex-col gap-4">
                    <?php foreach ($articles as $article) : ?>
                        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                            <img src="<?= $article['picture']; ?>" alt="Article Image" class="w-full h-80 object-cover">
                            <div class="p-4">
                                <h2 class="text-xl font-semibold mb-2"><?= htmlspecialchars($article['title']) ?></h2>
                                <p class="text-gray-600 mb-2"><?= htmlspecialchars($article['header']); ?></p>
                                <p class="text-gray-600 text-sm">By <?= htmlspecialchars($article['author_name']) ?></p>
                                <a href="/LSPWebsite/article/view?id=<?= htmlspecialchars($article['article_id']) ?>" class="text-blue-600 hover:underline">Read More</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Aside panel for recent articles -->
        <aside class="w-1/4">
            <h3 class="text-xl font-semibold mb-4">Recent Articles</h3>
            <div class="flex flex-col gap-2">
                <?php foreach ($recentArticles as $article) : ?>
                    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                        <img src="<?= $article['picture']; ?>" alt="<?= htmlspecialchars($article['title']) ?>" class="w-full h-20 object-cover">
                        <div class="p-2">
                            <h4 class="text-lg font-semibold"><?= htmlspecialchars($article['title']) ?></h4>
                            <p class="text-gray-600 text-sm"><?= htmlspecialchars($article['header']) ?></p>
                            <a href="/LSPWebsite/article/view?id=<?= htmlspecialchars($article['article_id']) ?>" class="text-blue-600 hover:underline">Read More</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </aside>
    </div>


    <!-- Footer -->
    <footer class="bg-gray-800 text-white p-4 text-center">
        <p>&copy; <?= date("Y") ?> LSP Article Website. All rights reserved.</p>
    </footer>
</body>

<!-- <body>
    <div></div>
</body> -->

</html>