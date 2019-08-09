<html>
	<head>
	<meta charset="utf-8">

	<title>mission5-1</title>

	</head>

<body>

<form action="mission_5-1.php" method="POST">

名前　<br />
<input type="text" name="name" value="" /><br />

コメント<br />
<input type="text" name="comment" value="" />
<input type="text"name="a_password"placeholder="パスワード">
<input type="submit" name="submit" value="送信"　/>
</form>

<form action="mission_5-1.php" method="POST">

削除対象番号<br />
<input type="text" name="delete_number" placeholder="(半角入力）" />
<input type="password"name="delete_password"placeholder="パスワード">
<input type = "submit" name="delete_submit" value="削除" /><br />
</form>

<form action="mission_5-1.php" method="POST">

編集したいコメント<br/>
<input type="number"name="edit_number"placeholder="編集したい投稿の番号"/>
<input type="text"name="edit_name"placeholder="名前"/><br/>
<input type="text"name="edit_comment"placeholder="コメント"/>
<input type="password"name="edit_password"placeholder="パスワード">
<input type="submit"name="edit_submit"value="送信"/>
</form>






 </body>

</html>










<?php

	$dsn = 'データベース名';
	$user = 'ユーザー名';
	$password = 'パスワード';
	$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));


	$sql = 'SELECT * FROM tbtest1';
	$stmt = $pdo->query($sql);
	$results = $stmt->fetchAll();
	foreach ($results as $row){
		//$rowの中にはテーブルのカラム名が入る
		echo $row['id'].',';
		echo $row['name'].',';
		echo $row['comment'].'<br>';
	echo "<hr>";
	}

//投稿フォーム__________________________________

if(isset($_POST["submit"])&&!empty($_POST["name"])&&!empty($_POST["comment"])&&!empty($_POST["a_password"])){


	$sql = $pdo -> prepare("INSERT INTO tbtest1 (name, comment, a_password) VALUES (:name, :comment, :a_password)");
	$sql -> bindParam(':name', $name, PDO::PARAM_STR);
	$sql -> bindParam(':comment', $comment, PDO::PARAM_STR);	$sql -> bindParam(':name', $name, PDO::PARAM_STR);
	$sql -> bindParam(':a_password', $a_password, PDO::PARAM_STR);

	$name = $_POST["name"];
	$comment = $_POST["comment"]; 
	$a_password=$_POST["a_password"];
	$sql -> execute();
	
	$sql = 'SELECT * FROM tbtest1';
	$stmt = $pdo->query($sql);
	$results = $stmt->fetchAll();
	foreach ($results as $row){
		echo $row['id'].',';
		echo $row['name'].',';
		echo $row['comment'].'<br>';
	echo "<hr>";
	}
}
//削除フォーム条件分岐________________________________

if(isset($_POST["delete_submit"])&&!empty($_POST["delete_password"])){

	$delete_password = $_POST["delete_password"];
	$id = $_POST["delete_number"];
	$sql = 'delete from tbtest1 where id=:id AND a_password=:delete_password';
	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(':id', $id, PDO::PARAM_INT);
	$stmt->bindParam(':delete_password', $delete_password, PDO::PARAM_INT);
	$stmt->execute();



}

//編集フォーム条件分岐____________________________________________________
if(isset($_POST["edit_submit"])&&!empty($_POST["edit_name"])&&!empty($_POST["edit_comment"])&&!empty($_POST["edit_password"])){

	$edit_password = $_POST["edit_password"];
	$id = $_POST["edit_number"]; 
	$name = $_POST["edit_name"];
	$comment =$_POST["edit_comment"]; 
	$sql = 'update tbtest1 set name=:name,comment=:comment where id=:id AND a_password=:edit_password';
	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(':name', $name, PDO::PARAM_STR);
	$stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
	$stmt->bindParam(':id', $id, PDO::PARAM_INT);
	$stmt->bindParam(':edit_password', $edit_password, PDO::PARAM_INT);

	$stmt->execute();
	
  

}
?>