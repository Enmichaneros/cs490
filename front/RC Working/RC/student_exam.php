<?php 
	include_once 'studentheader.php';
 ?>

        
        <div id="Exam" class = "content">
            <h2>Take Exam</h2>
            <div style="margin-bottom:100px;">
                <p id="exam_content"></p>
            </div>
        </div>

        
        <script>
            window.onload = showExams;
            
            function showExams() {
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                      document.getElementById("exam_content").innerHTML =
                      this.responseText;
                    }
                  };


                xhttp.open("POST","https://web.njit.edu/~sk2292/RC/show_exams.php");
                xhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
                xhttp.send();  
            }
            
            function openExam() {
                var exams = document.getElementsByClassName('openExam');
                var testid = '';
                if (exams.length == 1) {
                    testid = exams[0].id;
                    
                    var xhttp = new XMLHttpRequest();
                    xhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                          document.getElementById("exam_content").innerHTML =
                          this.responseText;
                        }
                      };


                    xhttp.open("POST","https://web.njit.edu/~sk2292/RC/exam.php");
                    xhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
                    xhttp.send("TestID="+testid);
                }

            }
        </script>
    </body>
</html>
