<?php
$botToken = getenv("BOT_TOKEN");
if (!$botToken) exit("BOT_TOKEN not set");

$apiUrl = "https://api.telegram.org/bot$botToken/";

$content = file_get_contents("php://input");
$update = json_decode($content, true);

// simple safety
if (!$update || !isset($update['message'])) {
    exit;
}

$chat_id = $update["message"]["chat"]["id"];
$text = isset($update["message"]["text"]) ? trim($update["message"]["text"]) : "";

// /start menu
if ($text === "/start") {
    $msg = "👋 Welcome!\n\nAll Available Admin Panels ✅\n\n"
         . "1️⃣ RTO CHALAN APK\n2️⃣ PM-Kisan APK\n3️⃣ PM AAWAS YOJANA APK\n4️⃣ Customer Support APK\n5️⃣ Health Insurance APK\n6️⃣ Electricity Bill APK\n7️⃣ Delhi Jal Board APK\n8️⃣ All Bank NetBanking APK\n9️⃣ All Bank Credit Card APK\n🔟 Other APK\n\n"
         . "*Plans:*\nM1 — $79 | 1 APK | 1 month\nM2 — $129 | 1 APK | 2 months\nM3 — $169 | 1 APK | 3 months\n\n_Note: Only USDT accepted._";
    sendMessage($chat_id, $msg);
    exit;
}

// If user types a number 1..10 show plans & design request
if (preg_match('/^(?:[1-9]|10)$/', $text)) {
    sendMessage($chat_id, "You chose App #$text. Choose design style:\n1 Modern\n2 Minimal\n3 Professional\n4 Gradient\nReply with design number.");
    exit;
}

// If user chooses design 1..4 send image + payment QR
if (in_array($text, ["1","2","3","4"])) {
    $designs = [
        "1" => "https://via.placeholder.com/600x400.png?text=Design+Modern",
        "2" => "https://via.placeholder.com/600x400.png?text=Design+Minimal",
        "3" => "https://via.placeholder.com/600x400.png?text=Design+Professional",
        "4" => "https://via.placeholder.com/600x400.png?text=Design+Gradient"
    ];
    $photo = $designs[$text];
    sendPhoto($chat_id, $photo, "Here is your design. Now scan to pay (USDT).");
    // mock payment QR
    sendPhoto($chat_id, "https://via.placeholder.com/300.png?text=USDT+QR", "Scan this to pay via USDT (demo).");
    exit;
}

sendMessage($chat_id, "Type /start to see available APKs.");

// helpers
function sendMessage($chat_id, $text) {
    global $apiUrl;
    $params = [
        "chat_id" => $chat_id,
        "text" => $text,
        "parse_mode" => "Markdown"
    ];
    file_get_contents($apiUrl . "sendMessage?" . http_build_query($params));
}

function sendPhoto($chat_id, $photoUrl, $caption = "") {
    global $apiUrl;
    $params = [
        "chat_id" => $chat_id,
        "photo" => $photoUrl,
        "caption" => $caption
    ];
    file_get_contents($apiUrl . "sendPhoto?" . http_build_query($params));
}
?>
