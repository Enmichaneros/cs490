<?php 
	include_once 'studentheader.php';
    $val = $_SESSION['username'];

 ?>

        
        <div id="Grades" class = "content">
            <h2>Grades</h2>
            <p id="test_dropdown"></p>
            <p id="student_test"></p>
        </div>

        
        <script>
            window.onload = tests;
            
            function tests() {
                var ucid = "<?php echo $val ?>";
                
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("test_dropdown").innerHTML = this.response;
                    }
                  };
                
                
                xhttp.open("POST","https://web.njit.edu/~sk2292/RV/student_get_grades.php");
                xhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
                xhttp.send("UCID="+ucid);
            }
            
            function showGradeExam() {
                var testid = document.getElementById("availTest").value;
                var ucid = "<?php echo $val ?>";
                
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("student_test").innerHTML = this.response;
                    }
                  };
                
                
                xhttp.open("POST","https://web.njit.edu/~sk2292/RV/student_get_exam.php");
                xhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
                xhttp.send("UCID="+ucid+"&TestID="+testid);
            }
            
        </script>
<?php 
	include_once 'footer.php';
 ?>

