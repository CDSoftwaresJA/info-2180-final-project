<?php 
session_start();
$host = getenv('IP');
$username = 'Cduncan';
$password = 'Damdog_101';
$dbname = 'DB';
$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
$users = $conn->query("SELECT * FROM users");
$userslist = $users->fetchAll(PDO::FETCH_ASSOC);
$issues = $conn->query("SELECT * FROM issues");
$issueslist = $issues->fetchAll(PDO::FETCH_ASSOC);

if (isset($_GET['userlist'])){
    foreach ($userslist as $user):
    $email=$user['email'];
    echo str_replace('#', '"',"<option value=#$email#>$email</option>");
    endforeach;
}

# Login and set session variables
if(isset($_GET['email']) && 
isset($_GET['password'])){
    foreach ($userslist as $user):
    if ($user['email']==$_GET['email'] && 
    password_verify($_GET['password'], $user['password'])){

        $_SESSION['email']=$user['email'];
        $_SESSION['password']=$user['password'];
        $_SESSION['id']=$user['id'];
        echo "true";
    }
    endforeach;

	}
	
	
#Session Email Adress
if(isset($_GET['session_id'])){
    echo $_SESSION['email'];
}

# Display all users
if(isset($_GET['display_users'])){
    foreach ($userslist as $user):
        $line=$user['id'].','.$user['lastname'] .','.$user['firstname'];
        echo $line;
        echo "<br>";
        
    endforeach;

	}
	
# Display all issues
if(isset($_GET['display_issues'])){
   echo " <table>";
        echo "<tr>";
        echo "    <th>ID</th>";
        echo "    <th>Type</th>";
        echo "    <th>Status</th>";
        echo "    <th>Assigned To</th>";
        echo "    <th>Created</th>";
        echo "  </tr>";
    foreach ($issueslist as $issue):
        $id=$issue['id'];
        $title=$issue['title'];
        $type=$issue['type'];
        $status=$issue['status'];
        $assigned_to=$issue['assigned_to'];
        $created=$issue['created'];
        echo "<tr>";
        echo str_replace('#', '"',"    <td><button class =#issue_page# type=#button#>$id $title</button></td>");   
        echo "    <td>$type</td>";
        if (strcmp($status,"OPEN")==0){
        echo str_replace('#', '"',"    <td id=#open#>$status</td>");    
        }elseif(strcmp($status,"CLOSED")==0){
        echo str_replace('#', '"',"    <td id=#closed#>$status</td>");     
        }elseif(strcmp($status,"IN PROGRESS")==0){
        echo str_replace('#', '"',"    <td id=#inprogress#>$status</td>");     
        }
        
        
        echo "    <td>$assigned_to</td>";
        echo "    <td>$created</td>";
        echo "  </tr>";
        
    endforeach;
        echo "</table>";
}

# Display all open issues
if(isset($_GET['display_issues_open'])){
   echo " <table>";
        echo "<tr>";
        echo "    <th>ID</th>";
        echo "    <th>Type</th>";
        echo "    <th>Status</th>";
        echo "    <th>Assigned To</th>";
        echo "    <th>Created</th>";
        echo "  </tr>";
    foreach ($issueslist as $issue):
        if (strcmp($issue['status'], 'OPEN') == 0){
        $id=$issue['id'];
        $title=$issue['title'];
        $type=$issue['type'];
        $status=$issue['status'];
        $assigned_to=$issue['assigned_to'];
        $created=$issue['created'];
        echo "<tr>";
        echo str_replace('#', '"',"    <td><button class =#issue_page# type=#button#>$id $title</button></td>"); 
        echo "    <td>$type</td>";
        if (strcmp($status,"OPEN")==0){
        echo str_replace('#', '"',"    <td id=#open#>$status</td>");    
        }elseif(strcmp($status,"CLOSED")==0){
        echo str_replace('#', '"',"    <td id=#closed#>$status</td>");     
        }elseif(strcmp($status,"IN PROGRESS")==0){
        echo str_replace('#', '"',"    <td id=#inprogress#>$status</td>");     
        }
        echo "    <td>$assigned_to</td>";
        echo "    <td>$created</td>";
        echo "  </tr>";
        }
    endforeach;
    echo "</table>";
}

# Display all my tickets
if(isset($_GET['display_issues_tickets'])){
   echo " <table>";
        echo "<tr>";
        echo "    <th>ID</th>";
        echo "    <th>Type</th>";
        echo "    <th>Status</th>";
        echo "    <th>Assigned To</th>";
        echo "    <th>Created</th>";
        echo "  </tr>";
    foreach ($issueslist as $issue):
        if (strcmp($issue['assigned_to'], $_SESSION['email']) == 0){
        $id=$issue['id'];
        $title=$issue['title'];
        $type=$issue['type'];
        $status=$issue['status'];
        $assigned_to=$issue['assigned_to'];
        $created=$issue['created'];
        echo "<tr>";
        echo str_replace('#', '"',"    <td><button class =#issue_page# type=#button#>$id $title</button></td>"); 
        
        echo "    <td>$type</td>";
        if (strcmp($status,"OPEN")==0){
        echo str_replace('#', '"',"    <td id=#open#>$status</td>");    
        }elseif(strcmp($status,"CLOSED")==0){
        echo str_replace('#', '"',"    <td id=#closed#>$status</td>");     
        }elseif(strcmp($status,"IN PROGRESS")==0){
        echo str_replace('#', '"',"    <td id=#inprogress#>$status</td>");     
        }
        
        echo "    <td>$assigned_to</td>";
        echo "    <td>$created</td>";
        echo "  </tr>";
        }
    endforeach;
    echo "</table>";
}

# Add a new user
if(isset($_GET['Firstname']) && 
isset($_GET['Lastname']) && 
isset($_GET['Password']) && 
isset($_GET['Email'])){
    $firstname=$_GET['Firstname'];
    $lastname=$_GET['Lastname'];
    $password=password_hash($_GET['Password'], PASSWORD_DEFAULT);
    $email=$_GET['Email'];
    $date_joined=date("Y/m/d");;
    $id=rand();
    $conn->query(str_replace('#', '"',"INSERT INTO users (id, firstname, lastname,password,email,date_joined)
        VALUES (#$id#,#$firstname#, #$lastname#, #$password#,#$email#,#$date_joined#); "));
}

# Add a new issue
if(isset($_GET['title']) && 
isset($_GET['description']) && 
isset($_GET['assignedto']) && 
isset($_GET['type'])&& 
isset($_GET['priority'])){
    $title=$_GET['title'];
    $description=$_GET['description'];
    $assignedto=$_GET['assignedto'];
    $type=$_GET['type'];
    $priority=$_GET['priority'];
    $status="OPEN";
    $createdBy=$_SESSION['email'];
    $created=date("Y/m/d");
    $updated=date("Y/m/d");
    $id=rand();
    $conn->query(str_replace('#', '"',"INSERT INTO issues 
    VALUES (#$id#,#$title#,#$description#, #$type#, #$priority#,#$status#,#$assignedto#,#$createdBy#,#$created#,#$updated#); "));
    
}


#Find Issue Information based on Issue Number
if (isset($_GET['issueID'])){
        foreach ($issueslist as $issue):
            if (strcmp(issueID,issue['id'])){
                $title= $issue['title'];
                $id= $issue['id'];
                $description= $issue['description'];
                $created= $issue['created'];
                $updated= $issue['updated'];
                $assigned_to= $issue['assigned_to'];
                $type= $issue['type'];
                $priority= $issue['priority'];
                $createdBy=$issue['created_by'];
                $status= $issue['status'];
                echo "<h1>$title</h1>";
                echo "<h4> Issue #$id</h4>";
                echo "<p>$description</p>";
                echo "<ul>";
                echo " <li>Issue created on: $created by $createdBy </li>";
                echo " <li>Issue updated on on: $updated</li>";
                echo "<li>Assigned to: $assigned_to</li>";
                echo "<li>Assigned to: $type</li>";
                echo "<li>Assigned to: $priority</li>";
                echo "<li>Assigned to: $status</li>";
                echo "</ul>";
                
            }    
        
        endforeach;
}

# Log out
if(isset($_GET['logout'])){
	    
	    session_unset();
	    session_destroy(); 
    
}

?>
