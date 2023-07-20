<?php
    include "config.php";
    //getting value which are sending from js ajax
    $full_url = mysqli_real_escape_string($conn, $_POST['full-url']);

    //if full url box is not empty and the user entered url is valid url
    if(!empty($full_url) && filter_var($full_url, FILTER_VALIDATE_URL)){
        $ran_url = substr(md5(microtime()), rand(0, 26), 5); //generating random 5 characters url
         //checking that random generated url already exists in the database or not
        $sql = mysqli_query($conn, "SELECT * FROM url WHERE shorten_url = '{$ran_url}'");
        
        if(mysqli_num_rows($sql) > 0){
            echo "Something went wrong, please generate URL again!";
        }else{
            //inserting user entered URL into table with short url
            $sql2 = mysqli_query($conn, "INSERT INTO url (full_url, shorten_url, clicks) VALUES ('{$full_url}', '{$ran_url}', '0')");
            
            if($sql2){     //if data is inserted successfully
                //selecting recently inserted short url
                $sql3 = mysqli_query($conn, "SELECT shorten_url FROM url WHERE shorten_url = '{$ran_url}'");
                
                if(mysqli_num_rows($sql3) > 0){
                    $shorten_url = mysqli_fetch_assoc($sql3);
                    echo $shorten_url['shorten_url'];
                }

            }else{
                echo "Something went wrong, please try again!";
            }
        }

    }else{
        echo "$full_url - This is not a valid URL!";
    }

?> 









