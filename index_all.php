<?php

define("SITE_ADDR", "http://localhost/lab/pas_website");

include("./include.php");

$site_title = 'ICD ALL | Website Version';
?>

<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width">

        <title><?php echo $site_title; ?></title>
        <link rel="stylesheet" type="text/css" href="./main.css"></link>
    </head>

    <body>

        <div id = "wrapper">
        <!-- 
            <div id="nav">
                <a href="<?php echo SITE_ADDR;?>/new_entry.php">New Entry</a>
            </div>
            --> 
            <center>
            <div id="logo">
                <h1><a href = "<?php echo SITE_ADDR;?>">ICD ALL</a></h1>
            </div>
            </center>
        </div>
        <div id = "main" class="shadow-box"><div id="content">

            <center>
            <form action="" method="GET" name="">
            <table>
            <caption style="caption-side:bottom">(ICD) Number -> Description</caption>
                <tr>
                    <td><input type = "text" name="k" placeholder="Search for codes" autocomplete="off"></td>
                    <td><input type = "submit" name="" value="Search"></td>
                </tr>

            </table>
        </form>
        </center>

        <?php
            //Checking to see the keywords inputted
            if (isset($_GET['k']) && $_GET['k'] !=''){

                $k = trim($_GET['k']);
                
                //seperating the keywords

                $query_string = "SELECT id_code,id_desc, icd_code_type, CONCAT(icd_code_type, '  ', id_code, '  -->    ', id_desc) full_name FROM icd_10 ";
                $display_words = "";

                $keywords = explode(' ', $k);
                #print_r($keywords);
                foreach($keywords as $word){
                    $query_string .= " where id_code LIKE '%".$word."%' OR id_desc LIKE '%".$word."%';   ";
                    $display_words .= $word. " ";
                }
                $query_string = substr($query_string, 0, strlen($query_string) - 3);

                #echo $query_string;

                $conn = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

                $query = mysqli_query($conn, $query_string);

                $count_result = mysqli_num_rows($query);

                if ($count_result > 0){
                
                echo '<div class = "right"><b><u> '.$count_result.'</u></b> results found</div>';
                echo 'Your search for <i> '.$display_words.' </i> <hr /><br/>';
                
                while($row = mysqli_fetch_assoc($query)){
                    echo nl2br('<tr>
                        <td>'.$row['full_name'].'</td>
                    </tr>'
                       
                );
                }

                echo '</table>';

                }
                else
                    echo 'No Such ICD Code found. Kindly check your input. :D';
            }
            else
                echo '';
        ?>

        </div></div>
        <div id="footer">

        </div>
    </body>
</html>