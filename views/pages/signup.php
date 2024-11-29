<div class="container">
    <form action="process_signup.php" method="POST" class="form">
        <h1>Daftar</h1>
        <label for="name">Nama Lengkap:</label>
        <input type="text" name="name" id="name" required>
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>
        <button type="submit" class="btn">Daftar</button>
        <p>Sudah punya akun? <a href="index.php?page=login">Login</a></p>
    </form>
</div>
