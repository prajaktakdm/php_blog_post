<?php

// connect database
$servername = "localhost";
$username = "root";
$password = "";
$db = "blog_post";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $db);



?>

<?php
    if(isset($_GET['id'])){

        $post_id = $_GET['id'];
        function getComments($conn,$post_id){

            $sql = "SELECT * FROM comments WHERE post_id = $post_id ORDER BY id DESC";
            $result = mysqli_query($conn, $sql);
            $data = array();
        
            while($row = mysqli_fetch_assoc($result)){
                $data[]=$row;
            }
            return $data;
        }
?>




<div class="py-1">
    <div class="card">
        <div class="card-header">
            <h3>Comments</h3>
        </div>

<?php 
    $comments = getComments($conn,$post_id);

        if(count($comments)<1){
            echo '<div class="card-body"><p class="card-text text-center">No Comments</p></div>';
        }

    foreach($comments as $comment){
?>

        <div class="card-body">
            <h4 class="card-title"><?php echo $comment['name'] ?></h4>
            <span><p class="card-text small text-secondary">Commented on <?php echo date ('F jS, Y',strtotime($comment['created_at']))?></p></span>
            <p class="card-text"><?php echo $comment['comment'] ?></p>
        </div>

        <?php } ?>   
    </div>
</div>

<?php } ?>