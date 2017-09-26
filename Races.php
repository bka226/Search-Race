<?php
/*
/////////////////////////////////////////////////////////////
//		 Name: Binod Katwal			                         //
//		 Class: CS316 TUTH 12:30 pm		                    //
//		 Project: 4				                            //
//		 Date: 02/04/2017			                        //
//							                               //
/////////////////////////////////////////////////////////////

The purpose of the program 4 is to learn basic web application
in PHP that will create  a dynamic search form.  The PHP script
will take user input from the form and perform basic searches on
files local to the webserver. Searches will involve JSON objects stored in those files.

*/
/*/////////////////////////////////////////////////////////////////////////////
///////////////////////    MAIN FUNCTION    ////////////////////////////////
/////////////////////////////////////////////////////////////////////////////*/

if(isset($_GET["raceToSearch"])) {
 //  echo " <h2> You are in Process function!</h2>";     
        processForm(); //Process to run user selection

    } 
    else {
    
       displayForm(); // display function
    }
    

/*/////////////////////////////////////////////////////////////////////////////
///////////////////////    DISPLAY FUNCTION    ////////////////////////////////
/////////////////////////////////////////////////////////////////////////////*/

function displayForm() {
    
   startHTML(); //begining of the html
    
    $Races = file_get_contents("./2016_Races.json", true); // Json file 
    
    // pre-condition:  $filesJSON is a string of JSON objects
    $results = json_decode($Races);
    
    
    $Race2016 = $results->races;
    $Match2016 = $results->match;
    $Stats2016 = $results->stats;
    //decared variables
     $enumRaces = "";
     $enumMatches = "";
     $enumStats ="";
     //using  three different foreach loop to grabs the $key and their $values from JSON file
    foreach($Race2016 as $key => $value) {
        
        
        $enumRaces = $enumRaces . "<option value= $value > $key </option>";
    }
    
    foreach($Match2016 as $key => $value) {
        
        $enumMatches  =  $enumMatches . "<option value=$value > $value </option>";
    }
    foreach($Stats2016 as $key => $value) {
        
        $enumStats  =  $enumStats . "<option value=$value > $value </option>";
    }
//HTML inside PHP by using ECHO
//Displays  HTMl into the web  to execute

    echo "
    <form action='Races.php' method='get'>
    Select parameters to search:<br>Error0";
    
    
    echo "
    <p>
    <select name='raceToSearch'>
    $enumRaces;
    </select>";
   echo "
    <p>
    <select name='whatToMatch'>
    $enumMatches
    </select>  <input type='text' name='matchValue'> " ;

    echo "
    <p>
    <select name='statToFind'>
    $enumStats
    </select>";
    
    echo "
    <p>
    <select name='maxOrmin'> ";
        echo "<option value='Max'>Max</option>";
        echo "<option value='Min'>Min</option>";
    echo "</select>";
    
    echo "
    <p>
    <input type='submit' value='Do search'>
    ";
    


    endHTML();
}
    
    // beginning of the html 
//**********************//
    function startHTML() {
        
        echo "
        <html>
        <head>
        <title>Search records!</title>
        </head>
        <body bgcolor= 'lightgreen'>
        <h1>Search records!</h1>
        ";
        
    }
    // ENd of the html
//********************//
    function endHTML() {
        
        echo "
        </body>
        </html>
        ";
        
    }
    

/*/////////////////////////////////////////////////////////////////////////////////////
///////////////////////    PROCESS FUNCTION FOR MAIN   ////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////*/
    function processForm() 

    {
        $myError = 0;
        
        //isset() will check if a variable is set using  PHP interpreter
        
        if ( isset($_GET["raceToSearch"]) and
            isset($_GET["whatToMatch"]) and
             isset($_GET["matchValue"]) and
             isset($_GET["statToFind"]) and
             isset($_GET["maxOrmin" ]) ) 
        {
        
            $raceTosearch = $_GET["raceToSearch"];
           $whatToMatch = $_GET["whatToMatch"];
           $matchValue = $_GET["matchValue"];
            $statToFind = $_GET["statToFind"];
            $maxOrmin =$_GET["maxOrmin"];
            
        } else 
        {
            err_400 ();
            return;
        }
        
        
        doSearch($raceTosearch, $whatToMatch,$matchValue, $statToFind, $maxOrmin); 
        //call do search function
        
        
        return;
    }
    
    
/*//////////////////////////////////////////////////////////////////////////////////////////
///////////////////////    DO SEARCH FUNCTION USE IN PROCESS FUNCTION    //////////////////
////////////////////////////////////////////////////////////////////////////////////////// 
*/

    //  Pre-conditions: 
    // $r contains a string representation of a season file
    //$w is want to search for WHAT TO MATCH as user input match value
    // $s is a statistic we want to search for
    //  $m is what function (Max or Min) we want.
    //  Post-conditions: Output of the information of the matching game.

// First Do Search will get the file then grab runners information  
// If user use "nothing" for what to match then valueMatch text will display error if not blank else goes to next step
// If user choose "age" for what to match, then ValueMatch will display error if blank or incorrect text else  next step
// if user choose " other option" from what to match, applies similar rule as age function.
function doSearch($r,$w,$a,$s,$m) 
{
      //The  Below code will search for the files which are avaliable for us to use or not.

        if ( file_get_contents($r)) {
            $fileContents = file_get_contents($r);
        
        } else if (file_get_contents("2016_".$r)){
         $r = "2016_" . $r;
            $fileContents = file_get_contents($r);
        
        }
        else {
        echo "<br><h2>THE FILE DOESN'T EXIST!</h2><br> "; // If the file is invalid, it will display this message
            return;
        }
    //declaration of variables
        $resultMatch = null;
         $currMatch = null;
        $currStat = null; 
        $resultStat = null;
        //produce a JSON object from the Races.json
        $gamesJSON = json_decode($fileContents,true);
        // declared errors
        $readErr = json_last_error();
        // error condition 
        if (  $readErr != JSON_ERROR_NONE) { // if not equal
            printJSONerror ( json_last_error ());
            exit();
        } else { // otherwise 
            // GAMES declared, gets runners
            $games = $gamesJSON["runners"]; //get the JSON file and sets games as runners targets
        }

  



///////////////////// Check stat function if there is numerical value  ////////////////////////////// //  If numerical value is not found then display below or else not found if empty stats //
        // if WhatToMatch is not numeric //
       


//if ( is_numeric() == FALSE and $games[0][$w] != null )
// if whatTomatch form runners is  not found or if all runners whattomatch is //correct
if ($games[$w] == null || $games[0][$w] !=FALSE) 
{         


    if  ($_GET["whatToMatch"]!= "Nothing" ) // if user choose Nothing
    {

        //echo "<br>  Requsested0!!!<br>";
        
        if ( $m == "Max") // if  max 
        {
          //convTimeToSeconds($s);
            // This code will grab the convtimeToSecond function and convert to seconds
                        if (strpos($value, "."))
                             {
                                $value= convTimeToSeconds($value);//call
                             }
                $currStat = $games[0][$s]; // declare current stat to the games array 
           
                foreach ( $games as $value ) 
                {
                    if ($value[$s] == " ") //or whatever
                        {continue; }
                    
             if (  $a==$value[$w]  )   // If matchValue is $a is matched in the value that are store in  whatToMatch
                    {  
                        
//if stats runners is greater than current
                     
                        if ( $value[$s] > $currStat ) // CHECK AND SEE IF CONDITION GETTER OR NOT
                        {

                          //  echo "hello";
                   
                            unset($resultStat);

                            $resultCountr=0;
                            $currStat = $value[$s];   
                
                         
                            $resultStat[$resultCountr++]= $value;
                         } 
                 else if ($value[$s] < $currStat ) 
                            {
                             unset($resultStat);
                            $resultCountr=0;
                            $currStat = $value[$s];
                            $resultStat[$resultCountr++]= $value;      
                             }  
                    
                     }  
                     
                    } 
                    

                }  
            
   
        
        if ( $m == "Min") // if  max 
        {
          //convTimeToSeconds($s);
            // This code will grab the convtimeToSecond function and convert to seconds
                        if (strpos($value, "."))
                             {
                                $value= convTimeToSeconds($value);
                             }
                $currStat = $games[0][$s]; // declare current stat to the games array 
           
                foreach ( $games as $value ) 
                { if ($value[$s] == null) //or whatever
                        {continue;  }
                    
               
                    if (  $a==$value[$w]  )   // If matchValue is $a is matched in the value that are store in  whatToMatch
                    {  
                        //if stats runners is lesser than current
                       if ( $value[$s] < $currStat ) // CHECK AND SEE IF CONDITION GETTER OR NOT
                        {
                   
                            unset($resultStat);

                            $resultCountr=0;
                            $currStat = $value[$s]; 


                            $resultStat[$resultCountr++]= $value;
                         
                        }  
                        //the conditional statement checks if the stat is comparable // incase the iteration match
                 else if ($value[$s] == $currStat ) 
                            {

                             unset($resultStat);
                            $resultCountr=0;
                            $currStat = $value[$s];
                            $resultStat[$resultCountr++]= $value;      
                             }  
                   }  
                
                     }

                }  
            
    

        
 
     }
 
//////////////////////////////////// For NOTHING WhatToMatch////////////////////////////////////////
// IF USER CHOSE NOT TO MATCH THE VALUE AND MAKE THE SELECTION OF NOTHING.

else  if ($_GET["whatToMatch"]== "Nothing" )
{
    //echo "<br> Requested2!!!<br>";
if ( $m == "Max") 
        {
         
//convTimeToSeconds($s);
            // This code will grab the convtimeToSecond function and convert to seconds
                        if (strpos($value, "."))
                             {
                                $value= convTimeToSeconds($value);//call
                             }
             
            
            $currStat = $games[0][$s]; ////declared $currStae as the all runners
           
            foreach ( $games as $value ) {
                if ($value[$s] == " ") //or whatever
                        {continue; }

             /*if ( $a!= null) // if valueMatch is not empty then perform
              {
                    echo " <h2> <br>If 'Nothing' is selected,Text Area must be blank!!!</h2>";
                    exit;
                else }*/
                //the conditional statement checks if the stat is comparable 
                //also the reason it checks for every single runners, is if in case some
                //runners has incompelete data doesn't stop the program from running
                //hence the programs shows the result compared between other runners.

                    //if stats runners is greater than current
               if ( $value[$s] > $currStat ) { // to find the max, stat value has to be greater
                   
                    unset($resultStat);
                    $resultCountr=0;
                    $currStat = $value[$s];
                    $resultStat[$resultCountr++]= $value;

                //the conditional statement checks if the stat is comparable numerical // incase the iteration match
                } else if  (is_numeric($value[$s]) and $value[$s] == $currStat ) {
                        
                            $resultStat[$resultCountr++] = $value;        
                } 
            } }   

else if ( $m == "Min") 
            {

//convTimeToSeconds($s);
            // This code will grab the convtimeToSecond function and convert to seconds
                        if (strpos($value, "."))
                             {
                                $value= convTimeToSeconds($value);//call
                             }
             
            //declared $currStae as the all runners
                $currStat = $games[0][$s]; // declaration of current stats
            
                foreach ( $games as $value ) 
                {  if ($value[$s] == null) //or whatever
                        {continue;  }

           /* if ( $a!= null)// if valueMatch is not empty then perform
            {
                echo " <h2> <br>If 'Nothing' is selected,Text Area must be blank!!!</h2>";
                exit();
            }*/
                  //the conditional statement checks if the stat is comparable numerical 

            if (is_numeric($value[$s]) and $value[$s] < $currStat  ) // to find the min, stat value has to be smaller
            {
                    
                                unset($resultStat);
                                $resultCountr=0; // declared
                                $currStat = $value[$s]; //Array of $s is now the current 
                                $resultStat[$resultCounter++] = $value;
            }
                      
            else if ($value[$s] == $currStat )  // incase the iteration match
                        {
                    
                         $resultStat[$resultCountr++] = $value;
                        } 
           
                } 
            
            }
} else // otherwise
        {
        //output error 
        echo "<br> <h2> ERROR - NO RECORD FOUND!!!<br> </h2>";
        }
       
//////////////////////// OUTPUT OF THE PORGRAM///////////////////////////////////
if ( $currStat != null and $resultStat != null )  // if not empty condition
{
            
            foreach ($resultStat as $value)  // LOOPS FOR EACH RUNNERS
            {
                
                echo "<br>";
            foreach ( $value as $key => $value ) //runners as the $key : $value
                {

                    echo "<br>";
                    print "$key :";// output

                    print $value; //output

                }
           }    
        //if $a= MatchValue doesn't belong to runner  value and if text is not blank and if text isn't "Nothing " then do below
    }else if ( $a!=$value[$w]and$a!= null and $_GET["whatToMatch"]!= "Nothing" ) 
                    {
                        echo " <h2> Entered value  does not match!!! </h2>";
                        exit();
                    }
// if matchValue text  is blank  and text doesn't belong to runners what to match
    else if ( $a== null and $a!=$value[$w] )
                    {
                        echo "<h2> Blank text does not match!!! </h2>";
                        exit();
                    }
    else  // if above condition does not satisfied then do below
                    {
                        echo "<h2> No Record Found !!!</h2>";
                        exit();
                
                     }
        
        

}  }

// Time function use for converting hours, mins, seconds  into thousands of seconds
// called into function
function convTimeToSeconds($x) {
   $rc = strpos($x, ".");    if ($rc === false) { // no "."
$newstring = $x;
   } else {
// has ".", strip it off $newstring = substr($x, 0, $rc);
   } //   print "Converting: ".$newstring."\n";    $tarray = explode(":",$newstring);
if (count($tarray) > 3 || count($tarray) < 2) {
print "Error on string conversion: ".$newstring."\n"; return -1; // displays arrays 
} if (count($tarray) == 3) {
   $seconds = $tarray[0]*3600+$tarray[1]*60+$tarray[2];
return $seconds;
} if (count($tarray) == 2) {
   $seconds = $tarray[0]*60+$tarray[1];
return $seconds;
}
}
    
//////////////////////////////////////////////////////////////////////////////////////
///////////////////////     PRINT JSON ERROR FUNCTION   ////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////// 
  

// Function will basically prints error messages 
// switch case is use to get specific errors 
function printJSONerror($e) 
{
        
        switch ($e) 
        {
            case JSON_ERROR_NONE:
                //            echo ' - No errors';
                return;
                break;
            case JSON_ERROR_DEPTH:
                echo ' - Maximum stack depth exceeded';
                break;
            case JSON_ERROR_STATE_MISMATCH:
                echo ' - Underflow or the modes mismatch';
                break;
            case JSON_ERROR_CTRL_CHAR:
                echo ' - Unexpected control character found';
                break;
            case JSON_ERROR_SYNTAX:
                echo ' - Syntax error, malformed JSON';
                break;
            case JSON_ERROR_UTF8:
                echo ' - Malformed UTF-8 characters, possibly incorrectly encoded';
                break;
            default:
                echo ' - Unknown error';
                break;
        }
        
        echo PHP_EOL;
        
}




 

?>
