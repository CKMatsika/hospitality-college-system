# Global Layout Fix Script
# This script will find all .blade files and replace @extends('layouts.app') with @extends('layouts.qbo')

# Method 1: PowerShell (Recommended)
powershell -ExecutionPolicy Bypass -Command "
Get-ChildItem -Path 'resources\views' -Recurse -Filter '*.blade.php' | ForEach-Object {
    \$content = Get-Content \$_.FullName
    if (\$content -match \"@extends\('layouts\.app'\)\") {
        Write-Host \"Fixing: \$(\$_.Name)\"
        \$newContent = \$content -replace \"@extends\('layouts\.app'\)\", \"@extends('layouts.qbo')\"
        Set-Content \$_.FullName \$newContent
    }
}
Write-Host 'All layouts fixed successfully!'
"

# Method 2: Using sed (if available)
# Uncomment these lines if you have sed/gsed available:
# find resources/views -name "*.blade.php" -type f -exec sed -i "s/@extends('layouts\.app')/@extends('layouts.qbo')/g" {} \;

# Method 3: Using VS Code
# Open VS Code and use Ctrl+Shift+F to find all instances of @extends('layouts.app')
# Then use Ctrl+H to replace all with @extends('layouts.qbo')

echo "Choose one of the methods above to fix all layouts globally"
