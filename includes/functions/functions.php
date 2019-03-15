<?php  
/* 
    - getTitle
    - This Function for rename the title
    - This is Void Function 
*/
function getTitle() {

    global $pageTitle;

    if (isset($pageTitle)){

        echo $pageTitle;
            
        }
 }
/* 
    - randomString
    - Create  Random String
    - This is string Function 
*/
function randomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
/* 
    - randomChars
    - Create  Random Chars
    - This is string Function 
*/
function randomChars($length = 10) {
    $characters = 'abcdefghijklmnopqrstuvwxyz';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
/* 
        - cheak
        - Check If item Exist in Database
        - $where is Optional
        - This is bool Function 
    */
    function cheak($select, $from, $where) {

        global $con;

        if(!empty($where)){

            $stmt = $con->prepare("SELECT  $select FROM  $from  WHERE $where");

        }else {

            $stmt = $con->prepare("SELECT  $select FROM  $from");

        }
            $stmt->execute();

            $get = $stmt->fetch();

            $count = $stmt->rowCount();

			// If Count > 0 This Mean The Data Exist in Database

			if ($count > 0) {

                return TRUE;

			} else {

                return FALSE;

            }

    }