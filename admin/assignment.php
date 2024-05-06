<?php
include 'main.php';
// Default input product values
$assignment = [
    
];

include_once "../controllers/bids_controller.php";

$bids_ctrl = new BidsController(true);

// If editing an assignment
if (isset($_GET['id'])) {
    // Get the assignment from the database
    $sql = 'SELECT a.id,a.title,a.description,a.topic,a.emergency,a.attachment,a.created_at,a.status,b.id as `user_id`,b.username,b.email FROM assignments as a INNER JOIN accounts as b on b.id=a.user_id WHERE a.id = ?';
    // var_dump($sql);
    // exit();
    $stmt = $con->prepare($sql);
    $stmt->bind_param('i', $_GET['id']);
    $stmt->execute();
    $stmt->bind_result($result_id, $result_title, $result_description,  $result_topic, $result_emergency, $result_attachment, $result_created, $result_status,$result_user_id,$result_username,$result_email);

    // var_dump($result_id);
    $stmt->fetch();
    $stmt->close();
    $assignment = [
        'id' => $result_id, 
        'user_id' => $result_user_id, 
        'username' => $result_username, 
        'title' => $result_title, 
        'description' => $result_description, 
        'topic' => $result_topic, 
        'emergency' => $result_emergency, 
        'attachment' => $result_attachment, 
        'created' => $result_created, 
        'status' => $result_status
    ];    
    // ID param exists, edit an existing account
    $page = 'View';
    // if (isset($_POST['submit'])) {
    //     // Update the account
    //     $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : $account['password'];
    //     $stmt = $con->prepare('UPDATE accounts SET username = ?, password = ?, email = ?, activation_code = ?, rememberme = ?, role = ?, registered = ?, last_seen = ? WHERE id = ?');
    //     $stmt->bind_param('ssssssssi', $_POST['username'], $password, $_POST['email'], $_POST['activation_code'], $_POST['rememberme'], $_POST['role'], $_POST['registered'], $_POST['last_seen'], $_GET['id']);
    //     $stmt->execute();
    //     header('Location: accounts.php?success_msg=2');
    //     exit;
    // }
    if (isset($_POST['delete'])) {
        // Redirect and delete the account
        header('Location: assignments.php?delete=' . $_GET['id']);
        exit;
    }
} else {
    // Create a new assignment
    $page = 'Create';
    // if (isset($_POST['submit'])) {
    //     $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    //     $stmt = $con->prepare('INSERT IGNORE INTO accounts (username,password,email,activation_code,rememberme,role,registered,last_seen) VALUES (?,?,?,?,?,?,?,?)');
    //     $stmt->bind_param('ssssssss', $_POST['username'], $password, $_POST['email'], $_POST['activation_code'], $_POST['rememberme'], $_POST['role'], $_POST['registered'], $_POST['last_seen']);
    //     $stmt->execute();
    //     header('Location: accounts.php?success_msg=1');
    //     exit;
    // }
}
?>
<?=template_admin_header($page . ' Assignment', 'assignments', 'manage')?>

<h2>Assignment &gt; <?php echo $assignment["title"];?></h2>

<div class="content-block">

    <table>
        <tr>
            <th style="min-width:600px;">DETAILS</th>
            <th style="width:40%;">CANDIDATES</th>
            <th style="width:40%;">SOLUTION</th>
        </tr>
        <tr>
            <td>
                <table>
                    <tr>
                        <th style="width:100px;text-align:right;">Posted by:</th>
                        <td><?php echo $assignment["username"];?> <?php if( $assignment['user_id'] != $_SESSION['id'] ){ ?><a href="../messages/?member_id=<?=$assignment['user_id']?>" title="Open chat with <?=$assignment['username']?>" target="_blank"><i class="fas fa-comment"></i></a><?php } ?></td>
                    </tr>
                    <tr>
                        <th style="text-align:right;">Date:</th>
                        <td><?php
                    
                    $tmp1 = explode(" " , $assignment['created'] );
					$tmp2 = explode("-" , $tmp1[0] );

                    $created_at_date =   $tmp2[1] . "/" . $tmp2[2] . "/" . substr($tmp2[0],2,2)  . " " . $tmp1[1];	

                    echo $created_at_date;

                    ?></td>
                    </tr>
                    <tr>
                        <th style="text-align:right;">Emergency:</th>
                        <td><?=str_replace("????","",$assignment['emergency'])?></td>
                    </tr>
                    <tr>
                        <th style="text-align:right;">Topics:</th>
                        <td><?php echo $assignment["topic"];?></td>
                    </tr>  
                    <tr>
                        <th style="text-align:right;">Attachment:</th>
                        <td><?php 
                        $attachment = $assignment["attachment"];
                        if( $attachment != ""){

                            $tmp = explode( "." , $attachment );
                            if( strtolower($tmp[1]) == "jpg" || strtolower($tmp[1]) == "jpeg" || strtolower($tmp[1]) == "png" || strtolower($tmp[1]) == "gif" || strtolower($tmp[1]) == "tiff"){
                                $attachment ="<a href='/uploads/".$attachment."' target='_blank' title='click to view image'><img style='width:80px;'	src='/uploads/".$attachment."' alt=''/></a>";
                            }else if( strtolower($tmp[1]) == "zip"){
                                $attachment ="<a href='/uploads/".$attachment."' target='_blank'>Download</a>";
                            }else{
                                $attachment = "Unknown file";
                            }
            
                        }else{
                            $attachment = "-";
                        }     
                        echo $attachment;                   
                        ?></td>
                    </tr>                      
                    <tr>
                        <td colspan="2" style="padding:15px;text-align:center;"><h3><?php echo $assignment["title"];?></h3></td>
                    </tr>

                    <tr>
                        <td colspan="2"><?php 
                        $pretty_content =  $assignment["description"];

                        $pretty_content =  preg_replace('/<code>(.*)<\/code>/si', "<pre style='background-color:#efefef;padding:5px;'>$1</pre>", $pretty_content,-1);

                        $pretty_content = str_replace("\n" , "<br>" , $pretty_content);

                        echo $pretty_content;
                
                        
                        ?></td>
                    </tr>                    
                                                                              
                </table>

            </td>
            <td valign="top" style="padding:5px;background-color:#efefef;">

                <div id="candidates" style="text-align:center;">
                    <?php
                    $list = $bids_ctrl->get_candidates_list( $assignment["id"], $_SESSION["id"], $_SESSION["role"]);
                    
                    echo $list[1] ;
                    ?>
                </div>
            </td>
            <td valign="top" >

                <?php
                $solution = $bids_ctrl->get_selected_bid( $assignment["id"], $_SESSION["role"]);                    
                ?>
                <div id="selected_candidate" style="text-align:center;background-color:#fff;border:1px solid #ececec;padding:20px;">
                <?php echo "Selected Candidate <br><strong>" . $solution["winner"] . "</strong>"; ?>
                </div>

                <div id="given_solution" style="text-align:center;background-color:#fff;border:1px solid #ececec;padding:20px;margin-top:30px;">
                <?php echo "Given Solution <br><strong>" . $solution["solution"] . "</strong>"; ?>
                </div>

            </td>            
    </table>

</div>

<?=template_admin_footer()?>