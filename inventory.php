<?php
include("connect/connect.php");

// Check if the connection is established
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory</title>
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="css/database.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo"></div>
        <h2>Admin Portal</h2>
        <ul>
            <li><a href="dashboard.php"><span class="material-symbols-outlined">dashboard</span>Dashboard</a></li>
            <li><a href="inventory.php"><span class="material-symbols-outlined">inventory_2</span>Inventory</a></li>
            <li><a href="reports.php"><span class="material-symbols-outlined">inventory</span>Reports</a></li>
            <li><a href="settings.php"><span class="material-symbols-outlined">settings</span>Settings</a></li>
            <li><a href="index.php"><span class="material-symbols-outlined">logout</span>Log out</a></li>
        </ul>
    </div>
    <main class="main-content">
        <div class="db-container">
            <div class="container-options">
                <div class="search-and-filter">
                    <form method="GET" action="inventory.php">
                        <input type="search" name="search" placeholder="Search by Title, Author, Publisher or Genre" value="<?php if (isset($_GET['search'])) {
                                                                                                                                echo htmlspecialchars($_GET['search']);
                                                                                                                            } ?>" id="search-input">
                    </form>
                </div>
                <div class="db-btns">
                    <button class="add-btn"><a href="actions/add.php">Add Book +</a></button>
                </div>
            </div>

            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Publisher</th>
                            <th>Genre</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- DISPLAYING DATA FROM TABLE -->
                        <?php
                        // Check if a search term is provided
                        if (isset($_GET['search']) && !empty($_GET['search'])) {
                            $search = mysqli_real_escape_string($conn, $_GET['search']);  // Sanitize user input

                            // Modify the SQL query to filter by title, author, publisher, or genre
                            $sql = "SELECT * FROM inventory WHERE title LIKE '%$search%' OR author LIKE '%$search%' OR publisher LIKE '%$search%' OR genre LIKE '%$search%'";
                        } else {
                            // Default query to fetch all records
                            $sql = "SELECT * FROM inventory";
                        }

                        $result = mysqli_query($conn, $sql);

                        // Check if the query execution was successful
                        if ($result) {
                            // Display rows if any results are found
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $id = $row["id"];
                                    $title = $row["title"];
                                    $author = $row["author"];
                                    $publisher = $row["publisher"];
                                    $genre = $row["genre"];
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($id) . "</td>";
                                    echo "<td>" . htmlspecialchars($title) . "</td>";
                                    echo "<td>" . htmlspecialchars($author) . "</td>";
                                    echo "<td>" . htmlspecialchars($publisher) . "</td>";
                                    echo "<td>" . htmlspecialchars($genre) . "</td>";
                                    echo "<td><a href='actions/edit.php?editid=$id'><i class='fa fa-edit' id='edit'></i></a> | <a href='actions/delete.php?deleteid=$id'><i class='fa fa-trash' id='del'></i></a></td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='6'>No results found.</td></tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6'>Error executing query: " . htmlspecialchars(mysqli_error($conn)) . "</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>

</html>