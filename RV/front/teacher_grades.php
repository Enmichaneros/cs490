<?php 
	include_once 'teacherheader.php';
 ?>
<!--        <p style="font-size: 100px;"> Hello</p>-->
        
        <div id="pickExam" class="content">
            <h2>Grades</h2>
            <div style="margin-bottom:100px;">
                <p id="test_dropdown" style="display: inline;"></p>
                <input type="button" value="Release Scores for Selected Exam" onclick="release()" style="display:inline;">
                <p id="released_content" style="display: inline;"></p>
                <p id="student_dropdown"></p>
                <p id="student_exam"></p>
                <p id="edit_grades"></p>
                <p id="edit_comments"></p>

            </div>
        </div>


        
        <script>
            window.onload = tests;
            
            function tests() {
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("test_dropdown").innerHTML = this.response;
                        document.getElementById("student_exam").innerHTML = "";
                        document.getElementById("edit_grades").innerHTML = "";
                        document.getElementById("edit_comments").innerHTML = "";
                    }
                  };
                
                
                xhttp.open("POST","https://web.njit.edu/~sk2292/RV/teacher_get_grades.php");
                xhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
                xhttp.send();
            }
            
            function showGradeExam() {
                var testid = document.getElementById("availTest").value;
                
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("student_dropdown").innerHTML = this.response;
                        document.getElementById("student_exam").innerHTML = "";
                        document.getElementById("edit_grades").innerHTML = "";
                        document.getElementById("edit_comments").innerHTML = "";
                    }
                  };
                
                
                xhttp.open("POST","https://web.njit.edu/~sk2292/RV/teacher_get_students.php");
                xhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
                xhttp.send("TestID="+testid);
            }
            
            function showGradeStudent() {
                var testid = document.getElementById("availTest").value;
                var ucid = document.getElementById("availStudents").value;

                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("student_exam").innerHTML = this.response;
                        document.getElementById("edit_grades").innerHTML = "<input type='button' value='Edit Grade' onclick='editGrade()'>";
                    }
                  };
                
                
                xhttp.open("POST","https://web.njit.edu/~sk2292/RV/teacher_student_exam.php");
                xhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
                xhttp.send("TestID="+testid+"&UCID="+ucid);
            }

            
            function editGrade() {
                var ucid = document.getElementById("availStudents").value;
                var testid = document.getElementById("availTest").value;
                var pointchange = document.getElementsByClassName("changesToPoints");
                var commentchange = document.getElementsByClassName("changesToComments");
                var points_string = "";
                var comments_string = "";
                var QID = "";
                var num_string = "";
                var num = 0;
                var QID_change = pointchange[0].id;
                
                for (var i = 0; i < pointchange.length; i++) {
                    if (pointchange[i].id != QID_change) {
                        num = 0;
                        QID_change = pointchange[i].id;
                    }
                    
                    QID += pointchange[i].id + "```";
                    points_string += pointchange[i].value + "```";
                    comments_string += commentchange[i].value + "```";
                    num_string += num.toString() + "```";
                    num += 1;
                }
                
                
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("edit_comments").innerHTML = this.response;
                    }
                  };
                
                
                xhttp.open("POST","https://web.njit.edu/~sk2292/RV/edit_grade.php");
                xhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
                xhttp.send("UCID="+ucid+"&TestID="+testid+"&QID="+QID+"&EarnedPts="+points_string+"&Comments="+comments_string+"&Num="+num_string);
                
            }
            
            function release() {
                var testid = document.getElementById("availTest").value;
                
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("released_content").innerHTML = this.response;
                    }
                  };
                
                
                xhttp.open("POST","https://web.njit.edu/~sk2292/RV/release_grades.php");
                xhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
                xhttp.send("TestID="+testid);
            }

        </script>
<?php 
	include_once 'footer.php';
 ?>

