<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../Member/Login.html");
    exit();
}

// Anda sudah me-require file connection.php, diasumsikan $conn sudah tersedia
require_once __DIR__ . "/../../../BackEnd/connection.php"; 

// --- PENGATURAN LOKAL DAN DATABASE ---
setlocale(LC_TIME, 'id_ID.utf8'); // Pastikan locale ID aktif

// Daftar bulan dalam Bahasa Indonesia untuk dropdown
$indonesianMonths = [
    1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 
    5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 
    9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
];

// --- TENTUKAN BULAN DAN TAHUN YANG DIPILIH ---
$currentYear = date('Y');
$currentMonth = date('n'); 

// Tentukan tahun minimum dan maksimum untuk dropdown
$minYear = 2024; // Tahun awal data dummy Anda
$maxYear = intval($currentYear); 

// Ambil input dari user. DEFAULT: Bulan 0 (Semua Bulan) dan Tahun saat ini.
$selectedYear = isset($_POST['tahun']) ? intval($_POST['tahun']) : intval($currentYear);
$selectedMonth = isset($_POST['bulan']) ? intval($_POST['bulan']) : 0; // Default 0 = Semua Bulan

// Validasi input tahun dan bulan
if ($selectedYear < $minYear || $selectedYear > $maxYear) {
    $selectedYear = intval($currentYear);
}
if ($selectedMonth < 0 || $selectedMonth > 12) {
    $selectedMonth = 0;
}

$isMonthlyView = ($selectedMonth == 0);

if ($isMonthlyView) {
    // --- MODE 1: PENDAPATAN BULANAN (JAN 2025 - BULAN INI) ---
    $viewTitle = "Grafik Pendapatan Bulanan (2025)";
    $summaryPeriod = "2025 - " . $indonesianMonths[$currentMonth];
    $labelUnit = "Bulan";
    $chartType = 'bar'; // Tetap bar
    
    $sql = "
        SELECT 
            DATE_FORMAT(tanggal, '%Y-%m') AS sort_key,
            -- Menggunakan format Singkat Bulan + Tahun untuk Label Grafik
            DATE_FORMAT(tanggal, '%b %Y') AS chart_label, 
            SUM(jumlah) AS total_pendapatan
        FROM 
            pendapatan_admin
        WHERE 
            YEAR(tanggal) >= 2025 -- Filter mulai dari tahun 2025
        GROUP BY 
            sort_key, chart_label
        ORDER BY 
            sort_key ASC;
    ";
    
} else {
    // --- MODE 2: PENDAPATAN HARIAN (BULAN TERTENTU) ---
    $monthName = $indonesianMonths[$selectedMonth];
    $viewTitle = "Grafik Pendapatan Harian Bulan " . $monthName . ' ' . $selectedYear;
    $summaryPeriod = $monthName . ' ' . $selectedYear;
    $labelUnit = "Tanggal";
    $chartType = 'bar';
    
    $sql = "
        SELECT 
            DAY(tanggal) AS sort_key, 
            CONCAT('Tgl ', DAY(tanggal)) AS chart_label, 
            SUM(jumlah) AS total_pendapatan 
        FROM 
            pendapatan_admin 
        WHERE 
            YEAR(tanggal) = $selectedYear AND MONTH(tanggal) = $selectedMonth
        GROUP BY 
            sort_key, chart_label
        ORDER BY 
            sort_key ASC;
    ";
}


// Pastikan variabel $conn sudah tersedia dari file connection.php
if (!isset($conn)) {
    die("Error: Variabel koneksi \$conn tidak tersedia. Pastikan connection.php mendefinisikannya.");
}

$result = $conn->query($sql);

// --- MEMPROSES HASIL QUERY ---
$labels = [];
$data = [];
$totalRevenue = 0;

if ($result === FALSE) {
    die("Error dalam Query SQL: " . $conn->error . "<br>Query: " . $sql);
}

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $labels[] = $row['chart_label']; 
        $data[] = (float) $row['total_pendapatan'];
        $totalRevenue += (float) $row['total_pendapatan'];
    }
}

if (isset($conn)) {
    $conn->close();
}


// --- DATA UNTUK CHART.JS ---
function formatRupiah($amount) {
    return 'Rp' . number_format($amount, 0, ',', '.');
}

$jsonLabels = json_encode($labels);
$jsonData = json_encode($data);

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard Pendapatan</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="../../css/dashboard.css"> 
</head>
<body>

<div class="dashboard-container">
    <header class="header">
        <h1>Dashboard Admin</h1>
        <p>Analisis Pendapatan</p>
    </header>

    <!-- FORM PEMILIHAN BULAN DAN TAHUN -->
    <div class="filter-card">
        <form method="POST" action="dashboard.php" style="display: flex; gap: 20px; align-items: center;">
            <div>
                <label for="bulan">Pilih Periode:</label>
                <select name="bulan" id="bulan" onchange="this.form.submit()">
                    <!-- Opsi default: Semua Bulan -->
                    <option value="0" <?php echo ($selectedMonth == 0) ? 'selected' : ''; ?>>Semua Bulan (2025)</option>
                    <?php foreach ($indonesianMonths as $num => $name): ?>
                        <option value="<?php echo $num; ?>" 
                            <?php echo ($num == $selectedMonth) ? 'selected' : ''; ?>>
                            <?php echo $name; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <?php if (!$isMonthlyView): ?>
            <div>
                <label for="tahun">Pilih Tahun:</label>
                <select name="tahun" id="tahun" onchange="this.form.submit()">
                    <?php 
                    for ($y = $minYear; $y <= $maxYear; $y++):
                    ?>
                        <option value="<?php echo $y; ?>" 
                            <?php echo ($y == $selectedYear) ? 'selected' : ''; ?>>
                            <?php echo $y; ?>
                        </option>
                    <?php endfor; ?>
                </select>
            </div>
            <?php else: ?>
                <!-- Hidden input untuk menjaga nilai tahun saat mode bulanan -->
                <input type="hidden" name="tahun" value="<?php echo $selectedYear; ?>">
            <?php endif; ?>
        </form>
    </div>
    
    <div class="summary-card">
        <h2>Total Pendapatan Periode <?php echo $summaryPeriod; ?></h2>
        <p class="revenue-amount"><?php echo formatRupiah($totalRevenue); ?></p>
    </div>

    <div class="chart-container">
        <h2 id="chartTitle"><?php echo $viewTitle; ?></h2>
        <canvas id="revenueChart"></canvas>
        
        <?php if (empty($data)): ?>
            <p style="text-align: center; color: #c7d5e0; padding: 20px;">Tidak ada data pendapatan yang tercatat untuk periode ini.</p>
        <?php endif; ?>
    </div>

</div>

<script>
    // Ambil data PHP yang sudah diubah ke JSON
    const labels = <?php echo $jsonLabels; ?>;
    const data = <?php echo $jsonData; ?>;
    const labelUnit = '<?php echo $labelUnit; ?>';

    if (labels.length > 0) {
        const ctx = document.getElementById('revenueChart').getContext('2d');
        
        new Chart(ctx, {
            type: 'bar', // Menggunakan chart type dari PHP jika ada (saat ini tetap 'bar')
            data: {
                labels: labels, 
                datasets: [{
                    label: 'Pendapatan (IDR)',
                    data: data, 
                    backgroundColor: 'rgba(102, 192, 244, 0.7)', // Steam Blue
                    borderColor: '#66c0f4',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        title: { display: true, text: labelUnit, color: '#c7d5e0' },
                        grid: { color: 'rgba(255,255,255,0.1)' },
                        ticks: { color: '#c7d5e0' }
                    },
                    y: {
                        beginAtZero: true,
                        title: { display: true, text: 'Pendapatan (Rupiah)', color: '#c7d5e0' },
                        grid: { color: 'rgba(255,255,255,0.1)' },
                        ticks: {
                            color: '#c7d5e0',
                            // Format Rupiah pada sumbu Y
                            callback: function(value, index, ticks) {
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
    }
</script>

</body>
</html>



