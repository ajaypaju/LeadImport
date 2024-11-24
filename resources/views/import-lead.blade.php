<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lead Generation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Lead Generation</h1>
        <div class="d-flex justify-content-between mb-3">
            <div>
                <button class="btn btn-primary">Leads</button>
                <button class="btn btn-secondary">Import</button>
            </div>
            <div>
                <img src="https://via.placeholder.com/30" alt="User Icon" class="rounded-circle">
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-light">
                    <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Mobile Number</th>
                        <th>Street 1</th>
                        <th>Street 2</th>
                        <th>City</th>
                        <th>State</th>
                        <th>Country</th>
                        <th>Leadsource</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Example data -->
                    <tr>
                        <td>John</td>
                        <td>Doe</td>
                        <td>john.doe@example.com</td>
                        <td>+1234567890</td>
                        <td>Main Street</td>
                        <td>Apt 101</td>
                        <td>New York</td>
                        <td>NY</td>
                        <td>USA</td>
                        <td>Website</td>
                    </tr>
                    <tr>
                        <td>Jane</td>
                        <td>Smith</td>
                        <td>jane.smith@example.com</td>
                        <td>+0987654321</td>
                        <td>Second Street</td>
                        <td>Suite 202</td>
                        <td>Los Angeles</td>
                        <td>CA</td>
                        <td>USA</td>
                        <td>Referral</td>
                    </tr>
                    <!-- Add dynamic data here -->
                </tbody>
            </table>
        </div>
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center mt-4">
                <li class="page-item disabled">
                    <a class="page-link" href="#" tabindex="-1">Previous</a>
                </li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item">
                    <a class="page-link" href="#">Next</a>
                </li>
            </ul>
        </nav>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
