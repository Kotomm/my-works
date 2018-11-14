<?php

header("Content-Type: text/html; charset=UTF-8");

//My SQL

$dsn='データベース名';
$user='ユーザー名';
$password='パスワード';

$config=array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_WARNING);
$pdo=new PDO($dsn,$user,$password,$config);


//3-5


$sql=$pdo->prepare("INSERT INTO 4test(name,comment,password)VALUES(:name,:comment,:password)");

$sql->bindParam(':name',$name,PDO::PARAM_STR);
$sql->bindParam(':comment',$comment,PDO::PARAM_STR);
$sql->bindParam(':password',$password,PDO::PARAM_STR);

$password="test";
$psw3=$_POST["passward3"];



//編集機能

//フォームから送られてきた編集対象番号を変数に格納

   $Number=$_POST["number_edit"];

//編集フォームから値が送信され,
if(!empty($Number)){

	//パスワードが入力されていたら、パスワードを照合する
	if(!empty($psw3)){
		$sql=$pdo->prepare("SELECT * FROM 4test where id=$Number");
		$sql->execute();
		$word=$sql->fetch();
		
		//パスワードが違うとき
		if($word[3]!=$psw3){
			echo "!!!！パスワードが違います!!!！";
		
		}else{//パスワードが同じ場合


			//編集番号と投稿番号が同じ場合,隠しフォームに表示


			if($Number==$word[0]){


				$number1=$word[0];
              			$name1=$word[1];
				$comment1=$word[2];
	
			}
		}
	}else{//パスワードが入力されていない場合
		echo "！!!!パスワードが入力されていません!!!！";
	}
}



?>

<!DOCTYPE html>
<head>
<meta charset="UTF-8">
<body>

<form method="POST" action="mission_4.php">

<label>名前:<label>
<input type="text" name="your_name" value="<?php echo $name1; ?>"><br>

<label>コメント:<label>
<input type="text" name="your_opinion" value="<?php echo $comment1; ?>">
<input type="hidden" name="invisible_num" value="<?php echo $number1; ?>"><br>
<input type="text" name="passward1" placeholder="パスワード">
<input type="submit" value="送信"><br>

<form method="POST" action="mission_4.php">

<input type="text" name="number_delete" placeholder="削除対象番号"><br>
<input type="text" name="passward2" placeholder="パスワード">
<input type="submit" value="削除"><br>

<input type="text" name="number_edit" placeholder="編集対象番号"><br>
<input type="text" name="passward3" placeholder="パスワード">
<input type="submit" value="編集"><br>


<?php
 header("Content-Type: text/html; charset=UTF-8");

//編集実行

//フォームから送られてきた名前データを変数に格納
  $name=$_POST["your_name"];

//編集用のテキストボックスの中身のデータを変数に格納
 $ediNumber=$_POST["invisible_num"];

if(!empty($ediNumber)){
	//フォームから送られてきたデータを変数に格納
	$nm=$_POST["your_name"];

	$come=$_POST["your_opinion"];

	$sql="update 4test set name='$nm', comment='$come' where id=$ediNumber";

	$result=$pdo->query($sql);


}else{//編集モードでないときは新規投稿

	$name=$_POST["your_name"];
	$comment=$_POST["your_opinion"];

	if(!empty($name)&& !empty($comment)){

	$sql->execute();


	}else{

	}
}

//削除機能

$deletenum=$_POST["number_delete"];

if(!empty($deletenum)){

	$psw2=$_POST["passward2"];

	//パスワードが入力されていたら、パスワードを照合する
	if(!empty($psw2)){
		$sql=$pdo->prepare("SELECT * FROM 4test where id=$deletenum");
		$sql->execute();
		$word=$sql->fetch();
		
		//パスワードがあっていたら,編集番号を取り出す
		if($word[3]==$psw2){

		$sql="DELETE FROM 4test WHERE id=$deletenum";

		$result=$pdo->query($sql);
		
		}else{//パスワードが違う場合
		
			echo "!!!!パスワードが違います!!!!";
			echo "<br>";
		}
	}else{//パスワードが入力されていない場合
		echo "!!!!パスワードが入力されていません!!!!";
		echo "<br>";
	}

}

  

$sql='SELECT * FROM 4test';
$results=$pdo->query($sql);
foreach($results as $row){

	echo $row['id'].',';
	echo $row['name'].',';
	echo $row['comment'].'<br>';

}

?>   
 
</form>
</body>
</head>