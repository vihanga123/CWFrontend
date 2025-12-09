<?php
// healthz.php — always returns 200 OK if PHP is running
http_response_code(200);
echo "OK";
?>