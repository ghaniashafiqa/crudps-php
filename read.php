<?php
if(isset($_GET["NIK"]) && !empty(trim($_GET["NIK"]))){
	require_once 'config.php';
	// Prepare a select Statement
	$sql = "SELECT *, (Telp + Jabatan + Gaji)/3 AS Nilai_akhir from payroll WHERE NIK = ? ";

	if($stmt = mysqli_prepare($conn, $sql)){
		//Kumpulkan variable ke dalam prepared statement sebagai parameter
		mysqli_stmt_bind_param($stmt, "i", $param_NIK);
		// Mennyiapkan atau men set Parameter
		$param_NIK = trim($_GET["NIK"]);
		
		// Jalankan Pernyataan yang Disiapkan
		if(mysqli_stmt_execute($stmt)){
			$result = mysqli_stmt_get_result($stmt);
			if(mysqli_num_rows($result) == 1){
				/* Mengambil result row sebagai sebuah array asosiatif. 
                    Karena result set hanya mengandung 1 row, maka tidak
                    diperlukan menggunakan loop atau pengulangan while */
				$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
				// mengambil nilai individu
				$Nama = $row["Nama"];
				$NIK = $row["NIK"];
				$Telp = $row["Telp"];
				$Jabatan = $row["Jabatan"];
				$Gaji = $row["Gaji"];
			} else{
				header("location: error.php");
				exit();
			}
		} else {
			echo "oops! something went wrong. please try again later.";
		}
	}
	mysqli_stmt_close($stmt);
	mysqli_close($conn);
} else{
	echo 'nik harus diisi';
	exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>VIEW RECORD</title>
	<link rel='stylesheet' href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
		<style type="text/css">
			.wrapper{
				width: 950px;
				margin: auto;
			}
		</style>
	</head>
	<body>
		<div class="wrapper">
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-12">
						<div class="page-header">
							<h1>Informasi Gaji - <?php echo $row["Nama"]; ?></h1>
						</div>
						<div class="form-group">
							<label>Nama</label>
							<p class="form-control-static"><?php echo $row["Nama"]; ?></p>
						<div class="form-group">
							<label>NIK</label>
							<p class="form-control-static"><?php echo $row["NIK"]; ?></p>
						<div class="form-group">
							<label>No. Telp</label>
							<p class="form-control-static"><?php echo $row["Telp"]; ?></p>
						</div>
						<div class="form-group">
							<label>Jabatan</label>
							<p class="form-control-static"><?php echo $row["Jabatan"]; ?></p>
						<div class="form-group">
							<label>Gaji</label>
							<p class="form-control-static"><?php echo $row["Gaji"]; ?></p>
						</div>
						<p><a href="index.php"class="btn btn-primary">Back</a></p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</body>
</html>