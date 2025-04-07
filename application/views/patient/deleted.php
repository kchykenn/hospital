<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deleted Patients</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<body>

    <div class="container mt-5">
        <h2>Deleted Patients List</h2>

        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success">
                <?php echo $this->session->flashdata('success'); ?>
            </div>
        <?php endif; ?>


        <a href="<?php echo site_url('patient/table'); ?>" class="btn btn-primary mb-3"><i class="fas fa-arrow-left"></i> Home</a>

        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Deleted At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($patients as $patient): ?>
                <tr>
                    <td><?php echo $patient['id']; ?></td>
                    <td><?php echo $patient['firstname']; ?></td>
                    <td><?php echo $patient['email']; ?></td>
                    <td><?php echo $patient['phone']; ?></td>
                    <td style="color: red;">
                        <?php echo date('Y-m-d H:i:s', strtotime($patient['deleted_at'])); ?>
                    </td>
                    <td>

                        <a href="<?php echo site_url('patient/restore/' . $patient['id']); ?>" class="btn btn-primary btn-sm"><i class="fas fa-undo"></i> Restore</a> |

                        <a href="<?php echo site_url('patient/destroy/' . $patient['id']); ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('Are you sure you want to permanently delete this patient?');"><i class="fas fa-trash"></i> Permanently Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
