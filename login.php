<?php
session_start();
$email = $_POST['email'];
$password = $_POST['password'];

// Connexion à la BDD
$conn = new mysqli("localhost", "root", "", "astropret");
$stmt = $conn->prepare("SELECT id, password_hash, role FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
  $user = $result->fetch_assoc();
  if (password_verify($password, $user['password_hash'])) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_role'] = $user['role'];
    header("Location: /astropret/frontend/calendar.html");
  } else {
    echo "Mot de passe incorrect !";
  }
} else {
  echo "Utilisateur non trouvé !";
}
?>

