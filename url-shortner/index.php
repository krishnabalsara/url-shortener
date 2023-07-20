
<!-- redirecting user to og link using shortened link  -->
<?php
    include "php/config.php";
    $new_url = "";
    if(isset($_GET)){
        
        foreach($_GET as $key=>$val){
            $u = mysqli_real_escape_string($conn, $key);
            $new_url = str_replace('/', '', $u); 
        }
        //getting full url of shorten url
        $sql = mysqli_query($conn, "SELECT full_url FROM url WHERE shorten_url = '{$new_url}'");

        if(mysqli_num_rows($sql) > 0){
            $count_query = mysqli_query($conn, "UPDATE url SET clicks = clicks + 1 WHERE shorten_url = '{$new_url}'");
            if($count_query){
                //redirecting
                $full_url = mysqli_fetch_assoc($sql);
                header("Location:".$full_url['full_url']);
            }   
        }
    }
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>URL Shortener</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v3.0.6/css/line.css">
</head>

<body>
    <div class="wrapper">
        <form action="#">
            <input type="text" name="full-url" placeholder="Enter/Paste a long URL" required>

            <i class="url-icon uil uil-link"></i>
            
            <button>Make it short</button>
        </form>

        <?php
            $sql2 = mysqli_query($conn, "SELECT * FROM url ORDER BY id DESC");
            if(mysqli_num_rows($sql2) > 0){
        ?>
                <div class="statistics">
                    <?php
                        $sql3 = mysqli_query($conn, "SELECT COUNT(*) FROM url");
                        $res = mysqli_fetch_assoc($sql3);

                        $sql4 = mysqli_query($conn, "SELECT clicks FROM url");
                        $total = 0;
                        
                        while($c = mysqli_fetch_assoc($sql4)){
                            $total = $c['clicks'] + $total;
                        }
                    ?>
                    <span>Total Links: <span><?php echo end($res);?></span> & Total Clicks: <span><?php echo $total;?></span></span>
                    <a href="php/delete.php?delete=all">Clear All</a>
                </div>

                <div class="urls-area">
            
                <div class="title">
                    <li>Shortened URL</li>
                    <li>Original URL</li>
                    <li>Clicks</li>
                    <li>Actions</li>
                </div>
                <?php
                while($row = mysqli_fetch_assoc($sql2)){
                ?>
                    <div class="data">
                        <li>
                            <a href="http://localhost/url-shortner/<?php echo $row['shorten_url']?>" target="_blank">
                            <?php 
                                // trimming url if it's more than 50chars
                                if('localhost/url-shortner/' .strlen($row['shorten_url'] > 50)){
                                    echo 'localhost/url-shortner/'.substr($row['shorten_url'], 0, 50). '...';
                                }else{
                                    echo 'localhost/url-shortner?u='.$row['shorten_url'];
                                }
                            ?>
                            </a>
                        </li>

                        <li>
                            <?php 
                                if(strlen($row['full_url'] > 65)){
                                    echo substr($row['full_url'], 0, 65). '...';
                                }else{
                                    echo $row['full_url'];
                                }
                            ?>
                        </li>

                        <li><?php echo $row['clicks']?></li>
                        <li><a href="php/delete.php?id=<?php echo $row['shorten_url'] ?>">Delete</a></li>
                    </div>
                <?php
                }
            }
            ?>
        </div>
    </div>

    <div class="blur-effect"></div>

    <div class="popup-box">
                
        <div class="info-box">Your short link is ready. You can edit this link now, no changes can be made once you saved it. </div>
        <form action="#">
            <label>Edit your shortened URL</label>
            <input type="text" spellcheck="false" value="example.com/xyz123">
            <i class="copy-icon uil uil-copy-alt"></i>
            <button>Save</button>
        </form>
    </div>

    <script src="script.js"></script>
</body>
</html>
