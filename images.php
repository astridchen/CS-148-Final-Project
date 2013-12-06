<?php

$query = <<<SQL
    SOME SQL QUERY
SQL;

$result = $db->prepare($query);

$result->execute();

while ($row = $result->fetch(PDO::FETCH_ASSOC) {
    $img = <<<HTML
        <img src="{$row['link']}">
HTML;
    echo $img;
}

?>
