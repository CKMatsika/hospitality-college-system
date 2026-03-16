# Fix all x-app-layout references to use QBO layout
# This will fix the major cause of old dashboard redirection

$files = @(
    "resources\views\courses\edit.blade.php",
    "resources\views\courses\show.blade.php", 
    "resources\views\enrollments\csv\preview.blade.php",
    "resources\views\enrollments\csv\result.blade.php",
    "resources\views\enrollments\manual\create.blade.php",
    "resources\views\library\books\edit.blade.php",
    "resources\views\library\books\show.blade.php",
    "resources\views\library\loans\create.blade.php",
    "resources\views\library\loans\index.blade.php",
    "resources\views\library\reservations\create.blade.php",
    "resources\views\library\reservations\index.blade.php",
    "resources\views\lms\courses\edit.blade.php",
    "resources\views\lms\courses\show.blade.php",
    "resources\views\lms\enrollments\create.blade.php",
    "resources\views\profile\edit.blade.php",
    "resources\views\programs\show.blade.php",
    "resources\views\reports\academic.blade.php",
    "resources\views\reports\enrollment.blade.php",
    "resources\views\reports\financial.blade.php",
    "resources\views\reports\library.blade.php",
    "resources\views\reports\lms.blade.php",
    "resources\views\reports\staff.blade.php",
    "resources\views\staff\edit.blade.php",
    "resources\views\staff\show.blade.php",
    "resources\views\students\edit.blade.php",
    "resources\views\students\show.blade.php",
    "resources\views\system-settings\edit.blade.php"
)

foreach ($file in $files) {
    if (Test-Path $file) {
        Write-Host "Fixing: $file"
        $content = Get-Content $file
        $newContent = $content -replace "<x-app-layout>", "@extends('layouts.qbo')" -replace "</x-app-layout>", "" -replace "<x-slot name=`"header`">", "@section('title', '" -replace "</x-slot>", "@section('content')" -replace "</h2>", "</h1>" -replace "<h2 class=`"font-semibold text-xl text-gray-800 leading-tight`">", "<h1 class=`"text-3xl font-bold text-gray-900`">" -replace "{{ __\(`"(.+)`")__ }}", '$1'
        Set-Content $file $newContent
    }
}

Write-Host "All x-app-layout references fixed!"
