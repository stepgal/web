<?php
if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'delete':
            delete($_POST['id']);
            break;
        case 'add':
            add($_POST['userId'], $_POST['title'], $_POST['description'], $_POST['cost']);
            break;
    }
}

function delete($id) {
    $url = 'http://3.15.18.44:3002/items/delete/'.$id;
    file_get_contents($url);
}

function add($id, $title, $description, $cost){
    $url = 'http://3.15.18.44:3002/items/insert/'.$id.'/'.$title.'/'.$description.'/'.$cost;
    file_get_contents($url);
}
?>


