<?php
session_start(); 
?>
<!DOCTYPE html>
<html>
    <head>
        <title>QR Generator</title>
        <link rel="shortcut icon" href="" />
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <style>
            body {
                display: flex;
                min-height: 100vh;
                flex-direction: column;
            }
            main {
                flex: 1;
            }
        </style>
    
    </head>
    <body>
        <main>
            <h1 class="text-center">QR Generator</h1>
            <br>
            <div class="container">
                <div class="card">
                    <div class="card-header">Instruction</div>
                    <div class="card-body">
                        Please choose your 3D structure files (i.e. '*.xyz') and then click <b>Upload</b> button.
                        The QR code will be automatically generated. Right click to save.
                        <ul>Note:
                            <li>Only files in the following format(s) are allowed: *.xyz</li>
                            <li>Files larger than 5MB are not allowed.</li>
                            <li>QR code image is in .svg format for easy scaling.</li>
                        </ul>
                    </div>
                </div>
            </div>
            <br>

            <div class="container">
                <form method="POST" action="upload.php" enctype="multipart/form-data">
                    <!-- <p>Upload a structure file: </p> -->
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroupFileAppendText01">Upload a structure file: </span>
                        </div>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="inputGroupFileAddon01" name="uploadedFile">
                            <label class="custom-file-label" for="inputGroupFileAddon01" aria-describedby="inputGroupFileAddon01">Choose file</label>
                        </div>
                    </div>
                    <br>

                    <div class="d-flex justify-content-center">
                        <input type="submit" name="uploadBtn" value="Upload" class="btn btn-danger"/>
                    </div>
                </form>
            </div>
            <br>

            <div class="container text-center bg-light">
                <?php
                    if (isset($_SESSION['message']) && $_SESSION['message'])
                    {
                        printf('<p><b>%s</b></p><br>', $_SESSION['message']);
                        unset($_SESSION['message']);
                    }

                    if (isset($_SESSION['file']) && $_SESSION['file']) {
                        $fileName = $_SESSION['file'];
                        // Remove filename extension: https://stackoverflow.com/a/55624126/6596203
                        $fileNameWithoutExtension = pathinfo($fileName, PATHINFO_FILENAME);
                        // Add your address full url address for the 3D viewer here:
                        $viewerUrl = '3dviewer.html?file=' . $fileNameWithoutExtension;

                        // urlencode the data first before sending for request.
                        $encodedUrl = urlencode($viewerUrl);
                        $qrApiUrl = 'https://api.qrserver.com/v1/create-qr-code/?data=' . $encodedUrl . '&size=200x200&format=svg';

                        // Use .svg scale so that it can be scaled up without pixelation
                        $imageName = $fileNameWithoutExtension . '.svg';

                        // Show the barcode on screen
                        echo "<p>
                                <a download='$imageName' href='$qrApiUrl' title='$imageName'>    
                                    <img src='$qrApiUrl' alt='' title='$imageName' />
                                </a>
                            </p>";

                        unset($_SESSION['file']);
                    }
                ?>                               
            </div>

            <br>
        </main>

        <footer class="my-4">
            <div class="container">
                <div class="container text-center">
                    Created by <b>Khoi Van</b> 2020.
                </div>
                <br>
                <div class="container small d-none d-md-block">
                    <div class="container">This page is enabled by:</div>

                    <!-- https://getbootstrap.com/docs/4.4/components/navs/#javascript-behavior -->
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="goqr-tab" data-toggle="tab" href="#goqr" role="tab" aria-controls="goqr" aria-selected="true">
                                QR Code Generator
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="3dmoljs-tab" data-toggle="tab" href="#threedmoljs" role="tab" aria-controls="3dmoljs" aria-selected="false">
                                Professor David Ryan Koes
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="goqr" role="tabpanel" aria-labelledby="goqr-tab">
                            <p>
                                Free 
                                <a href="http://goqr.me/">
                                    QR code generator 
                                </a>
                                with free API access.
                            </p>
                        </div>
                        <div class="tab-pane fade" id="threedmoljs" role="tabpanel" aria-labelledby="3dmoljs-tab">
                            <p>
                                <a href="http://bits.csb.pitt.edu/">
                                Professor David Ryan Koes, PhD
                                </a>
                                (University of Pittsburgh): creator of  
                                <a href="http://3dmol.csb.pitt.edu/">3DMol.js</a>
                                , a molecular visualization library for Web.
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </footer>

        <!-- To display input file: https://stackoverflow.com/a/43255741/6596203 -->
        <script>
            document.querySelector('.custom-file-input').addEventListener('change',function(e){
                var fileName = document.getElementById("inputGroupFileAddon01").files[0].name;
                var nextSibling = e.target.nextElementSibling
                nextSibling.innerText = fileName
            })
        </script>

        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    </body>
</html>
