<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Patient</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<body>

    <div class="container mt-5">
        <h2>Edit Patient</h2>
        <?php if (validation_errors()): ?>
            <div class="alert alert-danger">
                <?php echo validation_errors(); ?>
            </div>
        <?php endif; ?>

        <?php echo form_open('patient/edit/'.$patient['id']); ?>

        <input type="hidden" name="id" value="<?php echo $patient['id']; ?>">

        <a href="<?php echo site_url('patient/index'); ?>" class="btn btn-primary mb-3">
            <i class="fas fa-arrow-left"></i> Home
        </a>

        <div class="mb-3">
            <label for="firstname" class="form-label">First Name:</label>
            <input type="text" class="form-control" id="firstname" name="firstname" value="<?php echo set_value('firstname', $patient['firstname']); ?>">
        </div>

        <div class="mb-3">
            <label for="middlename" class="form-label">Middle Name:</label>
            <input type="text" class="form-control" id="middlename" name="middlename" value="<?php echo set_value('middlename', $patient['middlename']); ?>">
        </div>

        <div class="mb-3">
            <label for="lastname" class="form-label">Last Name:</label>
            <input type="text" class="form-control" id="lastname" name="lastname" value="<?php echo set_value('lastname', $patient['lastname']); ?>">
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo set_value('email', $patient['email']); ?>">
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">Phone:</label>
            <input type="text" class="form-control" id="phone" name="phone" value="<?php echo set_value('phone', $patient['phone']); ?>">
        </div>

        <div class="mb-3">
            <label for="birthdate" class="form-label">Birthdate:</label>
            <input type="date" class="form-control" id="birthdate" name="birthdate" value="<?php echo set_value('birthdate', $patient['birthdate']); ?>">
        </div>

        <div class="mb-3">
            <label for="sex" class="form-label">Sex:</label>
            <select name="sex" class="form-select" id="sex">
                <option value="male" <?php echo set_select('sex', 'male', ($patient['sex'] == 'male') ? true : false); ?>>Male</option>
                <option value="female" <?php echo set_select('sex', 'female', ($patient['sex'] == 'female') ? true : false); ?>>Female</option>
                <option value="other" <?php echo set_select('sex', 'other', ($patient['sex'] == 'other') ? true : false); ?>>Other</option>
            </select>
        </div>

        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Update</button>
        </div>

        <?php echo form_close(); ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
