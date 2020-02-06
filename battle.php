<?php

ini_set('log_errors','on');
ini_set('error_log','php.log');
session_start();


$girls = array();
$gameOver = 'gameover';
$messages[] = '彼女: ふふ..';
$messages[] = '彼女: 褒め言葉として受け取っておくわ';
$messages[] = '彼女: ちょっ..いきなり恥ずかしい事言わないでよ！';
$messages[] = '彼女: 男らしいとこあるんだね..';
$messages[] = '彼女: あ..ありがと..';
$messages[] = '彼女: 飲みに行く？';
$messages[] = '彼女: えへへ';
$messages[] = '彼女: ばっっっかじゃないの..!!？';
$messages[] = '彼女: おもしろいね君';

$messages[] = '彼女: 無理 ♡';



abstract class Human{
  protected $name;
  protected $hobby;
  protected $age;
  protected $like;
  protected $hp;


  public function setName($str){
    $this->name = $str;
  }

  public function getName(){
    return $this->name;
  }
  public function getHobby(){
    return $this->hobby;
  }
  public function getAge(){
    return $this->age;
  }
  public function getLike(){
    return $this->like;
  }
  public function setHp($num){
    $this->hp = $num;
  }
  public function getHp(){
    return $this->hp;
  }

public function attack($targetObj){
  $attackPoint = mt_rand(60,100);
  if(!mt_rand(0,8)){
    $attackPoint = $attackPoint * 2;
    $attackPoint = (int)$attackPoint;
    History::set('僕 : すごく嬉しそうだ！');
    History::set('メーター急上昇！！');
    $targetObj->setHp($targetObj->getHp()+$attackPoint);
  }else{
  $targetObj->setHp($targetObj->getHp()+$attackPoint);

  }
}
}


class Girl extends Human{
  protected $img;
  public function __construct($name,$hobby,$age,$like,$hp,$img){
    $this->name = $name;
    $this->hobby = $hobby;
    $this->age = $age;
    $this->like = $like;
    $this->hp = $hp;
    $this->img = $img;
  }


  public function getImg(){
    return $this->img;
  }

  }



class History{
  public static function set($str){
    if(empty($_SESSION['history'])) $_SESSION['history'] = '';
    $_SESSION['history'].=$str.'<br>'.'<br>';
  }
  public static function clear(){
    unset($_SESSION['history']);
  }
}


$girls[] = new Girl('疾風のかな子(自称)','チョーク投げ','16才','風の唄を聴く',0,'img/girl.png');
$girls[] = new Girl('ミキ','Excel','26才','デプロイ',0,'img/girl02.png');
$girls[] = new Girl('横浜のイズミ','ドイツ語','37才','旅行',0,'img/girl03.png');

function createGirl(){
global $girls;
$girl = $girls[mt_rand(0,2)];

History::set('彼女: 何か用？');
$_SESSION['girl'] = $girl;
}


function init(){
  History::clear();
 
  createGirl();
}
function HistoryClear(){
  History::clear();
}

function gameOver(){
  global $gameOver;
  $_SESSION['gameover'] = $gameOver;
}


if(!empty($_POST)){
  $attakFlg = (!empty($_POST['attack'])) ? true : false;
  $startFlg = (!empty($_POST['start'])) ? true : false;
  $loveFlg = (!empty($_POST['love'])) ? true : false;
  $escapeFlg = (!empty($_POST['escape'])) ? true : false;
  $home = (!empty($_POST['home'])) ? true : false;
  error_log('POSTされました');

if($startFlg){
  // History::set('教室に彼女がたたずんでいる');
  init();
}else{
  if($attakFlg){
    
    History::set($messages[mt_rand(0,8)]);
    $_SESSION['girl']->attack($_SESSION['girl'] );

    if($_SESSION['girl']->getHp()< 0){
      gameOver();
    }else{
      // if($_SESSION['girl']->getHp() >= 500 && !empty($loveFlg)){
      //   History::set('彼女: わたし好きな人いるの..ごめんなさい');
      //   History::set('目の前が真っ暗になった');
      //   gameOver();

      // }else{
      //   if($_SESSION['girl']->getHp() < 500 && !empty($loveFlg)){
        
      //   History::set($messages[6]);
      //   History::set('話をきいていない');
      //   }
      // }
    }


  }else{
    if($_SESSION['girl']->getHp() >= 500 && !empty($loveFlg)){
      HistoryClear();
      History::set('ごめんなさい！！');
      gameOver();
      
    
   
  }else{
    if($_SESSION['girl']->getHp() < 500 && !empty($loveFlg)){
    History::set($messages[9]);
   
    }else{
      if(!empty($escapeFlg)){
      
      createGirl();
      init();
      }else{
        if($home){
          $_SESSION = array();
        }
      }
    }
}
}

}
$_POST = array();
}


?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>ドキ♡ドキクエスト</title>
  
    <style>

    body{
      margin:0;
      padding:0;
      width:100%;
      height:850px;
      overflow-x:hidden;
      position:relative;
      font-family: 'ヒラギノ明朝 ProN','Hiragino Mincho ProN','HanziPen TC',cursive;	

    }

    .page-title{
      width:100%;
      height:70px;
      background:pink;
      text-align:center;
      font-size:30px;
      margin:0;
      box-sizing:border-box;
      overflow-x:hidden;
      line-height:80px;
      
      color:#FF6699;	
      font-family: 'ヒラギノ明朝 ProN','Hiragino Mincho ProN','HanziPen TC',cursive;
    }
   .girl-info{
     margin-left:10px;
     padding:0;
     height:720px;
    
     
     
   }
   /* .girl-img-area{
     width:50%;
     height:530px;
     margin-bottom:0;
     padding:0px 10px 0px 10px;
     box-sizing:border-box;
     border:2px solid pink;
     background:#e5e5e5;
   } */

   .girl-info>img{
     width:50%;
     height:550px;
     margin:0;
     display:block;
     margin-bottom:10px;
     box-sizing:border-box;
     margin-top:5px;
     border:7px solid pink;
  
    
     
   }
   .girl-profile-area{
     width:50%;
     height:150px;
     background:#FFCCCC;
     padding:14px 24px 24px 38px;
     
     border:3px solid pink;
     box-sizing:border-box;
     /* display:flex; */
     /* display:wrap; */
     /* justify-content: space-between; */
     
     
   }
   .girl-profile-area>p{
     display:block;
     width:300px;
     height:30px;
     font-size:18px;
     box-sizing:border-box;
     display:inline-block;
     margin-right:10px;
     font-family: 'ヒラギノ明朝 ProN','Hiragino Mincho ProN','HanziPen TC',cursive;
   }
   .connection{
     
    position:absolute;
    left:780px;
    top:90px;
    font-family: 'ヒラギノ明朝 ProN','Hiragino Mincho ProN','HanziPen TC',cursive;

    
     
   }
   .message{
     width:500px;
     height:450px;
     padding:30px;
     color:white;
     background:black;
     overflow-x:hidden;
     box-sizing:border-box;
     margin-bottom:15px;
     border:3px solid pink;
     font-size:14px;
     font-family: 'Corben', cursive;
   }  
.user-option{
     width:500px;
     height:150px;
     background:#C2EEFF;
     padding:40px 0 40px 65px ;
     box-sizing:border-box;
     border:3px solid pink;
     margin:0 auto;
     display:block;
     overflow-x:hidden;
     line-height:75px;
     display:flex;
     justify-content: space-between;
}


meter{
  width:60%;
  height:30px;
  display:block;
 
  box-sizing:border-box;
  margin-bottom:20px;
}
span{
  font-size:20px;
  color:#FF6699;
  margin-left:8px;
}
input[type="submit"]{
	    	border: none;
	    	padding: 20px 20px;
	      border-radius:10px;
	      font-size:14px;
        color:#FF6699;
        margin-right:9px;
        display:block;
        float:left;
	    
    	}
    	input[type="submit"]:hover{
	    	background: #3d3938;
	    	cursor: pointer;
    	}
    	a{
	    	color: #545454;
	    	display: block;
    	}
    	a:hover{
	    	text-decoration: none;
    	}
      #cover {
    background: #000;
    opacity: 0.9;
    width: 100%;
    height: 100%;
    position: absolute;
    top: 0;
    left: 0;
    z-index: 1;
    display: none;
  }
  body.menu-open #cover {
    display: block;
  }
#show{
  position:absolute;
  top:600px;
  left:620px;
 
  overflow-x:hidden;
  padding:40px;
  font-size:20px;
  z-index: 2;
}
.over{
  position:absolute;
  top:20px;
  left:40px;
  width:100%;
  height:300px;
  overflow-x:hidden;
  padding:100px;
  font-size:150px;
  z-index: 2;
  color:red;
}
.page-start{
  position:relative;
  width:50%;
  height:500px;
  padding:70px;
  margin:0 auto;
  /* background:red; */
}
.start{
  position:absolute;
  top:300px;
  left:300px;
  width:30%;
  height:300px;
  /* line-height:200px; */
  margin:0 auto;
  /* text-align:center; */
}
.start>h2{
  /* padding:5px 0 0 10px; */
 font-size:20px;
 background-color: #f3a3a8; /* 背景色 */
    background-image: radial-gradient(#f5b2b6 20%, transparent 0), radial-gradient(#f5b2b6 20%, transparent 0); /* 水玉の色 */
    /* background-position: 0 0, 10px 10px; */
    background-size: 10px 10px;
  color: #590c11; /* 文字色 */
    padding: 10px; 
    text-align:center;
    display:block;
    width:75%;
}
#start {
  display: inline-block;
  padding: .65em 4em;
  background: -webkit-linear-gradient(#fe5f95 , #ff3f7f);
  background: linear-gradient(#fe5f95 , #ff3f7f);
  border: 1px solid #fe3276;
  border-radius: 4px;
  color: #fff;
  text-decoration: none;
  text-align: center;
  -webkit-transition: .3s ease-in-out;
  transition: .3s ease-in-out;
}
#start:hover {
  -webkit-animation: bounce 2s ease-in-out;
  animation: bounce 2s ease-in-out;
}
@-webkit-keyframes bounce {
  5%  { -webkit-transform: scale(1.1, .8); }
  10% { -webkit-transform: scale(.8, 1.1) translateY(-5px); }
  15% { -webkit-transform: scale(1, 1); }
}
@keyframes bounce {
  5%  { transform: scale(1.1, .8); }
  10% { transform: scale(.8, 1.1) translateY(-5px); }
  15% { transform: scale(1, 1); }
}  

    </style>
  </head>
  
  <body>

  <?php if(empty($_SESSION)){ ?>
  <section class="page-start">
  <div class="start">
 <h2 style="margin-top:60px;">Ready?</h2>
 <form method="post">
 <input type="submit" name="start" value="▶ゲームスタート" id="start">
   </form>
  </div>
</section>
  

   <?php }else{ ?>

   <header class="page-title">
   ドキ❤︎ドキクエスト 
   </header>
    
   <section class="girl-info">
  <img src="<?php echo $_SESSION['girl']->getImg(); ?>">

  <div class="girl-profile-area">
   <p>なまえ : <?php echo $_SESSION['girl']->getName();?></p>
   <p>特技 : <?php echo $_SESSION['girl']->getHobby();?></p>
   <p>年齢 : <?php echo $_SESSION['girl']->getAge();?></p>
   <p>好きなこと : <?php echo $_SESSION['girl']->getLike();?></p>
  </div>
 </section>
  

 <section class="connection">
 <span>ドキドキメーター♡</span>
<?php if($_SESSION['girl']->getHp()<=500){?>
 <?php echo $_SESSION['girl']->getHp()?> / 500
 <meter class="test" max="500" low="20" high="40" value="100"></meter>
 
 
 <div class="message">
   <p><?php echo (!empty($_SESSION['history'])) ? $_SESSION['history'] : ''; ?></p>
  </div>
  <div class="user-option">
    
    <form method="post">
    <input type="submit" name="attack" value="ほめる" >
   <input type="submit" name="tword" value="ほほえむ">
   <input type="submit" name="escape" value="あきらめる">
    <input type="submit" name="love" value="告る">
     </form>

     <?php }else{ ?>
      <?php $_SESSION['girl']->setHp(500)?>
      <?php echo $_SESSION['girl']->getHp()?> / 500
      <meter class="test" max="500" low="20" high="40" value="100"></meter>
 
 
 <div class="message">
   <p><?php echo (!empty($_SESSION['history'])) ? $_SESSION['history'] : ''; ?></p>
  </div>
  <div class="user-option">
    
    <form method="post">
    <input type="submit" name="attack" value="覚悟を" >
   <input type="submit" name="tword" value="決めろ！">
   <input type="submit" name="escape" value="男だろ！？">
    <input type="submit" name="love" value="告る！！！" >
     </form>


      <?php } ?>

      <?php } ?>
  </div>
 </section>


 <?php if(!empty($_SESSION{'gameover'})){ 
  if(!empty($_POST['home'])){
    session_destroy();
  }
   ?>
  <body class="menu-open"> 
  <form method="post">
  <input type="submit" name="home" value="家にひきこもる！" id="show"
  >
   </form>

  <div class="over">
   <p><?php
    echo (!empty($_SESSION['history'])) ? $_SESSION['history'] : ''; ?></p>
  </div>
  
  <div id="cover"></div>
</div>
</body>
<?php
 }
?>
<!-- <script src="main.js"></script> -->
 <script src="https://code.jquery.com/jquery-3.4.1.min.js"> 
  </script>
    <script>
var count = 0;
    var countup = function(){
      console.log(count++);
      var power = setTimeout(countup, 1);
      $(".test").val(power); //体力回復 jQuery部分
      if(count >= <?php echo $_SESSION['girl']->getHp();?>){
        clearTimeout(power);　//clearTimeoutで時間処理STOP
      }
    }
    countup();
    </script>
 </body>
</html>
   
   
   







  








   
 


































 



  
  


 
  

 
 
    

    



  

   



    


   
   
   
   
   
   
   
        



   
     

 










