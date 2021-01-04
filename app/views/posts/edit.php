<?php require APPROOT . "/views/inc/header.php"; ?>

<a href="<?php echo URLROOT; ?>/post" class="btn btn-light"><i class="fa fa-backward">Go back</i></a>
<div class="card card-body bg light mt-5">
    <h2>Edit post</h2>
    <p>Create a post with this form</p>
    <form action="<?php echo URLROOT; ?>/posts/edit/<?php echo $data['id']; ?>" method="post">
        <div class="form-group">
            <label for="title">Title: <sub>*</sup></label>
            <input type="text" name="title"
                class="form-control form-control-lg <?php echo (!empty($data['title_error'])) ? 'is-invalid' : ''; ?>"
                value="<?php echo $data['title']; ?>">
            <span class="invalid-feedback"><?php echo $data['title_error']; ?></span>
        </div>
        <div class="form-group">
            <label for="body">Body: <sub>*</sup></label>
            <textarea name="body"
                class="form-control form-control-lg <?php echo (!empty($data['body_error'])) ? 'is-invalid' : ''; ?>"> <?php echo $data['body']; ?>
            </textarea>
            <span class=" invalid-feedback"><?php echo $data['body_error']; ?></span>
        </div>
        <div class="mt-3">
            <input type="submit" class="btn btn-success" value="Submit">
        </div>
    </form>
</div>

<?php require APPROOT . "/views/inc/footer.php"; ?>