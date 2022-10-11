<html>
    <head>
        <title>Public Registration</title>
    </head>
    <body>
        <form method="POST" action="./register_api.php" enctype="multipart/form-data">
            <input type="text" name="fullname" placeholder="fullname">
            <input type="text" name="phone" placeholder="phone">
            <input type="text" name="email" placeholder="email">
            <input type="file" name="adhaar" id="adhaar">
            <input type="file" name="pan" id="pan">
            <input type="text" name="password" placeholder="password">
            <input type="text" name="address" placeholder="address">
            <input type="text" name="pincode" placeholder="pincode">
            <input type="text" name="referred_by" placeholder="referred_by">
            <input type="text" name="registered_on" placeholder="registered_on">
            <input type="file" name="photo" id="photo">
            <input type="submit" name="submit">
        </form>
    </body>
</html>