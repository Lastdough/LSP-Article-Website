
# Project Structure

```bash
/LSP Article Website
    /src
        /app
            /controllers
                - AdminController.php
                - ArticleController.php
            /models
                - Database.php
                - Article.php
                - Admin.php
            /views
                /admin
                    - dashboard.php
                    - login.php
                    - register.php
                    - edit_article.php
                    - create_article.php
                /user
                    - home_page.php
                    - view_article.php
                /error
                    - 404.php
        /public
            /css
            /js
            /images
        /utilities
            - utils.php
    .htaccess
    index.php
    tailwind.config.js
    package.json
    composer.json
```

## Htdocs 

```bash 
$htdocs = "C:\xampp\htdocs\LSPWebsite"
$current = Get-Location

Write-Output $htdocs $current

cmd.exe /c mklink /j $htdocs $current

```


