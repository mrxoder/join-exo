<?php


$classes = $db->getclass();

$views = new views\school(["classes"=>$classes, "db"=>$db]);
$views->header();
new views\sidebar($routes->value, "school");
$views->content();
$views->script();
$views->footer();

?>

  
