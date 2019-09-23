
<?php
$images = "";

    if (isset($_FILES['images']) && !empty(trim($_FILES['images']['name'][0]))) {

        if (count($_FILES['images']['name']) > 0) {

            $file_names = $_FILES['images']['name'];
            $file_types = $_FILES['images']['type'];
            $file_tmps = $_FILES['images']['tmp_name'];
            $file_errors = $_FILES['images']['error'];
            $file_sizes = $_FILES['images']['size'];
            // die(json_encode(['message' => [$file_names[0], $file_types[0], $file_tmps[0], $file_errors[0]]]));


            for ($i = 0; $i < count($file_names); $i++) {
                $images .= '<img class="inbox-image" src="/storage/' . File::upload(
                    [
                        'name' => $file_names[$i],
                        'type' => $file_types[$i],
                        'tmp_name' => $file_tmps[$i],
                        'error' => $file_errors[$i],
                        'size' => $file_sizes[$i]
                    ],
                    'groups/messages/' . time() . "_" . $i . '_' . $user . '.' . extension([
                        'name' => $file_names[$i],
                        'type' => $file_types[$i],
                        'tmp_name' => $file_tmps[$i],
                        'error' => $file_errors[$i],
                        'size' => $file_sizes[$i]
                    ]),
                    4000000,
                    ['image' => [
                        'png', 'jpg', 'jpeg', 'gif', 'bmp', 'svg'
                    ]]
                ) . '">';
            }
        }
    }
    
     $sql = "INSERT INTO 
            group_messages (`group_id`, `admin_id`,`user_id`, `message`) 
            VALUES('1', '1','1', :message)";
    $stmt = $con->prepare($sql);
    $stmt->bindValue(':message', $message . '<br><p class="inbox-image-block">' . $images . '</p>', PDO::PARAM_STR);
    $res = $stmt->execute();
