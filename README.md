## OVERVIEW

- This template is inspired by [QRChem](https://qrchem.net) by [Professor Neil Garg](https://garg.chem.ucla.edu/) and his QRChem team. However, this template allows users to upload their own structures and not just structures existing in Pubchem database.
- What this template is: This is a simple template for auto generation of QR code for uploaded molecules. This template does:
  1. Upload structural files to a pre-determined folder on server via http or https
  2. Generate a QR code to the 3D viewer (using [3DMol.js](http://3dmol.csb.pitt.edu/)) for the uploaded files
- What this template is **NOT**: it does not optimize (i.e. energy minimization) the structure input so the structures will need to be optimized before uploading.
<br/>

## CONTENT

- [OVERVIEW](#overview)
- [CONTENT](#content)
- [DEMO](#demo)
- [REQUIREMENTS](#requirements)
- [USAGE](#usage)
- [DEPENDENCIES](#dependencies)
- [QUESTIONS/COMMENTS](#questionscomments)
<br/>

## DEMO

![Demo](docs/demo.gif)
<br/>

## REQUIREMENTS

- Server access
- PHP 5+
<br/>

## USAGE

1. Clone this github to your local server:
2. Modify the url for your 3D Viewer page in `qrgenerator.php`. Simply set [`$viewerUrl`](qrgenerator.php#L78) to your webpage url by by replacing `http://localhost` in the following line:

   ```php
   $viewerUrl = 'http://localhost/3dviewer.html?file=' . $fileNameWithoutExtension;
   ```

3. Modify the upload folder, currently `upload/structures` in:
   - **upload.php**: [`$uploadFileDir`](upload.php#L34)
   - **3dviewer.html**: [`file`](3dviewer.html#L49)

4. (Optional) Modify the requirement for uploaded files in `upload.php`. Current settings:
   - Only allows `*.mol` and `*.xyz` files. Change by modifying [`$allowedfileExtensions`](upload.php#L25)
   - Only allows files smaller than 5 MB. . Change by modifying [`$fileSize`](upload.php#L27)

5. (Optional) Modify the file format for QR code by replacing `.svg` in [`$imageName` in qrgenerator.php](qrgenerator.php#L85). Options include: '.png', '.gif', 'jpeg', 'jpg', 'svg', and 'eps'. More [info here](http://goqr.me/api/doc/create-qr-code/#param_format)
   
6. Copy these files into your web folder:
   - qrgenerator.php
   - upload.php
   - 3dviewer.html

7. Make sure the webserver user (i.e. 'apache' on CentOS 7 or 'www-apache' on Ubuntu) has read and write access to the:
   - Upload folder
   - qrgenerator.php
   - upload.php
   - 3dviewer.html
  
8. Enjoy!
<br/>


## DEPENDENCIES

- [3DMol.js](http://3dmol.csb.pitt.edu/)
- [QR Code Generator](http://goqr.me/)
<br/>


## QUESTIONS/COMMENTS

All questions, comments, suggestions are welcomed! Please consider [creating a new issue](https://github.com/khoivan88/qr-generator-3dview/issues/new).
