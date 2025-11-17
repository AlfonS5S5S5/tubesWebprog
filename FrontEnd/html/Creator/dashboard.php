<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../Member/Login.html");
    exit();
}

require_once __DIR__ . "/../../../BackEnd/connection.php";

// Ambil creator_id dari session (asumsi creator sudah login)
$creator_id = isset($_SESSION['creator_id']) ? $_SESSION['creator_id'] : 1;

// --- AMBIL INFORMASI CREATOR ---
$sqlCreator = "SELECT creator_name, email, pendapatan_creator FROM creator WHERE creator_id = $creator_id";
$resultCreator = mysqli_query($conn, $sqlCreator);

if ($resultCreator && mysqli_num_rows($resultCreator) > 0) {
    $creatorInfo = mysqli_fetch_assoc($resultCreator);
    $creatorName = $creatorInfo['creator_name'];
    $creatorEmail = $creatorInfo['email'];
    $totalPendapatanCreator = (float) $creatorInfo['pendapatan_creator'];
} else {
    die("Error: Creator tidak ditemukan.");
}

// --- AMBIL DAFTAR GAME DAN PENJUALAN ---
$sqlGames = "
    SELECT 
        g.game_name,
        g.game_price,
        COUNT(l.game_id) AS total_terjual,
        SUM(l.library_buy_game_price) AS total_pendapatan_game
    FROM 
        game g
    LEFT JOIN 
        library l ON g.game_id = l.game_id
    WHERE 
        g.game_developer = '$creatorName'
    GROUP BY 
        g.game_id, g.game_name, g.game_price
    ORDER BY 
        total_pendapatan_game DESC;
";

$resultGames = mysqli_query($conn, $sqlGames);
$gamesList = [];
$totalRevenue = 0;

if ($resultGames && mysqli_num_rows($resultGames) > 0) {
    while($row = mysqli_fetch_assoc($resultGames)) {
        $gamesList[] = $row;
        $totalRevenue += (float) $row['total_pendapatan_game'];
    }
}

mysqli_close($conn);

// --- FUNGSI FORMAT RUPIAH ---
function formatRupiah($amount) {
    if ($amount === null) {
        return 'Rp0';
    }
    return 'Rp' . number_format($amount, 0, ',', '.');
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Creator Dashboard - <?php echo $creatorName; ?></title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="../../css/dashboard.css">
    <style>
        body {
            background: #1b2838;
            color: #c7d5e0;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        .dashboard-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .header {
            background: linear-gradient(135deg, #1b2838 0%, #2a475e 100%);
            padding: 30px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0,0,0,0.3);
        }

        .header h1 {
            color: #66c0f4;
            margin: 0 0 10px 0;
        }

        .header p {
            color: #c7d5e0;
            margin: 0;
        }

        .creator-info {
            background: linear-gradient(135deg, #1b2838 0%, #2a475e 100%);
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.3);
        }
        
        .creator-info h2 {
            color: #66c0f4;
            margin-bottom: 10px;
        }
        
        .creator-info p {
            color: #c7d5e0;
            margin: 5px 0;
        }
        
        .games-table {
            background: #1b2838;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
            overflow-x: auto;
            box-shadow: 0 4px 6px rgba(0,0,0,0.3);
        }
        
        .games-table h2 {
            color: #66c0f4;
            margin-bottom: 15px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        table th {
            background: #2a475e;
            color: #66c0f4;
            padding: 12px;
            text-align: left;
            border-bottom: 2px solid #66c0f4;
        }
        
        table td {
            padding: 10px 12px;
            color: #c7d5e0;
            border-bottom: 1px solid #2a475e;
        }
        
        table tr:hover {
            background: #2a475e;
        }
        
        .stat-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 20px;
        }
        
        .stat-card {
            background: linear-gradient(135deg, #1b2838 0%, #2a475e 100%);
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.3);
        }
        
        .stat-card h3 {
            color: #66c0f4;
            font-size: 14px;
            margin-bottom: 8px;
        }
        
        .stat-card p {
            color: #fff;
            font-size: 24px;
            font-weight: bold;
            margin: 0;
        }

        .chart-container {
            background: #1b2838;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.3);
        }

        .chart-container h2 {
            color: #66c0f4;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

<div class="dashboard-container">
    <header class="header">
        <h1>Dashboard Creator</h1>
        <p>Analisis Pendapatan Game</p>
    </header>

    <!-- INFORMASI CREATOR -->
    <div class="creator-info">
        <h2>Informasi Creator</h2>
        <p><strong>Nama:</strong> <?php echo $creatorName; ?></p>
        <p><strong>Email:</strong> <?php echo $creatorEmail; ?></p>
    </div>

    <!-- STATISTIK RINGKAS -->
    <div class="stat-grid">
        <div class="stat-card">
            <h3>Total Pendapatan (Database)</h3>
            <p><?php echo formatRupiah($totalPendapatanCreator); ?></p>
        </div>
        <div class="stat-card">
            <h3>Total Pendapatan (Penjualan)</h3>
            <p><?php echo formatRupiah($totalRevenue); ?></p>
        </div>
        <div class="stat-card">
            <h3>Jumlah Game</h3>
            <p><?php echo count($gamesList); ?></p>
        </div>
    </div>

    <!-- GRAFIK PENDAPATAN PER GAME -->
    <div class="chart-container">
        <h2>Grafik Pendapatan Per Game</h2>
        <canvas id="revenueChart"></canvas>
        
        <?php if (empty($gamesList)): ?>
            <p style="text-align: center; color: #c7d5e0; padding: 20px;">Tidak ada data game yang tersedia.</p>
        <?php endif; ?>
    </div>

    <!-- TABEL DAFTAR GAME -->
    <div class="games-table">
        <h2>Daftar Game dan Penjualan</h2>
        <?php if (!empty($gamesList)): ?>
        <table>
            <thead>
                <tr>
                    <th>Nama Game</th>
                    <th>Harga Game</th>
                    <th>Total Terjual</th>
                    <th>Total Pendapatan</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($gamesList as $game): ?>
                <tr>
                    <td><?php echo $game['game_name']; ?></td>
                    <td><?php echo formatRupiah($game['game_price']); ?></td>
                    <td><?php echo $game['total_terjual']; ?> unit</td>
                    <td><?php echo formatRupiah($game['total_pendapatan_game']); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php else: ?>
            <p style="color: #c7d5e0; text-align: center;">Belum ada game yang terdaftar.</p>
        <?php endif; ?>
    </div>

</div>

<script>
    <?php if (!empty($gamesList)): ?>
    // Prepare data for chart
    const gameNames = <?php echo json_encode(array_column($gamesList, 'game_name')); ?>;
    const gameRevenues = <?php echo json_encode(array_column($gamesList, 'total_pendapatan_game')); ?>;

    const ctx = document.getElementById('revenueChart').getContext('2d');
    
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: gameNames,
            datasets: [{
                label: 'Pendapatan (IDR)',
                data: gameRevenues,
                backgroundColor: 'rgba(102, 192, 244, 0.7)',
                borderColor: '#66c0f4',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    title: { display: true, text: 'Nama Game', color: '#c7d5e0' },
                    grid: { color: 'rgba(255,255,255,0.1)' },
                    ticks: { color: '#c7d5e0' }
                },
                y: {
                    beginAtZero: true,
                    title: { display: true, text: 'Pendapatan (Rupiah)', color: '#c7d5e0' },
                    grid: { color: 'rgba(255,255,255,0.1)' },
                    ticks: {
                        color: '#c7d5e0',
                        callback: function(value) {
                            if (value >= 1000000) {
                                return 'Rp ' + (value / 1000000).toFixed(1) + ' Jt';
                            } else if (value >= 1000) {
                                return 'Rp ' + (value / 1000) + ' Rb';
                            }
                            return 'Rp ' + value;
                        }
                    }
                }
            },
            plugins: {
                legend: {
                    labels: {
                        color: '#c7d5e0'
                    }
                }
            }
        }
    });
    <?php endif; ?>
</script>

</body>
</html>