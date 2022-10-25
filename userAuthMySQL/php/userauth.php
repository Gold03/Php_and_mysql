<?php

require_once "../config.php";

//register users
function registerUser($full_names, $email, $password, $gender, $country){
    //create a connection variable using the db function in config.php
    $conn = db();
   //check if user with this email already exist in the database
   $sql = "SELECT * FROM students WHERE email = '$email'";
   $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_assoc($result)){
           if($row['email'] == $email) {
            echo 'User already exists';
            die();
           }
    }
             
  $querry = "INSERT INTO students (`full_names`, `country`, `email`, `gender`, `password`) VALUES ('$full_names','$country','$email', '$gender','$password')";
   if(mysqli_query($conn,$querry)){
  echo 'User successfully registered';  
   }   

   mysqli_close($conn);
}


//login users
function loginUser($email, $password){
    //create a connection variable using the db function in config.php
    $conn = db();

    echo "<h1 style='color: red'> LOG ME IN (IMPLEMENT ME) </h1>";
    //open connection to the database and check if username exist in the database
    //if it does, check if the password is the same with what is given
    //if true then set user session for the user and redirect to the dasbboard
    $sql = "SELECT * FROM students where email = '$email' and password = '$password'";
    $result = mysqli_query($conn,$sql);
       if (mysqli_num_rows($result) > 0) {
        while($rows = mysqli_fetch_assoc($result)){
            session_start();
            $_SESSION['username'] = $rows['full_names'];
            header('location:..\dashboard.php');
        }
        

        }
        else {
            session_start();
            header('location:..\forms\login.html');
        }
    mysqli_close($conn);
    }



function resetPassword($email, $password){
    //create a connection variable using the db function in config.php
    $conn = db();
    echo "<h1 style='color: red'>RESET YOUR PASSWORD (IMPLEMENT ME)</h1>";
    //open connection to the database and check if username exist in the database
    //if it does, replace the password with $password given
    $sql = "UPDATE students SET password = '$password' WHERE email = '$email'";
    if($conn->query($sql)==TRUE) {
        echo 'password changed successfully';
    }
    else {
        echo 'User not found';
    }
    mysqli_close($conn);
}

function getusers(){
    $conn = db();
    $sql = "SELECT * FROM Students";
    $result = mysqli_query($conn, $sql);
    echo"<html>
    <head></head>
    <body>
    <center><h1><u> ZURI PHP STUDENTS </u> </h1> 
    <table border='1' style='width: 700px; background-color: magenta; border-style: none'; >
    <tr style='height: 40px'><th>ID</th><th>Full Names</th> <th>Email</th> <th>Gender</th> <th>Country</th> <th>Action</th></tr>";
    if(mysqli_num_rows($result) > 0){
        while($data = mysqli_fetch_assoc($result)){
            //show data
            echo "<tr style='height: 30px'>".
                "<td style='width: 50px; background: blue'>" . $data['id'] . "</td>
                <td style='width: 150px'>" . $data['full_names'] .
                "</td> <td style='width: 150px'>" . $data['email'] .
                "</td> <td style='width: 150px'>" . $data['gender'] . 
                "</td> <td style='width: 150px'>" . $data['country'] . 
                "</td>
                <form action='action.php' method='post'>
                <input type='hidden' name='id'" .
                 "value=" . $data['id'] . ">".
                "<td style='width: 150px'> <button type='submit', name='delete'> DELETE </button>".
                "</tr>";
        }
        echo "</table></table></center></body></html>";
    }
    //return users from the database
    //loop through the users and display them on a table
}

 function deleteaccount($id){
     $conn = db();
     //delete user with the given id from the database
     $sql = "DELETE FROM students WHERE id = '$id' ";
     if($conn->query($sql) == TRUE) {
        echo 'User Deleted Successfully';
     }
 }

