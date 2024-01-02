<!DOCTYPE html>
<html>

<head>
    <title>Article Detail</title>
    <!-- Include any stylesheets or scripts here -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php if ($article) : ?>
        <h1><?= htmlspecialchars($article['title']) ?></h1>
        <p><?= htmlspecialchars($article['description']) ?></p>
        <div><?= nl2br(htmlspecialchars($article['article'])) ?></div>
        <!-- Add more fields as necessary -->
    <?php else : ?>
        <p>Article not found.</p>
    <?php endif; ?>
<!-- 
    <div class="container mt-5">
        <img src="<?php echo $row['picture']; ?>" class="" alt="Article Image">
        <h1><?php echo $title; ?></h1>
        <p><?php echo $description; ?></p>
        <p>Author: <?php echo $author; ?></p>
        <p>Publish Date: <?php echo $publish_date; ?></p>
        <hr>
        <div><?php echo $content; ?></div>
        <a class="btn btn-secondary" href="index.php">Back to Article List</a>
    </div> -->
</body>

</html>