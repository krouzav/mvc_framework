<?php require APPROOT . "/views/inc/header.php"; ?>
<a href="<?php echo URLROOT; ?>/post" class="btn btn-light"><i class="fa fa-backward">Go back</i></a>
<br>
<h1><?php echo $data['post']->title; ?></h1>
<div class="bg-secondary text-white p-2 mb-3"></div>
written by <?php echo $data['user']->name; ?> on <?php echo $data['post']->created; ?>
<p><?php echo $data['post']->body; ?></p>

<?php if ($data['post']->userId == $_SESSION['user_id']) : ?>
<hr>
<a href="<?php echo URLROOT; ?>/posts/edit/<?php echo $data['post']->id; ?>" class="btn btn-dark">Edit</a>

<form class="pull-right" action="<?php echo URLROOT; ?>/posts/delete/<?php echo $data['post']->id; ?>" method="post">
    <input type="submit" value="Delete" class="btn btn-danger">
</form>

</div>
<?php endif; ?>

<?php require APPROOT . "/views/inc/footer.php"; ?>