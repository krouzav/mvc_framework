<?php require APPROOT . "/views/inc/header.php"; ?>
<h1> WELCOME </h1>
<ul> <?php foreach ($data['posts'] as $post) : ?>
    <li> <?php echo $post->title; ?> </li>
    <?php endforeach; ?>
</ul>
<?php require APPROOT . "/views/inc/footer.php"; ?>