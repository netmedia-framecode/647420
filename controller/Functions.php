<?php

function handle_error($errno, $errstr, $errfile, $errline)
{
  // Create error log file path based on the file where the error occurred
  $errorLog = dirname(__FILE__) . '/error_log.log'; // Error log file location within the project folder

  // Format error message with additional information
  $error_message = "[" . date("Y-m-d H:i:s") . "] Error [$errno]: $errstr in $errfile on line $errline" . PHP_EOL;

  // Attempt to open the error log file in append mode, creating it if it doesn't exist
  $file_handle = fopen($errorLog, 'a');
  if ($file_handle !== false) {
    // Write error message to the log file
    fwrite($file_handle, $error_message);
    // Close the file handle
    fclose($file_handle);
  }

  // Save error message in session
  $_SESSION['error_message'] = $error_message;

  // Redirect user back to the same page only if there is no error
  if (!isset($_SESSION['error_flag'])) {
    // Set error flag to prevent infinite redirection loop
    $_SESSION['error_flag'] = true;
    // Redirect user back to the same page
    header("Location: {$_SERVER['REQUEST_URI']}");
    exit(); // Stop further execution
  }
}

function valid($conn, $value)
{
  $valid = htmlspecialchars(addslashes(trim(mysqli_real_escape_string($conn, $value))));
  return $valid;
}

function separateAlphaNumeric($string)
{
  $alpha = "";
  $numeric = "";
  // Mengiterasi setiap karakter dalam string
  for ($i = 0; $i < strlen($string); $i++) {
    // Memeriksa apakah karakter adalah huruf
    if (ctype_alpha($string[$i])) {
      $alpha .= $string[$i];
    }
    // Memeriksa apakah karakter adalah angka
    if (ctype_digit($string[$i])) {
      $numeric .= $string[$i];
    }
  }
  // Mengembalikan array yang berisi huruf dan angka terpisah
  return array(
    "alpha" => $alpha,
    "numeric" => $numeric
  );
}

function generateToken()
{
  // Generate a random 6-digit number
  $token = mt_rand(100000, 999999);
  return $token;
}

function compressImage($source, $destination, $quality)
{
  // mendapatkan info image
  $imgInfo = getimagesize($source);
  $mime = $imgInfo['mime'];
  // membuat image baru
  switch ($mime) {
      // proses kode memilih tipe tipe image 
    case 'image/jpeg':
      $image = imagecreatefromjpeg($source);
      break;
    case 'image/png':
      $image = imagecreatefrompng($source);
      break;
    default:
      $image = imagecreatefromjpeg($source);
  }

  // Menyimpan image dengan ukuran yang baru
  imagejpeg($image, $destination, $quality);

  // Return image
  return $destination;
}

if (!isset($_SESSION["project_penggajian_pegawai"]["users"])) {
  function register($conn, $data, $action)
  {
    if ($action == "insert") {
      $checkEmail = "SELECT * FROM users WHERE email='$data[email]'";
      $checkEmail = mysqli_query($conn, $checkEmail);
      if (mysqli_num_rows($checkEmail) > 0) {
        $message = "Maaf, email yang anda masukan sudah terdaftar.";
        $message_type = "danger";
        alert($message, $message_type);
        return false;
      } else {
        if ($data['password'] !== $data['re_password']) {
          $message = "Maaf, konfirmasi password yang anda masukan belum sama.";
          $message_type = "danger";
          alert($message, $message_type);
          return false;
        } else {
          $password = password_hash($data['password'], PASSWORD_DEFAULT);
          $token = generateToken();
          $en_user = password_hash($token, PASSWORD_DEFAULT);
          $en_user = str_replace("$", "", $en_user);
          $en_user = str_replace("/", "", $en_user);
          $en_user = str_replace(".", "", $en_user);
          $to       = $data['email'];
          $subject  = "Account Verification - Penggajian Pegawai";
          $message  = "<!doctype html>
          <html>
            <head>
                <meta name='viewport' content='width=device-width'>
                <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
                <title>Account Verification</title>
                <style>
                    @media only screen and (max-width: 620px) {
                        table[class='body'] h1 {
                            font-size: 28px !important;
                            margin-bottom: 10px !important;}
                        table[class='body'] p,
                        table[class='body'] ul,
                        table[class='body'] ol,
                        table[class='body'] td,
                        table[class='body'] span,
                        table[class='body'] a {
                            font-size: 16px !important;}
                        table[class='body'] .wrapper,
                        table[class='body'] .article {
                            padding: 10px !important;}
                        table[class='body'] .content {
                            padding: 0 !important;}
                        table[class='body'] .container {
                            padding: 0 !important;
                            width: 100% !important;}
                        table[class='body'] .main {
                            border-left-width: 0 !important;
                            border-radius: 0 !important;
                            border-right-width: 0 !important;}
                        table[class='body'] .btn table {
                            width: 100% !important;}
                        table[class='body'] .btn a {
                            width: 100% !important;}
                        table[class='body'] .img-responsive {
                            height: auto !important;
                            max-width: 100% !important;
                            width: auto !important;}}
                    @media all {
                        .ExternalClass {
                            width: 100%;}
                        .ExternalClass,
                        .ExternalClass p,
                        .ExternalClass span,
                        .ExternalClass font,
                        .ExternalClass td,
                        .ExternalClass div {
                            line-height: 100%;}
                        .apple-link a {
                            color: inherit !important;
                            font-family: inherit !important;
                            font-size: inherit !important;
                            font-weight: inherit !important;
                            line-height: inherit !important;
                            text-decoration: none !important;
                        .btn-primary table td:hover {
                            background-color: #d5075d !important;}
                        .btn-primary a:hover {
                            background-color: #000 !important;
                            border-color: #000 !important;
                            color: #fff !important;}}
                </style>
            </head>
            <body class style='background-color: #e1e3e5; font-family: sans-serif; -webkit-font-smoothing: antialiased; font-size: 14px; line-height: 1.4; margin: 0; padding: 0; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;'>
                <table role='presentation' border='0' cellpadding='0' cellspacing='0' class='body' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; background-color: #e1e3e5; width: 100%;' width='100%' bgcolor='#e1e3e5'>
                <tr>
                    <td style='font-family: sans-serif; font-size: 14px; vertical-align: top;' valign='top'>&nbsp;</td>
                    <td class='container' style='font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; max-width: 580px; padding: 10px; width: 580px; margin: 0 auto;' width='580' valign='top'>
                    <div class='content' style='box-sizing: border-box; display: block; margin: 0 auto; max-width: 580px; padding: 10px;'>
            
                        <!-- START CENTERED WHITE CONTAINER -->
                        <table role='presentation' class='main' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; background: #ffffff; border-radius: 3px; width: 100%;' width='100%'>
            
                        <!-- START MAIN CONTENT AREA -->
                        <tr>
                            <td class='wrapper' style='font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;' valign='top'>
                            <table role='presentation' border='0' cellpadding='0' cellspacing='0' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; width: 100%;' width='100%'>
                                <tr>
                                <td style='font-family: sans-serif; font-size: 14px; vertical-align: top;' valign='top'>
                                    <p style='font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;'>Hi " . $data['name'] . ",</p>
                                    <p style='font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;'>Selamat akun kamu sudah terdaftar, tinggal satu langkah lagi kamu sudah bisa menggunakan akun. Silakan salin kode token dibawah ini untuk memverifikasi akun kamu.</p>
                                    <table role='presentation' border='0' cellpadding='0' cellspacing='0' class='btn btn-primary' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; box-sizing: border-box; min-width: 100%; width: 100%;' width='100%'>
                                    <tbody>
                                        <tr>
                                        <td align='left' style='font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px;' valign='top'>
                                            <table role='presentation' border='0' cellpadding='0' cellspacing='0' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: auto; width: auto;'>
                                            <tbody>
                                                <tr>
                                                <td style='font-family: sans-serif; font-size: 14px; vertical-align: top; background-color: #ffffff; border-radius: 5px; text-align: center; font-weight: bold;' valign='top' bgcolor='#ffffff' align='center'>" . $token . "</td>
                                                </tr>
                                            </tbody>
                                            </table>
                                        </td>
                                        </tr>
                                    </tbody>
                                    </table>
                                    <p style='font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;'>Terima kasih telah mendaftar di Penggajian Pegawai.</p>
                                    <small>Peringatan! Ini adalah pesan otomatis sehingga Anda tidak dapat membalas pesan ini.</small>
                                </td>
                                </tr>
                            </table>
                            </td>
                        </tr>
            
                        <!-- END MAIN CONTENT AREA -->
                        </table>
                        
                        <!-- START FOOTER -->
                        <div class='footer' style='clear: both; margin-top: 10px; text-align: center; width: 100%;'>
                        <table role='presentation' border='0' cellpadding='0' cellspacing='0' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; width: 100%;' width='100%'>
                            <tr>
                            <td class='content-block' style='font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; color: #9a9ea6; font-size: 12px; text-align: center;' valign='top' align='center'>
                                <span class='apple-link' style='color: #9a9ea6; font-size: 12px; text-align: center;'>Workarea Jln. S. K. Lerik, Kota Baru, Kupang, NTT, Indonesia. (0380) 8438423</span>
                            </td>
                            </tr>
                            <tr>
                            <td class='content-block powered-by' style='font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; color: #9a9ea6; font-size: 12px; text-align: center;' valign='top' align='center'>
                                Powered by <a href='https://www.netmedia-framecode.com' style='color: #9a9ea6; font-size: 12px; text-align: center; text-decoration: none;'>Netmedia Framecode</a>.
                            </td>
                            </tr>
                        </table>
                        </div>
                        <!-- END FOOTER -->
            
                    <!-- END CENTERED WHITE CONTAINER -->
                    </div>
                    </td>
                    <td style='font-family: sans-serif; font-size: 14px; vertical-align: top;' valign='top'>&nbsp;</td>
                </tr>
                </table>
            </body>
          </html>";
          smtp_mail($to, $subject, $message, "", "", 0, 0, true);
          $_SESSION['data_auth'] = ['en_user' => $en_user];
          $sql = "INSERT INTO users(en_user,token,name,email,password) VALUES('$en_user','$token','$data[name]','$data[email]','$password')";
        }
      }
    }

    mysqli_query($conn, $sql);
    return mysqli_affected_rows($conn);
  }

  function re_verifikasi($conn, $data, $action)
  {
    if ($action == "update") {
      $checkEN = "SELECT * FROM users WHERE en_user='$data[en_user]'";
      $checkEN = mysqli_query($conn, $checkEN);
      if (mysqli_num_rows($checkEN) == 0) {
        $message = "Maaf, sepertinya ada kesalahan saat mendaftar.";
        $message_type = "danger";
        alert($message, $message_type);
        return false;
      } else if (mysqli_num_rows($checkEN) > 0) {
        $row = mysqli_fetch_assoc($checkEN);
        $name = $row['name'];
        $email = $row['email'];
        $token = generateToken();
        $reen_user = password_hash($token, PASSWORD_DEFAULT);
        $reen_user = str_replace("$", "", $reen_user);
        $reen_user = str_replace("/", "", $reen_user);
        $reen_user = str_replace(".", "", $reen_user);
        $to       = $email;
        $subject  = "Account Verification - Penggajian Pegawai";
        $message  = "<!doctype html>
        <html>
          <head>
              <meta name='viewport' content='width=device-width'>
              <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
              <title>Account Verification</title>
              <style>
                  @media only screen and (max-width: 620px) {
                      table[class='body'] h1 {
                          font-size: 28px !important;
                          margin-bottom: 10px !important;}
                      table[class='body'] p,
                      table[class='body'] ul,
                      table[class='body'] ol,
                      table[class='body'] td,
                      table[class='body'] span,
                      table[class='body'] a {
                          font-size: 16px !important;}
                      table[class='body'] .wrapper,
                      table[class='body'] .article {
                          padding: 10px !important;}
                      table[class='body'] .content {
                          padding: 0 !important;}
                      table[class='body'] .container {
                          padding: 0 !important;
                          width: 100% !important;}
                      table[class='body'] .main {
                          border-left-width: 0 !important;
                          border-radius: 0 !important;
                          border-right-width: 0 !important;}
                      table[class='body'] .btn table {
                          width: 100% !important;}
                      table[class='body'] .btn a {
                          width: 100% !important;}
                      table[class='body'] .img-responsive {
                          height: auto !important;
                          max-width: 100% !important;
                          width: auto !important;}}
                  @media all {
                      .ExternalClass {
                          width: 100%;}
                      .ExternalClass,
                      .ExternalClass p,
                      .ExternalClass span,
                      .ExternalClass font,
                      .ExternalClass td,
                      .ExternalClass div {
                          line-height: 100%;}
                      .apple-link a {
                          color: inherit !important;
                          font-family: inherit !important;
                          font-size: inherit !important;
                          font-weight: inherit !important;
                          line-height: inherit !important;
                          text-decoration: none !important;
                      .btn-primary table td:hover {
                          background-color: #d5075d !important;}
                      .btn-primary a:hover {
                          background-color: #000 !important;
                          border-color: #000 !important;
                          color: #fff !important;}}
              </style>
          </head>
          <body class style='background-color: #e1e3e5; font-family: sans-serif; -webkit-font-smoothing: antialiased; font-size: 14px; line-height: 1.4; margin: 0; padding: 0; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;'>
              <table role='presentation' border='0' cellpadding='0' cellspacing='0' class='body' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; background-color: #e1e3e5; width: 100%;' width='100%' bgcolor='#e1e3e5'>
              <tr>
                  <td style='font-family: sans-serif; font-size: 14px; vertical-align: top;' valign='top'>&nbsp;</td>
                  <td class='container' style='font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; max-width: 580px; padding: 10px; width: 580px; margin: 0 auto;' width='580' valign='top'>
                  <div class='content' style='box-sizing: border-box; display: block; margin: 0 auto; max-width: 580px; padding: 10px;'>
          
                      <!-- START CENTERED WHITE CONTAINER -->
                      <table role='presentation' class='main' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; background: #ffffff; border-radius: 3px; width: 100%;' width='100%'>
          
                      <!-- START MAIN CONTENT AREA -->
                      <tr>
                          <td class='wrapper' style='font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;' valign='top'>
                          <table role='presentation' border='0' cellpadding='0' cellspacing='0' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; width: 100%;' width='100%'>
                              <tr>
                              <td style='font-family: sans-serif; font-size: 14px; vertical-align: top;' valign='top'>
                                  <p style='font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;'>Hi " . $name . ",</p>
                                  <p style='font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;'>Selamat akun kamu sudah terdaftar, tinggal satu langkah lagi kamu sudah bisa menggunakan akun. Silakan salin kode token dibawah ini untuk memverifikasi akun kamu.</p>
                                  <table role='presentation' border='0' cellpadding='0' cellspacing='0' class='btn btn-primary' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; box-sizing: border-box; min-width: 100%; width: 100%;' width='100%'>
                                  <tbody>
                                      <tr>
                                      <td align='left' style='font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px;' valign='top'>
                                          <table role='presentation' border='0' cellpadding='0' cellspacing='0' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: auto; width: auto;'>
                                          <tbody>
                                              <tr>
                                              <td style='font-family: sans-serif; font-size: 14px; vertical-align: top; background-color: #ffffff; border-radius: 5px; text-align: center; font-weight: bold;' valign='top' bgcolor='#ffffff' align='center'>" . $token . "</td>
                                              </tr>
                                          </tbody>
                                          </table>
                                      </td>
                                      </tr>
                                  </tbody>
                                  </table>
                                  <p style='font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;'>Terima kasih telah mendaftar di Penggajian Pegawai.</p>
                                  <small>Peringatan! Ini adalah pesan otomatis sehingga Anda tidak dapat membalas pesan ini.</small>
                              </td>
                              </tr>
                          </table>
                          </td>
                      </tr>
          
                      <!-- END MAIN CONTENT AREA -->
                      </table>
                      
                      <!-- START FOOTER -->
                      <div class='footer' style='clear: both; margin-top: 10px; text-align: center; width: 100%;'>
                      <table role='presentation' border='0' cellpadding='0' cellspacing='0' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; width: 100%;' width='100%'>
                          <tr>
                          <td class='content-block' style='font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; color: #9a9ea6; font-size: 12px; text-align: center;' valign='top' align='center'>
                              <span class='apple-link' style='color: #9a9ea6; font-size: 12px; text-align: center;'>Workarea Jln. S. K. Lerik, Kota Baru, Kupang, NTT, Indonesia. (0380) 8438423</span>
                          </td>
                          </tr>
                          <tr>
                          <td class='content-block powered-by' style='font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; color: #9a9ea6; font-size: 12px; text-align: center;' valign='top' align='center'>
                              Powered by <a href='https://www.netmedia-framecode.com' style='color: #9a9ea6; font-size: 12px; text-align: center; text-decoration: none;'>Netmedia Framecode</a>.
                          </td>
                          </tr>
                      </table>
                      </div>
                      <!-- END FOOTER -->
          
                  <!-- END CENTERED WHITE CONTAINER -->
                  </div>
                  </td>
                  <td style='font-family: sans-serif; font-size: 14px; vertical-align: top;' valign='top'>&nbsp;</td>
              </tr>
              </table>
          </body>
        </html>";
        smtp_mail($to, $subject, $message, "", "", 0, 0, true);
        $_SESSION['data_auth'] = ['en_user' => $reen_user];
        $sql = "UPDATE users SET en_user='$reen_user', token='$token', updated_at=current_timestamp WHERE en_user='$data[en_user]'";
      }
    }

    mysqli_query($conn, $sql);
    return mysqli_affected_rows($conn);
  }

  function verifikasi($conn, $data, $action)
  {
    if ($action == "update") {
      $checkEN = "SELECT * FROM users WHERE en_user='$data[en_user]'";
      $checkEN = mysqli_query($conn, $checkEN);
      if (mysqli_num_rows($checkEN) == 0) {
        $message = "Maaf, sepertinya ada kesalahan saat mendaftar.";
        $message_type = "warning";
        alert($message, $message_type);
        return false;
      } else if (mysqli_num_rows($checkEN) > 0) {
        $row = mysqli_fetch_assoc($checkEN);
        $token_primary = $row['token'];
        $updated_at = strtotime($row['updated_at']);
        $current_time = time();
        if (($current_time - $updated_at) > (5 * 60)) {
          $message = "Maaf, waktu untuk verifikasi telah habis.";
          $message_type = "warning";
          alert($message, $message_type);
          $_SESSION["project_penggajian_pegawai"] = [
            "message-warning" => "Maaf, waktu untuk verifikasi telah habis.",
            "time-message" => time()
          ];
          return false;
        }
        if ($data['token'] !== $token_primary) {
          $message = "Maaf, kode token yang anda masukan masih salah.";
          $message_type = "warning";
          alert($message, $message_type);
          return false;
        }
        $sql = "UPDATE users SET id_active='1', updated_at=current_timestamp WHERE en_user='$data[en_user]'";
      }
    }

    mysqli_query($conn, $sql);
    return mysqli_affected_rows($conn);
  }

  function forgot_password($conn, $data, $action, $baseURL)
  {
    if ($action == "update") {
      $checkEmail = "SELECT * FROM users WHERE email='$data[email]'";
      $checkEmail = mysqli_query($conn, $checkEmail);
      if (mysqli_num_rows($checkEmail) === 0) {
        $message = "Maaf, email yang anda masukan belum terdaftar.";
        $message_type = "danger";
        alert($message, $message_type);
        return false;
      } else {
        $row = mysqli_fetch_assoc($checkEmail);
        $name = valid($conn, $row['name']);
        $token = generateToken();
        $en_user = password_hash($token, PASSWORD_DEFAULT);
        $en_user = str_replace("$", "", $en_user);
        $en_user = str_replace("/", "", $en_user);
        $en_user = str_replace(".", "", $en_user);
        $to       = $data['email'];
        $subject  = "Reset password - Penggajian Pegawai";
        $message  = "<!doctype html>
        <html>
          <head>
              <meta name='viewport' content='width=device-width'>
              <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
              <title>Reset password</title>
              <style>
                  @media only screen and (max-width: 620px) {
                      table[class='body'] h1 {
                          font-size: 28px !important;
                          margin-bottom: 10px !important;}
                      table[class='body'] p,
                      table[class='body'] ul,
                      table[class='body'] ol,
                      table[class='body'] td,
                      table[class='body'] span,
                      table[class='body'] a {
                          font-size: 16px !important;}
                      table[class='body'] .wrapper,
                      table[class='body'] .article {
                          padding: 10px !important;}
                      table[class='body'] .content {
                          padding: 0 !important;}
                      table[class='body'] .container {
                          padding: 0 !important;
                          width: 100% !important;}
                      table[class='body'] .main {
                          border-left-width: 0 !important;
                          border-radius: 0 !important;
                          border-right-width: 0 !important;}
                      table[class='body'] .btn table {
                          width: 100% !important;}
                      table[class='body'] .btn a {
                          width: 100% !important;}
                      table[class='body'] .img-responsive {
                          height: auto !important;
                          max-width: 100% !important;
                          width: auto !important;}}
                  @media all {
                      .ExternalClass {
                          width: 100%;}
                      .ExternalClass,
                      .ExternalClass p,
                      .ExternalClass span,
                      .ExternalClass font,
                      .ExternalClass td,
                      .ExternalClass div {
                          line-height: 100%;}
                      .apple-link a {
                          color: inherit !important;
                          font-family: inherit !important;
                          font-size: inherit !important;
                          font-weight: inherit !important;
                          line-height: inherit !important;
                          text-decoration: none !important;
                      .btn-primary table td:hover {
                          background-color: #d5075d !important;}
                      .btn-primary a:hover {
                          background-color: #000 !important;
                          border-color: #000 !important;
                          color: #fff !important;}}
              </style>
          </head>
          <body class style='background-color: #e1e3e5; font-family: sans-serif; -webkit-font-smoothing: antialiased; font-size: 14px; line-height: 1.4; margin: 0; padding: 0; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;'>
              <table role='presentation' border='0' cellpadding='0' cellspacing='0' class='body' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; background-color: #e1e3e5; width: 100%;' width='100%' bgcolor='#e1e3e5'>
              <tr>
                  <td style='font-family: sans-serif; font-size: 14px; vertical-align: top;' valign='top'>&nbsp;</td>
                  <td class='container' style='font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; max-width: 580px; padding: 10px; width: 580px; margin: 0 auto;' width='580' valign='top'>
                  <div class='content' style='box-sizing: border-box; display: block; margin: 0 auto; max-width: 580px; padding: 10px;'>
          
                      <!-- START CENTERED WHITE CONTAINER -->
                      <table role='presentation' class='main' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; background: #ffffff; border-radius: 3px; width: 100%;' width='100%'>
          
                      <!-- START MAIN CONTENT AREA -->
                      <tr>
                          <td class='wrapper' style='font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;' valign='top'>
                          <table role='presentation' border='0' cellpadding='0' cellspacing='0' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; width: 100%;' width='100%'>
                              <tr>
                              <td style='font-family: sans-serif; font-size: 14px; vertical-align: top;' valign='top'>
                                  <p style='font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;'>Hi " . $name . ",</p>
                                  <p style='font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;'>Pesan ini secara otomatis dikirimkan kepada anda karena anda meminta untuk mereset kata sandi. Jika anda tidak sama sekali ingin mereset atau bukan anda yang ingin mereset abaikan saja. Klik tombol reset berikut untuk melanjutkan:</p>
                                  <table role='presentation' border='0' cellpadding='0' cellspacing='0' class='btn btn-primary' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; box-sizing: border-box; min-width: 100%; width: 100%;' width='100%'>
                                  <tbody>
                                      <tr>
                                      <td align='left' style='font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px;' valign='top'>
                                          <table role='presentation' border='0' cellpadding='0' cellspacing='0' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: auto; width: auto;'>
                                          <tbody>
                                              <tr>
                                                <td style='font-family: sans-serif; font-size: 14px; vertical-align: top; background-color: #ffffff; border-radius: 5px; text-align: center;' valign='top' bgcolor='#ffffff' align='center'>
                                                  <a href='" . $baseURL . "auth/new-password?en=" . $en_user . "' target='_blank' style='background-color: #ffffff; border: solid 1px #000; border-radius: 5px; box-sizing: border-box; cursor: pointer; display: inline-block; font-size: 14px; font-weight: bold; margin: 0; padding: 12px 25px; text-decoration: none; text-transform: capitalize; border-color: #000; color: #000;'>Atur Ulang Kata Sandi</a> 
                                                </td>
                                              </tr>
                                          </tbody>
                                          </table>
                                      </td>
                                      </tr>
                                  </tbody>
                                  </table>
                                  <small>Peringatan! Ini adalah pesan otomatis sehingga Anda tidak dapat membalas pesan ini.</small>
                              </td>
                              </tr>
                          </table>
                          </td>
                      </tr>
          
                      <!-- END MAIN CONTENT AREA -->
                      </table>
                      
                      <!-- START FOOTER -->
                      <div class='footer' style='clear: both; margin-top: 10px; text-align: center; width: 100%;'>
                      <table role='presentation' border='0' cellpadding='0' cellspacing='0' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; width: 100%;' width='100%'>
                          <tr>
                          <td class='content-block' style='font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; color: #9a9ea6; font-size: 12px; text-align: center;' valign='top' align='center'>
                              <span class='apple-link' style='color: #9a9ea6; font-size: 12px; text-align: center;'>Workarea Jln. S. K. Lerik, Kota Baru, Kupang, NTT, Indonesia. (0380) 8438423</span>
                          </td>
                          </tr>
                          <tr>
                          <td class='content-block powered-by' style='font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; color: #9a9ea6; font-size: 12px; text-align: center;' valign='top' align='center'>
                              Powered by <a href='https://www.netmedia-framecode.com' style='color: #9a9ea6; font-size: 12px; text-align: center; text-decoration: none;'>Netmedia Framecode</a>.
                          </td>
                          </tr>
                      </table>
                      </div>
                      <!-- END FOOTER -->
          
                  <!-- END CENTERED WHITE CONTAINER -->
                  </div>
                  </td>
                  <td style='font-family: sans-serif; font-size: 14px; vertical-align: top;' valign='top'>&nbsp;</td>
              </tr>
              </table>
          </body>
        </html>";
        smtp_mail($to, $subject, $message, "", "", 0, 0, true);
        $sql = "UPDATE users SET en_user='$en_user', token='$token', updated_at=current_timestamp WHERE email='$data[email]'";
      }
    }

    mysqli_query($conn, $sql);
    return mysqli_affected_rows($conn);
  }

  function new_password($conn, $data, $action)
  {
    if ($action == "update") {
      $lenght = strlen($data['password']);
      if ($lenght < 8) {
        $message = "Maaf, password yang anda masukan harus 8 digit atau lebih.";
        $message_type = "danger";
        alert($message, $message_type);
        return false;
      } else if ($data['password'] !== $data['re_password']) {
        $message = "Maaf, konfirmasi password yang anda masukan belum sama.";
        $message_type = "danger";
        alert($message, $message_type);
        return false;
      } else {
        $password = password_hash($data['password'], PASSWORD_DEFAULT);
        $sql = "UPDATE users SET password='$password' WHERE email='$data[email]'";
      }
    }

    mysqli_query($conn, $sql);
    return mysqli_affected_rows($conn);
  }

  function login($conn, $data)
  {
    // check account
    $checkAccount = mysqli_query($conn, "SELECT * FROM users JOIN user_role ON users.id_role=user_role.id_role WHERE users.email='$data[email]'");
    if (mysqli_num_rows($checkAccount) == 0) {
      $message = "Maaf, akun yang anda masukan belum terdaftar.";
      $message_type = "danger";
      alert($message, $message_type);
      return false;
    } else if (mysqli_num_rows($checkAccount) > 0) {
      $row = mysqli_fetch_assoc($checkAccount);
      if (password_verify($data['password'], $row["password"])) {
        $_SESSION["project_penggajian_pegawai"]["users"] = [
          "id" => $row["id_user"],
          "id_role" => $row["id_role"],
          "role" => $row["role"],
          "email" => $row["email"],
          "name" => $row["name"],
          "image" => $row["image"]
        ];
        return mysqli_affected_rows($conn);
      } else {
        $message = "Maaf, kata sandi yang anda masukan salah.";
        $message_type = "danger";
        alert($message, $message_type);
        return false;
      }
    }
  }
}

if (isset($_SESSION["project_penggajian_pegawai"]["users"])) {

  function profil($conn, $data, $action, $id_user)
  {
    if ($action == "update") {
      $path = "../assets/img/profil/";
      if (!empty($_FILES['image']["name"])) {
        $fileName = basename($_FILES["image"]["name"]);
        $fileName = str_replace(" ", "-", $fileName);
        $fileName_encrypt = crc32($fileName);
        $ekstensiGambar = explode('.', $fileName);
        $ekstensiGambar = strtolower(end($ekstensiGambar));
        $imageUploadPath = $path . $fileName_encrypt . "." . $ekstensiGambar;
        $fileType = pathinfo($imageUploadPath, PATHINFO_EXTENSION);
        $allowTypes = array('jpg', 'png', 'jpeg');
        if (in_array($fileType, $allowTypes)) {
          $imageTemp = $_FILES["image"]["tmp_name"];
          compressImage($imageTemp, $imageUploadPath, 75);
          $image = $fileName_encrypt . "." . $ekstensiGambar;
        } else {
          $message = "Maaf, hanya file gambar JPG, JPEG, dan PNG yang diizinkan.";
          $message_type = "danger";
          alert($message, $message_type);
          return false;
        }
      }
      if (!empty($_FILES['image']["name"])) {
        $unwanted_characters = "../assets/img/profil/";
        $remove_image = str_replace($unwanted_characters, "", $data['imageOld']);
        if ($remove_image != "default.svg") {
          unlink($path . $remove_image);
        }
      } else if (empty($_FILE['image']["name"])) {
        $image = $data['imageOld'];
      }
      if (!empty($data['password'])) {
        $password = password_hash($data['password'], PASSWORD_DEFAULT);
        $sql = "UPDATE users SET name='$data[name]', image='$image', password='$password' WHERE id_user='$id_user'";
      } else {
        $sql = "UPDATE users SET name='$data[name]', image='$image' WHERE id_user='$id_user'";
      }
    }

    mysqli_query($conn, $sql);
    return mysqli_affected_rows($conn);
  }

  function setting($conn, $data, $action)
  {

    if ($action == "update") {
      $path = "../assets/img/auth/";
      if (!empty($_FILES['image']["name"])) {
        $fileName = basename($_FILES["image"]["name"]);
        $fileName = str_replace(" ", "-", $fileName);
        $fileName_encrypt = crc32($fileName);
        $ekstensiGambar = explode('.', $fileName);
        $ekstensiGambar = strtolower(end($ekstensiGambar));
        $imageUploadPath = $path . $fileName_encrypt . "." . $ekstensiGambar;
        $fileType = pathinfo($imageUploadPath, PATHINFO_EXTENSION);
        $allowTypes = array('jpg', 'png', 'jpeg');
        if (in_array($fileType, $allowTypes)) {
          $imageTemp = $_FILES["image"]["tmp_name"];
          compressImage($imageTemp, $imageUploadPath, 75);
          $image = $fileName_encrypt . "." . $ekstensiGambar;
        } else {
          $message = "Maaf, hanya file gambar JPG, JPEG, dan PNG yang diizinkan.";
          $message_type = "danger";
          alert($message, $message_type);
          return false;
        }
      }
      if (!empty($_FILES['image']["name"])) {
        $unwanted_characters = "../assets/img/auth/";
        $remove_image = str_replace($unwanted_characters, "", $data['imageOld']);
        unlink($path . $remove_image);
      } else if (empty($_FILE['image']["name"])) {
        $image = $data['imageOld'];
      }
      $sql = "UPDATE auth SET image='$image', bg='$data[bg]'";
    }

    mysqli_query($conn, $sql);
    return mysqli_affected_rows($conn);
  }

  function users($conn, $data, $action)
  {

    if ($action == "update") {
      $sql = "UPDATE users SET id_role='$data[id_role]', id_active='$data[id_active]' WHERE id_user='$data[id_user]'";
    }

    mysqli_query($conn, $sql);
    return mysqli_affected_rows($conn);
  }

  function role($conn, $data, $action)
  {
    if ($action == "insert") {
      $checkRole = "SELECT * FROM user_role WHERE role LIKE '%$data[role]%'";
      $checkRole = mysqli_query($conn, $checkRole);
      if (mysqli_num_rows($checkRole) > 0) {
        $message = "Maaf, role yang anda masukan sudah ada.";
        $message_type = "danger";
        alert($message, $message_type);
        return false;
      } else {
        $sql = "INSERT INTO user_role(role) VALUES('$data[role]')";
      }
    }

    if ($action == "update") {
      if ($data['role'] !== $data['roleOld']) {
        $checkRole = "SELECT * FROM user_role WHERE role LIKE '%$data[role]%'";
        $checkRole = mysqli_query($conn, $checkRole);
        if (mysqli_num_rows($checkRole) > 0) {
          $message = "Maaf, role yang anda masukan sudah ada.";
          $message_type = "danger";
          alert($message, $message_type);
          return false;
        }
      }
      $sql = "UPDATE user_role SET role='$data[role]' WHERE id_role='$data[id_role]'";
    }

    if ($action == "delete") {
      $sql = "DELETE FROM user_role WHERE id_role='$data[id_role]'";
    }

    mysqli_query($conn, $sql);
    return mysqli_affected_rows($conn);
  }

  function menu($conn, $data, $action)
  {
    if ($action == "insert") {
      $checkMenu = "SELECT * FROM user_menu WHERE menu='$data[menu]'";
      $checkMenu = mysqli_query($conn, $checkMenu);
      if (mysqli_num_rows($checkMenu) > 0) {
        $message = "Maaf, menu yang anda masukan sudah ada.";
        $message_type = "danger";
        alert($message, $message_type);
        return false;
      } else {
        $sql = "INSERT INTO user_menu(menu) VALUES('$data[menu]')";
      }
    }

    if ($action == "update") {
      if ($data['menu'] !== $data['menuOld']) {
        $checkMenu = "SELECT * FROM user_menu WHERE menu='$data[menu]'";
        $checkMenu = mysqli_query($conn, $checkMenu);
        if (mysqli_num_rows($checkMenu) > 0) {
          $message = "Maaf, menu yang anda masukan sudah ada.";
          $message_type = "danger";
          alert($message, $message_type);
          return false;
        }
      }
      $sql = "UPDATE user_menu SET menu='$data[menu]' WHERE id_menu='$data[id_menu]'";
    }

    if ($action == "delete") {
      $sql = "DELETE FROM user_menu WHERE id_menu='$data[id_menu]'";
    }

    mysqli_query($conn, $sql);
    return mysqli_affected_rows($conn);
  }

  function sub_menu($conn, $data, $action, $baseURL)
  {
    $url = strtolower($data['title']);
    $url = str_replace(" ", "-", $url);

    if ($action == "insert") {
      $checkSubMenu = "SELECT * FROM user_sub_menu WHERE title='$data[title]'";
      $checkSubMenu = mysqli_query($conn, $checkSubMenu);
      if (mysqli_num_rows($checkSubMenu) > 0) {
        $message = "Maaf, nama sub menu yang anda masukan sudah ada.";
        $message_type = "danger";
        alert($message, $message_type);
        return false;
      } else {
        $file_views = fopen("../views/" . $url . ".php", "w");
        fwrite($file_views, '<?php require_once("../controller/' . $url . '.php");
        $_SESSION["project_penggajian_pegawai"]["name_page"] = "' . $data['title'] . '";
        require_once("../templates/views_top.php"); ?>
        
        <!-- Begin Page Content -->
        <div class="container-fluid">
        
          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION["project_penggajian_pegawai"]["name_page"] ?></h1>
          </div>
        
          <!-- Mulai buatlah lembar kerja anda disini! -->
        
        </div>
        <!-- /.container-fluid -->
        
        <?php require_once("../templates/views_bottom.php") ?>
        ');
        fclose($file_views);
        $file_controller = fopen("../controller/" . $url . ".php", "w");
        fwrite($file_controller, '<?php

        require_once("../config/Base.php");
        require_once("../config/Auth.php");
        require_once("../config/Alert.php");
        ');
        fclose($file_controller);
        $sql = "INSERT INTO user_sub_menu(id_menu,id_active,title,url,icon) VALUES('$data[id_menu]','$data[id_active]','$data[title]','$url','$data[icon]')";
      }
    }

    if ($action == "update") {
      if ($data['title'] !== $data['titleOld']) {
        $checkSubMenu = "SELECT * FROM user_sub_menu WHERE title='$data[title]'";
        $checkSubMenu = mysqli_query($conn, $checkSubMenu);
        if (mysqli_num_rows($checkSubMenu) > 0) {
          $message = "Maaf, nama sub menu yang anda masukan sudah ada.";
          $message_type = "danger";
          alert($message, $message_type);
          return false;
        }
      }
      $sql = "UPDATE user_sub_menu SET id_menu='$data[id_menu]', id_active='$data[id_active]', title='$data[title]', url='$url', icon='$data[icon]' WHERE id_sub_menu='$data[id_sub_menu]'";
    }

    if ($action == "delete") {
      unlink("../views/" . $url . ".php");
      unlink("../controller/" . $url . ".php");
      $sql = "DELETE FROM user_sub_menu WHERE id_sub_menu='$data[id_sub_menu]'";
    }

    mysqli_query($conn, $sql);
    return mysqli_affected_rows($conn);
  }

  function menu_access($conn, $data, $action)
  {
    if ($action == "insert") {
      $sql = "INSERT INTO user_access_menu(id_role,id_menu) VALUES('$data[id_role]','$data[id_menu]')";
    }

    if ($action == "update") {
      $sql = "UPDATE user_access_menu SET id_role='$data[id_role]', id_menu='$data[id_menu]' WHERE id_access_menu='$data[id_access_menu]'";
    }

    if ($action == "delete") {
      $sql = "DELETE FROM user_access_menu WHERE id_access_menu='$data[id_access_menu]'";
    }

    mysqli_query($conn, $sql);
    return mysqli_affected_rows($conn);
  }

  function sub_menu_access($conn, $data, $action)
  {
    if ($action == "insert") {
      $sql = "INSERT INTO user_access_sub_menu(id_role,id_sub_menu) VALUES('$data[id_role]','$data[id_sub_menu]')";
    }

    if ($action == "update") {
      $sql = "UPDATE user_access_sub_menu SET id_role='$data[id_role]', id_sub_menu='$data[id_sub_menu]' WHERE id_access_sub_menu='$data[id_access_sub_menu]'";
    }

    if ($action == "delete") {
      $sql = "DELETE FROM user_access_sub_menu WHERE id_access_sub_menu='$data[id_access_sub_menu]'";
    }

    mysqli_query($conn, $sql);
    return mysqli_affected_rows($conn);
  }

  function pangkat_pegawai($conn, $data, $action)
  {
    if ($action == "insert") {
      $checkID = "SELECT * FROM pangkat_pegawai ORDER BY id_pangkat DESC LIMIT 1";
      $checkID = mysqli_query($conn, $checkID);
      if (mysqli_num_rows($checkID) > 0) {
        $dataID = mysqli_fetch_assoc($checkID);
        $id_pangkat = $dataID['id_pangkat'] + 1;
      } else {
        $id_pangkat = 1;
      }
      $sql = "INSERT INTO pangkat_pegawai(id_pangkat,nama_pangkat) VALUES('$id_pangkat','$data[nama_pangkat]');";
      $sql .= "INSERT INTO golongan_pegawai(id_golongan,nama_golongan) VALUES('$id_pangkat','$data[nama_pangkat]');";
    }

    if ($action == "update") {
      $sql = "UPDATE pangkat_pegawai SET nama_pangkat='$data[nama_pangkat]' WHERE id_pangkat='$data[id_pangkat]';";
      $sql .= "UPDATE golongan_pegawai SET nama_golongan='$data[nama_pangkat]' WHERE id_golongan='$data[id_pangkat]';";
    }

    if ($action == "delete") {
      $sql = "DELETE FROM pangkat_pegawai WHERE id_pangkat='$data[id_pangkat]';";
      $sql .= "DELETE FROM golongan_pegawai WHERE id_golongan='$data[id_pangkat]';";
    }

    mysqli_multi_query($conn, $sql);
    return mysqli_affected_rows($conn);
  }

  function jabatan_pegawai($conn, $data, $action)
  {
    if ($action == "insert") {
      $sql = "INSERT INTO jabatan_pegawai(nama_jabatan) VALUES('$data[nama_jabatan]')";
    }

    if ($action == "update") {
      $sql = "UPDATE jabatan_pegawai SET nama_jabatan='$data[nama_jabatan]' WHERE id_jabatan='$data[id_jabatan]'";
    }

    if ($action == "delete") {
      $sql = "DELETE FROM jabatan_pegawai WHERE id_jabatan='$data[id_jabatan]'";
    }

    mysqli_query($conn, $sql);
    return mysqli_affected_rows($conn);
  }

  function exportPegawaiToPDF($conn)
  {
    $query = "SELECT pegawai.*, pangkat_pegawai.nama_pangkat, jabatan_pegawai.nama_jabatan 
      FROM pegawai 
      JOIN pangkat_pegawai ON pegawai.id_pangkat = pangkat_pegawai.id_pangkat
      JOIN jabatan_pegawai ON pegawai.id_jabatan = jabatan_pegawai.id_jabatan
      ORDER BY pegawai.id_pegawai DESC";
    $result = mysqli_query($conn, $query);
    $mpdf = new \Mpdf\Mpdf();
    $html = '<h5 style="text-align: center;">NOMATIF KANTOR CAMAT KOTING <br>TAHUN ' . date('Y') . ' <br>DATA PEGAWAI KECAMATAN KOTING</h5>';
    $html .= '<table border="1" cellspacing="0" cellpadding="5" style="width: 100%;">
                <tr>
                  <th>No</th>
                  <th>Nama</th>
                  <th>NIP</th>
                  <th>Pangkat/Gol Ruang</th>
                  <th>Jabatan</th>
                </tr>';
    $no = 1;
    while ($row = mysqli_fetch_assoc($result)) {
      $html .= '<tr>
                    <td>' . $no++ . '</td>
                    <td>' . $row['nama'] . '</td>
                    <td>' . $row['nip'] . '</td>
                    <td>' . $row['nama_pangkat'] . '</td>
                    <td>' . $row['nama_jabatan'] . '</td>
                 </tr>';
    }
    $html .= '</table>';
    $mpdf->WriteHTML($html);
    $mpdf->Output('nomatif_kantor_camat_koting.pdf', 'D');
  }

  function exportPegawaiToExcel($conn)
  {
    $query = "SELECT pegawai.*, pangkat_pegawai.nama_pangkat, jabatan_pegawai.nama_jabatan 
      FROM pegawai 
      JOIN pangkat_pegawai ON pegawai.id_pangkat = pangkat_pegawai.id_pangkat
      JOIN jabatan_pegawai ON pegawai.id_jabatan = jabatan_pegawai.id_jabatan
      ORDER BY pegawai.id_pegawai DESC";
    $result = mysqli_query($conn, $query);
    $spreadsheet = new PhpOffice\PhpSpreadsheet\Spreadsheet();
    $spreadsheet->getProperties()->setCreator('Creator')
      ->setLastModifiedBy('Last Modified By')
      ->setTitle('DATA PEGAWAI KECAMATAN KOTING')
      ->setSubject('DATA PEGAWAI KECAMATAN KOTING')
      ->setDescription('DATA PEGAWAI KECAMATAN KOTING')
      ->setKeywords('DATA PEGAWAI KECAMATAN KOTING')
      ->setCategory('Data');
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setCellValue('A1', 'No');
    $sheet->setCellValue('B1', 'Nama');
    $sheet->setCellValue('C1', 'NIP');
    $sheet->setCellValue('D1', 'Pangkat/Gol Ruang');
    $sheet->setCellValue('E1', 'Jabatan');
    $row = 2;
    $no = 1;
    while ($row_data = mysqli_fetch_assoc($result)) {
      $sheet->setCellValue('A' . $row, $no);
      $sheet->setCellValue('B' . $row, $row_data['nama']);
      $sheet->setCellValue('C' . $row, $row_data['nip']);
      $sheet->setCellValue('D' . $row, $row_data['nama_pangkat']);
      $sheet->setCellValue('E' . $row, $row_data['nama_jabatan']);
      $row++;
      $no++;
    }
    foreach (range('A', 'E') as $column) {
      $sheet->getColumnDimension($column)->setAutoSize(true);
    }
    $writer = new PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
    $filename = 'data_pegawai_kecamatan_koting.xlsx';
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');
    $writer->save('php://output');
    exit;
  }

  function pegawai($conn, $data, $action)
  {
    if ($action == "insert") {
      $checkEmail = "SELECT * FROM users WHERE email='$data[email]'";
      $checkEmail = mysqli_query($conn, $checkEmail);
      if (mysqli_num_rows($checkEmail) > 0) {
        $message = "Maaf, email yang anda masukan sudah terdaftar.";
        $message_type = "danger";
        alert($message, $message_type);
        return false;
      } else {
        $password = password_hash($data['nip'], PASSWORD_DEFAULT);
        $token = generateToken();
        $en_user = password_hash($token, PASSWORD_DEFAULT);
        $en_user = str_replace("$", "", $en_user);
        $en_user = str_replace("/", "", $en_user);
        $en_user = str_replace(".", "", $en_user);
        $sql = "INSERT INTO users(id_role,id_active,en_user,token,name,email,password) VALUES('3','1','$en_user','$token','$data[nama]','$data[email]','$password');";
        $sql .= "INSERT INTO pegawai(nama,nip,id_pangkat,id_jabatan) VALUES('$data[nama]','$data[nip]','$data[id_pangkat]','$data[id_jabatan]');";
        if (mysqli_multi_query($conn, $sql)) {
          $to       = $data['email'];
          $subject  = "Pembuatan Akun Pegawai Berhasil - Penggajian Pegawai";
          $message  = "<!doctype html>
          <html>
            <head>
                <meta name='viewport' content='width=device-width'>
                <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
                <title>Pembuatan Akun Pegawai Berhasil</title>
                <style>
                    @media only screen and (max-width: 620px) {
                        table[class='body'] h1 {
                            font-size: 28px !important;
                            margin-bottom: 10px !important;}
                        table[class='body'] p,
                        table[class='body'] ul,
                        table[class='body'] ol,
                        table[class='body'] td,
                        table[class='body'] span,
                        table[class='body'] a {
                            font-size: 16px !important;}
                        table[class='body'] .wrapper,
                        table[class='body'] .article {
                            padding: 10px !important;}
                        table[class='body'] .content {
                            padding: 0 !important;}
                        table[class='body'] .container {
                            padding: 0 !important;
                            width: 100% !important;}
                        table[class='body'] .main {
                            border-left-width: 0 !important;
                            border-radius: 0 !important;
                            border-right-width: 0 !important;}
                        table[class='body'] .btn table {
                            width: 100% !important;}
                        table[class='body'] .btn a {
                            width: 100% !important;}
                        table[class='body'] .img-responsive {
                            height: auto !important;
                            max-width: 100% !important;
                            width: auto !important;}}
                    @media all {
                        .ExternalClass {
                            width: 100%;}
                        .ExternalClass,
                        .ExternalClass p,
                        .ExternalClass span,
                        .ExternalClass font,
                        .ExternalClass td,
                        .ExternalClass div {
                            line-height: 100%;}
                        .apple-link a {
                            color: inherit !important;
                            font-family: inherit !important;
                            font-size: inherit !important;
                            font-weight: inherit !important;
                            line-height: inherit !important;
                            text-decoration: none !important;
                        .btn-primary table td:hover {
                            background-color: #d5075d !important;}
                        .btn-primary a:hover {
                            background-color: #000 !important;
                            border-color: #000 !important;
                            color: #fff !important;}}
                </style>
            </head>
            <body class style='background-color: #e1e3e5; font-family: sans-serif; -webkit-font-smoothing: antialiased; font-size: 14px; line-height: 1.4; margin: 0; padding: 0; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;'>
                <table role='presentation' border='0' cellpadding='0' cellspacing='0' class='body' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; background-color: #e1e3e5; width: 100%;' width='100%' bgcolor='#e1e3e5'>
                <tr>
                    <td style='font-family: sans-serif; font-size: 14px; vertical-align: top;' valign='top'>&nbsp;</td>
                    <td class='container' style='font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; max-width: 580px; padding: 10px; width: 580px; margin: 0 auto;' width='580' valign='top'>
                    <div class='content' style='box-sizing: border-box; display: block; margin: 0 auto; max-width: 580px; padding: 10px;'>
            
                        <!-- START CENTERED WHITE CONTAINER -->
                        <table role='presentation' class='main' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; background: #ffffff; border-radius: 3px; width: 100%;' width='100%'>
            
                        <!-- START MAIN CONTENT AREA -->
                        <tr>
                            <td class='wrapper' style='font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;' valign='top'>
                            <table role='presentation' border='0' cellpadding='0' cellspacing='0' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; width: 100%;' width='100%'>
                                <tr>
                                <td style='font-family: sans-serif; font-size: 14px; vertical-align: top;' valign='top'>
                                    <p style='font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;'>Hi " . $data['nama'] . ",</p>
                                    <p style='font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;'>Selamat akun kamu sudah terdaftar, berikut detail mengenai akun kamu:</p>
                                    <table role='presentation' border='0' cellpadding='0' cellspacing='0' class='btn btn-primary' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; box-sizing: border-box; min-width: 100%; width: 100%;' width='100%'>
                                    <tbody>
                                        <tr>
                                        <td align='left' style='font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px;' valign='top'>
                                            <table role='presentation' border='0' cellpadding='0' cellspacing='0' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: auto; width: auto;'>
                                            <tbody>
                                                <tr>
                                                  <td style='font-family: sans-serif; font-size: 14px; vertical-align: top; background-color: #ffffff; border-radius: 5px; text-align: center;' valign='top' bgcolor='#ffffff' align='center'>Email/NIP : </td>
                                                  <td style='font-family: sans-serif; font-size: 14px; vertical-align: top; background-color: #ffffff; border-radius: 5px; font-weight: bold;' valign='top' bgcolor='#ffffff'>" . $data['email'] . " / " . $data['nip'] . "</td>
                                                </tr>
                                                <tr>
                                                  <td style='font-family: sans-serif; font-size: 14px; vertical-align: top; background-color: #ffffff; border-radius: 5px; text-align: center;' valign='top' bgcolor='#ffffff' align='center'>Password : </td>
                                                  <td style='font-family: sans-serif; font-size: 14px; vertical-align: top; background-color: #ffffff; border-radius: 5px; font-weight: bold;' valign='top' bgcolor='#ffffff'>" . $data['nip'] . "</td>
                                                </tr>
                                            </tbody>
                                            </table>
                                        </td>
                                        </tr>
                                    </tbody>
                                    </table>
                                    <p style='font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;'>Terima kasih telah mendaftar di Penggajian Pegawai.</p>
                                    <small>Peringatan! Ini adalah pesan otomatis sehingga Anda tidak dapat membalas pesan ini.</small>
                                </td>
                                </tr>
                            </table>
                            </td>
                        </tr>
            
                        <!-- END MAIN CONTENT AREA -->
                        </table>
                        
                        <!-- START FOOTER -->
                        <div class='footer' style='clear: both; margin-top: 10px; text-align: center; width: 100%;'>
                        <table role='presentation' border='0' cellpadding='0' cellspacing='0' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; width: 100%;' width='100%'>
                            <tr>
                            <td class='content-block' style='font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; color: #9a9ea6; font-size: 12px; text-align: center;' valign='top' align='center'>
                                <span class='apple-link' style='color: #9a9ea6; font-size: 12px; text-align: center;'>Workarea Jln. S. K. Lerik, Kota Baru, Kupang, NTT, Indonesia. (0380) 8438423</span>
                            </td>
                            </tr>
                            <tr>
                            <td class='content-block powered-by' style='font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; color: #9a9ea6; font-size: 12px; text-align: center;' valign='top' align='center'>
                                Powered by <a href='https://www.netmedia-framecode.com' style='color: #9a9ea6; font-size: 12px; text-align: center; text-decoration: none;'>Netmedia Framecode</a>.
                            </td>
                            </tr>
                        </table>
                        </div>
                        <!-- END FOOTER -->
            
                    <!-- END CENTERED WHITE CONTAINER -->
                    </div>
                    </td>
                    <td style='font-family: sans-serif; font-size: 14px; vertical-align: top;' valign='top'>&nbsp;</td>
                </tr>
                </table>
            </body>
          </html>";
          smtp_mail($to, $subject, $message, "", "", 0, 0, true);
        } else {
          $message = "Gagal mengeksekusi permintaan anda!. Error: " . mysqli_error($conn);
          $message_type = "danger";
          alert($message, $message_type);
          return false;
        }
      }
    }

    if ($action == "update") {
      $sql = "UPDATE pegawai SET nama='$data[nama]', nip='$data[nip]', id_pangkat='$data[id_pangkat]', id_jabatan='$data[id_jabatan]' WHERE id_pegawai='$data[id_pegawai]'";
      mysqli_query($conn, $sql);
    }

    if ($action == "delete") {
      $sql = "DELETE FROM pegawai WHERE id_pegawai='$data[id_pegawai]';";
      $sql .= "DELETE FROM users WHERE nama='$data[nama]';";
      mysqli_multi_query($conn, $sql);
    }

    if ($action == "export") {
      if ($data['format_file'] === "pdf") {
        exportPegawaiToPDF($conn);
      } else if ($data['format_file'] === "excel") {
        exportPegawaiToExcel($conn);
      }
    }

    return mysqli_affected_rows($conn);
  }

  function waktu_absensi($conn, $data, $action)
  {
    if ($action == "insert") {
      $sql = "INSERT INTO waktu_absensi(waktu_masuk,waktu_pulang) VALUES('$data[waktu_masuk]','$data[waktu_pulang]')";
    }

    if ($action == "update") {
      $sql = "UPDATE waktu_absensi SET waktu_masuk='$data[waktu_masuk]', waktu_pulang='$data[waktu_pulang]' WHERE id_waktu_absensi='$data[id_waktu_absensi]'";
    }

    mysqli_query($conn, $sql);
    return mysqli_affected_rows($conn);
  }

  function radius_absen($conn, $data, $action)
  {
    if ($action == "insert") {
      $sql = "INSERT INTO radius_absen(radius,latitude,longitude) VALUES('$data[radius]','$data[latitude]','$data[longitude]')";
    }

    if ($action == "update") {
      $sql = "UPDATE radius_absen SET radius='$data[radius]', latitude='$data[latitude]', longitude='$data[longitude]' WHERE id_radius='$data[id_radius]'";
    }

    mysqli_query($conn, $sql);
    return mysqli_affected_rows($conn);
  }

  function getOfficeRadius($conn)
  {
    $sql = "SELECT radius, latitude, longitude FROM radius_absen WHERE id_radius = 1";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($result);
  }

  function haversine($lat1, $lon1, $lat2, $lon2)
  {
    $earthRadius = 6371000;
    $dLat = deg2rad($lat2 - $lat1);
    $dLon = deg2rad($lon2 - $lon1);
    $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon / 2) * sin($dLon / 2);
    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
    return $earthRadius * $c;
  }

  function checkLocation($latitude, $longitude, $officeLatitude, $officeLongitude, $radius)
  {
    $distance = haversine($latitude, $longitude, $officeLatitude, $officeLongitude);
    return $distance <= $radius;
  }

  function getOfficeHours($conn)
  {
    $sql = "SELECT waktu_masuk, waktu_pulang FROM waktu_absensi WHERE id_waktu_absensi = 1";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($result);
  }

  function checkAttendanceStatus($data, $officeHours)
  {
    $waktuMasuk = new DateTime($data['waktu_masuk']);
    $waktuPulang = new DateTime($data['waktu_pulang']);
    $expectedMasuk = new DateTime($officeHours['waktu_masuk']);
    $expectedPulang = new DateTime($officeHours['waktu_pulang']);

    if ($waktuMasuk < $expectedMasuk) {
      return 'Datang awal';
    } elseif ($waktuPulang > $expectedPulang) {
      return 'Pulang terlambat';
    } else {
      return 'Hadir';
    }
  }

  function absensi($conn, $data, $latitude, $longitude, $action)
  {
    if ($action == "insert") {
      $officeRadius = getOfficeRadius($conn);
      // $radius = $officeRadius['radius'];
      $radius = "500"; // testing loc
      // $officeLatitude = $officeRadius['latitude'];
      $officeLatitude = "-10.1727953"; // testing loc
      // $officeLongitude = $officeRadius['longitude'];
      $officeLongitude = "123.6083928"; // testing loc
      $isInRange = checkLocation($latitude, $longitude, $officeLatitude, $officeLongitude, $radius);
      if (!$isInRange) {
        $message = "Gagal absen: Anda berada di luar jangkauan radius kantor.";
        $message_type = "danger";
        alert($message, $message_type);
        return false;
      }
      $officeHours = getOfficeHours($conn);
      $statusAbsensi = checkAttendanceStatus($data, $officeHours);
      $sql = "INSERT INTO absensi(id_pegawai, waktu_masuk, waktu_pulang, status_absensi) VALUES('$data[id_pegawai]', '$data[waktu_masuk]', '$data[waktu_pulang]', '$statusAbsensi')";
    }

    if ($action == "delete") {
      $sql = "DELETE FROM absensi WHERE id_absensi='$data[id_absensi]'";
    }

    mysqli_query($conn, $sql);
    return mysqli_affected_rows($conn);
  }

  function exportTPPToPDF($conn)
  {
    $query = "SELECT tpp.*, pegawai.nama, jabatan_pegawai.nama_jabatan 
      FROM tpp 
      JOIN pegawai ON tpp.id_pegawai=pegawai.id_pegawai 
      JOIN jabatan_pegawai ON pegawai.id_jabatan=jabatan_pegawai.id_jabatan 
      ORDER BY tpp.id_tpp DESC";
    $result = mysqli_query($conn, $query);
    $mpdf = new \Mpdf\Mpdf();
    $html = '<h5 style="text-align: center;">DAFTAR TPP <br>BULAN ' . date('M') . ' TAHUN ' . date('Y') . '</h5>';
    $html .= '<table border="1" cellspacing="0" cellpadding="5" style="width: 100%;">
                <tr>
                <th rowspan="4">Nama Pejabat / Pegawai</th>
                <th rowspan="4">Jabatan</th>
                <th rowspan="4">Kelas Jabatan</th>
                <th rowspan="4">Besaran TPP</th>
                <th colspan="4">Komponen Produktifitas Kerja</th>
                <th colspan="4">Komponen Disiplin Kerja</th>
                <th>Jumlah TPP</th>
                <th colspan="8">Komponen Pengurangan Aspek</th>
                <th>Jumlah TPP</th>
                <th rowspan="4">Pasal 21</th>
                <th rowspan="4">Jumlah TPP Setelah Pajak (Rp)</th>
              </tr>
              <tr>
                <th rowspan="3">Besaran (Rp)</th>
                <th colspan="2">Pengurangan (Rp)</th>
                <th rowspan="3">Jumlah (Rp)</th>
                <th rowspan="3">Besaran (Rp)</th>
                <th colspan="2">Pengurangan (Rp)</th>
                <th rowspan="3">Jumlah (Rp)</th>
                <th>Sblm Pengurangan</th>
                <th colspan="2">Laporan Gratifikasi</th>
                <th colspan="2">Ketepatan Waktu</th>
                <th colspan="2">TPTGR</th>
                <th colspan="2">JHKPN</th>
                <th>Sebelum Pajak</th>
              </tr>
              <tr>
                <th rowspan="2">Persen</th>
                <th rowspan="2">Nilai</th>
                <th rowspan="2">Persen</th>
                <th rowspan="2">Nilai</th>
                <th rowspan="2">Aspek Lainnya</th>
                <th rowspan="2">Persen</th>
                <th rowspan="2">Nilai</th>
                <th colspan="2">Pengembalian</th>
                <th rowspan="2">Persen</th>
                <th rowspan="2">Nilai</th>
                <th rowspan="2">Persen</th>
                <th rowspan="2">Nilai</th>
                <th rowspan="2">PPh</th>
              </tr>
              <tr>
                <th>Persen</th>
                <th>Nilai</th>
              </tr>';
    $no = 1;
    while ($row = mysqli_fetch_assoc($result)) {
      $html .= '<tr>
                    <td>' . $row['nama'] . '</td>
                    <td>' . $row['nama_jabatan'] . '</td>
                    <td>' . $row['kelas_jabatan'] . '</td>
                    <td>Rp.' . number_format($row['besaran_tpp_kpk']) . '</td>
                    <td>Rp.' . number_format($row['besaran_kpk']) . '</td>
                    <td>' . $row['persen_kpk'] . '%</td>
                    <td>Rp.' . $row['nilai_kpk'] . '</td>
                    <td>Rp.' . number_format($row['jumlah_kpk']) . '</td>
                    <td>Rp.' . number_format($row['besaran_kdk']) . '</td>
                    <td>' . $row['persen_kdk'] . '%</td>
                    <td>Rp.' . number_format($row['nilai_kdk']) . '</td>
                    <td>Rp.' . number_format($row['jumlah_kdk']) . '</td>
                    <td>Rp.' . number_format($row['jumlah_tpp_sblm_kpal']) . '</td>
                    <td>' . $row['persen_lap_gratifikasi'] . '%</td>
                    <td>Rp.' . number_format($row['nilai_lap_gratifikasi']) . '</td>
                    <td>' . $row['persen_pengembalian_bmd'] . '%</td>
                    <td>Rp.' . number_format($row['nilai_pengembalian_bmd']) . '</td>
                    <td>' . $row['persen_tptgr'] . '%</td>
                    <td>Rp.' . number_format($row['nilai_tptgr']) . '</td>
                    <td>' . $row['persen_jhkpn'] . '%</td>
                    <td>Rp.' . number_format($row['nilai_jhkpn']) . '</td>
                    <td>Rp.' . number_format($row['jumlah_tpp_sblm_pajak']) . '</td>
                    <td>Rp.' . number_format($row['pasal_21']) . '</td>
                    <td>Rp.' . number_format($row['jumlah_tpp_setelah_pajak']) . '</td>
                 </tr>';
    }
    $html .= '</table>';
    $mpdf->WriteHTML($html);
    $mpdf->Output('daftar_tpp_bulan_' . date('M') . '_tahun_' . date('Y') . '.pdf', 'D');
  }

  function tpp($conn, $data, $action)
  {
    if ($action == "insert") {
      $sql = "INSERT INTO tpp(
        id_pegawai,
        kelas_jabatan,
        besaran_tpp_kpk,
        besaran_kpk,
        persen_kpk,
        nilai_kpk,
        jumlah_kpk,
        besaran_kdk,
        persen_kdk,
        nilai_kdk,
        jumlah_kdk,
        jumlah_tpp_sblm_kpal,
        persen_lap_gratifikasi,
        nilai_lap_gratifikasi,
        persen_pengembalian_bmd,
        nilai_pengembalian_bmd,
        persen_tptgr,
        nilai_tptgr,
        persen_jhkpn,
        nilai_jhkpn,
        jumlah_tpp_sblm_pajak,
        pasal_21,
        jumlah_tpp_setelah_pajak
      ) VALUES(
        '$data[id_pegawai]',
        '$data[kelas_jabatan]',
        '$data[besaran_tpp_kpk]',
        '$data[besaran_kpk]',
        '$data[persen_kpk]',
        '$data[nilai_kpk]',
        '$data[jumlah_kpk]',
        '$data[besaran_kdk]',
        '$data[persen_kdk]',
        '$data[nilai_kdk]',
        '$data[jumlah_kdk]',
        '$data[jumlah_tpp_sblm_kpal]',
        '$data[persen_lap_gratifikasi]',
        '$data[nilai_lap_gratifikasi]',
        '$data[persen_pengembalian_bmd]',
        '$data[nilai_pengembalian_bmd]',
        '$data[persen_tptgr]',
        '$data[nilai_tptgr]',
        '$data[persen_jhkpn]',
        '$data[nilai_jhkpn]',
        '$data[jumlah_tpp_sblm_pajak]',
        '$data[pasal_21]',
        '$data[jumlah_tpp_setelah_pajak]'
      )";
    }

    if ($action == "update") {
      $sql = "UPDATE tpp 
        SET id_pegawai='$data[id_pegawai]',
        kelas_jabatan='$data[kelas_jabatan]',
        besaran_tpp_kpk='$data[besaran_tpp_kpk]',
        besaran_kpk='$data[besaran_kpk]',
        persen_kpk='$data[persen_kpk]',
        nilai_kpk='$data[nilai_kpk]',
        jumlah_kpk='$data[jumlah_kpk]',
        besaran_kdk='$data[besaran_kdk]',
        persen_kdk='$data[persen_kdk]',
        nilai_kdk='$data[nilai_kdk]',
        jumlah_kdk='$data[jumlah_kdk]',
        jumlah_tpp_sblm_kpal='$data[jumlah_tpp_sblm_kpal]',
        persen_lap_gratifikasi='$data[persen_lap_gratifikasi]',
        nilai_lap_gratifikasi='$data[nilai_lap_gratifikasi]',
        persen_pengembalian_bmd='$data[persen_pengembalian_bmd]',
        nilai_pengembalian_bmd='$data[nilai_pengembalian_bmd]',
        persen_tptgr='$data[persen_tptgr]',
        nilai_tptgr='$data[nilai_tptgr]',
        persen_jhkpn='$data[persen_jhkpn]',
        nilai_jhkpn='$data[nilai_jhkpn]',
        jumlah_tpp_sblm_pajak='$data[jumlah_tpp_sblm_pajak]',
        pasal_21='$data[pasal_21]',
        jumlah_tpp_setelah_pajak='$data[jumlah_tpp_setelah_pajak]'
        WHERE id_tpp='$data[id_tpp]'";
    }

    if ($action == "delete") {
      $sql = "DELETE FROM tpp WHERE id_tpp='$data[id_tpp]'";
    }

    if ($action == "export") {
      if ($data['format_file'] === "pdf") {
        exportTPPToPDF($conn);
      }
    }

    mysqli_query($conn, $sql);
    return mysqli_affected_rows($conn);
  }

  function golongan_pegawai($conn, $data, $action)
  {
    if ($action == "update") {
      $sql = "UPDATE golongan_pegawai SET upah_golongan='$data[upah_golongan]' WHERE id_golongan='$data[id_golongan]';";
    }

    mysqli_query($conn, $sql);
    return mysqli_affected_rows($conn);
  }

  function tunjangan_pegawai($conn, $data, $action)
  {
    if ($action == "insert") {
      $sql = "INSERT INTO tunjangan_pegawai(nama_tunjangan,upah_tunjangan) VALUES('$data[nama_tunjangan]','$data[upah_tunjangan]')";
    }

    if ($action == "update") {
      $sql = "UPDATE tunjangan_pegawai SET nama_tunjangan='$data[nama_tunjangan]', upah_tunjangan='$data[upah_tunjangan]' WHERE id_tunjangan='$data[id_tunjangan]'";
    }

    if ($action == "delete") {
      $sql = "DELETE FROM tunjangan_pegawai WHERE id_tunjangan='$data[id_tunjangan]'";
    }

    mysqli_query($conn, $sql);
    return mysqli_affected_rows($conn);
  }

  function hitungPendapatanBersih($gajiPokok, $tunjanganArray, $potonganArray, $totalKehadiran, $hariKerja)
  {
    $totalTunjangan = is_array($tunjanganArray) ? array_sum($tunjanganArray) : 0;
    $totalPotongan = is_array($potonganArray) ? array_sum($potonganArray) : 0;
    $absensi = ($totalKehadiran / $hariKerja) * 100;
    $gajiPokokAbsensi = $gajiPokok * ($absensi / 100);
    $pendapatanBersih = ($gajiPokokAbsensi + $totalTunjangan) - $totalPotongan;
    return $pendapatanBersih;
  }

  function hitungHariKerja($bulan, $tahun)
  {
    $totalHari = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
    $hariKerja = 0;
    for ($i = 1; $i <= $totalHari; $i++) {
      $tanggal = sprintf('%04d-%02d-%02d', $tahun, $bulan, $i);
      $hariDalamMinggu = date('N', strtotime($tanggal));
      if ($hariDalamMinggu < 6) {
        $hariKerja++;
      }
    }
    return $hariKerja;
  }

  function rekap_gaji($conn, $data, $action)
  {
    if ($action == "insert") {
      // Ambil ID terakhir dari rekap_gaji dan increment
      $checkID = "SELECT id_rekap_gaji FROM rekap_gaji ORDER BY id_rekap_gaji DESC LIMIT 1";
      $checkIDResult = mysqli_query($conn, $checkID);
      if (mysqli_num_rows($checkIDResult) > 0) {
        $dataID = mysqli_fetch_assoc($checkIDResult);
        $id_rekap_gaji = $dataID['id_rekap_gaji'] + 1;
      } else {
        $id_rekap_gaji = 1;
      }

      // Insert ke rekap_gaji
      $sql = "INSERT INTO rekap_gaji(id_rekap_gaji, id_pegawai, gaji) VALUES('$id_rekap_gaji', '$data[id_pegawai]', '$data[upah_golongan]')";
      mysqli_query($conn, $sql);

      // Proses tunjangan
      $jumlah_bruto = 0;
      if (!empty($data['id_tunjangan']) && is_array($data['id_tunjangan'])) {
        $tunjangan = $data['id_tunjangan'];
        foreach ($tunjangan as $id_tunjangan) {
          $sql_tunjangan = "INSERT INTO rekap_gaji_tunj(id_rekap_gaji, id_tunjangan) VALUES('$id_rekap_gaji', '$id_tunjangan')";
          mysqli_query($conn, $sql_tunjangan);
        }

        $upah_tunjangan = $data['upah_tunjangan'];
        foreach ($upah_tunjangan as $upah) {
          $jumlah_bruto += $upah;
        }
      }

      // Proses potongan
      $jumlah_potongan = 0;
      if (!empty($data['id_potongan']) && is_array($data['id_potongan']) && !empty($data['upah_potongan']) && is_array($data['upah_potongan'])) {
        $potongan = $data['id_potongan'];
        $upahPotongan = $data['upah_potongan'];

        foreach ($potongan as $index => $id_potongan) {
          // Pastikan indeks yang ada di kedua array adalah valid
          if (isset($upahPotongan[$index])) {
            $upah_dipotong = $upahPotongan[$index];

            $sql_potongan = "INSERT INTO rekap_gaji_potongan(id_rekap_gaji, id_potongan, upah_dipotong) VALUES('$id_rekap_gaji', '$id_potongan', '$upah_dipotong')";
            mysqli_query($conn, $sql_potongan);

            $jumlah_potongan += $upah_dipotong;
          }
        }
      }


      // Hitung absensi
      $bulanSaatIni = date('n');
      $tahunSaatIni = date('Y');
      $check_absensi = "SELECT * FROM absensi WHERE id_pegawai='$data[id_pegawai]' AND MONTH(created_at) = '$bulanSaatIni' AND YEAR(created_at) = '$tahunSaatIni'";
      $view_absensi = mysqli_query($conn, $check_absensi);
      $total_absensi = mysqli_num_rows($view_absensi);

      $total_hari_kerja = hitungHariKerja($bulanSaatIni, $tahunSaatIni);
      $presentasi_absensi = number_format(($total_absensi / $total_hari_kerja) * 100, 2);

      // Hitung pendapatan bersih
      $jumlah_dibayarkan = hitungPendapatanBersih($data['upah_golongan'], $jumlah_bruto, $jumlah_potongan, $total_absensi, $total_hari_kerja);

      // Update rekap_gaji dengan informasi tambahan
      $sql_update_rekap_gaji = "UPDATE rekap_gaji SET total_absensi='$total_absensi', presentasi_absensi='$presentasi_absensi', total_hari_kerja='$total_hari_kerja', jumlah_bruto='$jumlah_bruto', jumlah_potongan='$jumlah_potongan', jumlah_dibayarkan='$jumlah_dibayarkan' WHERE id_rekap_gaji='$id_rekap_gaji'";
      mysqli_query($conn, $sql_update_rekap_gaji);
    }


    if ($action == "delete") {
      $sql = "DELETE FROM rekap_gaji WHERE id_rekap_gaji='$data[id_rekap_gaji]'";
      mysqli_query($conn, $sql);
    }

    return mysqli_affected_rows($conn);
  }

  function exportRekapGajiToPDF($conn, $id_rekap_gaji)
  {
    $query = "SELECT rekap_gaji.*, pegawai.nama, pegawai.nip, pangkat_pegawai.nama_pangkat, jabatan_pegawai.nama_jabatan 
      FROM rekap_gaji 
      JOIN pegawai ON rekap_gaji.id_pegawai = pegawai.id_pegawai
      JOIN pangkat_pegawai ON pegawai.id_pangkat = pangkat_pegawai.id_pangkat
      JOIN jabatan_pegawai ON pegawai.id_jabatan = jabatan_pegawai.id_jabatan
      WHERE rekap_gaji.id_rekap_gaji = '$id_rekap_gaji'";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);
    $mpdf = new \Mpdf\Mpdf();
    $html = '<p style="text-align: center; text-decoration: underline;"><b>SURAT KETERANGAN PERINCIAN GAJI<b></p>';
    $html .= '<p style="text-align: center;"><b>UNTUK BULAN ' . strtoupper(date('M Y')) . '<b></p>';
    $html .= '<table style="border-collapse: collapse; width: 100%; margin: auto;">
    <tbody>
      <tr>
        <td style="width: 150px; ">Nama</td>
        <td style="width: 10px; ">:</td>
        <td>' . $data['nama'] . '</td>
      </tr>
      <tr>
        <td>NIP</td>
        <td>:</td>
        <td>' . $data['nip'] . '</td>
      </tr>
      <tr>
        <td>Pangkat / Golongan</td>
        <td>:</td>
        <td>' . $data['nama_pangkat'] . '</td>
      </tr>
      <tr>
        <td>Jabatan</td>
        <td>:</td>
        <td>' . $data['nama_jabatan'] . '</td>
      </tr>
    </tbody>
    </table>';
    $html .= '<p style="text-align: left;margin-top: 50px;"><b>PERINCIAN : <b></p>';
    $html .= '<table style="border-collapse: collapse; width: 100%; margin: auto;">
    <tbody>
      <tr>
        <th style="width: 250px; text-align: left;">Total Kehadiran</th>
        <td style="width: 10px; ">:</td>
        <td>' . $data['total_absensi'] . ' hari</td>
      </tr>
      <tr>
        <th style="width: 250px; text-align: left;">Total Hari Kerja</th>
        <td style="width: 10px; ">:</td>
        <td>' . $data['total_hari_kerja'] . ' hari</td>
      </tr>
      <tr>
        <th style="width: 250px; text-align: left;" colspan="3">Penghasilan :</th>
      </tr>
      <tr>
        <td style="width: 250px; ">Gaji Pokok</td>
        <td style="width: 10px; ">:</td>
        <td>Rp.' . number_format($data['gaji']) . '</td>
      </tr>';
    $id_rekap_gaji = $data['id_rekap_gaji'];
    $rekap_gaji_tunj = "SELECT * FROM rekap_gaji_tunj JOIN tunjangan_pegawai ON rekap_gaji_tunj.id_tunjangan=tunjangan_pegawai.id_tunjangan WHERE rekap_gaji_tunj.id_rekap_gaji='$id_rekap_gaji'";
    $views_rekap_gaji_tunj = mysqli_query($conn, $rekap_gaji_tunj);
    $total_tunjangan = 0;
    if (mysqli_num_rows($views_rekap_gaji_tunj) > 0) {
      while ($data_rgt = mysqli_fetch_assoc($views_rekap_gaji_tunj)) {
        $html .= '<tr>
        <td>' . $data_rgt['nama_tunjangan'] . '</td>
        <td>:</td>
        <td>Rp.' . number_format($data_rgt['upah_tunjangan']) . '</td>
      </tr>';
      }
    }
    $html .= '<tr>
        <th style="width: 250px; ">Jumlah</th>
        <th style="width: 10px; ">:</th>
        <th style="text-align: left;">Rp.' . number_format($data['jumlah_bruto']) . '</th>
      </tr></tbody>
    </table>';
    $html .= '<table style="border-collapse: collapse; width: 100%; margin: auto;">
    <tbody>
    <tr>
      <th style="width: 250px;text-align: left;" colspan="3">Potongan :</th>
    </tr>';
    $rekap_gaji_potongan = "SELECT * FROM rekap_gaji_potongan JOIN potongan_pegawai ON rekap_gaji_potongan.id_potongan=potongan_pegawai.id_potongan WHERE rekap_gaji_potongan.id_rekap_gaji='$id_rekap_gaji'";
    $views_rekap_gaji_potongan = mysqli_query($conn, $rekap_gaji_potongan);
    $total_potongan = 0;
    if (mysqli_num_rows($views_rekap_gaji_potongan) > 0) {
      while ($data_rgp = mysqli_fetch_assoc($views_rekap_gaji_potongan)) {
        $html .= '<tr>
      <td>' . $data_rgp['nama_potongan'] . '</td>
      <td>:</td>
      <td>Rp.' . number_format($data_rgp['upah_potongan']) . '</td>
    </tr>';
      }
    }
    $html .= '<tr>
        <th style="width: 250px; ">Jumlah</th>
        <th style="width: 10px; ">:</th>
        <th style="text-align: left;">Rp.' . number_format($data['jumlah_potongan']) . '</th>
      </tr>
      <tr>
        <th style="width: 250px; ">Jumlah yang Dibayarkan</th>
        <th style="width: 10px; ">:</th>
        <th style="text-align: left;">Rp.' . number_format($data['jumlah_dibayarkan']) . '</th>
      </tr></tbody>
    </table>';
    $html .= '<div style="width: 300px; margin-top: 20px; float: right; text-align: right;">
      <p style="text-align: center;">Kec. Koting, ' . date("d M Y") . '</p>
      <p style="text-align: center; padding-top: -15px;">Sekretariat</p>
      <h4 style="padding-top: 50px; text-decoration: underline; text-align: center;"></h4>
    </div>';
    $mpdf->WriteHTML($html);
    $mpdf->Output('rekap_gaji_' . $data['nama'] . '.pdf', 'D');
  }

  function cetak_gaji($conn, $data, $action)
  {
    if ($action == "unduh") {
      $id_rekap_gaji = $data['id_rekap_gaji'];
      exportRekapGajiToPDF($conn, $id_rekap_gaji);
    }

    return mysqli_affected_rows($conn);
  }

  function potongan_pegawai($conn, $data, $action)
  {
    if ($action == "insert") {
      $sql = "INSERT INTO potongan_pegawai(nama_potongan,upah_potongan) VALUES('$data[nama_potongan]','$data[upah_potongan]')";
    }

    if ($action == "update") {
      $sql = "UPDATE potongan_pegawai SET nama_potongan='$data[nama_potongan]', upah_potongan='$data[upah_potongan]' WHERE id_potongan='$data[id_potongan]'";
    }

    if ($action == "delete") {
      $sql = "DELETE FROM potongan_pegawai WHERE id_potongan='$data[id_potongan]'";
    }

    mysqli_query($conn, $sql);
    return mysqli_affected_rows($conn);
  }

  function __name($conn, $data, $action)
  {
    if ($action == "insert") {
    }

    if ($action == "update") {
    }

    if ($action == "delete") {
    }

    // mysqli_query($conn, $sql);
    return mysqli_affected_rows($conn);
  }
}
