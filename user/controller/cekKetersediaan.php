<?php
require "../../function.php";
if (!isset($_GET['tgl']) || !isset($_GET['id_lapangan'])) exit("Parameter kurang");

$tgl = $_GET['tgl'];
$id_lapangan = $_GET['id_lapangan'];
$hariKe = date('N', strtotime($tgl));
$mapHari = [1 => "Senin", 2 => "Selasa", 3 => "Rabu", 4 => "Kamis", 5 => "Jumat", 6 => "Sabtu", 7 => "Minggu"];
$hariText = $mapHari[$hariKe];
$jadwal = query("SELECT * FROM jadwal WHERE hari_buka='$hariText' LIMIT 1");
if (!$jadwal) {
    echo "<span class='text-danger'>Jadwal tidak ditemukan untuk hari $hariText.</span>";
    exit;
}
$jadwal = $jadwal[0];
$start = (int)substr($jadwal['jam_buka'], 0, 2);
$end = (int)substr($jadwal['jam_tutup'], 0, 2);

$booked = [];
$reservasi = query("SELECT jam_booking FROM reservasi WHERE tanggal_booking='$tgl' AND id_lapangan='$id_lapangan'");
foreach ($reservasi as $r) {
    $jam_array = explode(',', $r['jam_booking']);
    foreach ($jam_array as $jam) {
        $booked[] = (int)trim($jam);
    }
}

// Generate checkbox dalam grid 2 kolom (per baris 2)
echo '<div class="row">';
$col = 0;
for ($i = $start; $i <= $end; $i++) {
    if ($col == 0 && $i != $start) echo '<div class="w-100"></div>'; // Baris baru tiap 4 kolom
    $jamText = sprintf('%02d:00', $i);
    $isBooked = in_array($i, $booked);
    echo '<div class="col-3 mb-3">';
    echo '<div class="form-check">';
    echo '<input class="form-check-input" type="checkbox" value="' . $i . '" id="jam_' . $i . '" ' . ($isBooked ? 'disabled' : '') . '>';
    echo '<label class="form-check-label" for="jam_' . $i . '" style="'.($isBooked?'color:#ccc;':'').'">' . $jamText . ($isBooked ? ' <span class="badge bg-danger">Booked</span>' : '') . '</label>';
    echo '</div>';
    echo '</div>';
    $col++;
    if ($col >= 4) { $col = 0; }
}
echo '</div>';
?>

