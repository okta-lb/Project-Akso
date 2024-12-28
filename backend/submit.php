<?php
$servername = "mysql"; // Hostname sesuai dengan nama service di docker-compose
$username = "stich"; // Username database
$password = "stich"; // Password database
$dbname = "Library"; // Nama database

// Membuat koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);

// Mengecek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Memproses data jika method adalah POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validasi data input
    $name = isset($_POST['name']) ? $conn->real_escape_string($_POST['name']) : '';
    $birth = isset($_POST['birth']) ? $conn->real_escape_string($_POST['birth']) : '';
    $gender = isset($_POST['gender']) ? $conn->real_escape_string($_POST['gender']) : '';
    $hobbies = isset($_POST['hobbies']) ? $conn->real_escape_string($_POST['hobbies']) : '';
    $pet = isset($_POST['pet']) ? $conn->real_escape_string($_POST['pet']) : '';
    $drinks = isset($_POST['drinks']) ? $conn->real_escape_string($_POST['drinks']) : '';
    $song = isset($_POST['song']) ? $conn->real_escape_string($_POST['song']) : '';
    $sports = isset($_POST['sports']) ? $conn->real_escape_string($_POST['sports']) : '';

    if (!empty($name) && !empty($birth) && !empty($gender) && !empty($hobbies) && !empty($pet) && !empty($drinks) && !empty($song) && !empty($sports)) {
        // Menggunakan prepared statements untuk keamanan
        $stmt = $conn->prepare("INSERT INTO biodata (name, birth, gender, hobbies, pet, drinks, song, sports) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssss", $name, $birth, $gender, $hobbies, $pet, $drinks, $song, $sports);

        if ($stmt->execute()) {
            echo "Biodata saved successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "All fields are required!";
    }
}

// Menutup koneksi
$conn->close();
?>
