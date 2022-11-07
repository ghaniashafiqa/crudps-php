<?php
// Include koneksi file
require_once "config.php";

// Tentukan variabel dan inisialisasi dengan nilai kosong
$Nama = $NIK = $Telp = $Jabatan = $Gaji = "";
$Nama_err = $NIK_err = $Telp_err = $Jabatan_err = $Gaji_err = "";

// Memproses data formulir saat formulir dikirimkan
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate name
    $input_Nama = trim( $_POST["Nama"]); 
	if(empty($input_Nama)){
		$Nama_err = "Harap masukkan Nama."; 
	} elseif(!filter_var($input_Nama, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))) {
		$Nama_err = "Harap masukkan Nama yang valid."; 
	} else{
		$Nama = $input_Nama;
	}

    // Validate NIK
    $input_NIK = trim($_POST['NIK']);
    if (empty($input_NIK)) {
        $NIK_err = "Please enter your nik.";
    } elseif (!ctype_digit($input_NIK)) {
        $NIK_err = "Please enter a positive integer value.";
    } else {
        $NIK = $input_NIK;
    }

    // Validate Telp
    $input_Telp = trim($_POST['Telp']);
    if (empty($input_Telp)) {
        $Telp_err = "Please enter your phone number.";
    } elseif (!ctype_digit($input_Telp)) {
        $Telp_err = "Please enter a positive integer value.";
    } else {
        $Telp = $input_Telp;
    }

    // Validate Jabatan
    $input_Jabatan = trim($_POST['Jabatan']);
    if(empty($input_Jabatan)){
		$Jabatan_err = "Harap masukkan Jabatan."; 
	} elseif(!filter_var($input_Jabatan, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))) {
		$Jabatan_err = "Harap masukkan Jabatan yang valid."; 
	} else{
		$Jabatan = $input_Jabatan;
	}
    
    // Validate Gaji
    $input_Gaji = trim($_POST['Gaji']);
    if (empty($input_Gaji)) {
        $Gaji_err = "Please enter your Gaji score.";
    } elseif (!ctype_digit($input_Gaji)) {
        $Gaji_err = "Please enter a positive integer value.";
    } else {
        $Gaji = $input_Gaji;
    }
    // Check input errors before inserting in database
    if (empty($Nama_err) && empty($NIK_err) && empty($Telp_err) && empty($Jabatan_err) && empty($Gaji_err)) {
        // Prepare an insert statement
        $sql = "INSERT INTO payroll (Nama, NIK, Telp, Jabatan, Gaji) VALUES (?,?,?,?,?)";
        if ($stmt = mysqli_prepare($conn, $sql)) {
            // Bind variable to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sisss", $param_Nama, $param_NIK, $param_Telp, $param_Jabatan, $param_Gaji);
            // SEt parameters
            $param_Nama = $Nama;
            $param_NIK = $NIK;
            $param_Telp = $Telp;
            $param_Jabatan = $Jabatan;
            $param_Gaji = $Gaji;
            // Attempt to execute successfully. Redirect to landing page
            if (mysqli_stmt_execute($stmt)) {
                header("location: index.php");
                exit();
            } else {
                echo "Something went wrong. Please try again later.";
            }
        }
        // Close statement
        mysqli_stmt_close($stmt);
    }
    // Close connection
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project CRUD Payroll</title>

    <!-- css link -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

	<style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="" style="margin-top:26px;">
						<h2 style="font-family: 'Arial', cursive;" class="bg-dark text-light text-center py-2" style="margin-top:10px;">Tambah Data Pegawai</h2> 
					</div>
                    <p>Silahkan isi form dibawah ini kemudian submit untuk menambahkan data pegawai serta gaji ke dalam database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group <?php echo (!empty($Nama_err)) ? 'has-error' : '';?>">
                        <label>Nama</label>
                        <input type="text" name="Nama"" class="form-control" value="<?php echo $Nama; ?>">
                        <span class="help-block"><?php echo $Nama_err; ?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($NIK_err)) ? 'has-error' : '';?>">
                        <label>NIK</label>
                        <input type="number" name="NIK" class="form-control" value="<?php echo $NIK; ?>">
                        <span class="help-block"><?php echo $NIK_err; ?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($Telp_err)) ? 'has-error' : '';?>">
                        <label>No. Telp</label>
                        <input type="number" name="Telp" class="form-control" value="<?php echo $Telp; ?>">
                        <span class="help-block"><?php echo $Telp_err; ?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($Jabatan_err)) ? 'has-error' : '';?>">
                        <label>Jabatan</label>
                        <input type="text" name="Jabatan" class="form-control" value="<?php echo $Jabatan; ?>">
                        <span class="help-block"><?php echo $Jabatan_err; ?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($Gaji_err)) ? 'has-error' : '';?>">
                        <label>Gaji</label>
                        <input type="number" name="Gaji" class="form-control" value="<?php echo $Gaji; ?>">
                        <span class="help-block"><?php echo $Gaji_err; ?></span>
                    </div>
                    <input style="font-size: 15px; color: whitesmoke; background: #00ABB3; margin-left: 137px;  width: 100px;" type="submit" class="btn" value="Submit" name="proses">
                    <a style="background: #C9BBCF; width: 100px;" href="index.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>