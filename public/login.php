<?php
use App\Core\Database;
use App\Core\Session;
use App\Core\Auth;
use App\User\UserRepository;

require '../vendor/autoload.php';

Session::start();

$db = Database::connect();
$user = new UserRepository($db);

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $users->findByEmail($_POST['email']);

    if ($user && password_verify($_POST['password'], $user->passwordHash)) {
        Auth::login($user->id);
        header("Location: index.php");
        exit;
    }
}
?>
<form method="post">
    <input type="email" name="email" id="email" placeholder="Email">
    <input type="password" name="password" id="password" placeholder="Password">
    <button>Login</button>
</form>