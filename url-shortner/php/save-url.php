<?php
    
    include "config.php";

    $og_url = mysqli_real_escape_string($conn, $_POST['shorten_url']);
    $full_url = str_replace(' ', '', $og_url);  //removing space from url if entered any by user
    $hidden_url = mysqli_real_escape_string($conn, $_POST['hidden_url']);

    if(!empty($full_url)){
        $domain = "localhost";
        //checking if user has edited or removed domain name
        if(preg_match("/{$domain}/i", $full_url) && preg_match("/\//i", $full_url)){
            $explodeURL = explode('/', $full_url);
            $short_url = end($explodeURL);  //getting last valuue of full url
            if($short_url != ""){
                //selecting randomly created url to update with user entered new value
                $sql = mysqli_query($conn, "SELECT shorten_url FROM url WHERE shorten_url = {'$short_url'} && shorten_url != {'$hidden_url'} ");
                if(mysqli_num_rows($sql) == 0){
                    //if user entered url does not exist in database
                    //updating the url
                    $sql2 = mysqli_query($conn, "UPDATE url SET shorten_url = '{$short_url}' WHERE shorten_url = '{$hidden_url}' ");

                    if($sql2){  //if url updated
                        echo "success";
                    }else{
                        echo "Something went wrong!";
                    }

                }else{
                    echo "Error! This URL already exists!";
                }

            }else{
                echo "Error! You have to enter short URL!";
            }

        }else{
            echo "Invalid URL! You can't edit domain name.";
        }
    }else{
        echo "Error! You have to enter short URL!";
    }
?>
