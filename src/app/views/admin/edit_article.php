<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Article</title>
    <style>
        <?php include "src\public\css\output.css" ?>
    </style>
    <!-- TinyMCE -->
    <script src="https://cdn.tiny.cloud/1/uylud4u1jsb5qj6yu5s2w33twij11lpjevd75rdgj4nv2x6i/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: 'textarea',
            height: 290,
            plugins: 'ai tinycomments mentions anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount checklist mediaembed casechange export formatpainter pageembed permanentpen footnotes advtemplate advtable advcode editimage tableofcontents mergetags powerpaste tinymcespellchecker autocorrect a11ychecker typography inlinecss',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | align lineheight | tinycomments | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
            tinycomments_mode: 'embedded',
            tinycomments_author: 'Author name',
            mergetags_list: [{
                    value: 'First.Name',
                    title: 'First Name'
                },
                {
                    value: 'Email',
                    title: 'Email'
                },
            ],
            ai_request: (request, respondWith) => respondWith.string(() => Promise.reject("See docs to implement AI Assistant")),
        });
    </script>
</head>

<body class="bg-gray-200">

    <div class="container mx-auto mt-8">
        <div class="bg-white p-6 rounded shadow-md">
            <h2 class="text-2xl font-bold mb-6">Edit Article</h2>

            <form id="articleForm" method="POST" action="/LSPWebsite/admin/article-edit?id=<?= $article['article_id'] ?>" enctype="multipart/form-data">
                <div class="mb-4">
                    <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Title:</label>
                    <input type="text" id="title" name="title" value="<?= htmlspecialchars($article['title']) ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>

                <div class="mb-4">
                    <label for="header" class="block text-gray-700 text-sm font-bold mb-2">Header:</label>
                    <input type="text" id="header" name="header" value="<?= htmlspecialchars($article['header']) ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>

                <div class="mb-4">
                    <label for="picture" class="block text-gray-700 text-sm font-bold mb-2">Picture:</label>
                    <input type="file" id="picture" name="picture" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <!-- Optionally show existing picture -->
                    <?php if (isset($article['picture'])) : ?>
                        <img src="<?= $article['picture'] ?>" alt="Current Picture" class="max-w-xs mt-2">
                    <?php endif; ?>
                </div>

                <div class="mb-4">
                    <label for="content" class="block text-gray-700 text-sm font-bold mb-2">Content:</label>
                    <textarea id="content" col="5" name="content"><?= htmlspecialchars($article['content']) ?></textarea>
                </div>

                <!-- Buttons for Draft and Publish -->
                <div class="flex justify-between">
                    <button type="submit" name="action" value="draft" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition-colors">Save as Draft</button>
                    <button type="submit" name="action" value="publish" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition-colors">Publish</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Initialize TinyMCE -->
    <script>
        tinymce.init({
            selector: '#content',
            plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
            toolbar_mode: 'floating',
        });
    </script>
</body>

</html>