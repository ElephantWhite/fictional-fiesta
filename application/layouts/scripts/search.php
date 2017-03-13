<?php
include __DIR__ . "../../../repository/BaseRepository.php";
echo "hai";
if(isset($_GET['s']) && $_GET['s'] != ''){
    $s = $_GET['s'];
    $res = BaseRepository::Search($s);
    foreach($res as $item)
    {
        echo key($item);
        $url = key($item)."/";
        foreach($item as $row)
        {
            $title = $row['title'];
            $url .= $row['title'];
            echo "<div style='' id='searchtitle'>" . "<a style='font-family: verdana; text-decoration: none; color: black;' href='$url'>" . $title . "</a>" . "</div>";

        }
    }
}

?>