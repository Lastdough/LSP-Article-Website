<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php if ($article) : ?>
        <title><?= $article['title'] ?></title>
    <?php else : ?>
        <title>Article not found.</title>
    <?php endif; ?>
    <style>
        .article-content h1 {
            font-size: 2rem !important;
            font-weight: 600 !important;

        }

        .article-content h2 {
            font-size: 1.5rem !important;
            font-weight: 600 !important;

        }

        .article-content h3 {
            font-weight: 600 !important;

        }


        .article-content table,
        th,
        td {
            border: 0.1px solid #000;
        }

        <?php include "src\public\css\output.css" ?>
    </style>
</head>

<body class="bg-gray-100">

    <div class="container mx-auto my-10 p-8 bg-white shadow-lg rounded-lg">
        <h1 class="text-4xl font-bold mb-4"><?= $article['title'] ?></h1>
        <h2 class="text-2xl font-semibold mb-4"><?= htmlspecialchars($article['header']) ?></h2>
        <p class="text-gray-600 mb-2">By <?= $article['author_name'] ?> | <?= $formattedDate ?></p>

        <div class="border-b border-t pt-2 pb-1 border-gray-300">
            <!-- Article Image -->
            <?php if (isset($article['picture'])) : ?>
                <img src="<?= $article['picture']; ?>" alt="Article Image" class="w-full h-full object-cover mb-4 rounded">
            <?php endif; ?>
        </div>
        <!-- Article Content -->
        <div class="article-content max-w-none">
            <?= $article['content'] ?>
        </div>
    </div>

</body>

</html>