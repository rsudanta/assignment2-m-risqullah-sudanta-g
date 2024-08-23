<?php

require_once("koneksi.php");

function getPostData($name)
{
    return isset($_POST[$name]) ? $_POST[$name] : '';
}

function saveData(
    $conn,
    $name,
    $role,
    $availability,
    $age,
    $location,
    $experience,
    $email
) {
    $isValid = formValidation($name, $role, $availability, $age, $location, $experience, $email);
    if (!$isValid) {
        header("location: form.php");
    }

    $sql = $conn->prepare("INSERT INTO `portfolio_table` 
    (`name`, `role`, `availability`, `age`, `location`, `experience`, `email`) 
    VALUES 
    (?, ?, ?, ?, ?, ?, ?);");
    $sql->bind_param("sssssss", $name, $role, $availability, $age, $location, $experience, $email);

    if ($sql->execute()) {
        header("location: form.php");
    } else {
        session_start();
        $_SESSION['errors'][] =  $conn->error;
        die("Error: Query failed: " . $conn->error);
    }

    $sql->close();
}

function formValidation($name, $role, $availability, $age, $location, $experience, $email)
{
    $isNameLengthValid = validateLength($name);
    $isRoleLengthValid = validateLength($role);
    $isLocationLengthValid = validateLength($location);

    $isAgeInt = validateInteger($age);
    $isExperienceInt = validateInteger($experience);

    $isAgePositive = validatePositiveInt($age);
    $isExperiencePositive = validatePositiveInt($experience);

    $isAgeGreaterThanZero = $age > 0;

    session_start();

    if (empty($name)) {
        $_SESSION['errors'][] = "Name is required!";
    }
    if (!$isNameLengthValid) {
        $_SESSION['errors'][] = "Name must be at least 3 characters long!";
    }

    if (empty($role)) {
        $_SESSION['errors'][] = "Role is required!";
    }
    if (!$isRoleLengthValid) {
        $_SESSION['errors'][] = "Role must be at least 3 characters long!";
    }

    if (empty($availability)) {
        $_SESSION['errors'][] = "Availability is required!";
    }

    if (empty($age)) {
        $_SESSION['errors'][] = "Age is required!";
    }
    if (!$isAgeInt) {
        $_SESSION['errors'][] = "Age must be type of an integer!";
    }
    if (!$isAgePositive) {
        $_SESSION['errors'][] = "Age must be positive number!";
    }
    if (!$isAgeGreaterThanZero) {
        $_SESSION['errors'][] = "Age must be greater than 0!";
    }

    if (empty($location)) {
        $_SESSION['errors'][] = "Location is required!";
    }
    if (!$isLocationLengthValid) {
        $_SESSION['errors'][] = "Location must be at least 3 characters long!";
    }

    if (empty($experience)) {
        $_SESSION['errors'][] = "Years of Experience is required!";
    }
    if (!$isExperienceInt) {
        $_SESSION['errors'][] = "Years of Experience must be type of an integer!";
    }
    if (!$isExperiencePositive) {
        $_SESSION['errors'][] = "Experience must be positive number!";
    }

    if (empty($email)) {
        $_SESSION['errors'][] = "Email is required!";
    }

    return empty($name) && empty($role) && empty($availability) && empty($age) && empty($location) && empty($experience) && empty($email) && $isNameLengthValid && $isRoleLengthValid && $isLocationLengthValid && $isAgeInt && $isExperienceInt && $isAgePositive && $isExperiencePositive && $isAgeGreaterThanZero;
}

function validateInteger($value)
{
    if ((is_numeric($value) && strpos($value, '.') !== false) || !is_numeric($value)) {
        return false;
    }
    return true;
}

function validatePositiveInt($value)
{
    return $value >= 0;
}

function validateLength($value)
{
    if (strlen($value) < 3) {
        return false;
    }
    return true;
}

function getData($conn, $id)
{
    $data['name'] = 'N/A';
    $data['role'] = 'N/A';
    $data['availability'] = 'N/A';
    $data['age'] = 'N/A';
    $data['location'] = 'N/A';
    $data['experience'] = 'N/A';
    $data['email'] = 'N/A';

    $condition = $id ? " where id = $id" : '';
    $sql = "select * from portfolio_table pt $condition order by id desc";
    $result = $conn->query($sql);
    if ($result === FALSE) {
        die("Error: Query failed: " . $conn->error);
    } else if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
    }

    return $data;
}

$conn = getConnection();
$action = $_GET['perintah'];
$id = @$_GET['id'];

$data = getData($conn, $id);

if ($action == 'create') {
    $name = getPostData("name");
    $role = getPostData("role");
    $availability = getPostData("availability");
    $age = getPostData("age");
    $location = getPostData("location");
    $experience = getPostData("experience");
    $email = getPostData("email");


    saveData($conn, $name, $role, $availability, $age, $location, $experience, $email);
}
