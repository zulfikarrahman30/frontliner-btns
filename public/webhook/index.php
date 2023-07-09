<?php 
 
 
 header('content-type: application/json');
 $data = json_decode(file_get_contents('php://input'), true);
 file_put_contents('whatsapp.txt', '[' . date('Y-m-d H:i:s') . "]\n" . json_encode($data) . "\n\n", FILE_APPEND);                                               
 $message = strtolower($data['message']);
 $from = strtolower($data['from']);
 $respon = false;
 
 // auto respond text   
 function sayHello(){    
 return ["text" => 'Halloooo!'];
             }
 
 // auto respond gambaar            
function gambar(){
 return [
     'image' => ['url' => 'https://seeklogo.com/images/W/whatsapp-logo-A5A7F17DC1-seeklogo.com.png'],
     'caption' => 'Logo whatsapp!'
 ];   
}
 
//auto respond button
 function button(){
     $buttons = [
         ['buttonId' => 'id1', 'buttonText' => ['displayText' => 'BUTTON 1'], 'type' => 1], // button 1 // 
         ['buttonId' => 'id2', 'buttonText' => ['displayText' => 'BUTTON 2'], 'type' => 1], // button 2
         ['buttonId' => 'id3', 'buttonText' => ['displayText' => 'BUTTON 3'], 'type' => 1], // button 3
     ];
     $buttonMessage = [
         'text' => 'HOLA, INI ADALAH PESAN BUTTON', 
         'footer' => 'ini pesan footer', 
         'buttons' => $buttons,
         'headerType' => 1 
     ];
     return $buttonMessage;
 }
 
 // auto respon lists
function lists(){
 $sections = [
        [ 
        	"title" => "This is List menu",
        	"rows" => [
	        ["title" => "List 1", "description" => "this is list one"],
	        ["title" => "List 2", "description" => "this is list two"],
    	] 
    ]
];
 
 $listMessage = [
  "text" => "This is a list",
  "title" => "Title Chat",
  "buttonText" => "Select what will you do?",
  "sections" => $sections
 ];
 
 return $listMessage;  
 }
 
 
 if($message === 'hai'){
     $respon = sayHello();
 } else if($message === 'gambar'){
     $respon = gambar();
 } else if($message === 'tes button'){
     $respon = button();
 } else if($message === 'lists msg'){
     $respon = lists();
 }
 $file = "result.json";
file_put_contents($file, $data);
echo json_encode($message);
?>