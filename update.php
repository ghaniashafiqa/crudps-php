<?php
// untu memanggil file config
require_once "config.php";

// menentukan variable dan inisialisasi dengan nilai kosong

$Nama = $NIK = $Telp = $Jabatan = $Gaji = "";
$Nama_err = $NIK_err = $Telp_err = $Jabatan_err = $Gaji_err ="";

// memproses data formulir saat formulir dikirimkan
if(isset($_POST["NIK"]) && !empty($_POST["NIK"])){
    // mendapatkan nilai input tersembunyi
    $NIK = $_POST["NIK"];

    // Validate name
    $input_Nama = trim($_POST["Nama"]);
    if(empty($input_Nama)){
        $Nama_err = "Please enter a name.";
    } elseif(!filter_var($input_Nama, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $Nama_err = "Please enter a valid name.";
    } else{
        $Nama = $input_Nama;
    }

    // validasi nik
    $input_NIK = trim($_POST["NIK"]);
    if(empty($input_NIK)){
        $NIK_err = "Please enter your nik.";
    } else{
        $NIK = $input_NIK;
    }

    // validasi Telp
    $input_Telp = trim($_POST["Telp"]);
    if(empty($input_Telp)){
        $Telp_err = "Please enter your phone number.";
    } elseif(!ctype_digit($input_Telp)){
        $Telp_err = "Please enter a positive integer value.";
    } else{
        $Telp = $input_Telp;
    }
    
    // validasi Jabatan
    $input_Jabatan = trim($_POST["Jabatan"]);
    if(empty($input_Jabatan)){
		$Jabatan_err = "Harap masukkan Jabatan."; 
	} elseif(!filter_var($input_Jabatan, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))) {
		$Jabatan_err = "Harap masukkan Jabatan yang valid."; 
	} else{
		$Jabatan = $input_Jabatan;
	}

    // validasi Gaji
    $input_Gaji = trim($_POST["Gaji"]);
    if(empty($input_Gaji)){
        $Gaji_err = "Please enter nilai Gaji.";
    } elseif(!ctype_digit($input_Gaji)){
        $Gaji_err = "Please enter a positive integer value.";
    } else{
        $Gaji = $input_Gaji;
    }

    // periksa kesalahan input sebelum memasukkan dalam database
    if(empty($Nama_err) && empty($NIK_err) && empty($Telp_err) && empty($Jabatan_err) && empty($Gaji_err)){
        // menyiapkan pernyataan insert
        $sql = "UPDATE payroll SET Nama=?, Telp=?, Jabatan=?, Gaji=? WHERE NIK=?";
        if($stmt = mysqli_prepare($conn, $sql)){
            // mengikat variabel ke pernyataam yang disiapkan sebagai parameter
            mysqli_stmt_bind_param($stmt, "sisii", $param_Nama, $param_Telp, $param_Jabatan, $param_Gaji, $param_NIK);
            // Set paramaters
            $param_Nama = $Nama;
            $param_Telp = $Telp;
            $param_Jabatan = $Jabatan;
            $param_Gaji = $Gaji;
            $param_NIK = $NIK;
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // jika data berhasil ke update maka akan mendirect ke halaman index
                header("location: index.php");
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Close connection
    mysqli_close($conn);

} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $NIK = trim($_GET["id"]);

        // Prepare a select statement
        $sql = "SELECT * FROM payroll WHERE NIK = ?";
        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parametes
            mysqli_stmt_bind_param($stmt, "i", $param_NIK);

            // Set parameters
            $param_NIK = $NIK;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);

                if(mysqli_num_rows($result) == 1){
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

                    // Retrieve individual field value
                    $Nama = $row["Nama"];
                    $NIK = $row["NIK"];
                    $Telp = $row["Telp"];
                    $Jabatan = $row["Jabatan"];
                    $Gaji = $row["Gaji"];
                } else{
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    exit();
                }

            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);

        // Close connection
        mysqli_close($conn);
    } else{
        // URL doesn't contain id parameter. Redirect to erro page
        header("location: error.php");
        exit();
    }
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
						<h2 style="font-family: 'Arial', cursive;" class="bg-dark text-light text-center py-2" style="margin-top:10px;">Edit Data Pegawai</h2> 
					</div>
                    <p>Silahkan edit form dibawah ini kemudian submit untuk mengubah data pegawai serta gaji yang sudah ada pada database.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group <?php echo (!empty($Nama_err)) ? 'has-error' : ''; ?>">
                            <label>Nama</label>
                            <input type="text" name="Nama" class="form-control" value="<?php echo $Nama; ?>">                          
                            <span class="help-block"><?php echo $Nama_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($NIK_err)) ? 'has-error' : ''; ?>">
                            <label>NIK</label>
                            <input type="number" name="NIK" class="form-control" value="<?php echo $NIK; ?>">                          
                            <span class="help-block"><?php echo $NIK_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($Telp_err)) ? 'has-error' : ''; ?>">
                            <label>Telp</label>
                            <input type="number" name="Telp" class="form-control" value="<?php echo $Telp; ?>">
                            <span class="help-block"><?php echo $Telp_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($Jabatan_err)) ? 'has-error' : ''; ?>">
                            <label>Jabatan</label>
                            <input type="text" name="Jabatan" class="form-control" value="<?php echo $Jabatan; ?>">
                            <span class="help-block"><?php echo $Jabatan_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($Gaji_err)) ? 'has-error' : ''; ?>">
                            <label>Gaji</label>
                            <input type="number" name="Gaji" class="form-control" value="<?php echo $Gaji; ?>">                         
                            <span class="help-block"><?php echo $Gaji_err;?></span>
                        </div>
                        <input type="hidden" name="NIK" value="<?php echo $NIK; ?>"/>
                        <input type="submit" class="btn" style="margin-left:160px; background-color: #3D8361; color:whitesmoke;" value="Submit">
                        <a href="index.php" class="btn" style="background-color: #FF9551; color:black;" >Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>