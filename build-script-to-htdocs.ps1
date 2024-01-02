$htdocs = "C:\xampp\htdocs\LSPWebsite"
$current = Get-Location

Write-Output $htdocs $current

cmd.exe /c mklink /j $htdocs $current