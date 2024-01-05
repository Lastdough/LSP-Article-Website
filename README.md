
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
                - register.php
                - edit_article.php
                - create_article.php
            /user
                - home_page.php
                - view_article.php
            /error
                - 404.php
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


