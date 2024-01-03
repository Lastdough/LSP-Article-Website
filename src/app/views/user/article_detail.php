<!DOCTYPE html>
<html>

<head>
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
        <h1><?= htmlspecialchars($article['title']); ?></h1>
        <div><?= json_encode($article) ?></div>
    <?php else : ?>
        <p>Article not found.</p>
    <?php endif; ?>
</body>

</html>