<?php
include 'db.php';

session_start();
// Assuming farmer ID is stored in session after login
$farmer_id = $_SESSION['farmer_id'] ?? $_GET['id'] ?? null;

if (!$farmer_id) {
    echo "Invalid or missing farmer ID!";
    exit;
}

$sql = "SELECT * FROM farmers WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $farmer_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Farmer not found!";
    exit;
}

$farmer = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Farmer Profile - Yield Cycle</title>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            background-color: #f6f6f6;
            margin: 0;
        }

        .header {
            background-color: #27ae60;
            color: white;
            padding: 15px 30px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .header img {
            height: 50px;
        }

        .header h1 {
            font-size: 24px;
            margin: 0;
        }

        .profile-container {
            max-width: 500px;
            margin: 50px auto;
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .profile-container h2 {
            color: #27ae60;
            text-align: center;
            margin-bottom: 30px;
        }

        .profile-group {
            margin-bottom: 20px;
        }

        .profile-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #333;
        }

        .profile-group input,
        .profile-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background: #f9f9f9;
        }

        .update-btn {
            display: block;
            width: 100%;
            background-color: #27ae60;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            font-size: 16px;
            cursor: pointer;
        }

        .update-btn:hover {
            background-color: #219150;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="log.jpg" alt="Logo">
        <h1>YIELD CYCLE</h1>
    </div>

    <div class="profile-container">
        <h2>Company Profile</h2>
        <form action="update.php" method="post">
            <input type="hidden" name="id" value="<?= $farmer['id'] ?>">

            <div class="profile-group">
                <label>Name of the Company</label>
                <input type="text" name="name" value="<?= htmlspecialchars($farmer['name']) ?>" required>
            </div>

            <div class="profile-group">
                <label>Contact Information</label>
                <input type="tel" name="phone" value="<?= htmlspecialchars($farmer['phone']) ?>" required>
            </div>

            <div class="profile-group">
                <label>Email ID</label>
                <input type="email" name="email" value="<?= htmlspecialchars($farmer['email']) ?>" required>
            </div>

            <div class="profile-group">
                <label>Address</label>
                <textarea name="address" rows="4"><?= htmlspecialchars($farmer['address']) ?></textarea>
            </div>

            <button type="submit" class="update-btn">Update Profile</button>
        </form>
    </div>
</body>
</html>
