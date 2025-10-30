<?php
session_start();
require_once 'config/database.php';

// Cek apakah user sudah login
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin-login.php');
    exit;
}

// Ambil data kontak dari database
$stmt = $pdo->query("SELECT * FROM contact_submissions ORDER BY submission_date DESC");
$contacts = $stmt->fetchAll();

// Logout
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: admin-login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - YNWARYN Creative Studio</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .admin-header {
            background: var(--primary-dark);
            color: var(--white);
            padding: 1rem 0;
        }
        .admin-nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .admin-content {
            padding: 2rem 0;
            min-height: 80vh;
        }
        .contact-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }
        .contact-table th,
        .contact-table td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid var(--light-gray);
        }
        .contact-table th {
            background: var(--accent-purple);
            color: var(--white);
        }
        .status-new {
            background: #fed7d7;
            color: #c53030;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            font-size: 0.8rem;
        }
        .status-read {
            background: #c6f6d5;
            color: #276749;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            font-size: 0.8rem;
        }
        .btn-logout {
            background: #e53e3e;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <header class="admin-header">
        <div class="container">
            <div class="admin-nav">
                <h1>Admin Dashboard - YNWARYN Creative Studio</h1>
                <div>
                    <span>Halo, <?php echo $_SESSION['admin_name']; ?></span>
                    <a href="?logout=1" class="btn-logout">Logout</a>
                </div>
            </div>
        </div>
    </header>

    <section class="admin-content">
        <div class="container">
            <h2>Data Kontak Klien</h2>
            
            <?php if (count($contacts) > 0): ?>
                <table class="contact-table">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Telepon</th>
                            <th>Perusahaan</th>
                            <th>Layanan</th>
                            <th>Budget</th>
                            <th>Pesan</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($contacts as $contact): ?>
                        <tr>
                            <td><?php echo date('d/m/Y H:i', strtotime($contact['submission_date'])); ?></td>
                            <td><?php echo htmlspecialchars($contact['name']); ?></td>
                            <td><?php echo htmlspecialchars($contact['email']); ?></td>
                            <td><?php echo htmlspecialchars($contact['phone']); ?></td>
                            <td><?php echo htmlspecialchars($contact['company']); ?></td>
                            <td><?php echo htmlspecialchars($contact['service']); ?></td>
                            <td><?php echo htmlspecialchars($contact['budget']); ?></td>
                            <td><?php echo htmlspecialchars(substr($contact['message'], 0, 50)) . '...'; ?></td>
                            <td>
                                <span class="status-<?php echo $contact['status']; ?>">
                                    <?php echo $contact['status']; ?>
                                </span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Belum ada data kontak.</p>
            <?php endif; ?>
        </div>
    </section>
</body>
</html>