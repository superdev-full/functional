<?php
include 'main.php';

include_once "../controllers/bids_controller.php";

$bids_ctrl = new BidsController(true);

// Retrieve the GET request parameters (if specified)
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$search = isset($_GET['search']) ? $_GET['search'] : '';
// Filters parameters
$status = isset($_GET['status']) ? $_GET['status'] : '';
$attachments = isset($_GET['attachments']) ? $_GET['attachments'] : '';
// Order by column
$order = isset($_GET['order']) && $_GET['order'] == 'ASC' ? 'ASC' : 'DESC';
// Add/remove columns to the whitelist array
$order_by_whitelist = ['id','username','title','topic','emergency','created_at'];
$order_by = isset($_GET['order_by']) && in_array($_GET['order_by'], $order_by_whitelist) ? $_GET['order_by'] : 'a.id';
// Number of results per pagination page
$results_per_page = 15;
// Questions array
$questions = [];
// Declare query param variables
$param1 = ($page - 1) * $results_per_page;
$param2 = $results_per_page;
$param3 = '%' . $search . '%';
// SQL where clause
$where = '';
$where .= $search ? 'WHERE (title LIKE ?  OR description LIKE ?  OR topic LIKE ? ) ' : '';
// Add filters
if ($status == '1') {
    $where .= $where ? 'AND status=1 ' : 'WHERE status=1 ';
}
if ($status == '0') {
    $where .= $where ?  'AND status=0 ' : 'WHERE status=0 ';
}
if ($attachments  == '1') {
    $where .= $where ? 'AND attachment != "" ' : 'WHERE attachment != "" ';
}

// Retrieve the total number of questions
$sql = 'SELECT COUNT(*) AS total FROM questions ' . $where;
// var_dump($sql);
// exit();
$stmt = $con->prepare($sql);
if ($search) {
    $stmt->bind_param('sss', $param3, $param3, $param3);
} 
$stmt->execute();
$stmt->bind_result($questions_total);
$stmt->fetch();
$stmt->close();
// Prepare search results query
$sql = 'SELECT a.id,a.title,a.description,a.topic,a.emergency,a.attachment,a.created_at,a.status,b.id as `user_id`,b.username,b.email FROM questions as a INNER JOIN accounts as b on b.id=a.user_id ' . $where . ' ORDER BY ' . $order_by . ' ' . $order . ' LIMIT ?,?';
// var_dump($sql);
// exit();
$stmt = $con->prepare($sql);
$types = '';
$params = [];
if ($search) {
    $params[] = &$param3;
    $params[] = &$param3;
    $params[] = &$param3;
    $types .= 'sss';
}

$params[] = &$param1;
$params[] = &$param2;
$types .= 'ii';
call_user_func_array([$stmt, 'bind_param'], array_merge([$types], $params));
// Retrieve query results
$stmt->execute();
$stmt->bind_result($result_id, $result_title, $result_description,  $result_topic, $result_emergency, $result_attachment, $result_created, $result_status,$result_user_id,$result_username,$result_email);
// Iterate the results
while($stmt->fetch()) {
    // Add result to accounts array
    $questions[] = ['id' => $result_id, 'user_id' => $result_user_id,'username' => $result_username, 'title' => $result_title, 'description' => $result_description, 'topic' => $result_topic, 'emergency' => $result_emergency, 'attachment' => $result_attachment, 'created' => $result_created, 'status' => $result_status];
}
// Delete question
if (isset($_GET['delete'])) {
    // Delete the question
    $stmt = $con->prepare('DELETE FROM questions WHERE id = ?');
    $stmt->bind_param('i', $_GET['delete']);
    $stmt->execute();
    header('Location: questions.php?success_msg=3');
    exit;
}
// Handle success messages
if (isset($_GET['success_msg'])) {
    if ($_GET['success_msg'] == 1) {
        $success_msg = 'Question created successfully!';
    }
    if ($_GET['success_msg'] == 2) {
        $success_msg = 'Question updated successfully!';
    }
    if ($_GET['success_msg'] == 3) {
        $success_msg = 'Question deleted successfully!';
    }
}
// Create URL
$url = 'questions.php?search=' . $search . '&status=' . $status ;
?>
<?=template_admin_header('Questions', 'questions', 'view')?>

<h2>Questions</h2>

<?php if (isset($success_msg)): ?>
<div class="msg success">
    <i class="fas fa-check-circle"></i>
    <p><?=$success_msg?></p>
    <i class="fas fa-times"></i>
</div>
<?php endif; ?>

<div class="content-header links">
    <!--<a href="question.php">Create Account</a>-->
    <form action="" method="get">
        <div class="filters">
            <a href="#"><i class="fas fa-filter"></i> Filters</a>
            <div class="list">
                <label><input type="checkbox" name="status" value="1"<?=$status=='1'?' checked':''?>>Active</label>
                <label><input type="checkbox" name="status" value="0"<?=$status=='0'?' checked':''?>>Inactive</label>
                <label><input type="checkbox" name="attachments" value="1"<?=$attachments=='1'?' checked':''?>>Has attachment</label>

                <button type="submit">Apply</button>
            </div>
        </div>
        <div class="search">
            <label for="search">
                <input id="search" type="text" name="search" placeholder="Search title, topic, description, username..." value="<?=$search?>" class="responsive-width-100">
                <i class="fas fa-search"></i>
            </label>
        </div>
    </form>
</div>

<div class="content-block">
    <div class="table">
        <table>
            <thead>
                <tr>
                    <th style="padding:5px;"><a href="<?=$url . '&order=' . ($order=='ASC'?'DESC':'ASC') . '&order_by=id'?>">#<?php if ($order_by=='id'): ?><i class="fas fa-level-<?=str_replace(['ASC', 'DESC'], ['up','down'], $order)?>-alt fa-xs"></i><?php endif; ?></a></th>
                    <th></th>
                    <th style="padding:5px;"><a href="<?=$url . '&order=' . ($order=='ASC'?'DESC':'ASC') . '&order_by=username'?>">Username<?php if ($order_by=='username'): ?><i class="fas fa-level-<?=str_replace(['ASC', 'DESC'], ['up','down'], $order)?>-alt fa-xs"></i><?php endif; ?></a></th>
                    <th style="padding:5px;" class="responsive-hidden"><a href="<?=$url . '&order=' . ($order=='ASC'?'DESC':'ASC') . '&order_by=title'?>">Title<?php if ($order_by=='title'): ?><i class="fas fa-level-<?=str_replace(['ASC', 'DESC'], ['up','down'], $order)?>-alt fa-xs"></i><?php endif; ?></a></th>
                        <th style="padding:5px;" class="responsive-hidden">Description</th>
                    <th style="padding:5px;" class="responsive-hidden"><a href="<?=$url . '&order=' . ($order=='ASC'?'DESC':'ASC') . '&order_by=topic'?>">Topics<?php if ($order_by=='topic'): ?><i class="fas fa-level-<?=str_replace(['ASC', 'DESC'], ['up','down'], $order)?>-alt fa-xs"></i><?php endif; ?></a></th>
                    
                    
                    <th style="padding:5px;" class="responsive-hidden"><a href="<?=$url . '&order=' . ($order=='ASC'?'DESC':'ASC') . '&order_by=emergency'?>">Emergency<?php if ($order_by=='emergency'): ?><i class="fas fa-level-<?=str_replace(['ASC', 'DESC'], ['up','down'], $order)?>-alt fa-xs"></i><?php endif; ?></a></th>
                    <th style="padding:5px;" class="responsive-hidden">Attach.</th>
                    <th style="padding:5px;" class="responsive-hidden">Selected Candidate</th>
                    <th style="padding:5px;" class="responsive-hidden">Given Solution</th>
                    <th style="padding:5px;" class="responsive-hidden"><a href="<?=$url . '&order=' . ($order=='ASC'?'DESC':'ASC') . '&order_by=created_at'?>">Created Date<?php if ($order_by=='created_at'): ?><i class="fas fa-level-<?=str_replace(['ASC', 'DESC'], ['up','down'], $order)?>-alt fa-xs"></i><?php endif; ?></a></th>
                    
                    <th style="padding:5px;" class="responsive-hidden"><a href="<?=$url . '&order=' . ($order=='ASC'?'DESC':'ASC') . '&order_by=status'?>">Status<?php if ($order_by=='status'): ?><i class="fas fa-level-<?=str_replace(['ASC', 'DESC'], ['up','down'], $order)?>-alt fa-xs"></i><?php endif; ?></a></th>
                    <th style="padding:5px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!$questions): ?>
                <tr>
                    <td colspan="8" style="text-align:center;">There are no questions</td>
                </tr>
                <?php endif; ?>
                <?php foreach ($questions as $question): ?>
                <tr>
                    <td><?=$question['id']?></td>
                    <td><?php if( $question['user_id'] != $_SESSION['id'] ){ ?><a href="../messages/?member_id=<?=$question['user_id']?>" title="Open chat with <?=$question['username']?>" target="_blank"><i class="fas fa-comment"></i></a><?php } ?></td>
                    <td><?=$question['username']?></td>
                    
                    
                    <td class="responsive-hidden"><?php
                    if(strlen($question['title'])>50){
                        $title = substr($question['title'],0,50) . "...";
                    }else{
                        $title = $question['title'];
                    }
                    echo $title;
                    ?></td>
                    <td class="responsive-hidden"><?php
                    if(strlen($question['description'])>50){
                        $description = substr($question['description'],0,50) . "...";
                    }else{
                        $description = $question['description'];
                    }
                    echo $description;
                    ?></td>                    
                    <td style="text-align:center;" class="responsive-hidden"><?=$question['topic']?></td>

                    <td style="text-align:center;" class="responsive-hidden"><?=str_replace("????","",$question['emergency'])?></td>
                    <td style="text-align:center;" class="responsive-hidden"><?php
                    if($question['attachment'] !=""){
                        echo "<a href='/uploads/".$question['attachment']."' target='_blank'>open</a>";
                    }
                    ?></td>
                   <?php
                    $solution = $bids_ctrl->get_selected_bid( $question["id"], $_SESSION["role"]);                    
                    ?>                  
                    <td style="text-align:center;" class="responsive-hidden"><?php echo $solution["winner"]; ?></td>
                    <td style="text-align:center;" class="responsive-hidden"><?php echo $solution["solution"]; ?></td>
                    <td style="text-align:center;" class="responsive-hidden"><?php
                    
                    $tmp1 = explode(" " , $question['created'] );
					$tmp2 = explode("-" , $tmp1[0] );

                    $created_at_date =   $tmp2[1] . "/" . $tmp2[2] . "/" . substr($tmp2[0],2,2)  . " " . $tmp1[1];	

                    echo $created_at_date;

                    ?></td>  
                
                    <td style="text-align:center;" class="responsive-hidden"><?=$question['status']?></td>
                    <td>
                    <a href="question.php?id=<?=$question['id']?>">View</a>
                        
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="pagination">
    <?php if ($page > 1): ?>
    <a href="<?=$url?>&page=<?=$page-1?>&order=<?=$order?>&order_by=<?=$order_by?>">Prev</a>
    <?php endif; ?>
    <span>Page <?=$page?> of <?=ceil($questions_total / $results_per_page) == 0 ? 1 : ceil($questions_total / $results_per_page)?></span>
    <?php if ($page * $results_per_page < $questions_total): ?>
    <a href="<?=$url?>&page=<?=$page+1?>&order=<?=$order?>&order_by=<?=$order_by?>">Next</a>
    <?php endif; ?>
</div>

<?=template_admin_footer()?>