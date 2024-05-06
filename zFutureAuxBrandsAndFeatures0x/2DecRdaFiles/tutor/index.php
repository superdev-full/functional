<?php
include 'main.php';
// Calculate Stats for questions
$questions = $con->query('SELECT * FROM questions WHERE cast(created_at as DATE) = cast(now() as DATE) ORDER BY created_at DESC')->fetch_all(MYSQLI_ASSOC);
$questions_total = $con->query('SELECT COUNT(*) AS total FROM questions')->fetch_object()->total;
// $active_questions = $con->query('SELECT * FROM questions WHERE created_At > date_sub(now(), interval 1 day) AND status=1 ORDER BY last_seen DESC')->fetch_all(MYSQLI_ASSOC);
$inactive_questions = $con->query('SELECT COUNT(*) AS total FROM questions WHERE created_at < date_sub(now(), interval 1 month) AND status=0')->fetch_object()->total;
$active_questions = $con->query('SELECT COUNT(*) AS total FROM questions WHERE created_at > date_sub(now(), interval 1 month) AND status=1 ')->fetch_object()->total;
//-------------------------------
?>
<?=template_admin_header('Dashboard', 'dashboard')?>

<h2>Dashboard</h2>

<div class="dashboard">
    <div class="content-block stat">
        <div>
            <h3>New Questions (&lt;1 day)</h3>
            <p><?=number_format(count($questions))?></p>
        </div>
        <i class="fas fa-comment"></i>
    </div>

    <div class="content-block stat">
        <div>
            <h3>Total Questions</h3>
            <p><?=number_format($questions_total)?></p>
        </div>
        <i class="fas fa-comment-alt"></i>
    </div>

    <div class="content-block stat">
        <div>
            <h3>Pending Questions (&lt;30 days)</h3>
            <p><?=number_format($active_questions)?></p>
        </div>
        <i class="fas fa-user-clock"></i>
    </div>

    <div class="content-block stat">
        <div>
            <h3>Finished Questions (&gt;30 days)</h3>
            <p><?=number_format($inactive_questions)?></p>
        </div>
        <i class="fas fa-user-check"></i>
    </div>

</div>



<?=template_admin_footer()?>