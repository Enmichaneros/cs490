<?php 
	include_once 'studentheader.php';
    $val = $_SESSION['username'];
 ?>

        
        <div id="Exam" class = "content">
            <h2>Take Exam</h2>
            <div style="margin-bottom:100px;">
                <p id="exam_content"></p>
                <p id="show_exam_content"></p>
                <p id="submit_content"></p>
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
<<<<<<< HEAD:RV/front/student_exam.php
                xhttp.open("POST","https://web.njit.edu/~sk2292/RV/show_exams.php");
=======
                xhttp.open("POST","https://web.njit.edu/~jj373/RV/show_exams.php");
>>>>>>> 2fa4f1ddaa61dd9a509b42a799b68e79b95a6eb0:RV/RV/student_exam.php
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

<<<<<<< HEAD:RV/front/student_exam.php
                    xhttp.open("POST","https://web.njit.edu/~sk2292/RV/exam.php");
=======
                    xhttp.open("POST","https://web.njit.edu/~jj373/RV/exam.php");
>>>>>>> 2fa4f1ddaa61dd9a509b42a799b68e79b95a6eb0:RV/RV/student_exam.php
                    xhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
                    xhttp.send("TestID="+testid);
                    document.getElementById("show_exam_content").innerHTML = "<input type='button' value='Submit Test' onclick='submitTest()'>";
                }
                else {
                    document.getElementById("show_exam_content").innerHTML = "Select Only One Exam";
                }

            }
            function submitTest() {
                var answerCode = document.getElementsByClassName('answerCode');
                var testid = document.getElementsByClassName("exam_info")[0].id;
                
                var QID = '';
                var code = '';
                for (var i = 0; i < answerCode.length; i++) {
                    QID += answerCode[i].id + "```";
                    code += answerCode[i].value + "```";
                    
                }
                var ucid = "<?php echo $val ?>";
//                document.getElementById("submit_content").innerHTML = code;
                code = encodeURIComponent(code);
                
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("submit_content").innerHTML = this.responseText;
                        //location.reload();

                    }
                  };

<<<<<<< HEAD:RV/front/student_exam.php
                xhttp.open("POST","https://web.njit.edu/~sk2292/RV/submit_test.php");
=======
                xhttp.open("POST","https://web.njit.edu/~jj373/RV/submit_test.php");
>>>>>>> 2fa4f1ddaa61dd9a509b42a799b68e79b95a6eb0:RV/RV/student_exam.php
                xhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
                xhttp.send("UCID="+ucid+"&TestID="+testid+"&QID="+QID+"&Code="+code);
            }
        // listener for tab key in textarea
           document.addEventListener('keydown',function(e){
               if(e.target && (e.keyCode == 9)) {
                   insertTab(document.activeElement, e);
               }
           });
        // function to allow tabs in text area
            function insertTab(o, e) {
                var kC = e.keyCode ? e.keyCode : e.charCode ? e.charCode : e.which;
                if (kC == 9 && !e.shiftKey && !e.ctrlKey && !e.altKey) {
                    var oS = o.scrollTop;
                    if (o.setSelectionRange) {
                        var sS = o.selectionStart;
                        var sE = o.selectionEnd;
                        o.value = o.value.substring(0, sS) + "\t" + o.value.substr(sE);
                        o.setSelectionRange(sS + 1, sS + 1);
                        o.focus();
                    } else if (o.createTextRange) {
                        document.selection.createRange().text = "\t";
                        e.returnValue = false;
                    }
                    o.scrollTop = oS;
                    if (e.preventDefault) {
                        e.preventDefault();
                    }
                    return false;
                }
                return true;
            }
        </script>

<?php 
	include_once 'footer.php';
 ?>

