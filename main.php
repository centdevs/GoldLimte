<?php
/**
*** Created By devzeus [https://t.me/devzeus]
*** Timer provided by Xavi [https://t.me/Th3_Pr3da70l]
*** Website idea provided by Xavi [https://t.me/Th3_Pr3da70l]
***
***
*** Released on a sunday 16th Jan 2021 
*** Make this count dude 
*** ### learn something new this year 
*** Happy 2022 , This is your 2022 present from me
*** 
***
*** If you need to edit the banner, You can but leave - 
***    alone these credits. 
***
*** My youtube channel : https://www.youtube.com/channel/UCoIH4EUB2V-E2uzouD3ZG2g 
***    -> subscribe and make me happy dude. 
***
*** Love you alot
**/

// check old cookie file, exists? then delete it
if(file_exists('cookie.txt'))
    unlink('cookie.txt');

// clear screen 
@system('clear');

// banner function
function banner(){
	echo "-------------------------------------------------------\n";
	echo " ->Created By devzeus[\033[1;32mt.me/devzeus\033[0m]\n ->I am not responsible for any irregularity, really! \n ->##enjoy [\033[1;31mhappy 2022\033[0m] • \033[1;32mlearn something new\033[0m\n -> \033[1;36mSubscribe My YouTube Channel :)\033[0m\n";
	echo "-------------------------------------------------------\n";
	sleep(3);
	// open my youtube channel. Subscribe. I will love that
	@system("termux-open-url 'https://www.youtube.com/channel/UCoIH4EUB2V-E2uzouD3ZG2g'");
}


// timer function by Xavi Rodriguez t.me/Th3_Pr3da70l
function timer($str = "wait",$tt = 30){
	$ijo="\033[92m";$pth="\033[37m";$tmr="\033[31m";
	$kn="\033[33m";$tr="\033[36m";$tmre="\033[35m";
	$tik=[$tr,$kn,$tmr,$tmre,$tr,$kn,$tmr,$tmre];$a=1;
	echo "\r                                          \r";
	for($tri=$tt; $tri>0; $tri--){   
		$a1=str_repeat("•",$a);$tok=$tik[$a-1];
		echo "{$pth}{$str} ".gmdate("H:i:s",$tri); echo " {$tok}".$a1."";
		if($a==8){
			$a=1;
		}else{
			$a++;
		}
		sleep(1);
		echo "\r                                        \r";
	}
}

// end timer 

// check if user agent is given, if not request one
if(!file_exists('ua')){
    echo "Input your user agent first> ";
    $ua = trim(fgets(STDIN));
    file_put_contents('ua', $ua);
    @system('clear');
}else{
    $ua = file_get_contents('ua');
}

// header array in [GLOBAL - available everywhere in the script]
// don't edit a single character
$GLOBALS['header'] = array(
    "upgrade-insecure-requests:1",
    "origin: https://goldlimte.com", 
    "content-type: application/x-www-form-urlencoded",
    "user-agent: $ua",
    "accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9",
    "referer: https://goldlimte.com/",
    "accept-language: en-GB,en-US;q=0.9,en;q=0.8"
);

// post function 
function post($url, $data){
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL=>$url,
        CURLOPT_SSL_VERIFYPEER=>false,
        CURLOPT_CUSTOMREQUEST=>"POST",
        CURLOPT_POSTFIELDS=>$data,
        CURLOPT_HTTPHEADER=>$GLOBALS['header'],
        CURLOPT_COOKIEJAR=>'cookie.txt',
        CURLOPT_COOKIEFILE=>'cookie.txt',
        CURLOPT_RETURNTRANSFER=>true
    ));
    try{
        return curl_exec($curl);
        curl_close($curl);
    }catch(Exception $e){
        exit("Error posting");
    }
}

// get function
function get($url){
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL=>$url,
        CURLOPT_SSL_VERIFYPEER=>false,
        CURLOPT_CUSTOMREQUEST=>"GET",
        CURLOPT_HTTPHEADER=>$GLOBALS['header'],
        CURLOPT_COOKIEJAR=>'cookie.txt',
        CURLOPT_COOKIEFILE=>'cookie.txt',
        CURLOPT_RETURNTRANSFER=>true
    ));
    try{
        return curl_exec($curl);
        curl_close($curl);
    }catch(Exception $e){
        exit("Error at Get");
    }
}

// gets form token [hidden]
function token(){
    $res = get('https://goldlimte.com', $GLOBALS['header']);
    if (preg_match("/name=\"token\" value=\"([a-zA-z0-9]{32})\"/", $res, $spoof)){
        return $spoof[1];
    } 
}

// login function, takes in username and password
function login($username, $password){
    $url = "https://goldlimte.com";
    $data = "token=".token()."&user=$username&password=$password&connect=";
    array_push($GLOBALS['header'], "cookie:AccExist=$username");
    post($url, $data);
}

// this checks user info | cheeky 😂
function index($username){
    $url = "https://goldlimte.com/index.php";
    $res = get($url, $GLOBALS['header']);
    

    preg_match("/class=\"text-warning\">[0-9]+.[0-9]+/", $res, $coins);
    if(!preg_match("/[0-9]+\.[0-9]+/", $coins[0], $nc)){
    	preg_match("/[0-9]+\,[0-9]+/", $coins[0], $nc);
    }
    preg_match("/class=\"text-white\">[0-9]+/", $res, $vidNum);
    preg_match("/[0-9]+/", $vidNum[0], $nvn);
    
    echo " -> User : \033[1;36m$username\033[0m - Points Balance : \033[1;36m".$nc[0]."\033[0m\n";

}

// finds all the videos and watches them all 
// also claims the coins
function videos(){
    $url = "https://goldlimte.com/index.php?page=videos";
    $res = get($url);
    // all videos

    // <div class="website_block" id="290">
    preg_match_all("/class=\"website_block\" id=\"[0-9]+/", $res, $vids);
    // loop through all videos
    foreach($vids[0] as $vid){
        // one video
        preg_match("/[0-9]+/", $vid, $vidid);
        $videoID = $vidid[0];
        
        $vidurl = "https://goldlimte.com/?page=videos&vid=$videoID";
        $vidRes = get($vidurl);
        
        
        preg_match("/span>\/[0-9]+ seconds/", $vidRes, $watchTime);
        preg_match("/[0-9]+/", $watchTime[0], $clwt);
        
        // sleep for the given time
       
        timer("please wait ", (int)$clwt[0]);
        echo "\r                                  \r";
        // get token 
        preg_match("/var token = \'([a-zA-z0-9]{32})\'/", $vidRes, $token);

        // on watch complete
        
        $urlCom = "https://goldlimte.com/system/gateways/video.php";
        $data = "data=$videoID&token=".$token[1];
        
        $res = post($urlCom, $data);
    
        //  You have received <b>15.00 coins
        preg_match("/ You have received <b>[0-9]+.[0-9]+/", $res, $coindata);
        preg_match("/[0-9]+.[0-9]+/", $coindata[0], $clreward);

        echo "You won ".$clreward[0]." coins\n";
        index(); 

    }
    // out of loop? videos are finished then ...
    echo "\033[1;31mNo more videos\033[0m\n";
}

// check if username file exists, if none then asks for one
if(file_exists('username')){
    $username = file_get_contents('username');
}else{
    echo "Input your Username> ";
    $username = trim(fgets(STDIN));
    file_put_contents('username', $username);
    @system('clear');
    
}

// check password file if exists, if not then ask for one
if(file_exists('password')){
    $password = file_get_contents('password');
}else{
    echo "Input your Password> ";
    $password = trim(fgets(STDIN));
    file_put_contents('password', $password);
    @system('clear');
    
}

// initialise banner. 
banner();

login($username, $password); // init login method
index($username); // init account info and balance method

videos(); // init videos claiming and checking method

?>