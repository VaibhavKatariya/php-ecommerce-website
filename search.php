<?php 

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['squery']) ) 
{
    $squery = $_POST['squery'];
    $squery = '"'.$squery.'%"';

    $machine = "localhost";
    $user = "root";
    $password = "";
    $db_name = "main";

    $connection = mysqli_connect($machine , $user , $password , $db_name);
    if (!$connection)
	    echo "Could not connect";
    $main_query = "select * from products where name like $squery;";

    $result = mysqli_query($connection , $main_query);

    $extensions = ['webp', 'jpeg', 'jpg', 'avif' , 'png'];

    $search_result = [];


    if (mysqli_num_rows($result) > 0)
    {
    while ($current_row = mysqli_fetch_assoc($result))
    {

        $imagePath = null;
        foreach ($extensions as $ext) 
        {
        if (file_exists("assets/images/{$current_row['id']}.$ext")) 
        {
        $imagePath = "assets/images/{$current_row['id']}.$ext";
        break;
        }
        }
        $search_result[] = [
            'name' => $current_row['name'],
            'category' => $current_row['category'],
            'id'    => $current_row['id'],
            'img'   => $imagePath
        ];
    }

    

    }


    $main_query = "select * from products where category like $squery;";
    $result = mysqli_query($connection , $main_query);

    if (mysqli_num_rows($result) > 0)
    {
    while ($current_row = mysqli_fetch_assoc($result))
    {

        $imagePath = null;
        foreach ($extensions as $ext) 
        {
        if (file_exists("assets/images/{$current_row['id']}.$ext")) 
        {
        $imagePath = "assets/images/{$current_row['id']}.$ext";
        break;
        }
        }
        $search_result[] = [
            'name' => $current_row['name'],
            'category' => $current_row['category'],
            'id'    => $current_row['id'],
            'img'   => $imagePath
        ];
    }
    }


    echo json_encode($search_result);
}
?>