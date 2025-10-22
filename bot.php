<?php
// Get the Telegram Bot Token from environment variable
$botToken = getenv("BOT_TOKEN");

// Telegram API URL
$apiUrl = "https://api.telegram.org/bot$botToken/";

// Get update from Telegram
$content = file_get_contents("php://input");
$update = json_decode($content, true);

if (!$update) {
    exit;
}

$chat_id = $update["message"]["chat"]["id"];
$text = trim($update["message"]["text"]);

// ✅ Step 1: Start message
if ($text == "/start") {
    $msg = "👋 Welcome!\n\nAll Available Admin Panels ✅\n\n"
         . "✍️✍️✍️\n"
         . "RTO CHALAN APK ✅\n"
         . "PM-Kisan APK ✅\n"
         . "PM AAWAS YOJANA APK ✅\n"
         . "Customer Support APK ✅\n"
         . "Health Insurance APK ✅\n"
         . "Electricity Bill APK ✅\n"
         . "Delhi Jal Board APK ✅\n"
         . "All Bank NetBanking APK ✅\n"
         . "All Bank Credit Card APK ✅\n"
         . "Other APK ✅\n\n"
         . "| Plan | Price | APKS | Valid |\n"
         . "|------|:-----:|:----:|:------:|\n"
         . "| M1 | $79 | 1 APK | 1 month |\n"
         . "| M2 | $129 | 1 APK | 2 months |\n"
         . "| M3 | $169 | 1 APK | 3 months |\n\n"
         . "💳 *Note:* Only USDT is accepted.\n(If you use UPI, please purchase USDT first, e.g. on Binance.)";

    sendMessage($chat_id, $msg);
    exit;
}

// ✅ Step 2: Handle design request
elseif (stripos($text, "apk") !== false) {
    $msg = "📱 Please select your preferred design type:";
    sendMessage($chat_id, $msg);

    // Send a placeholder design image
    sendPhoto($chat_id, "https://via.placeholder.com/600x400.png?text=Sample+Design");
    exit;
}

// ✅ Step 3: Handle design selection
elseif (stripos($text, "design") !== false) {
    $msg = "💵 Please scan this QR to complete payment via USDT (TRC20):";
    sendPhoto($chat_id, "https://via.placeholder.com/300.png?text=USDT+Payment+QR");
    exit;
}

// ✅ Step 4: Default reply
else {
    sendMessage($chat_id, "⚙️ Please type /start to view available APKs.");
}

// 📤 Function to send messages
function sendMessage($chat_id, $text) {
    global $apiUrl;
    $url = $apiUrl . "sendMessage";
    $post = [
        "chat_id" => $chat_id,
        "text" => $text,
        "parse_mode" => "Markdown"
    ];
    file_get_contents($url . "?" . http_build_query($post));
}

// 📸 Function to send photos
function sendPhoto($chat_id, $photoUrl) {
    global $apiUrl;
    $url = $apiUrl . "sendPhoto";
    $post = [
        "chat_id" => $chat_id,
        "photo" => $photoUrl
    ];
    file_get_contents($url . "?" . http_build_query($post));
}
?>
