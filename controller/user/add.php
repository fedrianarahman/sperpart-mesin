<?php
//ini wajib dipanggil paling atas
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../PHPMailer-master/PHPMailer-master/src/Exception.php';
require '../../PHPMailer-master/PHPMailer-master/src/PHPMailer.php';
require '../../PHPMailer-master/PHPMailer-master/src/SMTP.php';

session_start();
include '../conn.php';

$nama = strtolower($_POST['nama']);
$email = $_POST['email'];
$no_telpon = $_POST['no_telpon'];
$username = $_POST['username'];
$password = $_POST['password'];
$role = $_POST['role'];

$mail = new PHPMailer();

try {
    //Server settings
    $mail->SMTPDebug = 0;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'fedrianarahman21@gmail.com';                     //SMTP username
    $mail->Password   = 'zmlcpmwkljevadmo';                               //SMTP password
    $mail->SMTPSecure = 'tls';            //Enable implicit TLS encryption
    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //pengirim
    
    $mail->setFrom('fedrianarahman21@gmail.com', 'Verifikasi');
    $mail->addAddress($email, 'Rahman Fedriana');     //Add a recipient
 
    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    // $mail->Subject = $judul;
    $mail->Subject = "Aktivasi Akun ";
    $mail->Body    = "Hi $nama Akun Anda Sudah Terdaftar Berikut Username dan password <br/>username : .$username <br/> password : $password";
    $mail->AltBody = '';
    //$mail->AddEmbeddedImage('gambar/logo.png', 'logo'); //abaikan jika tidak ada logo
    //$mail->addAttachment(''); 

    $ambilDataUser = mysqli_query($conn, "SELECT * FROM user INNER JOIN role ON role.id = user.role");
    $cekData = mysqli_fetch_array($ambilDataUser);
    if ($cekData['nama']===$nama) {
        # code...
        $_SESSION['status-fail'] = "User sudah ada";
    } else {
       
        $mail->send();
        if ($mail) {
            $tambahDataGuru = mysqli_query($conn, "INSERT INTO `user`(`id`, `photo`, `nama`, `email`, `no_telpon`, `username`, `password`, `alamat`, `role`) VALUES ('','','$nama','$email','$no_telpon','$username','$password','','$role')");
            if ($tambahDataGuru) {
                $_SESSION['status-info'] = "Data Berhasil Dimasukan";
            }
               
        }else{
            $_SESSION['status-fail'] = "Data Tidak Berhasil Dimasukan";
        }
        // $res = mysqli_fetch_array($tambahDataGuru);
        // if ($res) {
        //     # code...
        // $mail->send();

        // 

        // }
        
    }
        

   

    // echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";

}

header("Location:../../dataUser.php");
?>