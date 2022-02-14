<?php

$error = 0;
$name_err = "";
$comment_err = "";



// connect database
$servername = "localhost";
$username = "root";
$password = "";
$db = "blog_post";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $db);


if(isset($_POST['addcomment'])){

    $name = mysqli_real_escape_string($conn,$_POST['name']) ?? null;
    $comment = mysqli_real_escape_string($conn, $_POST['comment'])?? null;
    $post_id = mysqli_real_escape_string($conn, $_POST['post_id'])?? null;



    if(!$name){
        $name_err = "Please enter your name.";
        $error = 1;
    }

    if(!$comment){
        $comment_err = "Write some comment.";
        $error = 1;
    }

    if(!$error){
    $query="INSERT INTO comments (name, comment, post_id) VALUES ('$name', '$comment', '$post_id')";

    if(!mysqli_query($conn,$query)){
        echo "comment is not added.";
    }

    // else{
    //     echo "comment is not added.";
    // }
}
}




$id = $_GET['id'];

$sql = "SELECT * from posts WHERE id=$id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

?>


<?php include("inc/header.php") ?>
<?php include("inc/navbar.php") ?>


<div class="container mt-5">
    <div class="row">

        <div class="col-sm-8">
            <div class="row border border-muted">
                <div class="pb-4">
                    <h1 class="py-2"><?php echo$row['title'] ?></h1>
                    <span class="bg-danger text-white p-1 rounded">Posted on <?php echo date ('F jS, Y',strtotime($row['created_at']))?></span> 
                    <span class="bg-primary text-white p-1 rounded"><?php echo $row['categories'] ?></span>
                    <hr>
                </div>
            
                <div>
                    <img src="<?php echo $row['image']; ?>" alt="" class="img-fluid">
                    <p class="py-2"><?php echo $row['desci'] ?></p>
                </div>
                <div class="pb-2">

                        <!-- for sharing -->
                    <div class="addthis_inline_share_toolbox"></div>

                    
                    <!--for comment -->

                    <!-- Button to Open the Modal -->
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">Comment On This</button>

                        <!-- The Modal -->
                        <div class="modal" id="myModal">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Comment</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <!-- Modal body -->
                                    <div class="modal-body">
                                    <form action="post.php?id=<?php echo $row['id'];?>" method="post">

                                        <div class="mb-3 mt-3">
                                            <label for="name" class="form-label">Name:</label>
                                            <input type="name" class="form-control" id="name" placeholder="" name="name">
                                            <span class="text-danger"><?php echo $name_err; ?></span>
                                        </div>

                                        <div class="mb-3">
                                            <label for="comment" class="form-label">Comment:</label>
                                            <input type="text" class="form-control" id="comment" placeholder="" name="comment">
                                            <span class="text-danger"><?php echo $comment_err; ?></span>
                                        </div>

                                        <input type="hidden" name="post_id" value="<?php echo $row['id'] ?>">
                                        <button type="submit" name="addcomment" class="btn btn-primary">Submit</button>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>
                
                
                </div>
            </div>
            <div class="row">
                <h3 class="pt-4">Related posts</h3>

    
<?php

$pquery = "SELECT * FROM posts WHERE categories = {$row['categories']} ORDER BY id DESC";
$prun = mysqli_query($conn,$pquery);
while($rpost = mysqli_fetch_assoc($prun)){
    if($rpost['id'] == $row['id']){
        continue;
    }
?>

                <div class="py-2">
                    <div class="row border border-muted">
                        <div class="col-sm-3 p-0">
                            <img src="<?php echo $rpost['image']; ?>" alt="" class="img-fluid">
                        </div>
                        <div class="col-sm-5 ms-3">
                            <a href="post.php?id=<?php echo $rpost['id']?>" style="text-decoration:none; color:black">
                            <div>
                                <h2 class="card-title"><?php echo $rpost['title'] ?></h2>
                                <p class="card-text text-truncate"><?php echo $rpost['desci'] ?></p>
                            </div>
                            <div>
                                <p class="card-text text-secondary">Last updated <?php echo date ('F jS, Y',strtotime($rpost['created_at']))?></p>
                            </div>
                            </a>
                        </div>
                    </div>
                </div>       

<?php
}
?>

            </div>
        </div>

        <div class="col-sm-4">
            <?php include("inc/sidebar.php") ?>
        </div>
        
    </div>
</div>


<?php include("inc/footer.php") ?>
