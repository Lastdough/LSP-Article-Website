
# Project Structure

```bash
/LSP Article Website
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
                - edit_article.php
                - new_article.php
            /user
                - index.php
                - article_detail.php
    /config
        - config.php
    /public
        /css
        /js
        /images
    .htaccess
    index.php
```

## Htdocs 

```bash 
$htdocs = "C:\xampp\htdocs\LSPWebsite"
$current = Get-Location

Write-Output $htdocs $current

cmd.exe /c mklink /j $htdocs $current

```


