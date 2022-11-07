<?php
// Include koneksi file
require_once "config.php";
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project CRUD Payroll</title>

    <!-- css link -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>
<body>
	<header>
    <div class="wrapper">
		<div class="container-fluid">
			<div class="row">
				<div class="col-12">
					<div class="" style="margin-top:26px;">
						<h2 style="font-family: 'Arial', cursive;" class="bg-dark text-light text-center py-2" style="margin-top:10px;">CRUD Pagination Search Payroll</h2> 
					</div> 
				</div>
			</div>
            <div class="row">
                <div class="col-12">
                    <form method="get">
                        <div class="input-group" style="margin: 14px 0px; padding:0px 10px;">
                            <input class="inpot" type="search" name="search" id="forml" placeholder="Search data here" class="form-control" />
                            <input style="border-radius:0px 10px 10px 0px;" type="submit" class="btn btn-primary" value="Search">
							<a href="create.php" class="btn btn-dark" style=";margin-left:1070px;"><b>Tambah Data</b></a>
                        </div>
                    </form>
                </div>
            </div>
		</div>
    </div>
    </header>
	<div class="wrapper">
		<div class="container-fluid"> 
			<div class="row"> 
				<div class="col-md-12"> 
					<?php
					$limit = 4;
                    $page = $_GET['page'] ?? null;
                    if(empty($page)){
                        $position = 0;
                        $page = 1;
                    } else{
                        $position = ($page-1) * $limit;
                    }
					
					if(isset($_GET['search'])){
						$search = $_GET['search'];
						$sql = "SELECT * FROM payroll WHERE Nama LIKE '%$search%' ORDER BY NIK DESC LIMIT $position, $limit";
					} else{
						$sql = "SELECT * FROM payroll ORDER BY NIK DESC LIMIT $position, $limit";
					}

					
					$i = 1;
					$result = mysqli_query($conn, $sql);
						if (mysqli_num_rows($result) > 0){ 
							echo "<table class='table table-bordered table-striped  table-hover'>"; 
								echo "<thead>"; 
									echo "<tr>";
										echo "<th class='text-center'>No</th>";
										echo "<th class='text-center'>NIK</th>";
										echo "<th class='text-center'>Nama</th>"; 
										echo "<th class='text-center'>Telp</th>"; 
										echo "<th class='text-center'>Jabatan</th>";
										echo "<th class='text-center'>Gaji</th>"; 
										echo "<th class='text-center'>Action</th>"; 
									echo "</tr>"; 
								echo "</thead>"; 
								echo "<tbody>";
								while ($row = mysqli_fetch_array($result)){
									echo "<tr>";
										echo "<td class='text-center'>" . $i++ . "</td>";
										echo "<td class='text-center'>" . $row['NIK'] . "</td>"; 
										echo "<td class='text-center'>" . $row['Nama'] . "</td>"; 
										echo "<td class='text-center'>" . $row['Telp'] . "</td>"; 
										echo "<td class='text-center'>" . $row['Jabatan'] . "</td>";
										echo "<td class='text-center'>" . $row['Gaji'] . "</td>"; 
										echo "<td class='text-center'>";
											echo "<a style='padding-right: 5px;' href='read.php?NIK=". $row['NIK'] ."' tittle='View Record' ><span><i class='fas fa-eye text-success' style='font-size:18px;'></i></span></a>";
											echo "<a style='padding-right: 5px;' href='update.php?id=". $row['NIK'] ."' title='Update Record' ><span><i class='fas fa-edit text-info' style='font-size:18px;'></i></span></a>"; 
											echo "<a style='padding-right: 5px;' href='delete.php?NIK=". $row['NIK'] ."' title='Delete Record'><span><i class='fas fa-trash-alt text-danger' style='font-size:18px;'></i></span></a>"; 
										echo "</td>"; 
									echo "</tr>";
								}
								echo "</tbody>"; 
							echo "</table>"; 
							// Free result set
							mysqli_free_result($result); 
						} else{
							echo "<table class='table table-bordered table-striped table-hover' style='background-color:white'>";
								echo "<thead>";
										echo "<tr>";
											echo "<th>NIK</th>";
											echo "<th>Nama</th>";
											echo "<th>No. Telp</th>";
											echo "<th>Jabatan</th>";
											echo "<th>Gaji</th>";
											echo "<th>Action</th>";
										echo "</tr>";
									echo "</thead>";
									echo "<tbody>";
										echo "<tr>";
											echo "<td td class='text-center' colspan='6'>Oops! Data Not Found.</td>";
										echo "</tr>";
										echo "</tbody>";
								echo "</table>";
						}
						if(isset($_GET['search'])){
							$search = $_GET['search'];
							$query2 = "SELECT * FROM payroll WHERE Nama LIKE '%$search%' ORDER BY NIK DESC";
						} else{
							$query2= "SELECT * FROM payroll ORDER BY NIK DESC";
						}
						$result2 = mysqli_query($conn, $query2);
						$jmlhdata = mysqli_num_rows($result2);
						$jmlhalaman = ceil($jmlhdata/$limit);
					// Close connection
					mysqli_close($conn);
				?> 
				<!-- <br> -->
					<ul class="pagination">
						<?php
							for ($i=1;$i<=$jmlhalaman;$i++) {
								if ($i != $page) {
									if (isset($_GET['search'])) {
										$search = $_GET['search'];
										echo "<li class='page-item'><a class='page-link' href='index.php?page=$i&search=$search'>$i</a></li>";
									} else {
										echo "<li class='page-item'><a class='page-link' href='index.php?page=$i' style='color: black;'>$i</a></li>";
									}
								} else {
									echo "<li class'page-item'><a class='page-link' href='#' style='color: black;'>$i</a></li>";
								}
							}
						?>
					</ul>
				</div>
			</div>
		</div>
	</div>
</body>
</html>