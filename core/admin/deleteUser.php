<?php
require_once (__DIR__."/../config.php");
require_once (__DIR__."/../inc/secure_session.php");
require_once (__DIR__."/../functions.php");
require_once (__DIR__."/../inc/database_api.php");

$page['title'] = "alpha_display_username";
require_once (__DIR__."/../template/header.php");
require_once (__DIR__."/../template/navbar.php");

$header = "Delete User";

$page_content = file_get_contents(__DIR__."/../../".TEMPLATE_FOLDER."/dashboard/alpha_display_username.html");
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$content = "<div class=\"container\">";
if(!isset($_GET['id'])){
    $sql = "SELECT uid, username FROM tbl_members";
    $result = $connect->prepare($sql);
    $content .= '
    
        <table class="table">
        <thead>
        <tr>
        <th scope="col">username</th>
        <th scope="col"></th>
        </tr>
        </thead>
        <tbody>
';
//Display username data
    if ($result = $connect->prepare($sql)) {

        $res = $connect->query($sql);
        while($row = $res->fetch_assoc()) {
            $content .= '<tr>';
            $content .= '<td>' .$row["username"] .' </td>';
            $content .= '<td><a href="setting.php?a=deleteuser&id='.$row["uid"].'" class="badge badge-danger">Delete</a></td>';
            $content .= '</tr>';
        }

    } else {
        $content .= "0 results";
    }

    $content .= '
        </tbody>
        </table>
    ';
}else{
    $uid = $_GET['id'];
    $sql = "DELETE FROM tbl_members WHERE uid = $uid";
    $res = $connect->query($sql);

    if($res = $connect->query($sql)){
        echo "Delete Done";
        header("Location: setting.php?a=deleteuser");
    }else{
        echo "Delete Error";
    }
}
$content .= '<div>';






$replacers = [
    'TEMPLATE_DIR' => TEMPLATE_FOLDER,
    'PAGE_TITLE' => $page['title'],
    'HEADER' => $header,
    'CONTENT' => $content
];

echo preg_replace_callback("|{(\w*)}|", 'replace_callback', $page_content);

?>