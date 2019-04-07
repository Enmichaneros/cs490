<?php 

session_start();

if (isset($_POST['submit'])) {

	$UCID = $_POST['UCID'];
	$Pass = $_POST['Pass'];

	//Error handlers
	//Check if inputs are empty
	if (empty($UCID) || empty($Pass)) {
			header("Location: ../index.php?error=emptyfields&UCID=".$UCID);
			exit();
	} else {
        
        //MICHELLE'S MIDDLE.PHP URL IN THE NEXT LINE 
        $url = 'https://web.njit.edu/~sk2292/Beta/middle.php';
        $post_data = array(
            'UCID' => $UCID,
            'Pass' => $Pass,
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
            header("Location: ../~sk2292/RC/student_exam.html");
            exit();
        }
        else if($output['acctype']=='Teacher'){
            header("Location: ../~sk2292/RC/teacher_add_questions.html");
            exit();
        }
        else{
            header("Location: ../index.php?error=invalidlogin&UCID=".$UCID);
			exit();
        }

	}
} else {
	header("Location: ../index.php");
	exit();
}