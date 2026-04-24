# 🚀 Stable Check-in Tunnel (using Localtunnel with Auto-Restart)
# This script keeps localtunnel alive and updates your QR code URL automatically.

$port = 8000
$tunnelFile = "tunnel_url.txt"
$subdomain = "extrafit-checkin-$(Get-Random -Minimum 1000 -Maximum 9999)"

Write-Host "--- Starting Auto-Healing Tunnel on port $port ---" -ForegroundColor Cyan

function Start-Tunnel {
    Write-Host "Connecting to Localtunnel..." -ForegroundColor Yellow
    
    # Start localtunnel and capture output
    $process = Start-Process cmd -ArgumentList "/c npx localtunnel --port $port --subdomain $subdomain" -NoNewWindow -PassThru -RedirectStandardOutput "tunnel.log"
    
    # Wait for URL
    $foundUrl = $false
    $attempts = 0
    while (!$foundUrl -and $attempts -lt 15) {
        Start-Sleep -Seconds 1
        if (Test-Path "tunnel.log") {
            $content = Get-Content "tunnel.log" -Raw
            if ($content -match "https://[a-z0-9-.]+\.loca\.lt") {
                $publicUrl = $matches[0]
                Write-Host "✅ Tunnel Active: $publicUrl" -ForegroundColor Green
                $publicUrl | Out-File -FilePath $tunnelFile -Encoding utf8
                Write-Host "✅ URL saved to $tunnelFile. QR codes updated!" -ForegroundColor Green
                $foundUrl = $true
            }
        }
        $attempts++
    }
    return $process
}

while ($true) {
    $proc = Start-Tunnel
    
    # Monitor the process or wait for a long time
    # Localtunnel sometimes stays alive but stops working. 
    # We will restart every 2 hours just in case, or if the process exits.
    $waitCounter = 0
    while (!$proc.HasExited -and $waitCounter -lt 7200) { # 2 hours
        Start-Sleep -Seconds 1
        $waitCounter++
    }
    
    Write-Warning "Tunnel connection dropped or timed out. Restarting..."
    if (!$proc.HasExited) { Stop-Process $proc.Id -Force }
    Remove-Item "tunnel.log" -ErrorAction SilentlyContinue
}
