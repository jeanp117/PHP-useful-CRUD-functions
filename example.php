    <?php
    include 'crud.php';
    $DB = new _MysqliDB();

    printJSON(
        $DB->_read(
            "SELECT post.*
                FROM post
                inner join categoriesBlog on post.categoryId = categoriesBlog.id
                inner join profile on post.author = profile.id
                 where post.id = ? limit 1",
            'i',   //i = int, s = string
            [intval($_GET['id'])] 
            
        )
    );

    ?>
