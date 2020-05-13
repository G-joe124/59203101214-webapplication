<?php
	//including file connection
    include "dbconnect.php"; //return connection $conn
	//include "menu.php"; //including menu

    if(isset($_POST['insdriver'])){ //in case of insertion
        // $drvid	=$_POST['drvid'];
        $fnme	= $_POST['fnme'];
		$lnme	= $_POST['lnme'];
		$gender	= $_POST['gender'];	
		$tel 	=$_POST['tel'];
		$licenNo 	=$_POST['licenNo'];
		$email 	=$_POST['email'];
		//$pwd 	=$_POST['pwd'];

		$regisdte = date('Y-m-d'); //$_POST['rigisdte']; //new Date();

		//$passwd	= "123456";	//set default password, instead of getting from the register form //$_POST['passwd'];
		//auto-generated email instead of fixing as above, however this password must be sent to the user via the email given, see sending mail in insertPatient
		
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$passwd = substr(str_shuffle( $chars ), 0, 8 ); //8 คือความยาวของพาสเวิร์ด str_shuffle คือ ฟังก์ชันในการซุ่มสลับค่าอักขระใน chars แล้วตัดมา 8 อักขระ

		$enpwd = hash('sha256', $passwd);

		if($email==""){ //check empty email          		
			echo "<script>
				  alert('Invalid email: empty !');
				  window.history.back();
				  </script>";	
			return;			
	 	}
		//check repeated email
		$sql = "Select * From driver Where email='$email'";
		$rs = mysqli_query($conn,$sql);
		if($rs->num_rows>0){ //meaning repeated email          		
              echo "<script>
					alert('Repeated email address!');
					window.history.back();
					</script>";				
		}else{//not repeated, can insert 

			//the order of such field must be matched the order of each field in the database
			$sql = "INSERT INTO driver (fnme, lnme, gender, tel, licenNo, email, pwd, regisdte) VALUES ('$fnme','$lnme','$gender','$tel','$licenNo','$email','$enpwd','$regisdte')";
			
			$rs = mysqli_query($conn,$sql); //รันคำสั่ง sql เก็บผลลัพธ์ใน $rs
			
			if($rs){ //กรณีสามารถรัน sql ผ่าน //หรือ if(mysqli_query($conn,$sql)) //meaning no error 
				//add sending confirmation email to the patient via the email given
				//จำเป็นต้อง download และติดตั้งโฟลเดอร์ PHPMailer ในโฟล์เดอร์เดียวกับไฟล์ operations.php นี้
				//และผู้พัฒนาหรือหน่วยงานจะต้องมี gmail ไว้สำหรับรับส่งเมล์ (แนะนำลงทะเบียนใหม่)
			
				///BEGIN send mail ****************************************************************
				require_once('PHPMailer/PHPMailerAutoload.php');
				$mail = new PHPMailer(); //สร้างอ็อบเจกต์สำหรับรับส่งเมล์
				$mail->IsHTML(true);	//กำหนดการส่งในรูปแบบไฟล์ HTML เป็นจริง
				$mail->IsSMTP();	//Protocal ที่ใช้ในการรับ-เมล์
				$mail->SMTPAuth = true; // enable SMTP authentication
				$mail->SMTPSecure = ""; // sets the prefix to the servier
				$mail->Host = "ssl://smtp.gmail.com"; // sets GMAIL as the SMTP server
				$mail->Port = 465; // set the SMTP port for the GMAIL server
				$mail->Username = "blupsu@gmail.com"; // GMAIL username, อีเมล์นี้ใช้เป็นต้นทางในการส่งผ่าน gmail ควรลงทะเบียนใหม่ และใช้พาสเวิร์ดเฉพาะ
				$mail->Password = "bluepsu2020"; // GMAIL password
				//$mail->From = "healthcare.register@gmail.com"; // "name@yourdomain.com"; อีเมล์นี้จะแสดงในช่อง from
				//$mail->AddReplyTo = "healthcare.register@gmail.com"; // Reply ที่อยู่เมล์ที่จะส่งกลับหาก ฝั่งรับต้องการตอบกลับ

				$mail->FromName = "PSU BLUE-TS System";  // set from Name
				$mail->Subject = "BLUE-TS: Registration Confirm"; //email subject
				
				//formulate the body of email สร้างข้อความที่จะส่งไปกับอีเมล์ ในที่นี้คือ ต้องการส่ง username กับ password ที่ถูก generated
				//ไปให้กับ patient ผ่านทางอีเมล์ของผู้ป่วยที่ระบุ โดยผู้รับเมล์จะต้องคลิกลิงค์ที่ส่งไปด้วยเพื่อดำเนินการ activate 
				//อย่างไรก็ตามข้อจำกัดของระบบนี้ อยู่บนสมมติฐานที่ว่าการลงทะเบียน บังคับว่าจะต้องมี email ซึ่งในทางปฏิบัติเป็นไปไม่ได้ทั้งหมดกับระบบงานโรงพยาบาล
				//แต่ใช้งานได้ดีกับระบบอื่นที่ มีเงื่อนไขว่าสมาชิกที่จะลงทะเบียนได้ต้องมีอีเมล์ เช่น facebook หรือ webapp อื่น ๆ

				$mail->Body = "Dear $fnme $lnme
				
							<br>You have successfully registered for the healthcare system <br>
							    Your Driver ID is $drvid . Your username and password are below
							   
							<br><br>username: $email
							<br><br>password: $passwd<br><br>
							
							<b>*** This is an automatically generated email. please do not reply. *** <br><br></b>
						
							<b>If you have any inquiry, please contact.</b> <br>
							Email : monsor.meesa@gmail.com <br>
							Phone : +66 73-313928-50 Ext. 1890 / +66 73-312179 <br>
							Fax : +66 073-312179 <br><br>
						
							<b>More information</b> <br>
							Website : https://sites.google.com/site/webprogroom <br>
							Facebook : https://www.facebook.com/kdamchoom<br>";
				
				
				$mail->AddAddress($email); // to email address
				// $mail->AddAddress("monsor.meesa@gmail.com"); 
				//$mail->AddBCC("kriangsak.d@psu.ac.th"); //add Bcc email, if required
				
				if($mail->Send()) //call the method to send this mail
				{
					//the script shown after sending mail completed
					echo 
						"<script>".
							"window.alert('You have successfully registered, please check your email box. ');".
						"</script>"; 
				}else{
					//delete the previous inserted rec if cannot send email
					$sql = "DELETE FROM driver WHERE drvid = '$drvid'";
					$conn->query($sql);
					//show message: invalid email 
					"<script>".
							"window.alert('NOT successfully registered, invalid email address.');".
					"</script>"; 
				}
				///END send mail ***************************************************************
			
			}else{ //กรณีลงทะเลียนไม่สำหรับ รัน sql ไม่ผ่าน
				
				echo "<script> alert('Insertion errors, ".$conn->error."');</script>";
			}
		}
	}//end insertion
	
	else if(isset($_POST['delDriver'])){ // (2) in case of deleting
		$drvid = $_POST['drvid']; //get patient ID from the previous form
		$sql = "DELETE FROM driver
				WHERE drvid = '$drvid'";
		
		if($conn->query($sql)==TRUE){
			echo "<script>alert('Driver ID = ".$drvid." is deleted successfully.'); window.location.href='showDriver.php';</script>";
       } else{
            //echo "Deleting Error".$conn->error;
			echo "<script>alert('Deleting Error:".$conn->error."');</script>";
        }	
    }//end delete
	else if(isset($_POST['updateDriver'])){ //in case of update
		$drvid	=$_POST['drvid'];
		$fnme	= $_POST['fnme'];
		$lnme	= $_POST['lnme'];
		$gender	= $_POST['gender'];	
		$tel 	=$_POST['tel'];
		$licenNo 	=$_POST['licenNo'];
		$email 	=$_POST['email'];
		$regisdte = $_POST['regisdte'];
		$sql = "UPDATE driver SET 
					fnme = '$fnme', 
					lnme = '$lnme',
					gender = '$gender',
					tel ='$tel', 
					licenNo = '$licenNo',
					email ='$email',
					regisdte = '$regisdte'
				WHERE drvid='$drvid'";
		if ($conn->query($sql) === TRUE) {
			//"Record updated successfully" and redirect to the menu
			session_start();//start session
			$id = $_SESSION['valid_id'];	
			$utype = $_SESSION['valid_utype'];
			echo "<script>
							alert('Updated successful');
							window.location.href='showDriver.php';
				  </script>";
			// if($utype==1) //staff/admin
			// 	echo "<script>
			// 				alert('Updated successful JA');
			// 				window.location.href='showPatients.php';
			// 		</script>";
			// else if($utype==3) //if patient
			// 	echo "<script>
			// 			alert('Updated successful JA');
			// 			window.location.href='menu.php';
			// 		</script>";
		} else {
			echo "Error updating record: " . $conn->error;
		}
			
	}
	// 	if(basename($_FILES["fileToUpload"]["name"])!=""){ //check loading image wheater it loaded or not
	// 		//uploading patient's image
	// 		$target_dir = "images/";
	// 		$target_file = $target_dir ."pt".$ptid."-".basename($_FILES["fileToUpload"]["name"]);
	// 		//$target_file = $target_dir ."pt".$ptid;
	// 		$uploadOk = 1;
	// 		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	// 		// Check if image file is a actual image or fake image
	// 		if(isset($_POST["submit"])) {
	// 			$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
	// 			if($check !== false) {
	// 				echo "File is an image - " . $check["mime"] . ".";
	// 				$uploadOk = 1;
	// 			} else {
	// 				echo "File is not an image.";
	// 				$uploadOk = 0;
	// 			}
	// 		}
	// 		// Allow certain file formats
	// 		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
	// 		&& $imageFileType != "gif" ) {
	// 			echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
	// 			$uploadOk = 0;
	// 		}
	// 		// Check if $uploadOk is set to 0 by an error
	// 		if ($uploadOk == 0) {
	// 			echo "Sorry, your file was not uploaded.";
	// 		// if everything is ok, try to upload file
	// 		} else { //update with updating image
	// 			if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
	// 				echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
	// 				$pic = $target_file;//
	// 				$sql = "UPDATE patients SET 
	// 						ptnme = '$fname', 
	// 						ptsnme = '$lname',
	// 						tel ='$tel', 
	// 						email ='$email', 
	// 						pid = '$pid',
	// 						addr = '$addr', 
	// 						dob = '$dob', 
	// 						gender = '$gender', 
	// 						bldgrp = '$bldgrp', 
	// 						natid = '$natid', 
	// 						pic = '$pic' 
	// 					WHERE ptid='$ptid'";
	// 			} else {
	// 				echo "Sorry, there was an error uploading your file.";
	// 			}
	// 		}
	// 	}else{ //incase of updating normally without updating pic
	// 		$sql = "UPDATE patients SET 
	// 				ptnme = '$fname', 
	// 				ptsnme = '$lname',
	// 				tel ='$tel', 
	// 				email ='$email', 
	// 				pid = '$pid',
	// 				addr = '$addr', 
	// 				dob = '$dob', 
	// 				gender = '$gender', 
	// 				bldgrp = '$bldgrp', 
	// 				natid = '$natid'
	// 			WHERE ptid='$ptid'";
	// 	}	
		// if ($conn->query($sql) === TRUE) {
		// 	//"Record updated successfully" and redirect to the menu
		// 	session_start();//start session
		// 	$id = $_SESSION['valid_id'];	
		// 	$utype = $_SESSION['valid_utype'];
		// 	if($utype==1) //staff/admin
		// 		echo "<script>
		// 					alert('Updated successful JA');
		// 					window.location.href='showPatients.php';
		// 			</script>";
		// 	else if($utype==3) //if patient
		// 		echo "<script>
		// 				alert('Updated successful JA');
		// 				window.location.href='menu.php';
		// 			</script>";
		// } else {
		// 	echo "Error updating record: " . $conn->error;
		// }
	// }

	if(isset($_POST['insBus'])){ //in case of insertion
		// $drvid	=$_POST['drvid'];
		$strbusstopno	= $_POST['strbusstopno'];
		$endbusstopno	= $_POST['endbusstopno'];
		$start_use	= $_POST['start_use'];	
		$end_use 	=$_POST['end_use'];
		$statuss 	=$_POST['statuss'];
		$seats 	=$_POST['seats'];
		$detail 	=$_POST['detail'];

			//the order of such field must be matched the order of each field in the database
			$sql = "INSERT INTO bus (strbusstopno, endbusstopno, start_use, end_use, statuss, seats, detail) 
			VALUES ('$strbusstopno','$endbusstopno','$start_use','$end_use','$statuss','$seats','$detail')";
			
			$rs = mysqli_query($conn,$sql); //รันคำสั่ง sql เก็บผลลัพธ์ใน $rs
			
			if($rs){ 
				echo 
				"<script>
					alert('Insert Bus  have successfully.');
					window.location.href='showBus.php';
				</script>"; 
			}else{ //กรณีลงทะเลียนไม่สำหรับ รัน sql ไม่ผ่าน
				
				echo "<script> alert('Insert Bus  errors NOT successfully, ".$conn->error."');</script>";
			}
	}//end insertion
	else if(isset($_POST['delฺฺBus'])){ // (2) in case of deleting
		$busno = $_POST['busno']; //get patient ID from the previous form
		$sql = "DELETE FROM bus
				WHERE busno = '$busno'";
		
		if($conn->query($sql)==TRUE){
			echo "<script>alert('Driver ID = ".$busno." is deleted successfully.'); window.location.href='showDriver.php';</script>";
       } else{
            //echo "Deleting Error".$conn->error;
			echo "<script>alert('Deleting Error:".$conn->error."');</script>";
        }	
	}//end delete
	else if(isset($_POST['updateBus'])){ //in case of update
		$busno	=$_POST['busno'];
		$strbusstopno	= $_POST['strbusstopno'];
		$endbusstopno	= $_POST['endbusstopno'];
		$start_use	= $_POST['start_use'];	
		$end_use 	=$_POST['end_use'];
		$statuss 	=$_POST['statuss'];
		$seats 	=$_POST['seats'];
		$detail 	=$_POST['detail'];
		$sql = "UPDATE bus SET 
					strbusstopno = '$strbusstopno', 
					endbusstopno = '$endbusstopno',
					start_use = '$start_use',
					end_use = '$end_use',
					statuss ='$statuss',
					seats ='$seats',
					detail = '$detail'
				WHERE busno='$busno'";
		if ($conn->query($sql) === TRUE) {
			//"Record updated successfully" and redirect to the menu
			session_start();//start session
			$id = $_SESSION['valid_id'];	
			$utype = $_SESSION['valid_utype'];
			echo "<script>
							alert('Updated successful');
							window.location.href='showBus.php';
				  </script>";
			// if($utype==1) //staff/admin
			// 	echo "<script>
			// 				alert('Updated successful JA');
			// 				window.location.href='showPatients.php';
			// 		</script>";
			// else if($utype==3) //if patient
			// 	echo "<script>
			// 			alert('Updated successful JA');
			// 			window.location.href='menu.php';
			// 		</script>";
		} else {
			echo "Error updating record: " . $conn->error;
		}
	}

	if(isset($_POST['insbusstop'])){ //in case of insertion
		// $drvid	=$_POST['drvid'];
		$bus_stopnme	= $_POST['bus_stopnme'];
		$lat	= $_POST['lat'];
		$lng	= $_POST['lng'];	
		$detail 	=$_POST['detail'];
	
		//the order of such field must be matched the order of each field in the database
		$sql = "INSERT INTO bus_stop (bus_stopnme, lat, lng, detail) VALUES ('$bus_stopnme','$lat','$lng','$detail')";
				
		$rs = mysqli_query($conn,$sql); //รันคำสั่ง sql เก็บผลลัพธ์ใน $rs
				
		if($rs){ 
			echo 
				"<script>
					alert('Insert Bus Stop have successfully.');
					window.location.href='showBusStop.php';
				</script>"; 
		}else{ //กรณีลงทะเลียนไม่สำหรับ รัน sql ไม่ผ่าน
					
			echo "<script> alert('Insert Bus Stop errors NOT successfully, ".$conn->error."');</script>";
		}
	}//end insertion
	else if(isset($_POST['delBusStop'])){ // (2) in case of deleting
		$bus_stopno = $_POST['bus_stopno']; //get patient ID from the previous form
		$sql = "DELETE FROM bus_stop
				WHERE bus_stopno = '$bus_stopno'";
		
		if($conn->query($sql)==TRUE){
			echo "<script>alert('bus stop ID = ".$bus_stopno." is deleted successfully.'); window.location.href='showBusStop.php';</script>";
       } else{
            //echo "Deleting Error".$conn->error;
			echo "<script>alert('Deleting Error:".$conn->error."');</script>";
        }	
    }//end delete
	else if(isset($_POST['updateBusStop'])){ //in case of update
		$bus_stopno	= $_POST['bus_stopno'];
		$bus_stopnme	= $_POST['bus_stopnme'];
		$lat	= $_POST['lat'];
		$lng	= $_POST['lng'];	
		$detail 	=$_POST['detail'];
		$sql = "UPDATE bus_stop SET 
					bus_stopnme = '$bus_stopnme', 
					lat = '$lat',
					lng = '$lng',
					detail ='$detail' 
				WHERE bus_stopno ='$bus_stopno'";
		if ($conn->query($sql) === TRUE) {
			//"Record updated successfully" and redirect to the menu
			session_start();//start session
			$id = $_SESSION['valid_id'];	
			$utype = $_SESSION['valid_utype'];
			echo "<script>
							alert('Updated successful');
							window.location.href='showBusStop.php';
				  </script>";
			// if($utype==1) //staff/admin
			// 	echo "<script>
			// 				alert('Updated successful JA');
			// 				window.location.href='showPatients.php';
			// 		</script>";
			// else if($utype==3) //if patient
			// 	echo "<script>
			// 			alert('Updated successful JA');
			// 			window.location.href='menu.php';
			// 		</script>";
		} else {
			echo "Error updating record: " . $conn->error;
		}
	}

	if(isset($_POST['insbusdrvsschedule'])){ //in case of insertion
        // $drvid	=$_POST['drvid'];
        $dte	= $_POST['dte'];
		$busno	= $_POST['busno'];
		$kha	= $_POST['kha'];	
		$khatime 	=$_POST['khatime'];
		$drvid 	=$_POST['drvid'];
		$statuss 	=$_POST['statuss'];

			//the order of such field must be matched the order of each field in the database
			$sql = "INSERT INTO busdrvsschedule (dte, busno, kha, khatime, drvid, statuss) VALUES ('$dte','$busno','$kha','$khatime','$drvid','$statuss')";
			
			$rs = mysqli_query($conn,$sql); //รันคำสั่ง sql เก็บผลลัพธ์ใน $rs
			
			if($rs){ 
				echo 
					// "<script>".
					// 	"window.alert('Insert Bus Driver Schedule have successfully. ');".
					// "</script>"; 
					"<script>
						alert('Insert Bus Driver Schedule have successfully');
						window.location.href='showBusdrvsschedule.php';
		 			 </script>";
				
			}else{ //กรณีลงทะเลียนไม่สำหรับ รัน sql ไม่ผ่าน
				
				echo "<script> alert('Insert Bus Driver Schedule errors NOT successfully, ".$conn->error."');</script>";
		}
	}//end insertion
	else if(isset($_POST['delbusdrvsschedule'])){ // (2) in case of deleting
		$dte = $_POST['dte']; //get patient ID from the previous form
		$busno	= $_POST['busno'];
		$kha	= $_POST['kha'];	
		$sql = "DELETE FROM busdrvsschedule
				WHERE dte = '$dte' AND busno = '$busno' AND kha = '$kha'";
		
		if($conn->query($sql)==TRUE){
			echo "<script>alert('Deleted successfully.'); window.location.href='showBusdrvsschedule.php';</script>";
       } else{
            //echo "Deleting Error".$conn->error;
			echo "<script>alert('Deleting Error:".$conn->error."');</script>";
        }	
	}//end delete
	else if(isset($_POST['updatebusdrvsschedule'])){ //in case of update
		$dte	= $_POST['dte'];
		$busno	= $_POST['busno'];
		$kha	= $_POST['kha'];	
		$khatime 	=$_POST['khatime'];
		$drvid 	=$_POST['drvid'];
		$statuss 	=$_POST['statuss'];
		$sql = "UPDATE busdrvsschedule SET 
					khatime = '$khatime', 
					drvid = '$drvid',
					statuss ='$statuss'
				WHERE dte ='$dte' AND busno='$busno' AND kha ='$kha'";
		if ($conn->query($sql) === TRUE) {
			//"Record updated successfully" and redirect to the menu
			session_start();//start session
			$id = $_SESSION['valid_id'];	
			$utype = $_SESSION['valid_utype'];
			echo "<script>
							alert('Updated successful');
							window.location.href='showBusdrvsschedule.php';
				  </script>";
			// if($utype==1) //staff/admin
			// 	echo "<script>
			// 				alert('Updated successful JA');
			// 				window.location.href='showPatients.php';
			// 		</script>";
			// else if($utype==3) //if patient
			// 	echo "<script>
			// 			alert('Updated successful JA');
			// 			window.location.href='menu.php';
			// 		</script>";
		} else {
			echo "Error updating record: " . $conn->error;
		}
	}

	if(isset($_POST['delbusRoute'])){ // (2) in case of deleting
		$busno	= $_POST['busno'];
		$orders	= $_POST['orders'];
		$bus_stopno	= $_POST['bus_stopno'];	
		$sql = "DELETE FROM busroute
				WHERE busno = '$busno' AND orders = '$orders' AND bus_stopno = '$bus_stopno'";
		
		if($conn->query($sql)==TRUE){
			echo "<script>
				alert('Deleting successful');
				window.location.href='showBusRoute.php';
  			</script>";
       } else{
            //echo "Deleting Error".$conn->error;
			echo "<script>alert('Deleting Error:".$conn->error."');</script>";
        }	
	}//end delete
	else if(isset($_POST['updatebusRoute'])){ //in case of update
		// $dte	= $_POST['dte'];
		// $busno	= $_POST['busno'];
		// $kha	= $_POST['kha'];	
		$busno	= $_POST['busno'];
		$orders	= $_POST['orders'];
		$bus_stopno	= $_POST['bus_stopno'];	
		$timestp	= $_POST['timestp'];	
		$sql = "UPDATE busroute SET 
					-- order = '$order', 
					-- bus_stopno = '$bus_stopno',
					timestp = '$timestp'
				WHERE busno = '$busno' AND orders = '$orders' AND bus_stopno = '$bus_stopno'";
		if ($conn->query($sql) === TRUE) {
			//"Record updated successfully" and redirect to the menu
			session_start();//start session
			$id = $_SESSION['valid_id'];	
			$utype = $_SESSION['valid_utype'];
			echo "<script>
							alert('Updated successful');
							window.location.href='showBusRoute.php';
				  </script>";
			// if($utype==1) //staff/admin
			// 	echo "<script>
			// 				alert('Updated successful JA');
			// 				window.location.href='showPatients.php';
			// 		</script>";
			// else if($utype==3) //if patient
			// 	echo "<script>
			// 			alert('Updated successful JA');
			// 			window.location.href='menu.php';
			// 		</script>";
		} else {
			echo "Error updating record: " . $conn->error;
		}
	}

	if(isset($_POST['delDayuse'])){ // (2) in case of deleting
		$busno	= $_POST['busno'];
		$drvid	= $_POST['drvid'];
		$dte	= $_POST['dte'];
		$sql = "DELETE FROM dayuse
				WHERE busno = '$busno' AND drvid = '$drvid' AND dte = '$dte'";
		
		if($conn->query($sql)==TRUE){
			echo "<script>
				alert('Deleting successful');
				window.location.href='showDayUse.php';
  			</script>";
       } else{
            //echo "Deleting Error".$conn->error;
			echo "<script>alert('Deleting Error:".$conn->error."');</script>";
        }	
	}//end delete
	else if(isset($_POST['updateDayuse'])){ //in case of update
		// $dte	= $_POST['dte'];
		// $busno	= $_POST['busno'];
		// $kha	= $_POST['kha'];	
		$busno	= $_POST['busno'];
		$drvid	= $_POST['drvid'];
		$dte = $_POST['dte'];
		$amount = $_POST['amount'];
		$sql = "UPDATE dayuse SET 
					-- order = '$order', 
					-- bus_stopno = '$bus_stopno',
					amount = '$amount'
					WHERE busno = '$busno' AND drvid = '$drvid' AND dte = '$dte'";
		if ($conn->query($sql) === TRUE) {
			//"Record updated successfully" and redirect to the menu
			session_start();//start session
			$id = $_SESSION['valid_id'];	
			$utype = $_SESSION['valid_utype'];
			echo "<script>
				alert('Update successful');
				window.location.href='showDayUse.php';
  			</script>";
		} else {
			echo "Error updating record: " . $conn->error;
		}
	}

	if(isset($_POST['delBusUse'])){ // (2) in case of deleting
		$busno	= $_POST['busno'];
		$drvid	= $_POST['drvid'];
		$dte	= $_POST['dte'];
		$timestr	= $_POST['timestr'];
		$sql = "DELETE FROM bususe
				WHERE busno = '$busno' AND drvid = '$drvid' AND dte = '$dte' AND timestr = '$timestr'";
		if($conn->query($sql)==TRUE){
			echo "<script>
				alert('Deleting successful');
				window.location.href='showBusUse.php';
  			</script>";
       } else{
			echo "<script>alert('Deleting Error:".$conn->error."');</script>";
        }	
	}//end delete
	else if(isset($_POST['updateBusUse'])){ //in case of update
		$busno	= $_POST['busno'];
		$drvid	= $_POST['drvid'];
		$dte	= $_POST['dte'];
		$timestr	= $_POST['timestr'];
		$timestp = $_POST['timestp'];
		$note = $_POST['note'];
		$sql = "UPDATE bususe SET 
				timestp = '$timestp',
				note = '$note'
				WHERE busno = '$busno' AND drvid = '$drvid' AND dte = '$dte' AND timestr = '$timestr'";		
		if ($conn->query($sql) === TRUE) {
			//"Record updated successfully" and redirect to the menu
			session_start();//start session
			$id = $_SESSION['valid_id'];	
			$utype = $_SESSION['valid_utype'];
			echo "<script>
				alert('Update successful');
				window.location.href='showBusUse.php';
  			</script>";
		} else {
			echo "Error updating record: " . $conn->error;
		}
	}
?>
