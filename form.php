<?php
@include("proses.php")
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Portfolio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.4/css/dataTables.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="asset/style.css">
</head>

<body class="mb-5">
    <nav class="navbar navbar-expand-lg sticky-top" style="background: white;">
        <div class="container">
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto flex-nowrap">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">HOME</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">PRODUCT</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">GALLERY</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">BLOG</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">MY INVENTORY</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="card mt-4 py-4 px-4">
            <div class="row">
                <div class="col-md-12 col-lg-2 text-center align-content-center">
                    <img src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png"
                        class="rounded-circle img-size " alt="Photo">
                </div>
                <div class="col-md-12 col-lg-5 mt-4 mt-lg-0 align-content-center">
                    <h2 id="data-name"><?php echo htmlspecialchars($data['name']); ?></h2>
                    <p id="data-role"><?php echo htmlspecialchars($data['role']); ?></p>
                    <div>
                        <button class="btn btn-success">Kontak</button>
                        <button class="btn btn-resume">Resume</button>
                    </div>
                </div>
                <div class="col-md-12 col-lg-5 mt-4 mt-lg-0 align-content-center">
                    <?php
                    $fields = [
                        'availability',
                        'age',
                        'location',
                        'experience',
                        'email'
                    ];

                    foreach ($fields as $field) {
                        $years = $field == "experience" || $field == "age" ? ($field > 1 ? 'years' : 'year') : '';
                        echo '<div class="row">';
                        echo '<div class="col-lg-4"><b>' . ucfirst($field) . '</b></div>';
                        echo '<div class="col-lg-8" id="data-' . $field . '"> ' . $data[$field] .  " $years" . '</div>';
                        echo '</div>';
                    }
                    ?>
                </div>
            </div>
        </div>

        <div class="card px-4 py-4 mt-4 container">
            <?php
            session_start();
            if (isset($_SESSION['errors'])) {
                echo '<div class="alert alert-danger" role="alert"> <ul>';
                foreach ($_SESSION['errors'] as $error) {
                    echo "<li>$error</li>";
                }
                echo '</ul></div>';
                unset($_SESSION['errors']);
            }
            ?>

            <form method="POST" action="proses.php?perintah=create">
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="Name..">
                </div>
                <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <input type="text" class="form-control" name="role" id="role" placeholder="Role..">
                </div>
                <div class="mb-3">
                    <label for="availability" class="form-label">Availability</label>
                    <select class="form-select" name="availability" id="availability">
                        <option value="Full Time">Full Time</option>
                        <option value="Part Time">Part Time</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="age" class="form-label">Age</label>
                    <input type="text" class="form-control" name="age" id="age" placeholder="Usia..">
                    <small class="number-warning form-text text-danger" style="display: none;">Age must be type of an integer and must be postive.</small>
                </div>
                <div class="mb-3">
                    <label for="location" class="form-label">Location</label>
                    <input type="text" class="form-control" name="location" id="location" placeholder="Location..">
                </div>
                <div class="mb-3">
                    <label for="experience" class="form-label">Years of Experience</label>
                    <input type="text" class="form-control" name="experience" id="experience" placeholder="Years of Experience..">
                    <small class="number-warning form-text text-danger" style="display: none;">Years of Experience must be type of an integer and must be postive.</small>

                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="Email..">
                </div>

                <button type="submit" class="btn btn-success w-100 btn-sm" id="submit">Submit</button>
            </form>
        </div>
    </div>
</body>

<footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    <script src="https://cdn.datatables.net/2.1.4/js/dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</footer>

</html>