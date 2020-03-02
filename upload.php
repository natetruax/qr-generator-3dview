<?php
session_start();

$message = ''; 
$file = '';    // Store the name of the uploaded file here
$error = [];  // Store errors here
if (isset($_POST['uploadBtn']) && $_POST['uploadBtn'] == 'Upload')
{
    if (isset($_FILES['uploadedFile']) && $_FILES['uploadedFile']['error'] === UPLOAD_ERR_OK)
    {
        // get details of the uploaded file
        $fileTmpPath = $_FILES['uploadedFile']['tmp_name'];
        $fileName = $_FILES['uploadedFile']['name'];
        $fileSize = $_FILES['uploadedFile']['size'];
        $fileType = $_FILES['uploadedFile']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // sanitize file-name
        // $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
        $newFileName = basename($fileName);

        // check if file has one of the following extensions
        // $allowedfileExtensions = array('jpg', 'gif', 'png', 'zip', 'txt', 'xls', 'doc', 'mol', 'xyz');
        $allowedfileExtensions = array('mol', 'xyz');

        if ($fileSize > 5000000) {
            $error[] = "File exceeds maximum size (5MB)";
        }

        if (in_array($fileExtension, $allowedfileExtensions))
        {
            // directory in which the uploaded file will be moved
            $uploadFileDir = './upload/structures/';

            $dest_path = $uploadFileDir . $newFileName;

            // // Check if file already exists
            // if (file_exists($dest_path)) {
            //     $error[] = "Sorry, file already exists.";
            // }

            // Continue if there is no error
            if (empty($error)) {
                if(move_uploaded_file($fileTmpPath, $dest_path)) 
                {
                    $message = "$newFileName is successfully uploaded.";
                    $file = $newFileName;
                }
                else 
                {
                    $message = 'There was some error moving the file to upload directory. Please make sure the upload directory is writable by web server.';
                }
            }

        }
        else
        {
        $message = 'Upload failed. Allowed file types: ' . implode(',', $allowedfileExtensions);
        }
    }
    else
    {
        $message = 'There is some error in the file upload. Please check the following error.<br>';
        $message .= 'Error:' . $_FILES['uploadedFile']['error'];
    }
}
$_SESSION['message'] = $message;
$_SESSION['file'] = $file;

header("Location: qrgenerator.php");