<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Laporan - MyReport</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        
        .navbar {
            background-color: #3E6EA2 !important;
            padding: 10px 20px;
        }
        
        .navbar-brand img {
            height: 30px;
        }
        
        .nav-link {
            color: white !important;
            margin-right: 15px;
            font-weight: 500;
        }
        
        .username-display {
            color: white;
            font-weight: 500;
            margin-left: auto;
            padding: 8px 12px;
            border-radius: 4px;
        }
        
        .content-container {
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .page-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        
        .search-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        
        .search-box {
            width: 800px;
            position: relative;
        }
        
        .search-box input {
            padding-left: 40px;
            border-radius: 20px;
        }
        
        .search-icon {
            position: absolute;
            left: 15px;
            top: 10px;
            color: #6c757d;
        }
        
        .btn-primary {
            position: fixed;
            bottom: 5rem;
            right: 4rem;
            background-color: #3E6EA2;
            border-color: #3E6EA2;
        }
        
        .report-table {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        
        .table thead th {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
            font-weight: 600;
        }
        
        .badge-success {
            background-color: #28a745;
            color: white;
            padding: 6px 12px;
            border-radius: 20px;
        }
        
        .badge-danger {
            background-color: #dc3545;
            color: white;
            padding: 6px 12px;
            border-radius: 20px;
        }
        
        .btn-details {
            background-color: #f8f9fa;
            border-color: #dee2e6;
            color: #212529;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="storages/logo.png" alt="MyReport Logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="bi bi-house-door"></i> Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="bi bi-info-circle"></i> About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="bi bi-telephone"></i> Contact</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            Lainnya
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Dashboard</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#">Logout</a></li>
                        </ul>
                    </li>
                </ul>
                <div class="username-display ms-auto">
                    <i class="bi bi-person"></i> <span id="username-placeholder">{username}</span>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="content-container">
        <h1 class="page-title">Daftar Laporan</h1>
        
        <!-- Search -->
        <div class="search-container">
            <div class="search-box">
                <i class="bi bi-search search-icon"></i>
                <input type="text" class="form-control" placeholder="Cari Laporan" id="searchInput">
            </div>
        </div>
        
        <!-- Table -->
        <div class="report-table">
            <table class="table table-hover" id="reportTable">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="15%">Nama</th>
                        <th width="15%">NIK</th>
                        <th width="15%">Tanggal</th>
                        <th width="15%">Photo</th>
                        <th width="15%">Kategori</th>
                        <th width="10%">Status</th>
                        <th width="10%">Action</th>
                    </tr>
                </thead>


                <!-- add report-->
                <button class="btn btn-primary" id="addReportBtn">
                <i class="bi bi-plus-circle"></i> Buat laporan
            </button>
                <tbody>
                    <!-- Data will be loaded dynamically -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Placeholder for data that would come from PHP/database
        const reportData = [
            {
                id: 1,
                nama: 'firjatulloh',
                nik: '783092005',
                tanggal: '05/07/2025',
                photo: 'Ubed.jpg',
                kategori: 'Jalanan',
                status: 'Disetujui'
            },
            {
                id: 2,
                nama: 'Ubed',
                nik: '320xxpxxxx',
                tanggal: '09/11/2001',
                photo: 'gengster.jpg',
                kategori: 'Rumah',
                status: 'Ditolak'
            }
        ];

        // Function to display username (would be replaced with server-side logic)
        function displayUsername() {
            // This would be replaced with actual user data from PHP session
            const username = "username"; // Placeholder
            document.getElementById('username-placeholder').textContent = username;
        }

        // Function to populate table
        function populateTable(data) {
            const tableBody = document.querySelector('#reportTable tbody');
            tableBody.innerHTML = '';
            
            data.forEach((report, index) => {
                const row = document.createElement('tr');
                
                // Create status badge
                let statusBadge;
                if (report.status === 'Disetujui') {
                    statusBadge = `<span class="badge-success">${report.status}</span>`;
                } else if (report.status === 'Ditolak') {
                    statusBadge = `<span class="badge-danger">${report.status}</span>`;
                } else {
                    statusBadge = `<span class="badge bg-secondary">${report.status}</span>`;
                }
                
                row.innerHTML = `
                    <td>${index + 1}</td>
                    <td>${report.nama}</td>
                    <td>${report.nik}</td>
                    <td>${report.tanggal}</td>
                    <td>${report.photo}</td>
                    <td>${report.kategori}</td>
                    <td>${statusBadge}</td>
                    <td>
                        <button class="btn btn-sm btn-details" onclick="viewDetails(${report.id})">Details</button>
                    </td>
                `;
                
                tableBody.appendChild(row);
            });
        }

        // Function to filter table based on search
        function filterTable() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            
            if (searchTerm === '') {
                populateTable(reportData);
                return;
            }
            
            const filteredData = reportData.filter(report => {
                return (
                    report.nama.toLowerCase().includes(searchTerm) ||
                    report.nik.toLowerCase().includes(searchTerm) ||
                    report.kategori.toLowerCase().includes(searchTerm) ||
                    report.status.toLowerCase().includes(searchTerm)
                );
            });
            
            populateTable(filteredData);
        }

        // Function to view details (would link to PHP page)
        function viewDetails(reportId) {
            // This would redirect to a PHP page with the ID
            console.log(`View details for report ID: ${reportId}`);
            // window.location.href = `detail_laporan.php?id=${reportId}`;
            alert(`View details for report ID: ${reportId}`);
        }

        // Add report button click handler
        document.getElementById('addReportBtn').addEventListener('click', function() {
            // This would redirect to a form page
            // window.location.href = 'tambah_laporan.php';
            alert('Redirect to add report form');
        });

        // Search input event listener
        document.getElementById('searchInput').addEventListener('input', filterTable);

        // Initialize the page
        document.addEventListener('DOMContentLoaded', function() {
            displayUsername();
            populateTable(reportData);
        });
    </script>
</body>
</html>