$files = @(
    "C:\laragon\www\batubata\resources\views\admin\tpa\dashboard.blade.php",
    "C:\laragon\www\batubata\resources\views\education\dashboard.blade.php",
    "C:\laragon\www\batubata\resources\views\industry\dashboard.blade.php",
    "C:\laragon\www\batubata\resources\views\teacher\dashboard.blade.php",
    "C:\laragon\www\batubata\resources\views\dashboard.blade.php"
)

foreach ($file in $files) {
    if (Test-Path $file) {
        $content = Get-Content $file -Raw
        
        $colors = @("blue", "red", "green", "yellow", "orange", "purple", "emerald", "indigo", "cyan")
        foreach ($c in $colors) {
            $pattern = "(?s)shadow-md(.*?border-l-$c-500.*?)hover:shadow-lg"
            $replacement = "shadow-$c-500/20 dark:shadow-$c-500/20$1hover:shadow-xl hover:shadow-$c-500/40"
            $content = [regex]::Replace($content, $pattern, $replacement)
        }
        
        $content = [regex]::Replace($content, "(?s)shadow-md(\s+p-6\s+border)", "shadow-xl shadow-gray-200/50 dark:shadow-gray-900/50$1")
        $content = [regex]::Replace($content, "(?s)shadow-md(\s+border\s+border-gray-200)", "shadow-xl shadow-gray-200/50 dark:shadow-gray-900/50$1")
        
        Set-Content -Path $file -Value $content -NoNewline
    }
}
