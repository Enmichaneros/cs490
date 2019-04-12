<?php 

session_start();

if (isset($_POST['submit'])) {

	$username = $_POST['username'];
	$password = $_POST['password'];

	//Error handlers
	//Check if inputs are empty
	if (empty($username) || empty($password)) {
			header("Location: ../index.php?error=emptyfields&UCID=".$UCID);
			exit();
	} else {
        
        $url = 'https://web.njit.edu/~sk2292/RC/login_middle.php';
        $post_data = array(
            'username' => $username,
            'password' => $password,
        );


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url); // url to send to
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //return output instead of printing
        curl_setopt($ch, CURLOPT_POST, 1); //posting
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data); //add post variables to request
        $output = curl_exec($ch); //execute request and fetch response
        if ($output == FALSE){ //check if request successful
            echo "cURL error: " . curl_error($ch);
        }
        curl_close($ch); //close curl
        
        $output = json_decode($output,true);


        if($output['acctype']=='Student'){
            $_SESSION['username'] = $username;
            header("Location: ../student_exam.php");
            exit();
        }
        else if($output['acctype']=='Teacher'){
            $_SESSION['username'] = $username;
            header("Location: ../teacher_add_questions.php");
            exit();
        }
        else{
            header("Location: ../index.php?error=invalidlogin&UCID=".$UCID);
			exit();
        }

	}
    
} else {
	header("Location: /index.php");
	exit();
}