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
    <!-- Include any stylesheets or scripts here -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php if ($article) : ?>
        <div>
            <h1><?= htmlspecialchars($article['title']); ?></h1>
            <img src="<?= $article['picture'] ?>" alt="Article Image" class="w-full h-64 object-cover rounded">
            <?php
            echo $article['content'];
            ?>
        </div>
    <?php else : ?>
        <p>Article not found.</p>
    <?php endif; ?>



    <div>

    </div>
</body>

</html>