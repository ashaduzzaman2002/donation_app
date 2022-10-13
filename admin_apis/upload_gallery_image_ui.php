<html>
    <head>
        <title>Admin Upload Gallery Image</title>
    </head>
    <body>
        <form method="POST" action="./upload_gallery_image_api.php" enctype="multipart/form-data">
            <input type="file" name="gallery_photo">
            <input type="text" name="caption" placeholder="Caption">
            <input type="submit" name="submit">
        </form>
    </body>
</html>