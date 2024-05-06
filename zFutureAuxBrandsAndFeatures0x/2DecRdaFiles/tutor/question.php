<?php
include 'main.php';
// Default input product values
$question = [
    
];

include_once "../controllers/bids_controller.php";

$bids_ctrl = new BidsController(true);

// If editing an question
if (isset($_GET['id'])) {
    // Get the question from the database
    $sql = 'SELECT a.id,a.title,a.description,a.topic,a.emergency,a.attachment,a.created_at,a.status,b.id as `user_id`,b.username,b.email FROM questions as a INNER JOIN accounts as b on b.id=a.user_id WHERE a.id = ?';
    // var_dump($sql);
    // exit();
    $stmt = $con->prepare($sql);
    $stmt->bind_param('i', $_GET['id']);
    $stmt->execute();
    $stmt->bind_result($result_id, $result_title, $result_description,  $result_topic, $result_emergency, $result_attachment, $result_created, $result_status,$result_user_id,$result_username,$result_email);

    // var_dump($result_id);
    $stmt->fetch();
    $stmt->close();
    $question = [
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
        header('Location: questions.php?delete=' . $_GET['id']);
        exit;
    }

    if (!empty($_GET['action']) && !empty($_GET['owner_id']) && $_GET['action']=="bid" && !empty($_GET['bid_amount']) && is_numeric($_GET['bid_amount'])  ) {

        $owner_id = $_GET['owner_id'];
        $bid_amount = $_GET['bid_amount'];
        $bid_action = $bids_ctrl->set_user_bid( $question["id"], $owner_id , $bid_amount, $_SESSION["id"] );
        if($bid_action["status"] == 1){
            $success_msg = "Congratulations you have placed your Bid!";
        }else{
            $error_msg = $bid_action["message"];
        }
    }    


    if (!empty($_GET['action']) && !empty($_GET['owner_id']) && $_GET['action']=="retract") {

        $owner_id = $_GET['owner_id'];
        $bid_action = $bids_ctrl->retract_user_bid( $question["id"], $owner_id , $_SESSION["id"] );
        if($bid_action["status"] == 1){
            $success_msg = "Congratulations you have retracked your Bid!";
        }else{
            $error_msg = $bid_action["message"];
        }
    }    
    
    if (!empty($_POST['solution_action']) && !empty($_GET['owner_id']) && $_POST['solution_action']=="update_solution") {

        $question_id    = $_GET['id'];
        $bid_id         = $_GET['bid_id'];
        $owner_id       = $_GET['owner_id'];
        $solution       = $_POST['solution'];

        $action_status = $bids_ctrl->update_solution( $question_id, $bid_id,  $owner_id , $solution, $_SESSION["id"] );
        if($action_status["status"] == 1){
            $success_msg = "Congratulations you have updated your solution.";
        }else{
            $error_msg = $action_status["message"];
        }        
    }            

    if (!empty($_POST['solution_action']) && !empty($_GET['owner_id']) && $_POST['solution_action']=="finalise_solution") {

        $question_id    = $_GET['id'];
        $bid_id         = $_GET['bid_id'];
        $owner_id       = $_GET['owner_id'];
        $solution       = $_POST['solution'];

        $action_status = $bids_ctrl->finalise_solution( $question_id, $bid_id, $owner_id , $solution, $_SESSION["id"] );
        if($action_status["status"] == 1){
            $success_msg = "Congratulations you have finalised your solution.";
        }else{
            $error_msg = $action_status["message"];
        }           
    }            

} else {
    // Create a new question
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
<?=template_admin_header($page . ' Question', 'questions', 'manage')?>

<h2>Question &gt; <?php echo $question["title"];?></h2>
<?php if (isset($success_msg)): ?>
<div class="msg success">
    <i class="fas fa-check-circle"></i>
    <p><?=$success_msg?></p>
    <i class="fas fa-times"></i>
</div>
<?php endif; ?>

<?php if (isset($error_msg)): ?>
<div class="msg error">
    <i class="fas fa-check-circle"></i>
    <p><?=$error_msg?></p>
    <i class="fas fa-times"></i>
</div>
<?php endif; ?>

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
                        <td><?php echo $question["username"];?> <?php if( $question['user_id'] != $_SESSION['id'] ){ ?><a href="../messages/?member_id=<?=$question['user_id']?>" title="Open chat with <?=$question['username']?>" target="_blank"><i class="fas fa-comment"></i></a><?php } ?></td>
                    </tr>
                    <tr>
                        <th style="text-align:right;">Date:</th>
                        <td><?php
                    
                    $tmp1 = explode(" " , $question['created'] );
					$tmp2 = explode("-" , $tmp1[0] );

                    $created_at_date =   $tmp2[1] . "/" . $tmp2[2] . "/" . substr($tmp2[0],2,2)  . " " . $tmp1[1];	

                    echo $created_at_date;

                    ?></td>
                    </tr>
                    <tr>
                        <th style="text-align:right;">Emergency:</th>
                        <td><?=str_replace("????","",$question['emergency'])?></td>
                    </tr>
                    <tr>
                        <th style="text-align:right;">Topics:</th>
                        <td><?php echo $question["topic"];?></td>
                    </tr>  
                    <tr>
                        <th style="text-align:right;">Attachment:</th>
                        <td><?php 
                        $attachment = $question["attachment"];
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
                        <td colspan="2" style="padding:15px;text-align:center;"><h3><?php echo $question["title"];?></h3></td>
                    </tr>

                    <tr>
                        <td colspan="2"><?php 
                        $pretty_content =  $question["description"];

                        $pretty_content =  preg_replace('/<code>(.*)<\/code>/si', "<pre style='background-color:#efefef;padding:5px;'>$1</pre>", $pretty_content,-1);

                        $pretty_content = str_replace("\n" , "<br>" , $pretty_content);

                        echo $pretty_content;
                
                        ?></td>
                    </tr>                    
                                                                              
                </table>

            </td>
            <td valign="top" style="padding:5px;background-color:#efefef;">
                    <?php
                    $bid_info = $bids_ctrl->can_user_bid( $question["id"], $_SESSION["id"] ,$_SESSION["role"] );
                    if( $bid_info["status"]  == 1){
                        ?>
                        <div id="candidates" style="text-align:center;background-color:#fff;border:1px solid #ececec;padding:20px;">
                        <form action="question.php" method="get" onsubmit="return confirm('Are you sure you want to place a Bid on this Question?');">
                            <input type="hidden" name="id" value="<?php echo $_GET["id"]?>" >
                            <input type="hidden" name="owner_id" value="<?php echo $question["user_id"];?>" >
                            <input type="hidden" name="action" value="bid" >
                            Bid amount: <input type="number" name="bid_amount" value="5" min="1" placehoder="5" style="width:80px;">($)<br>
                        <button type="submit">Place your Bid!</button>
                        </form>
                        </div>
                        <?php
                    }elseif( $bid_info["status"]  == 0){
                        // Already Bid
                        ?>
                        <div id="candidates" style="text-align:center;background-color:#fff;border:1px solid #ececec;padding:20px;"><?php echo $bid_info["message"]; ?><br>
                        <div>Bid amount: $<?php echo $bid_info["bid_amount"];?> </div>
                        <?php if( !$bid_info["selected"] && !$bid_info["rejected"]  && !$bid_info["paid"] ){ ?>
                        <a href="question.php?id=<?php echo $_GET["id"]?>&owner_id=<?php echo $question["user_id"];?>&action=retract" onclick="return confirm('Are you sure you want to RETRACT a Bid on this Question?');">Retract your Bid!</a>
                        <?php } ?>
                    </div>
                        <?php
                    }else{
                        ?>
                        <div id="candidates" style="text-align:center;background-color:#fff;border:1px solid #ececec;padding:20px;"><?php echo $bid_info["message"]; ?></div>
                        <?php
                    }
                    ?>

                <div id="candidates" style="text-align:center;margin-top:20px;">
                    <?php
                    $list = $bids_ctrl->get_candidates_list( $question["id"], $_SESSION["id"], $_SESSION["role"]);
                    echo $list[1];
                    ?>
                </div>
            </td>
            <td valign="top">
                <?php
                $solution = $bids_ctrl->get_selected_bid( $question["id"], $_SESSION["role"]);                    
                ?>
                <div id="selected_candidate" style="text-align:center;background-color:#fff;border:1px solid #ececec;padding:20px;">
                <?php echo "Selected Candidate <br><strong>" . $solution["winner"] . "</strong>"; ?>
                </div>

                <div id="given_solution" style="text-align:center;background-color:#fff;border:1px solid #ececec;padding:20px;margin-top:30px;">
                <?php echo "Given Solution <br>"; 
                // var_dump($bid_info);
                if( ( $bid_info["selected"] && $bid_info["paid"] ) && !$bid_info["finalised"] ){
                    // The Tutor has bid and his bid has been selected/paid
                    ?>
                    <form id="frmSolution" action="question.php?id=<?php echo $_GET["id"]?>&bid_id=<?php echo $solution["id"]?>&owner_id=<?php echo $question["user_id"];?>" method="post" onsubmit="return confirm('Are you sure?');"  enctype="multipart/form-data">

                        <input type="hidden" id="solution_action" name="solution_action" value="update_solution">
                        <textarea id="solution" name="solution" style="width:500px; height:170px;"><?php echo $solution["solution"];?></textarea>
                        <br>
                        Attachment: <input id="file-input" name="file-input" type="file" accept=".png,.jpg,.gif,.jpeg,.tiff,.zip" /><br><br>
                        <button type="submit" id="update-solution-btn">Update</button>
                        <button type="button" id="finalise-solution-btn" onclick="finalise_solution();">Finalize and submit!</button>

                    </form>
                    <?php
                    if($solution["attachment"]!=""){
                        $attachment_url = $solution["attachment"];
                        $tmp = explode(".", $attachment_url );
                        $ext = $tmp[ count($tmp)-1 ];              
                        if($ext =="zip"){
                            $attachment_link = "<a href='".$attachment_url."' title='Download attachment' target='_blank'>Attachment</a>";
                        }else{
                            $attachment_link = "<a href='".$attachment_url."' title='View image' target='_blank'><img src='".$attachment_url."' style='height:100px;'></a>";
                        }                                  
                        echo "<ul><li>" .  $attachment_link . "</li></ul>";
                    }else{

                    }
                }else if( ( $bid_info["finalised"]  ) ){
                    // The Tutor has bid and his bid has been selected/paid and finalised
                    ?>
                    <?php echo $solution["solution"];?>
                    <?php
                    if($solution["attachment"]!=""){
                        $attachment_url = $solution["attachment"];
                        $tmp = explode(".", $attachment_url );
                        $ext = $tmp[ count($tmp)-1 ];              
                        if($ext =="zip"){
                            $attachment_link = "<a href='".$attachment_url."' title='Download attachment' target='_blank'>Attachment</a>";
                        }else{
                            $attachment_link = "<a href='".$attachment_url."' title='View image' target='_blank'><img src='".$attachment_url."' style='height:100px;'></a>";
                        }                                  
                        echo "<ul><li>" .  $attachment_link . "</li></ul>";
                    }else{

                    }
                }else{
                    // The Tutor's bid has not been selected
                    echo "<strong>" .  $solution["solution"] . "</strong><br>";
                    if($solution["attachment"]!=""){
                        echo "<ul><li>Attachment: " .  $solution["attachment"] . "</li></ul>";
                    }

                }
                ?>
                </div>
            </td>            
    </table>

</div>

<?=template_admin_footer()?>
