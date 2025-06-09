<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];

    $sql = "UPDATE farmers SET name=?, phone=?, email=?, address=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $name, $phone, $email, $address, $id);

    if ($stmt->execute()) {
        header("Location: profile.php?id=$id");
        exit;
    } else {
        echo "Error updating profile: " . $conn->error;
    }
}
?>
