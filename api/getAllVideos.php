<?php
include_once "../conn.php";
mysqli_query($con, "DELETE from videos where id=20");
$q = mysqli_query($con, "SELECT * from videos order by sort_no asc");
$res = array();
while ($fetch = mysqli_fetch_assoc($q)) {
  $fetch['video_link'] = BASE_URL .'uploads/'. $fetch['video_link'];
  $fetch['thumbnail'] = BASE_URL .'uploads/icons/'. $fetch['thumbnail'];
  $fetch['background'] = BASE_URL .'uploads/bg/'. $fetch['background'];
  $fetch['end_video'] = BASE_URL .'uploads/end_animations/'. $fetch['end_video'];
  $res[] = $fetch;
}
if (count($res) == 0) {
  $code = http_response_code(200);
  echo json_encode(array("response" => 0, "code" => $code, "message" => "No video found " . mysqli_error($con)));
  exit();
}
$code = http_response_code(201);
echo json_encode(array("response" => 1, "code" => $code, 'data' => $res));
exit();
