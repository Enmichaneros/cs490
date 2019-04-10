<?php 
	include_once 'studentheader.php';
 ?>
        
        <div id="Exam" class = "content">
            <h2>Take Exam</h2>
            <div style="margin-bottom:100px;">
                <p id="exam_content"></p>
                <p id="show_exam_content"></p>
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
//                document.getElementById("exam_content").innerHTML = exams[0].id + " " + exams[1].id;
                
                var testid = '';
                var count = 0;
                var index = 0;
                for (var i = 0; i < exams.length; i++) {
                    if (exams[i].checked) {
                        index = i;
                        count++;
                    }
                }
                if (count == 1) {
                    testid = exams[index].id;
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
                    document.getElementById("show_exam_content").innerHTML = "";
                }
                else {
                    document.getElementById("show_exam_content").innerHTML = "Select Only One Exam";
                }

            }
        </script>
    </body>
</html>