<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = $_POST["email"];
  $file = $_FILES["file"];

  // Configure your email settings
  $to = "recipient@example.com";
  $subject = "File Upload";
  $message = "A file has been uploaded. Please find it attached.";

  // Attach the uploaded file
  $attachment = $file["tmp_name"];
  $attachment_name = $file["name"];

  // Set the email headers
  $headers = "From: sender@example.com\r\n";
  $headers .= "Reply-To: sender@example.com\r\n";
  $headers .= "MIME-Version: 1.0\r\n";
  $headers .= "Content-Type: multipart/mixed; boundary=\"boundary\"\r\n";

  // Build the email content
  $content = "--boundary\r\n";
  $content .= "Content-Type: text/plain; charset=\"iso-8859-1\"\r\n";
  $content .= "Content-Transfer-Encoding: 7bit\r\n";
  $content .= "$message\r\n";
  $content .= "--boundary\r\n";
  $content .= "Content-Type: application/octet-stream; name=\"$attachment_name\"\r\n";
  $content .= "Content-Transfer-Encoding: base64\r\n";
  $content .= "Content-Disposition: attachment\r\n";
  $content .= chunk_split(base64_encode(file_get_contents($attachment))) . "\r\n";
  $content .= "--boundary--";

  // Send the email
  if (mail($to, $subject, $content, $headers)) {
    echo "Email sent successfully.";
  } else {
    echo "Failed to send email.";
  }
}
?>
