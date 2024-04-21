<?php



include ('db/database.php');
include ('inc/header.php');
include ('inc/navbar.php');


if (!isset($_SESSION['username']) || !isset($_SESSION['loggedin'])) {
    header('Location: Auth/login.php');
}
$clubname = $_GET['search'];

?>
<link rel="stylesheet" href="CSS/club-styles.css">

<body>

    <div class="main">
        <div class="info">
            <div class="clubinfo">

                <?php
                //Retriving the club data;
                $cdata = $pdo->query("SELECT * from clubs where name = '{$clubname}' ORDER BY 'created_at' asc;");
                $cresults = $cdata->fetchAll(PDO::FETCH_ASSOC);
                echo "Name: <a style='font-weight: bold;'> " . $cresults[0]['name'] . "<a><br>";
                echo "Genre: <a style='font-weight: bold;'> " . $cresults[0]['genre'] . "<a><br>";
                echo "Description: <a style='font-weight: bold;'> " . $cresults[0]['description'] . "<a><br>";
                ?>

            </div>
            <div class="members">

                <p style="padding: 0 0 0 10px; margin-bottom: 10px; font-size: 1.3em; font-weight: bold;">Club Members
                </p>

                <?php

                //Retriving the club users from club data and storing it as an ARRAY
                $cusers = explode(' ', $cresults[0]['users']);

                //Using foreach to iterate through all the users of the club to display their names in the members section
                foreach ($cusers as $cuser) {



                    if ($cuser != '') {

                        $bd = $pdo->query("SELECT * FROM users WHERE username = '{$cuser}';");
                        $br = $bd->fetchAll(PDO::FETCH_ASSOC);

                        $book = $br[0]['book'];
                        $bg = $br[0]['bg'];
                        if ($book == NULL) {
                            $book = "Not set";
                        }
                        echo "<div class='member'>";
                        if ($bg != 0) {
                            echo "<img src='{$bg}'>";
                        }
                        echo "<div class='text-container'>"; // Adding a class for styling
                        echo "<a style='font-weight: bold'>" . $cuser . "</a><br>";
                        echo "<a style='font-size: 0.8em;'>Currently reading: {$book}</a>";
                        echo "</div>";
                        echo "</div>";
                    }
                }
                ?>
            </div>
        </div>
        <div class="club">
            <div class="posts">


                <?php
                //------------------------------
                //DISPLAYING POSTS FOR THIS CLUB
                //------------------------------
                
                $postData = $pdo->query("SELECT * FROM post WHERE `club` = '{$clubname}';   ");
                $postResult = $postData->fetchAll(PDO::FETCH_ASSOC);

                //If result is NULL for ie no posts are in the club
                if ($postResult == NULL) {
                    echo "<p style='color: white; font-size: 1.3em;'>Be the first person to make a post in this club.<p>";
                } else {
                    //Else display the posts from the retrived result;
                    foreach ($postResult as $result) {
                        echo "<div class='post'>";
                        echo $result['user'] . "<br>";
                        echo $result['created_at'] . "<br>";
                        echo "<hr>";
                        echo $result['content'] . "<br>";

                        if ($result['user'] == $_SESSION['username']) {

                            $id = $result['id'];
                            $uri = $_SERVER['REQUEST_URI'];

                            echo "<br><form method='post' action='auth/del.php'>";
                            echo "<input type='hidden' name='postid' value='{$id}'>";
                            echo "<input type='hidden' name='returnuri' value='{$uri}'>";
                            echo "<button type='submit'  style='border: none; cursor:pointer; background-color: white'>";
                            echo "<ion-icon name='trash-outline'></ion-icon>";
                            echo "</button>";
                            echo "<br></form>";
                        }
                        echo "</div>";
                    }
                }

                ?>


            </div>



            <?php

            //CHECKS IF THE USER IS IN THE CLUB OR NOT
            
            //RETRIVE THE DATA FROM CLUBS TABLE WITH LIKE [USERNAME] CLAUSE
            $username = $_SESSION['username'];

            //RETRIVE DATA FROM CLUBS TABLE WHERE USERS == USERNAME and CLUBNAME == CURRENT CLUBNAME
            $data = $pdo->query("SELECT `name` from clubs where users LIKE '%{$username}%' AND `name` = '$clubname';");
            $results = $data->fetchAll(PDO::FETCH_ASSOC);

            $joined;

            //IS RESULTS ARE NULL THEN THE USER HAS NOT JOINED THE CLUB
            if ($results == NULL) {
                $joined = false;
            } else {
                //ELSE JOINED == TRUE AND SHOW THE POST CREATE OPTION AND EXIT CLUB OPTION
                $joined = true;

                ?>
                <div class="new">
                    <form action="" method="post" id="form">
                        <textarea name="text" id="text" style="resize:none;" form="form" placeholder="Create new post"
                            rows=5></textarea>
                        <div class="newPost">
                            <input type="submit" name="exitClub" value="Exit Club">
                            <input type="submit" name="sendPost" value="Send">
                        </div>
                    </form>
                </div>

                <?php

            }

            //--------------------
            //JOINING A CLUB
            //--------------------
            


            //CHECK IF JOINED == FALSE IN THE CURRENT CLUB THEN GIVE THE OPTION TO JOIN THE CLUB WITH NO JOIN MSG
            if ($joined == false) {
                ?>
                <div style="display:inline-flex; align-items: center">
                    <p id="msg">You have not joined the club, join to post</p>
                    <form method="post" action="">
                        <input type="submit" name="joinbtn" value="Join">
                    </form>
                </div>

                <?php

                //JOIN CLUB PHP, GETS USERS COLUMN FROM CLUBS TABLE, ADD CURRENT USERNAME TO IT
                //UPDATES THE DATA IN THE CLUBS TABLE USERS COLUMN
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    if (isset($_POST['joinbtn'])) {
                        $clubUserData = $pdo->query("SELECT users from clubs where name = '$clubname';");
                        $clubUserResults = $clubUserData->fetchAll(PDO::FETCH_ASSOC);
                        $clubUsers = $clubUserResults[0]['users'];
                        $clubUser = $clubUsers . ' ' . $username;
                        $query = "UPDATE clubs SET users = '{$clubUser}' Where name = '$clubname';";
                        $res = $pdo->query($query);
                        header("Refresh: 0");
                    }
                }
            }
            ?>

        </div>
    </div>
    </div>

</body>

</html>
<?php

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    //--------------
    //EXITING A CLUB
    //--------------

    if (isset($_POST['exitClub'])) {


        //MAKING A USER EXIT A CLUB BY REMOVING THEIR NAME FROM THE USERS COLUMN IN CLUBS TABLE


        //GETTING EXISTING USERS DATA FOR THAT TABLE
        $clubUserData = $pdo->query("SELECT users from clubs where name = '$clubname';");
        $clubUserResults = $clubUserData->fetchAll(PDO::FETCH_ASSOC);
        $clubUsers = $clubUserResults[0]['users'];


        //SEPARATING DATA INTO ARRAY (FROM STRING)
        $userArr = explode(' ', $clubUsers);
        $userInd = array_search($username, $userArr);

        //DELETING THE USER'S NAME FROM THE ARRAY
        unset($userArr[$userInd]);
        $clubUsers = implode(' ', $userArr);

        //UPDATE THE CLUB TABLE USERS COLUMN WITH NEW USERS DATA
        $query = "UPDATE clubs SET users = '{$clubUsers}' Where name = '{$clubname}';";
        $res = $pdo->query($query);

        header("Refresh: 0");
    }

    //CREATE A NEW POST

    if (isset($_POST['sendPost'])) {

        //GET VALUES 
        $username = $_SESSION['username'];
        $clubname = $_GET['search'];
        $content = nl2br(htmlspecialchars($_POST['text']));

        //INSERT INTO POST TABLE
        $query = "INSERT into post (user,club,content) VALUES (?,?,?);";
        $stmt = $pdo->prepare($query);
        $result = $stmt->execute([$username, $clubname, $content]);

        header("Refresh: 0");
    }

}
?>