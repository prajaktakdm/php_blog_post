<?php

$error = 0;
$title_err = "";
$desci_err = "";
$categories_err = "";
$image_err = "";

 // connect database

 $servername = "localhost";
 $username = "root";
 $password = "";
 $db = "blog_post";

 // Create connection
 $conn = mysqli_connect($servername, $username, $password, $db);

 // Check connection
 if (!$conn) {
 die("Connection failed: " . mysqli_connect_error());
 }
 // echo "Connected successfully";


if($_POST){



    $title = $_POST['title'] ?? null;
    $desci = mysqli_real_escape_string($conn,$_POST['desci'] ?? null);
    $categories = $_POST['categories'] ?? null;
    $image = $_FILES['image'] ?? null;
    

    $imagename = $image['name'];
    $imagetmp = $image['tmp_name'];
   
    // ex. imagename = 55.JPG

    // explode() function breaks a string into an array.
    $imageext = explode('.',$imagename);
    // imageext break iamgename i.e 55 and JPG

    $imagecheck = strtolower(end($imageext));
    // imagecheck = JPG convert jpg

    $imageextstored = array('png','jpg','jpeg');

    // in_array() function searches an array for a specific value.
    // in_array check imagecheck is present in the array imageextstored 

    if(in_array($imagecheck,$imageextstored)){
        $destinationimage = 'upload/'.$imagename;

        // move_uploaded_file() function moves an uploaded file to a new destination.
        move_uploaded_file($imagetmp,$destinationimage);
    }
    

    // validation
    if(!$title){
        $title_err = "Title is empty.";
        $error = 1;
    }

    if(!$desci){
        $desci_err = "Description is empty.";
        $error = 1;
    }

    if(!$categories){
        $categories_err = "Choose the categories.";
        $error = 1;
    }

    if(!$image){
        $image_err = "Upload the image.";
        $error = 1;
    }

    if(!$error){

    

       


        // store data in the database
        $sql = "INSERT INTO posts (title, desci, categories, image)
        VALUES ('$title', '$desci', '$categories', '$destinationimage')";
    
    // var_dump($sql);die;

        $query = mysqli_query($conn,$sql);


        if ($query === TRUE) {
            header("Location: index.php");
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        // $conn->close();
    }


}

?>




<?php include("inc/header.php") ?>
<?php include("inc/navbar.php") ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-7">
            <form action="create_post.php" method="post" enctype="multipart/form-data">
                <div class="mb-3 mt-3">
                    <label for="title" class="form-label">Title:</label>
                    <input type="title" class="form-control" id="title" placeholder="" name="title">
                    <span class="text-danger"><?php echo $title_err; ?></span>
                </div> 
                <div class="mb-3 mt-3">
                    <label for="desci">Description:</label>
                    <textarea class="form-control" rows="5" id="desci" name="desci"></textarea>
                    <span class="text-danger"><?php echo $desci_err; ?></span>
                </div>
                <div class="mb-3 mt-3">
                    <label for="categories" class="form-label">Categories:</label>
                    <select class="form-select"  name="categories">
                        <option selected></option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                        <option value="4">Four</option>
                        <option value="5">Five</option>
                        <option value="6">Six</option>
                    </select>
                    <span class="text-danger"><?php echo $categories_err; ?></span>
                </div>   
                <div class="mb-3 mt-3">
                    <label for="image" class="form-label">Upload Image:</label>
                    <input type="file" class="form-control" id="image" placeholder="" name="image">
                    <span class="text-danger"><?php echo $image_err; ?></span>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>  
            
    </div>
</div>






<?php include("inc/footer.php") ?>