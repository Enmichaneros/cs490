<html>
    <head>
        <title>Student View</title>
        <link rel="stylesheet" href="studentstyle.css">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
        <button class="tablink" onclick="openPage('Exam', this, '#5680E9')" id="defaultOpen">Exam</button>
        <button class="tablink" onclick="openPage('Grades', this, '#5680E9')">Grades</button>
        
        <div id="Exam" class="tabcontent">
            <div class="full">
              <div class="centered" style="">
                <h2>Take Exam</h2>
                <div class="form">
                    <form>
                        <input type="button" onclick="showTests();" value="Show Available Tests" id="availTests"/>
                    </form>
                    <p id="show_tests_content"></p>
                </div>
                 <div class="form" style="max-width: 600px;">
                    <form class="login-form">
                        <p id="exam">Test Section</p>
                    </form>
                </div>
              </div>
            </div>
        </div>
        <div id="Grades" class="tabcontent">
            <div class="full">
              <div class="centered" style="">
                <h2>View Grades</h2>
                <div class="form">
                    <form>
                        <input type="text" placeholder="UCID" id="UCIDScore"/>
                        <input type="text" placeholder="Test ID" id="TestIDScore"/>
                        <input type="button" onclick="showStudentScore();" value="Show Score" id="showScore"/>
                    </form>
                    <p id="show_scores"></p>
                </div>
              </div>
            </div>
        </div>

        <script>
            function showTests()
            {
                var Status = 'Not Taken';
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                      document.getElementById("show_tests_content").innerHTML =
                      this.responseText;
                    }
                  };
                
                
                //KRYSTAL'S POST.PHP URL IN THE NEXT LINE 
                xhttp.open("POST","https://web.njit.edu/~sk2292/Beta/show_tests.php");
                xhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
                xhttp.send("Status="+Status);

            }    

            function openTest()
            {
                var TestID = document.getElementById('TestIDGetTest').value;
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                      document.getElementById("exam").innerHTML =
                      this.responseText;
                    }
                  };
                
                
                xhttp.open("POST","https://web.njit.edu/~sk2292/Beta/get_test.php");
                xhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
                xhttp.send("TestID="+TestID);

            }
            
            function showStudentScore()
            {
                var UCID = document.getElementById('UCIDScore').value;
                var TestID = document.getElementById('TestIDScore').value;
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                      document.getElementById("show_scores").innerHTML =
                      this.responseText;
                    }
                  };
                
                
                //KRYSTAL'S POST.PHP URL IN THE NEXT LINE 
                xhttp.open("POST","https://web.njit.edu/~sk2292/Beta/student_scores.php");
                xhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
                xhttp.send("UCID="+UCID+"&TestID="+TestID);

            }    
            
            function openPage(pageName, elmnt, color) {
              // Hide all elements with class="tabcontent" by default */
              var i, tabcontent, tablinks;
              tabcontent = document.getElementsByClassName("tabcontent");
              for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
              }
              // Remove the background color of all tablinks/buttons
              tablinks = document.getElementsByClassName("tablink");
              for (i = 0; i < tablinks.length; i++) {
                tablinks[i].style.backgroundColor = "#BBDEF0";
              }
              // Show the specific tab content
              document.getElementById(pageName).style.display = "block";
              // Add the specific color to the button used to open the tab content
              elmnt.style.backgroundColor = color;
            }
            // Get the element with id="defaultOpen" and click on it
            document.getElementById("defaultOpen").click();
        </script>
        
        


    </body>
    
</html>
    

