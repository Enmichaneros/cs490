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
                <div>
                    <p id="filter_content" style="padding-right: 10px; padding-left: 10px;"></p>
                </div>
            </div>

            <div class="split right">
                <h2 style="margin-left: 10px;">Add Question</h2>
                <div>
                    <p style="text-align: center;">Enter Question: </p>
                    <p style="padding-bottom: 10px; padding-left: 150px; padding-top: 0px;"><textarea id="question_addQuestion" cols="50" rows="10"></textarea></p>
                    
                    <p style="text-align: center; display: inline; padding-left: 200px;">Function Name: </p><input style="display: inline;" type="text" placeholder="Function Name" id="funcName_addQuestion"/>
                    
                    <div style="text-align: center; padding-top: 20px;">
                        <p style="display: inline;">Difficulty</p>
                        <p style="display: inline; padding-left: 90px; padding-right: 120px; ">Topic</p>
                        <p style="display: inline;">Keyword</p>
                    </div>
                    <div style="text-align: center; padding-bottom: 30px;">
                        <div style="display: inline;">
                            <select id="difficulty_addQuestion">
                                <option value="easy">Easy</option>
                                <option value="medium">Medium</option>
                                <option value="hard">Hard</option>
                            </select>
                        </div>
                        <div style="display: inline; padding-right: 40px; padding-left: 40px;">
                            <select id="topic_addQuestion">
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
                        <div style="display: inline;">
                            <input type="text" placeholder="Keyword" id="keyword_addQuestion"/>
                        </div>
                    </div>
                    
                    <div style="text-align: center; padding-bottom: 20px;">
                        <p style="display: inline;">For Loop:</p><input type='checkbox' id='forloopNec' value="forloopNec" style="display: inline; margin-right: 10px;">
                        <p style="display: inline;">While Loop:</p><input type='checkbox' id='whileloopNec' value="whileloopNec" style="display: inline; margin-right: 10px;">
                        <p style="display: inline;">Return Statment:</p><input type='checkbox' id='returnNec' value="returnNec" style="display: inline; margin-right: 10px;">
                        <p style="display: inline;">Print Statment:</p><input type='checkbox' id='printNec' value="printNec" style="display: inline; margin-right: 10px;">
                    </div>
                    
                    <div>
                        <p style="text-align: center; padding-bottom: 10px; padding-top: 0px;">Enter TestCase 1:&nbsp;&nbsp;&nbsp;
                        Input:&nbsp;<textarea id="input0" cols="50" rows="10" style="resize:none; width: 150px;"></textarea>&nbsp;&nbsp;
                        Output:&nbsp;<textarea id="output0" cols="50" rows="10" style="resize:none; width: 150px;"></textarea>
                        </p>
                        <p style="text-align: center; padding-bottom: 10px; padding-top: 0px;">Enter TestCase 2:&nbsp;&nbsp;&nbsp;
                        Input:&nbsp;<textarea id="input1" cols="50" rows="10" style="resize:none; width: 150px;"></textarea>&nbsp;&nbsp;
                        Output:&nbsp;<textarea id="output1" cols="50" rows="10" style="resize:none; width: 150px;"></textarea>
                        </p>
                        <p id="testcase_content2"></p>
                        <p id="testcase_content3"></p>
                        <p id="testcase_content4"></p>
                        <p id="testcase_content5"></p>

                        <input style="margin-bottom: 10px; margin-left: 50px;" type="button" onclick="add_testcase()" value="Add TestCase" id="add_testcase"/>
                    </div>
                    <div>
                        <input style="margin-bottom: 100px; margin-left: 250px;" type="button" onclick="add_question();" value="Add Question" id="add_question"/>
                        <p id="add_question_content" style="margin-bottom: 20px;"></p>
                        <p id="add_question_content" style="margin-bottom: 100px;">&nbsp;</p>
                    </div>
                </div>
            </div>
        </div>
        <script>
            var testcaseNum = 1;
            function add_testcase() {
                if (testcaseNum >= 5) {
                    document.getElementById("add_testcase").value = "Reached Max Test Cases";
                    return;
                }
                ++testcaseNum;
                testcase = "<p style='text-align: center; padding-bottom: 10px; padding-top: 0px;'>Enter TestCase "+(testcaseNum+1)+":&nbsp;&nbsp;&nbsp;Input:&nbsp;<textarea id='input"+testcaseNum+"' cols='50' rows='10' style='resize:none; width: 150px;'></textarea>&nbsp;&nbsp;Output:&nbsp;<textarea id='output"+testcaseNum+"' cols='50' rows='10' style='resize:none; width: 150px;'></textarea></p>";
                id = "testcase_content"+testcaseNum
                document.getElementById(id).innerHTML = testcase;

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
            function add_question() {
                var QText = document.getElementById('question_addQuestion').value;
                var FuncName = document.getElementById('funcName_addQuestion').value;
                var Diff = document.getElementById('difficulty_addQuestion').value;
                var Keyword = document.getElementById('keyword_addQuestion').value;
                var Topic = document.getElementById('topic_addQuestion').value;
                var ForLoop = document.getElementById('forloopNec').checked;
                var WhileLoop = document.getElementById('whileloopNec').checked;
                var Return = document.getElementById('returnNec').checked;
                var Print = document.getElementById('printNec').checked;
                var Input = "";
                var Output = "";
                for (var i = 0; i <= testcaseNum; ++i) {
                    var inp = "input"+i;
                    var out = "output"+i;
                    Input += document.getElementById(inp).value + "```";
                    Output += document.getElementById(out).value + "```";

                }
//                document.getElementById("add_question_content").innerHTML = Input;
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("add_question_content").innerHTML = this.responseText+" "+FuncName;
                        location.reload();
                    }
                  };
                
                
                xhttp.open("POST","https://web.njit.edu/~jj373/RC/add_questions.php");
                xhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
                xhttp.send("QText="+QText+"&FuncName="+FuncName+"&Input="+Input+"&Output="+Output+"&Diff="+Diff+"&Keyword="+Keyword+"&Topic="+Topic+"&ForLoop="+ForLoop+"&WhileLoop="+WhileLoop+"&Return="+Return+"&Print="+Print);
            }
        </script>
<?php 
	include_once 'footer.php';
 ?>

