# Telegram Bot (PHP)
A simple Telegram bot that lists APKs and handles design/payment flow.

## Deployment
1. Push to GitHub.
2. Connect to Render → New Web Service.
3. Environment:
   - Runtime: PHP
   - Start Command: `php -S 0.0.0.0:10000 bot.php`
   - Add Environment Variable:
     - BOT_TOKEN = your Telegram bot token
4. Deploy and set webhook:

