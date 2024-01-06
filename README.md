
# Project Structure

```bash
/LSP Article Website
    /src
        /app
            /controllers
                - AdminController.php
                - ArticleController.php
            /models
                - Admin.php
                - Article.php
                - Database.php
            /views
                /admin
                    - create_article.php
                    - dashboard.php
                    - edit_article.php
                    - login.php
                    - register.php
                /error
                    - 404.php
                /user
                    - home_page.php
                    - view_article.php
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


