<?php
require "../../function.php";

// Bagian validasi parameter dan query data (tidak ada perubahan)
// ... (kode dari awal sampai ksort) ...

if (!isset($_GET['tgl']) || !isset($_GET['id_lapangan'])) {
    exit("Parameter kurang");
}
$tgl = $_GET['tgl'];
$id_lapangan = $_GET['id_lapangan'];
// ... (sisa kode query sampai ksort) ...
$lapangan = query("SELECT harga_lapangan FROM lapangan WHERE id_lapangan = '$id_lapangan' LIMIT 1");
if (!$lapangan) {
    exit("Data lapangan tidak ditemukan.");
}
$harga_lapangan = $lapangan[0]['harga_lapangan'];

$hariKe = date('N', strtotime($tgl));
$mapHari = [1 => "Senin", 2 => "Selasa", 3 => "Rabu", 4 => "Kamis", 5 => "Jumat", 6 => "Sabtu", 7 => "Minggu"];
$hariText = $mapHari[$hariKe];
$jadwal = query("SELECT * FROM jadwal WHERE hari_buka='$hariText' LIMIT 1");
if (!$jadwal) {
    exit("Jadwal tidak ditemukan untuk hari $hariText.");
}
$jadwal = $jadwal[0];
$start = (int)substr($jadwal['jam_buka'], 0, 2);
$end = (int)substr($jadwal['jam_tutup'], 0, 2);

$booking_details = [];
$reservasi = query("SELECT jam_booking FROM reservasi WHERE tanggal_booking='$tgl' AND id_lapangan='$id_lapangan' AND status='lunas'");
foreach ($reservasi as $r) {
    $booking_ranges = explode(',', $r['jam_booking']);
    foreach ($booking_ranges as $range) {
        $parts = explode('-', trim($range));
        if (count($parts) == 2) {
            $start_hour = (int)$parts[0];
            $end_hour = (int)$parts[1];
            $booking_details[$start_hour] = $end_hour;
        }
    }
}
ksort($booking_details);
?>

<?php
?>
<style>
    .slot-card {
        border: 1px solid #dee2e6;
        background-color: #ffffff;
        transition: all 0.2s ease-in-out;
    }

    /* Mengubah selector dari radio ke checkbox */
    input[type="checkbox"]:checked+.slot-card {
        border-color: #dc3545;
        background-color: #f8d7da;
        color: #58151c;
        transform: scale(1.05);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    input[type="checkbox"]:checked+.slot-card .harga {
        color: #842029;
        font-weight: bold;
    }
</style>

<?php
// --- LOGIKA TAMPILAN (DISPLAY) ---
echo '<div class="row row-cols-2 row-cols-md-3">';

for ($i = $start; $i < $end;) {

    if (isset($booking_details[$i])) {

        $start_booking = $i;
        $end_booking = $booking_details[$i];
        $duration_minutes = ($end_booking - $start_booking) * 60;
        echo '<div class="col mb-3">';
        echo '  <div class="card h-100 text-center p-2 bg-light text-muted">';
        echo '    <div style="font-size: 0.8em;">' . $duration_minutes . ' Menit</div>';
        echo '    <div class="fs-6">' . sprintf('%02d:00 - %02d:00', $start_booking, $end_booking) . '</div>';
        echo '    <div>Booked</div>';
        echo '  </div>';
        echo '</div>';
        $i = $end_booking;
    } else {

        $jamText = sprintf('%02d:00 - %02d:00', $i, $i + 1);
        $valueJam = $i . '-' . ($i + 1);
        $hargaFormatted = 'Rp' . number_format($harga_lapangan, 0, ',', '.');

        echo '<div class="col mb-3">';


        echo '  <input class="form-check-input visually-hidden" type="checkbox" name="jam_booking[]" id="jam_' . $i . '" value="' . $valueJam . '">';

        echo '  <label class="card h-100 text-center p-2 slot-card" for="jam_' . $i . '" style="cursor:pointer;">';
        echo '    <div style="font-size: 0.8em; color: #6c757d;">60 Menit</div>';
        echo '    <div class="fw-bold fs-6">' . $jamText . '</div>';
        echo '    <div class="harga">' . $hargaFormatted . '</div>';
        echo '  </label>';
        echo '</div>';
        $i++;
    }
}
echo '</div>';
?> 
