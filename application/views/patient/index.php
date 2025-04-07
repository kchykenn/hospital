<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patients List</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2>Patients List</h2>

    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success">
            <?php echo $this->session->flashdata('success'); ?>
        </div>
    <?php endif; ?>

    <div class="mb-3">
        <!-- Button to trigger modal -->
        <a href="<?php echo site_url('patient/add'); ?>" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add New Patient
        </a>
        <a href="<?php echo site_url('patient/show_deleted_pat'); ?>" class="btn btn-warning">
            <i class="fas fa-eye"></i> Show All Deleted Patients
        </a>

        <a href="<?php echo site_url('patient/table'); ?>" class="btn btn-warning">
            <i class="fas fa-table"></i> Show Table
        </a>
    </div>

    <table class="table table-bordered table-hover" id="patientsTable">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Profile Image</th>
                <th>Patient Full Name</th>
                <th>Birthdate</th>
                <th>Sex</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Actions</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($patients as $patient): ?>
            <tr>
                <td><?php echo $patient['id']; ?></td>
                <td>
                    <!-- Display the profile image if it exists -->
                    <?php if (!empty($patient['profile_image'])): ?>
                        <img src="<?php echo base_url('upload/' . $patient['profile_image']); ?>" alt="Profile Image" style="width: 50px; height: 50px; object-fit: cover;">
                    <?php else: ?>
                        <span>No Image</span>
                    <?php endif; ?>
                </td>
                <td>
                    <?php echo $patient['firstname'] . ' ' . $patient['middlename'] . ' ' . $patient['lastname']; ?>
                </td>
                <td><?php echo date('Y-m-d', strtotime($patient['birthdate'])); ?></td>
                <td><?php echo ucfirst($patient['sex']); ?></td>
                <td><i class="fas fa-envelope"></i> <?php echo $patient['email']; ?></td>
                <td><i class="fas fa-phone"></i> <?php echo $patient['phone']; ?></td>
                <td>
                    <?php if ($patient['deleted_at'] !== NULL): ?>
                        <span class="text-danger">(Deleted)</span>
                    <?php else: ?>
                        <a href="<?php echo site_url('patient/edit/' . $patient['id']); ?>">
                            <i class="fas fa-pen"></i>
                        </a>
                        |
                        <a href="<?php echo site_url('patient/delete/' . $patient['id']); ?>" onclick="return confirm('Are you sure you want to delete this patient?');">
                            <i class="fas fa-trash"></i>
                        </a>
                        |
                        <a onclick="viewPatient(<?php echo $patient['id']; ?>)" data-bs-toggle="modal" data-bs-target="#patientModal">
                                  <i class="fas fa-eye"></i>
                              </a>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if ($patient['deleted_at'] !== NULL): ?>
                        <span class="text-danger">Deleted on: <?php echo date('Y-m-d H:i:s', strtotime($patient['deleted_at'])); ?></span>
                    <?php else: ?>
                        <span class="text-success">Active</span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>


<div class="modal fade" id="patientModal" tabindex="-1" aria-hidden="true">
              <div class="modal-dialog" role="document">
                  <div class="modal-content">
                      <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel1">Patient Details</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                          <p><strong>Name:</strong><span id="patientName"></span></p>
                          <p><strong>Email:</strong><span id="patientEmail"></span></p>
                          <p><strong>Phone:</strong><span id="patientPhone"></span></p>
                          <p><strong>Sex:</strong><span id="patientSex"></span></p>
                          <p><strong>Birthdate:</strong><span id="patientBirthdate"></span></p>
                      </div>
                      <div class="modal-footer">
                          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                              Close
                          </button>
                      </div>
                  </div>
              </div>
          </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    $(document).ready(function() {
        $('#patientsTable').DataTable();
    });

    function viewPatient(id) {
      console.log(id);
    $.ajax({
        url: "<?php echo base_url('patient/view_profile/'); ?>" + id, 
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            if (data) {
                $('#patientName').text(data.firstname + ' ' + data.middlename+ ' ' + data.lastname); 
                $('#patientEmail').text(data.email);
                $('#patientPhone').text(data.phone);
                $('#patientSex').text(data.sex);
                $('#patientBirthdate').text(data.birthdate);
            }
        },
        error: function() {
            alert('Failed to load patient data');
        }
    });
}

</script>


</body>
</html>
