<?php
function encryptVigenere($text, $key) {
    $encrypted_text = "";
    $text_length = strlen($text);
    $key_length = strlen($key);

    for ($i = 0; $i < $text_length; $i++) {
        $char = $text[$i];
        $key_char = $key[$i % $key_length];

        $char_code = ord($char);
        $key_code = ord($key_char);

        $encrypted_char = chr(($char_code + $key_code) % 256);
        $encrypted_text .= $encrypted_char;
    }

    return base64_encode($encrypted_text);
}

function decryptVigenere($encrypted_text, $key) {
    $decrypted_text = base64_decode($encrypted_text);
    $text_length = strlen($decrypted_text);
    $key_length = strlen($key);

    for ($i = 0; $i < $text_length; $i++) {
        $char = $decrypted_text[$i];
        $key_char = $key[$i % $key_length];

        $char_code = ord($char);
        $key_code = ord($key_char);

        // Menerapkan dekripsi Vigenere Cipher
        $decrypted_char = chr(($char_code - $key_code + 256) % 256);
        $decrypted_text[$i] = $decrypted_char;
    }

    return $decrypted_text;
}

$database = [
    "username" => "username",
    "password" => encryptVigenere("sandi", "secretkey")
];

$login_result = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input_username = $_POST["username"];
    $input_password = $_POST["password"];

    if ($input_username == $database["username"] && decryptVigenere($database["password"], "secretkey") == $input_password) {
        $login_result = "Login berhasil!";
    } else {
        $login_result = "Login gagal!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login dengan Vigenere Cipher</title>
</head>
<body>
    <h3>Login dengan Vigenere Cipher</h3>
    <form method="POST">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username"><br><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password"><br><br>
        <input type="submit" value="Login">
    </form>
    <?php
    if (!empty($login_result)) {
        echo "<p>Hasil Enkripsi Password: " . $database["password"] . "</p>";
        echo "<p>Hasil Login: " . $login_result . "</p>";
    }
    ?>
</body>
</html>
