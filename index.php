<?php

    // connect database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $db = "blog_post";

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $db);

    $search = $_GET['search'] ?? null;
    $page = $_GET['page'] ?? 1;
    $limit = 5;  
    $offset = $limit*($page-1);  

    $p = '';
    if($search)
        $p = "WHERE title LIKE '%$search%'";
    
    // $postQuery = "SELECT * from posts WHERE title LIKE '%$search%' order by id desc limit $limit offset $offset";
    $postQuery = "SELECT * from posts $p order by id desc limit $limit offset $offset";
    $result = mysqli_query($conn, $postQuery);


    // $limit = 5;  
    // if(isset($_POST["page"])) {
    //     $page  = $_POST["page"]; 
    // } 
    // else{ 
    //     $page=1;
    // };  
    // $start_from = ($page-1) * $limit; 

    
    // $sql = "SELECT * from posts order by id desc LIMIT $start_from, $limit";
    // $result = mysqli_query($conn, $sql);





?>


<?php include("inc/header.php") ?>
<?php include("inc/navbar.php") ?>

    <div class="container">
        <div class="row justify-content-end pt-3">
            <div class="col-sm-4">
                <form class="d-flex" action="index.php" method="GET">
                    <input class="form-control me-2" name="search" type="text" placeholder="Search">
                    <button class="btn btn-primary" type="submit">Search</button>
                </form>
            </div>
        </div>
    </div>
    
  
<div class="container mt-2">
    <div class="row justify-content-center">
        <div class="col-sm-8">

            <?php
                while($row = mysqli_fetch_assoc($result)){
                    // The fetch_assoc() / mysqli_fetch_assoc() function fetches a result row as an associative array
            ?>

            <div class="py-2">
                <div class="row border border-muted">
                    <div class="col-sm-3 p-0">
                        <img src="<?php echo $row['image']; ?>" alt="" class="img-fluid">
                        
                    </div>
                    <div class="col-sm-5">
                        <a href="post.php?id=<?php echo $row['id']?>" style="text-decoration:none; color:black">
                        <div>
                            <h2 class="card-title"><?php echo $row['title'] ?></h2>
                            <p class="card-text text-truncate"><?php echo $row['desci'] ?></p>
                        </div>
                        <div>
                            <p class="card-text small text-secondary">Posted on <?php echo date ('F jS, Y',strtotime($row['created_at']))?></p>
                        </div>
                        </a>
                    </div>
                </div>
            </div>

            <?php } ?>


            
        </div>

        
        
        <div class="col-sm-4">
            <?php include("inc/sidebar.php") ?>
        </div>
        
    </div>
</div>

<div class="container">
    <div class="row">
    <?php  

        $q="SELECT COUNT(id) FROM posts $p";
        // count(id) == total no. of id
        $result_db = mysqli_query($conn,$q); 
        
        $row_db = mysqli_fetch_row($result_db);  
        // The fetch_row() / mysqli_fetch_row() function fetches one row from a result-set and returns it as an enumerated array.

        $total_records = $row_db[0];  
        $total_pages = ceil($total_records / $limit); 
        // The ceil() function rounds a number UP to the nearest integer,
        /* echo  $total_pages; */

        $pagLink = "<ul class='pagination justify-content-center' style='margin:20px 0'>";  
    
        // $s ='';
        $s = $search ? "&search=$search": '';
        for ($i=1; $i<=$total_pages; $i++) {
                    $pagLink .= "<li class='page-item'><a class='page-link' href='index.php?page=".$i.$s."'>".$i."</a></li>";	
        }
        echo $pagLink . "</ul>"; 
        
        ?>

        <!-- <ul class="pagination justify-content-center" style="margin:20px 0">
        <li class="page-item"><a class="page-link" href="#">1</a></li>
        <li class="page-item"><a class="page-link" href="#">2</a></li>
        <li class="page-item"><a class="page-link" href="#">3</a></li>
        </ul> -->
    </div>
</div>



<?php include("inc/footer.php") ?>

