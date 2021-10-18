<?php

/*
Template Name: Blog
*/
?>

<?php get_header();?>

<?php

try {
    $pdo = new PDO('mysql:host=localhost; dbname=strathac_test, 'strathac_admin', 'CFR<LARRI'');
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
# by default your username is root
# if you don't have a password don't fill in it

#(optional) :
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

  $sql = "CREATE TABLE test (id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, name VARCHAR(30) NOT NULL, surname VARCHAR(30) NOT NULL, sex VARCHAR(50))";
  $stmt= $pdo->prepare($sql);
  $stmt->execute();

  $sql = "INSERT INTO test (name, surname, sex) VALUES (?,?,?)";
  $stmt= $pdo->prepare($sql);
  $stmt->execute(["blubby", "the eagle", "eagle"]);

  $stmt = $pdo->query("SELECT * FROM test");
  while ($row = $stmt->fetch()) {
      echo $row['name']."<br />\n";
  }
?>

<?php get_template_part( "includes/blogs-archive/section", "blogs-carousel" );?>
<?php get_template_part( "includes/blogs-archive/section", "archive" );?>
<?php get_template_part( "includes/blogs-archive/section", "blog-series-archive" );?>

<?php get_footer();?>
