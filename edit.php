<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit();
}
include 'config/koneksi.php';

// Get employee data based on ID from URL
$id = $_GET['id'];
$query = "SELECT * FROM pegawai WHERE id = $id";
$result = mysqli_query($koneksi, $query);
$pegawai = mysqli_fetch_assoc($result);

if (isset($_POST['update'])) {
    // Get form data
    $nama = $_POST['nama'];
    $umur = $_POST['umur'];
    $alamat = $_POST['alamat'];
    $deskripsi = $_POST['deskripsi'];
    $kategori = $_POST['kategori'];

    // Check if fields are not empty
    if (!empty($nama) && !empty($umur) && !empty($alamat) && !empty($deskripsi) && !empty($kategori)) {
        // Directly include variables in SQL query (unsafe)
        $query = "UPDATE pegawai SET nama = '$nama', umur = '$umur', alamat = '$alamat', deskripsi = '$deskripsi', kategori_id = '$kategori' WHERE id = $id";
        
        if (mysqli_query($koneksi, $query)) {
            // Redirect to index after successful update
            header("Location: index.php");
            exit();
        } else {
            $error = "Gagal mengupdate data!";
        }
    } else {
        $error = "Semua field harus diisi!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Pegawai</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>

    <div class="container mt-5">
        <div class="card">
            <div class="card-body">
                <div class="text-center">
                    <h3 class="mb-4">Edit Pegawai</h3>
                </div>
                <form method="POST">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" id="nama" name="nama" class="form-control" value="<?= $pegawai['nama'] ?>" required>
                        
                    </div>
                    <div class="mb-3">
                        <label for="umur" class="form-label">Umur</label>
                        <input type="number" id="umur" name="umur" class="form-control" value="<?= $pegawai['umur'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <input type="text" id="alamat" name="alamat" class="form-control" value="<?= $pegawai['alamat'] ?>" required>
                    </div>
                    <div class="mb-3 form-group">
                        <label >Kategori</label>
                        <select class="form-select" aria-label="Default select example" name="kategori">
                            <option value="">Open this select menu</option>
                                <option value="Freelance" <?= $pegawai['kategori_id'] == 1 ? 'selected' : '' ?>>Freelance</option>
                                <option value="Part Time" <?= $pegawai['kategori_id'] == 2 ? 'selected' : '' ?>>Part Time</option>
                                <option value="Full Time " <?= $pegawai['kategori_id'] == 3 ? 'selected' : '' ?>>Full Time</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea id="deskripsi" name="deskripsi" class="form-control" required><?= $pegawai['deskripsi'] ?></textarea>
                    </div>
                    <div class="d-grid gap-2 col-6 mx-auto">
                        <button class="btn btn-primary" type="submit" name="update">Update</button>
                    </div>
                </form>
                <!-- Menampilkan pesan error jika ada -->
                <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoBpy5KfUts8gF4Qsb1D1XbJKNqKZjVA/k9ZCjF2Gp3cYB2" crossorigin="anonymous"></script>
</body>
</html>
