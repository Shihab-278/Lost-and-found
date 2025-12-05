<?php
header('Content-Type: application/json; charset=utf-8');
include 'admin/config.php';
$q = '';
if(isset($_GET['q'])){
  $q = mysqli_real_escape_string($connection, trim($_GET['q']));
}
if($q === ''){
  echo json_encode([]);
  exit;
}

$query = "SELECT post_id, title FROM post WHERE title LIKE '%".$q."%' OR description LIKE '%".$q."%' ORDER BY post_date DESC LIMIT 8";
$res = mysqli_query($connection, $query) or die(json_encode([]));
$items = [];
while($r = mysqli_fetch_assoc($res)){
  $items[] = ['id' => $r['post_id'], 'title' => $r['title']];
}

echo json_encode($items);
