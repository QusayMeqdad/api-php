<?php

$servername = "localhost";
$username = "root";
$password = "password";
$database = "mydatabase";

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// العملية المطلوبة من الطلب
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
    // الحصول على جميع الطلاب
  $sql = "SELECT * FROM students";
   $result = mysqli_query($conn, $sql);

  if (mysqli_num_rows($result) > 0) {
     $students = array();
     while ($row = mysqli_fetch_assoc($result)) {
    $students[] = $row;
       }
    echo json_encode($students);
       } else {
    echo json_encode([]);
      }
  break;

    case 'POST':
        // إضافة طالب جديد
    $name = $_POST['name'];
     $age = $_POST['age'];

    $sql = "INSERT INTO students (name, age) VALUES ('$name', '$age')";
   if (mysqli_query($conn, $sql)) {
     echo json_encode(['message' => 'Student added successfully']);
     } else {
       echo json_encode(['message' => 'Error adding student']);
     }
      break;

    case 'DELETE':
     // حذف طالب
        $id = $_GET['id'];
     $sql = "DELETE FROM students WHERE id = $id";
    if (mysqli_query($conn, $sql)) {
     echo json_encode(['message' => 'Student deleted successfully']);
  } else {
  echo json_encode(['message' => 'Error deleting student']);
}
   break;

    case 'PUT':
    // تعديل بيانات طالب
    parse_str(file_get_contents("php://input"), $putData);
    $id = $putData['id'];
     $name = $putData['name'];
   $age = $putData['age'];

   $sql = "UPDATE students SET name = '$name', age = '$age' WHERE id = $id";
    if (mysqli_query($conn, $sql)) {
  echo json_encode(['message' => 'Student updated successfully']);
  } else {
   echo json_encode(['message' => 'Error updating student']);
}
break;
}
mysqli_close($conn);
?>
