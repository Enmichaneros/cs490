<?php 
	include_once 'teacherheader.php';
 ?>

        <div class="content">
            <div class="split left">
                <h2 style="margin-left: 10px;">Filter Questions</h2>
                <div style="text-align: center;">
                    <p style="display: inline; padding-right: 70px;">Difficulty</p>
                    <p style="display: inline; padding-right: 100px;">Topic</p>
                    <p style="display: inline; padding-right: 125px;">Keyword</p>
                </div>
                <div style="text-align: center;">
                    <div style="display: inline; padding-right: 35px;">
                        <select id="difficulty">
                            <option value="easy">Easy</option>
                            <option value="medium">Medium</option>
                            <option value="hard">Hard</option>
                            <option value="allDifficulty">All</option>
                        </select>
                    </div>
                    <div style="display: inline; padding-right: 35px;">
                        <select id="topic">
                            <option value="while loops">While Loops</option>
                            <option value="for loops">For Loops</option>
                            <option value="strings">Strings</option>
                            <option value="if statements">If Statements</option>
                            <option value="lists">Lists</option>
                            <option value="turtle">Turtle</option>
                            <option value="def">Def</option>
                            <option value="files">Files</option>
                            <option value="dictionary">Dictionary</option>
                            <option value="namespaces">Namespaces</option>
                            <option value="exceptions">Exceptions</option>
                            <option value="classes">Classes</option>
                            <option value="allTopics">All</option>
                        </select>
                    </div>
                    <div style="display: inline; padding-right: 40px;">
                        <input type="text" placeholder="Keyword" id="keyword"/>
                    </div>
                    <input style="text-align: center;" type="button" onclick="filter_post();" value="Filter" id="filter"/>
                </div>
                <div style='padding-bottom: 100px;'>
                    <p id="filter_content" style="padding-right: 10px; padding-left: 10px;"></p>
                    <input type="button" onclick="addTestQuestion();" value="Add Question to Test ->" id="addTestQues_button">
                </div>
            </div>

            <div class="split right">
                <h2 style="margin-left: 10px;">Make Test</h2>
                <div style='padding-bottom: 100px;'>
                    
                    <p style="text-align: center; display: inline; padding-left: 200px;">Test Name: </p><input style="display: inline;" type="text" placeholder="Function Name" id="testName_makeTest"/>
                    
                    <p id="test_questions_content" style="margin-bottom: 20px; padding-right: 10px; padding-left: 10px;"></p>
                    <p style="margin-left: 475px; display: inline;">Total Points: &nbsp;</p><p id="points_content" style="display: inline; margin-bottom: 10px;" value="0"></p>
                    <input type="button" onclick="makeTest()" value="Create Test">
                    <p id="makeTest_content"></p>
                </div>
            </div>
            
        </div>
        
        <script>
            
            function calcPoints() 
            {
                var totalPoints = 0;
                var points = document.getElementsByClassName('pointsToQues');
                for(var i=0; i<points.length; i++) {
                    if (points[i].value) {
                        totalPoints += parseInt(points[i].value);
                    }
                }
                
                document.getElementById("points_content").innerHTML = String(totalPoints);
                document.getElementById("points_content").value = String(totalPoints);
            }
            
            function filter_post()
            {
                var Diff = document.getElementById('difficulty').value;
                var Keyword = document.getElementById('keyword').value;
                var Topic = document.getElementById('topic').value;
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                      document.getElementById("filter_content").innerHTML =
                      this.responseText;
                    }
                  };
                
                
                //KRYSTAL'S POST.PHP URL IN THE NEXT LINE 
                xhttp.open("POST","https://web.njit.edu/~jj373/RC/filter.php");
                xhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
                xhttp.send("Diff="+Diff+"&Keyword="+Keyword+"&Topic="+Topic);

            }
            
            function addTestQuestion()
            {
                var filterContent = document.getElementsByClassName('checkQuestion');
                var QID = '';
                for(var i=0; i<filterContent.length; i++) {
                    if (filterContent[i].checked) {
                        QID += filterContent[i].name;
                        QID += ' ';
                    }
                }
//                document.getElementById("test_questions_content").innerHTML = QID;

                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                      document.getElementById("test_questions_content").innerHTML =
                      this.responseText;
                    }
                  };
                
                
                //KRYSTAL'S POST.PHP URL IN THE NEXT LINE 
                xhttp.open("POST","https://web.njit.edu/~jj373/RC/select_questions.php");
                xhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
                xhttp.send("QID="+QID);

            }
            
            function makeTest()
            {
                var TestName = document.getElementById('testName_makeTest').value;
                var TotalPoints = document.getElementById('points_content').value;
                
                var Points = '';
                var pointList = document.getElementsByClassName('pointsToQues');
                for(var i=0; i<pointList.length; i++) {
                    Points += pointList[i].value;
                    Points += ' ';
                }
                
                var QIDList = document.getElementsByClassName('selectedQues');             
                var QID = '';
                for(var i=0; i<QIDList.length; i++) {
                    QID += QIDList[i].id;
                    QID += ' ';
                }
                
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                      document.getElementById("makeTest_content").innerHTML =
                      this.responseText + " " + TestName;
                    }
                  };
                
                
                //KRYSTAL'S POST.PHP URL IN THE NEXT LINE 
                xhttp.open("POST","https://web.njit.edu/~jj373/RC/add_test_questions.php");
                xhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
                xhttp.send("TestName="+TestName+"&QID="+QID+"&Points="+Points+"&TotalPoints="+TotalPoints);

            }
        </script>
<?php 
	include_once 'footer.php';
 ?>

