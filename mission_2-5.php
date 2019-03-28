<?php
  
  $filename = 'mission_2-5.txt';
  $namae = $_POST['namae'];
  $comment = $_POST['comment'];
  $deleteNo = $_POST['deleteNo'];
  $editNo = $_POST['editNo'];
  $edithidden = $_POST['edithidden'];
  $postpass = $_POST['postpass'];
  $deletepass = $_POST['deletepass'];
  $editpass = $_POST['editpass'];
  date_default_timezone_set('Asia/Tokyo');
  $datetime = new Datetime();
  $date = $datetime -> format('Y/m/d H:i:s');

  if(!empty($editNo)&&!empty($editpass)) //編集選択(2-4)//
  {
   $selectlines = file($filename);
   
   foreach($selectlines as $selectline)
   {
    $selectvalue = explode("<>",$selectline);
    
    if($editNo == $selectvalue[0] && $editpass == $selectvalue[4])
    {
     $selectnumber = $selectvalue[0]; //以下の3行でhtmlのフォームのvalueに入れることができる//
     $selectnamae = $selectvalue[1];
     $selectcomment = $selectvalue[2]; 
    }
    
    elseif($editNo == $selectvalue[0] && $editpass != $selectvalue[4])
    {
     echo "パスワードが違います。";
    }

    elseif(!empty($deleteNo) && empty($editpass))
    {
     echo "パスワードを入力してください。";
    }
   }
  }
  
  if(!empty($namae)&&!empty($comment)&&empty($edithidden)&&!empty($postpass)) //新規投稿処理(2-1)//
  {
   $fp = fopen($filename,'a'); //追記//
   $count = count(file($filename))+1;
   $newdata = $count."<>".$namae."<>".$comment."<>".$date."<>".$postpass."<>"."\n";
   fwrite($fp,$newdata); //テキストファイルに書き込む//
   fclose($fp);
  }

  if(!empty($deleteNo)&&!empty($deletepass)) //削除実行(2-3)//
  {
   $lines = file($filename); //テキストファイルの内容を配列として変数に保存//
   $fp = fopen($filename,'w'); //上書き保存モードw、→ファイルが空になる//

   foreach($lines as $line) //ループ関数で全データを表示//
   {
    $value = explode("<>",$line); //explode関数で<>を分解//
    
    if($deleteNo != $value[0] && $deletepass != $value[4] || $deleteNo != $value[0] && $deletepass == $value[4] || $deleteNo == $value[0] && $deletepass != $value[4])
    {
     fwrite($fp,$line); //一致しない投稿番号の行だけ上書き//
    }
     
    elseif($deleteNo == $value[0] && $deletepass != $value[4])
    {
     echo "パスワードが違います。\n";
    }
   }
   fclose($fp);
  }

  
  if(!empty($namae)&&!empty($comment)&&!empty($edithidden)&&!empty($postpass)) //編集実行(2-4)//
  {
   $executionlines = file($filename);
   $fp = fopen($filename,'w');

   foreach($executionlines as $executionline)
   {
    $executionvalue = explode("<>",$executionline);

    if($executionvalue[0] == $edithidden) //一致するとき、名前とコメントを書き換える//
    {
     $newvalue = $executionvalue[0]."<>".$namae."<>".$comment."<>".$date."<>".$postpass."<>"."\n";
    }
    
    elseif($executionvalue[0] != $edithidden) //一致しないときはそのまま//
    {
     $newvalue = $executionvalue[0]."<>".$executionvalue[1]."<>".$executionvalue[2]."<>".$executionvalue[3]."<>".$executionvalue[4]."<>"."\n";
    }
    fwrite($fp,$newvalue);
   }
    fclose($fp);
  }

?>

<html>
  <head>
    <title>mission_2-5</title>
    <meta charset = "utf-8">
  </head>
  <body>
    <form method = "POST" action = "mission_2-5.php"> <!--投稿フォーム-->
     <input type = "text" name = "namae" value = "<?php echo $selectnamae; ?>" placeholder = "名前"><br/>
     <input type = "text" name = "comment" value = "<?php echo $selectcomment; ?>" placeholder = "コメント"><br/>
     <input type = "hidden" name = "edithidden" value = "<?php echo $selectnumber; ?>"> <!--隠す編集番号-->
     <input type = "password" name = "postpass" placeholder = "パスワード">
     <input type = "submit" value = "送信"><br/>
    </form>
    <form method = "POST" action = "mission_2-5.php"> <!--削除フォーム-->
     <input type = "text" name = "deleteNo" placeholder = "削除対象番号"><br/>
     <input type = "password" name = "deletepass" placeholder = "パスワード">
     <input type = "submit" value = "削除"><br/>
    </form>
    <form method = "POST" action = "mission_2-5.php"> <!--編集フォーム-->
     <input type = "text" name = "editNo" placeholder = "編集対象番号"><br/>
     <input type = "password" name = "editpass" placeholder = "パスワード">
     <input type = "submit" value = "編集"><br/>
  </body>
</html>

<?php
 
 $fp = fopen($filename,'a');
 $filename = 'mission_2-5.txt';
 $lines = file($filename); //表示処理(2-2)//

 foreach($lines as $line)
 {
  $value = explode("<>",$line);
  echo $value[0]." ".$value[1]." ".$value[2]." ".$value[3]."<br/>";
 }
?>
