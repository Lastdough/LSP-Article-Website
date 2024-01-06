<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Article</title>
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
    <style>
        <?php include "src\public\css\output.css" ?>
    </style>
</head>

<body class="bg-gray-200">

    <div class="container mx-auto mt-8">
        <div class="bg-white p-6 rounded shadow-md">
            <h2 class="text-2xl font-bold mb-6">Create New Article</h2>
            <?php if (isset($_SESSION['error'])) : ?>
                <div id="errorPopup" class="fixed bottom-5 right-5 bg-red-500 text-white p-4 rounded-lg shadow-lg z-50">
                    <?= htmlspecialchars($_SESSION['error']); ?>
                    <button onclick="document.getElementById('errorPopup').style.display='none'" class="text-lg ml-2">&times;</button>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <form id="articleForm" method="POST" action="/LSPWebsite/admin/article-create" enctype="multipart/form-data">
                <div class="mb-4">
                    <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Title:</label>
                    <input type="text" id="title" name="title" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>

                <div class="mb-4">
                    <label for="header" class="block text-gray-700 text-sm font-bold mb-2">Header:</label>
                    <input type="text" id="header" name="header" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>

                <!-- Picture Input -->
                <div class="mb-4">
                    <label for="picture" class="block text-gray-700 text-sm font-bold mb-2">Picture:</label>
                    <input type="file" id="picture" name="picture" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" onchange="previewImage();" required>
                    <!-- Image Preview Container -->
                    <div id="imagePreviewContainer" class="mt-2">
                        <img id="imagePreview" src="#" alt="Image Preview" class="hidden max-w-xs mt-2" />
                    </div>
                </div>


                <div class="mb-4">
                    <label for="content" class="block text-gray-700 text-sm font-bold mb-2">Content:</label>
                    <textarea id="content" col="5" name="content"></textarea>
                </div>

                <!-- Buttons for Draft and Publish -->
                <div class="flex justify-end">
                    <button type="submit" name="action" value="draft" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition-colors mr-2">Save as Draft</button>
                    <button type="submit" name="action" value="publish" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition-colors">Publish</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Initialize TinyMCE -->
    <script>
        setTimeout(function() {
            document.getElementById('errorPopup').style.display = 'none';
        }, 3000);

        tinymce.init({
            selector: '#content',
            plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
            toolbar_mode: 'floating',
        });

        function previewImage() {
            var preview = document.getElementById('imagePreview');
            var file = document.getElementById('picture').files[0];
            var reader = new FileReader();

            reader.onloadend = function() {
                preview.src = reader.result;
                preview.classList.remove('hidden');
            }

            if (file) {
                reader.readAsDataURL(file);
            } else {
                preview.src = "";
                preview.classList.add('hidden');
            }
        }
    </script>
</body>

</html>