Get-ChildItem -Path "resources\views" -Recurse -Filter "*.blade.php" | ForEach-Object {
    $content = Get-Content $_.FullName
    if ($content -match "@extends\('layouts\.app'\)") {
        Write-Host "Fixing: $($_.Name)"
        $newContent = $content -replace "@extends\('layouts\.app'\)", "@extends('layouts.qbo')"
        Set-Content $_.FullName $newContent
    }
}
Write-Host "All layouts fixed successfully!"
