<?php include 'setting/system.php'; ?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= NAME_ ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
  <link href='https://fonts.googleapis.com/css?family=Baumans' rel='stylesheet'>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  // Add CSP header
<VirtualHost *:443>
    # Enable HSTS for one year and apply it to all subdomains
    Header always set Strict-Transport-Security "max-age=31536000; includeSubDomains"
</VirtualHost>

<VirtualHost *:443>
    # Allow framing only from the same origin
    Header always set X-Frame-Options "SAMEORIGIN"
</VirtualHost>

<VirtualHost *:443>
    # Prevent MIME sniffing
    Header always set X-Content-Type-Options "nosniff"
</VirtualHost>

# Enable HTTP headers
<IfModule mod_headers.c>
    # Set Referrer-Policy header
    Header set Referrer-Policy "no-referrer-when-downgrade"
</IfModule>

# Ensure mod_headers is enabled
<IfModule mod_headers.c>
    # Set Permissions-Policy header
    Header set Permissions-Policy "geolocation=(self), camera=(), microphone=()"
</IfModule>
 header("Content-Security-Policy: default-src 'self'; script-src 'self' https://jsvpiggery.com;");
 header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload");
 header("X-Content-Type-Options: nosniff");
 header("X-Frame-Options: DENY");
 header("X-XSS-Protection: 1; mode=block");
 header("Referrer-Policy: no-referrer");
 header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
 header('Pragma: no-cache');
 header('Expires: 0');
 header('Content-Type: text/html; charset=utf-8');
 header("X-Frame-Options: SAMEORIGIN");
 header("Referrer-Policy: strict-origin-when-cross-origin");
 header("Permissions-Policy: geolocation=()");
 

foreach ($_GET as $key => $value) {
    $_GET[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}
foreach ($_POST as $key => $value) {
    $_POST[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}
foreach ($_COOKIE as $key => $value) {
    $_COOKIE[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

  <style>
    body {
      font-family: 'Baumans';
      background-color: #d4d8dd;
    }
  </style>
</head>

<body>