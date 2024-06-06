<!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet"> -->

<script src="https://kit.fontawesome.com/e67b69b241.js" crossorigin="anonymous"></script>
<style>
    body {
        display: flex;
        min-height: 100vh;
        flex-direction: column;
        transition: margin-left 0.3s;
      }
      .wrapper {
        display: flex;
        width: 100%;
      }
      .sidebar {
        width: 250px;
        background: #343a40;
        color: #fff;
        padding: 15px;
        position: fixed;
        height: 100vh;
        transition: margin-left 0.6s;
        margin-left: -250px; /* Initially hidden */
        z-index: 1000;
      }
      .sidebar .nav-link {
        color: #fff;
      }
      .sidebar .nav-link.active {
        background: #495057;
      }
      .content {
        margin-left: 0; /* Initially full width */
        padding: 20px;
        flex-grow: 1;
        transition: margin-left 0.6s;
      }
      .expanded-sidebar {
        margin-left: 0;
      }
      .collapsed-content {
        margin-left: 250px;
      }
      .toggle-btn {
        position: fixed;
        left: 15px;
        top: 15px;
        z-index: 1100;
        background: #343a40;
        color: #fff;
        border: none;
        padding: 10px 15px;
        cursor: pointer;
        border-radius: 5px;
        transition: 0.6s;
      }
      .toggle-btn.move-right {
      left: 265px; /* Move right when sidebar is expanded */
    }
    .toggle-btn:hover {
      background: #495057; /* Slightly different on hover */
      color: #CFE2FF;
    }
    /* Sidebar hover effect */
.sidebar .nav-link {
    color: #fff;
    transition: background-color 0.3s, color 0.3s; /* Smooth transition */
}

.sidebar .nav-link:hover {
    background-color: #495057; /* Background color on hover */
    color: #CFE2FF; /* Text color on hover */
}

</style>
    <button class="toggle-btn btn-primary" id="toggleSidebar"><i class="fas fa-bars"></i></button>
      <div class="sidebar" id="sidebar">
        <h3 class="text-center">KampusMadu</h3>
        <ul class="nav flex-column">
    <li class="nav-item">
        <a id="tambah-barang" class="nav-link" aria-current="page" href="index.php">
        <i class="fa-solid fa-box"></i> Tambah Barang
        </a>
    </li>
    <li class="nav-item">
        <a id="update-penjualan" class="nav-link" href="update.php">
        <i class="fa-solid fa-cart-plus"></i> Update Penjualan
        </a>
    </li>
    <li class="nav-item">
        <a id="edit" class="nav-link" href="edit.php">
        <i class="fa-regular fa-pen-to-square"></i> Edit Barang
        </a>
    </li>
    <li class="nav-item">
        <a id="rekap" class="nav-link" href="rekap.php">
        <i class="fa-solid fa-chart-simple"></i> Rekap
        </a>
    </li>
    <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
            <li class="nav-item">
                <a class="nav-link" href="logout.php">
                <i class="fa-solid fa-right-from-bracket"></i> Logout
                </a>
            </li>
            <?php endif; ?>
</ul>
        </div>
        <script>
    document.getElementById('toggleSidebar').addEventListener('click', function () {
        var sidebar = document.getElementById('sidebar');
        var content = document.getElementById('content');
        var toggleBtn = document.getElementById('toggleSidebar');

        sidebar.classList.toggle('expanded-sidebar');
        content.classList.toggle('collapsed-content');
        toggleBtn.classList.toggle('move-right');
    });

    document.addEventListener('DOMContentLoaded', function() {
        var path = window.location.pathname;
        var page = path.split("/").pop();

        switch(page) {
            case 'index.php':
                document.getElementById('tambah-barang').classList.add('active');
                break;
            case 'update.php':
                document.getElementById('update-penjualan').classList.add('active');
                break;
            case 'rekap.php':
                document.getElementById('rekap').classList.add('active');
                break;
                case 'edit.php':
                document.getElementById('edit').classList.add('active');
                break;
            default:
                // Default action if no match is found
                break;
        }
    });
</script>
