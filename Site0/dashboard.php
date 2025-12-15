<?php
require_once 'config.php';
requireLogin();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Панель управления</title>
    <link rel="stylesheet" href="style.css">
    <script>
    function confirmLogout() {
        return confirm("Вы уверены, что хотите выйти?");
    }
    
    function searchTable() {
        const input = document.getElementById('searchInput');
        const filter = input.value.toUpperCase();
        const table = document.getElementById('productsTable');
        const tr = table.getElementsByTagName('tr');
        
        for (let i = 1; i < tr.length; i++) {
            const td = tr[i].getElementsByTagName('td');
            let found = false;
            
            for (let j = 0; j < td.length; j++) {
                const cell = td[j];
                if (cell) {
                    if (cell.innerHTML.toUpperCase().indexOf(filter) > -1) {
                        found = true;
                        break;
                    }
                }
            }
            
            tr[i].style.display = found ? '' : 'none';
        }
    }
    </script>
</head>
<body>
    <div class="container">
        <header class="header">
            <h1>Панель управления</h1>
            <div class="user-info">
                <span>Вы вошли как: <strong><?php echo $_SESSION['username']; ?></strong></span>
                <a href="logout.php" class="btn-logout" onclick="return confirmLogout()">Выйти</a>
            </div>
        </header>
        
        <main class="main-content">
            <div class="controls">
                <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Поиск по таблице...">
            </div>
            
            <div class="table-container">
                <h2>Список товаров</h2>
                <?php
                $conn = getDBConnection();
                $result = $conn->query("SELECT * FROM products ORDER BY id DESC");
                
                if ($result->num_rows > 0): ?>
                    <table id="productsTable" class="data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Наименование</th>
                                <th>Категория</th>
                                <th>Цена</th>
                                <th>Количество</th>
                                <th>Дата добавления</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo htmlspecialchars($row['name']); ?></td>
                                <td><?php echo htmlspecialchars($row['category']); ?></td>
                                <td><?php echo number_format($row['price'], 2, '.', ' '); ?> ₽</td>
                                <td><?php echo $row['quantity']; ?></td>
                                <td><?php echo date('d.m.Y H:i', strtotime($row['created_at'])); ?></td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                    
                    <div class="table-info">
                        Всего записей: <?php echo $result->num_rows; ?>
                    </div>
                <?php else: ?>
                    <p class="no-data">Нет данных для отображения</p>
                <?php endif; 
                $conn->close();
                ?>
            </div>
        </main>
    </div>
</body>
</html>