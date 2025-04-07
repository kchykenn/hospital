  <!doctype html>

  <html
    lang="en"
    class="light-style layout-menu-fixed layout-compact"
    dir="ltr"
    data-theme="theme-default"
    data-assets-path="../assets/"
    data-template="vertical-menu-template-free"
    data-style="light">
    <head>
      <meta charset="utf-8" />
      <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

      <title>EMR Training Sites</title>

      <meta name="description" content="" />

      <!-- Favicon -->
      <link rel="icon" type="image/x-icon" href="../assets/img/favicon/weblogo.png" />

      <!-- Fonts -->
      <link rel="preconnect" href="https://fonts.googleapis.com" />
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
      <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&ampdisplay=swap"
        rel="stylesheet" />


      <link rel="stylesheet" href="../assets/vendor/fonts/remixicon/remixicon.css" />

      <!-- Menu waves for no-customizer fix -->
      <link rel="stylesheet" href="../assets/vendor/libs/node-waves/node-waves.css" />

      <!-- Core CSS -->
      <link rel="stylesheet" href="../assets/vendor/css/core.css" class="template-customizer-core-css" />
      <link rel="stylesheet" href="../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
      <link rel="stylesheet" href="../assets/css/demo.css" />

      <!-- Vendors CSS -->
      <link rel="stylesheet" href="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

      <!-- Page CSS -->

      <!-- Helpers -->
      <script src="../assets/vendor/js/helpers.js"></script>
      <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
      <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
      <script src="../assets/js/config.js"></script>
    </head>
  <!-- <style>
  span{
    color: green;
    font-style: italic;
    font-weight: bold;
  }
</style> -->

  <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <!-- Menu -->

        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
          <div class="app-brand demo">
            <a href="<?php echo site_url('patient/table'); ?>" class="app-brand-link">
            <img class="app-brand-logo demo" src="../assets/img/favicon/weblogo.png" alt="Logo" width="50" height="50">
              <span class="app-brand-text demo menu-text fw-semibold ms-2">DOH EMR</span>
            </a>

            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
              <i class="menu-toggle-icon d-xl-block align-middle"></i>
            </a>
          </div>

          <div class="menu-inner-shadow"></div>

          <ul class="menu-inner py-1">
            <!-- Dashboards -->
            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ri-home-smile-line"></i>
                <div data-i18n="Dashboards">Dashboards</div>
                <div class="badge bg-danger rounded-pill ms-auto">5</div>
              </a>
            </li>

            <!-- Tables -->
            <li class="menu-item active">
              <a href="<?php echo site_url('patient/table'); ?>" class="menu-link">
                <i class="menu-icon tf-icons ri-table-alt-line"></i>
                <div data-i18n="Tables">Patients Information</div>
              </a>
            </li>
            <!-- Misc -->
            <li class="menu-header mt-7"><span class="menu-header-text">Misc</span></li>
            <li class="menu-item">
              <a
                href="#"
                target="_blank"
                class="menu-link">
                <i class="menu-icon tf-icons ri-lifebuoy-line"></i>
                <div data-i18n="Support">Support</div>
              </a>
            </li>
            <li class="menu-item">
              <a
                href="#"
                target="_blank"
                class="menu-link">
                <i class="menu-icon tf-icons ri-article-line"></i>
                <div data-i18n="Documentation">Documentation</div>
              </a>
            </li>

            <li class="menu-header mt-7"><span class="menu-header-text">Settings</span></li>
            <li class="menu-item">
              <a
                href="#"
                target="_blank"
                class="menu-link">
                <i class="menu-icon ri-profile-line"></i>
                <div data-i18n="Documentation">User Profile</div>
              </a>
            </li>
            <li class="menu-item">
              <a
                href="#"
                target="_blank"
                class="menu-link">
                <i class="menu-icon ri-file-info-line"></i>
                <div data-i18n="Documentation">System About</div>
              </a>
            </li>
            <li class="menu-item">
              <a
                href="#"
                target="_blank"
                class="menu-link">
                <i class="menu-icon ri-logout-circle-r-line"></i>
                <div data-i18n="Documentation">Logout</div>
              </a>
            </li>
          </ul>
        </aside>
        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">





          <div class="content-wrapper">
            <div class="container-xxl flex-grow-1 container-p-y">
              <div class="card">
                <h5 class="card-header">Patient List</h5>

                <div class="card-body">
                      <div class="row ">
                          <div class="col-lg-6 col-md-6">
                            <div class="btn-group">
                                    <a href="<?php echo site_url('patient/add'); ?>" 
                                          type="button"
                                            class="btn btn-success">
                                            <i class="ri-user-add-line"></i>
                                            <div data-i18n="AddNew">Add New Patient</div>
                                      </a> 

                                      <a href="<?php echo site_url('patient/show_deleted_pat'); ?>" 
                                          type="button"
                                            class="btn btn-outline-warning">
                                            <i class="ri-delete-bin-6-line"></i>
                                          Deleted Patients
                                      </a>
          
                                        <button
                                            type="button"
                                              class="btn btn-outline-primary"
                                              data-bs-toggle="modal"
                                              data-bs-target="#">
                                              <i class="ri-filter-line"></i>
                                            Filter
                                        </button>
                            </div>
                        </div>
                    </div>
                </div>

                <?php if ($this->session->flashdata('success')): ?>
                    <div style="width: 200px;"class="toast-container position-fixed top-0 end-0 p-3">
                        <div class="toast show bg-success text-white" role="alert" aria-live="assertive" aria-atomic="true">
                            <!-- <div class="toast-header">
                                <strong class="me-auto">Login Successfully</strong>
                                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                            </div> -->
                            <div class="toast-body">
                                <?php echo $this->session->flashdata('success'); ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <script>
                    window.addEventListener('DOMContentLoaded', (event) => {
                        var toastElement = document.querySelector('.toast');
                        if (toastElement) {
                            var toast = new bootstrap.Toast(toastElement);
                            toast.show();
                        }
                    });
                </script>



                <div class="table-responsive table-hover" id="patientsTable">
                  <table class="table">
                    <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Patient Full Name</th>
                        <th>Birthdate</th>
                        <th>Sex</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Actions</th>
                        <th>Status</th>
                    </tr>
                </thead>
                    <tbody class="table-border-bottom-0">
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
                          <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                              <i class="ri-more-2-line"></i>
                            </button>
                            <div class="dropdown-menu">
                              <a class="dropdown-item" href="<?php echo site_url('patient/edit/' . $patient['id']); ?>"
                                ><i class="ri-pencil-line me-1"></i> Edit</a
                              >
                              <a class="dropdown-item"  href="<?php echo site_url('patient/delete/' . $patient['id']); ?>"
                                ><i class="ri-delete-bin-6-line me-1"></i> Delete</a
                              >

                              <a class="dropdown-item" onclick="viewPatient(<?php echo $patient['id']; ?>)" data-bs-toggle="modal" data-bs-target="#patientModal">
                              <i class="ri-eye-2-line"></i></i> View Profile
                              </a>

                              <a class="dropdown-item consent-btn" consent-conshospRecordNo="<?php echo $patient['id']; ?>" href="#">
                              <i class="ri-printer-line"></i> Print Profile
                              </a>
                              
                        <td>
                            <?php if ($patient['deleted_at'] !== NULL): ?>
                                <span class="text-danger">Deleted on: <?php echo date('Y-m-d H:i:s', strtotime($patient['deleted_at'])); ?></span>
                            <?php else: ?>
                                <span class="badge rounded-pill bg-label-success me-1">Active</span>
                            <?php endif; ?>
                        </td>
                      </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
              </div>


            </div>
            <!-- / Content -->



          <!-- view modal -->
          <div class="modal fade" id="patientModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel1">Patient Details</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <div class="col-lg-12">
                    <div class="demo-inline-spacing mt-4">
                      <li class="list-group-item d-flex align-items-center justify-content-center">
                        <!-- Display the profile image if it exists -->
                        <?php if (!empty($patient['profile_image'])): ?>
                          <img src="<?php echo base_url('upload/' . $patient['profile_image']); ?>" alt="Profile Image" style="width: 50%; height: 50%; object-fit: cover; border-radius: 5%;">
                        <?php else: ?>
                          <span>No Image</span>
                        <?php endif; ?>
                      </li>
                      <ul class="list-group">
                        <li class="list-group-item d-flex align-items-center">
                          <i class="ri-computer-line ri-22px me-3"></i>
                          :<span id="patientName"></span>
                        </li>
                        <li class="list-group-item d-flex align-items-center">
                          <i class="ri-notification-4-line ri-22px me-3"></i>
                          :<span id="patientEmail"></span>
                        </li>
                        <li class="list-group-item d-flex align-items-center">
                          <i class="ri-headphone-fill ri-22px me-3"></i>
                          :<span id="patientPhone"></span>
                        </li>
                        <li class="list-group-item d-flex align-items-center">
                          <i class="ri-price-tag-3-line ri-22px me-3"></i>
                          :<span id="patientSex"></span>
                        </li>
                        <li class="list-group-item d-flex align-items-center">
                          <i class="ri-focus-2-line ri-22px me-3"></i>
                          :<span id="patientBirthdate"></span>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    Close
                  </button>
                </div>
              </div>
            </div>
          </div>





            <!-- Footer -->
            <footer class="content-footer footer bg-footer-theme">
              <div class="container-xxl">
                <div
                  class="footer-container d-flex align-items-center justify-content-between py-4 flex-md-row flex-column">
                  <div class="text-body mb-2 mb-md-0">
                    ©
                    <script>
                      document.write(new Date().getFullYear());
                    </script>
                    , made with <span class="text-danger"><i class="tf-icons ri-heart-fill"></i></span> by
                    <a href="#" target="_blank" class="footer-link">Hykenn</a>
                  </div>

                </div>
              </div>
            </footer>
            <!-- / Footer -->


            <div class="content-backdrop fade"></div>
          </div>
          <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
      </div>

      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="../assets/vendor/libs/jquery/jquery.js"></script>
    <script src="../assets/vendor/libs/popper/popper.js"></script>
    <script src="../assets/vendor/js/bootstrap.js"></script>
    <script src="../assets/vendor/libs/node-waves/node-waves.js"></script>
    <script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="../assets/vendor/js/menu.js"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS -->
    <script src="../assets/js/main.js"></script>

    <!-- Page JS -->
  </body>
</html>
<script>
    // $(document).ready(function() {
    //     $('#patientsTable').DataTable();
    // });

    function viewPatient(id) {
    $.ajax({
        url: "<?php echo base_url('patient/view_profile/'); ?>" + id, 
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            if (data) {
                // Populate the modal with the patient data
                $('#patientName').text(data.firstname + ' ' + data.middlename + ' ' + data.lastname); 
                $('#patientEmail').text(data.email);
                $('#patientPhone').text(data.phone);
                $('#patientSex').text(data.sex);
                $('#patientBirthdate').text(data.birthdate);
                
                // Set the profile image
                if (data.profile_image) {
                    // Assuming you store images in an 'uploads' directory
                    $('#patientImage').attr('src', '<?php echo base_url('./upload/'); ?>' + data.profile_image);
                } else {
                    // Default image if the patient does not have a profile image
                    $('#patientImage').attr('src', '<?php echo base_url('./upload/'); ?>');
                }
            }
        },
        error: function() {
            alert('Failed to load patient data');
        }
    });
}


</script>

<script>
  document.addEventListener('click', function (event) {
    if (event.target && event.target.classList.contains('consent-btn')) {
      const hospitalRecordNo = event.target.getAttribute('consent-conshospRecordNo');

      fetch(`<?php echo base_url('patient/view_profile/'); ?>${hospitalRecordNo}`)
        .then(response => response.json())
        .then(patient => {
          if (patient) {
            const patientName = `${patient.firstname} ${patient.middlename ? patient.middlename + ' ' : ''}${patient.lastname}`;
            console.log(patient);
            const consentFormHTML = `
              <div class="modal fade" id="printModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="printArea">
                      <!-- Header Section -->
                      <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px;">
                        <img src="../assets/img/favicon/weblogo.png" alt="DOH Logo" style="height: 80px;">
                        <div style="text-align: center; flex-grow: 1;">
                          <p style="margin: 0; font-size: 20px; font-weight: bold; color: black;">Sample District/Provincial Hospital</p>
                          <p style="margin: 0; font-size: 20px; font-weight: bold; color: black;">Municipality of Magallanes</p>
                          <p style="margin: 0; font-size: 16px; color: black;">Purok 8, Brgy. Sto. Rosario, Magallanes, Agusan del Norte</p>
                        </div>
                        <img src="../assets/img/favicon/bago.png" alt="BP Logo" style="height: 80px;">
                      </div>

                      <!-- Form Title -->
                      <h5 class="text-center"><b>PATIENT PROFILE</b></h5>

                      <!-- Patient Details Section -->
                      <h6 style="color: rgb(2, 146, 2);"><b>Patient Information</b></h6>
                      <p><strong>Full Name:</strong> <span style="color: black; font-weight: bold;">${patientName}</span></p>
                      <p><strong>Date of Birth:</strong> <span style="color: black; font-weight: bold;">${patient.birthdate}</span></p>
                      <p><strong>Email:</strong> <span style="color: black; font-weight: bold;">${patient.email}</span></p>
                      <p><strong>Sex:</strong> <span style="color: black; font-weight: bold;">${patient.sex}</span></p>
                      <p><strong>Contact Number:</strong> <span style="color: black; font-weight: bold;">${patient.phone}</span></p>

                      <!-- Data Privacy Section -->
                      <h6 style="color: rgb(2, 146, 2);"><b>Data Privacy Consent</b></h6>
                      <p>
                        I, <span style="color: black; font-weight: bold;">${patientName}</span>, hereby consent to the processing of my personal and medical information as outlined by the hospital's data privacy policy.
                      </p>

                      <p>
                        I understand that my personal and medical data will be securely stored and only shared with authorized personnel and institutions as necessary for my treatment and care, in compliance with applicable data privacy laws.
                      </p>

                      <p>
                        I acknowledge that I have been informed of my rights regarding data privacy, including the right to access, rectify, or request deletion of my data, as per the hospital's privacy policy.
                      </p>

                      <h6 style="color: rgb(2, 146, 2);"><b>Signature:</b></h6>
                      <p><strong>Patient Signature:</strong> ________________________</p>
                      <p><strong>Date:</strong> ________________________</p>

                      <!-- Footer Section -->
                      <h6 style="color: rgb(2, 146, 2);"><b>For Minor Patients:</b></h6>
                      <p><strong>Guardian/Representative Name:</strong> ________________________</p>
                      <p><strong>Relationship to Patient:</strong> ________________________</p>
                      <p><strong>Signature:</strong> ________________________</p>
                      <p><strong>Date:</strong> ________________________</p>
                    </div>
                    <div class="modal-footer">
                      <div class="btn-group">
                        <button type="button" class="btn btn-outline-success" id="printProfile"><i class="ri-printer-line"></i></i> Print</button>
                        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal"><i class="ri-close-circle-line"></i> Close</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            `;

            const existingModal = document.getElementById('printModal');
            if (existingModal) {
              existingModal.remove();
            }

            document.body.insertAdjacentHTML('beforeend', consentFormHTML);
            const printModal = new bootstrap.Modal(document.getElementById('printModal'));
            printModal.show();

            document.getElementById('printProfile').addEventListener('click', function () {
              const printContents = document.getElementById('printArea').innerHTML;
              const originalContents = document.body.innerHTML;

              document.body.innerHTML = printContents;
              window.print();

              document.body.innerHTML = originalContents;
              window.location.reload();
            });
          } else {
            alert('Patient data not found');
          }
        })
        .catch(error => console.error('Error fetching patient details:', error));
    }
  });
</script>