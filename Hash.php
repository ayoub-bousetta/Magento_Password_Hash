<?php
 
error_reporting(E_ALL | E_STRICT);
$mageFilename = 'app/Mage.php';
if (!file_exists($mageFilename)) {
    echo $mageFilename." was not found";
    exit;
}
require_once $mageFilename;
Varien_Profiler::enable();
Mage::setIsDeveloperMode(true);
ini_set('display_errors', 1);
umask(0);
Mage::app(); 
 
//get all customers
 
$customers = Mage::getModel('customer/customer')->getCollection();
 
 
//Loop to get a single customer informations
 
foreach ($customers as $customer){
   
   
   // Get customers extanded Data by email
    $customerpass = Mage::getModel('customer/customer')
 ->setWebsiteId(Mage::app()->getStore()->getWebsiteId())
 ->loadByEmail($customer->getEmail());
 
 
// Get current password (No hashed PW)
$pass = $customerpass->getData("password_hash");
 $salt = "at";
 $password = md5($salt.$pass).":".$salt;
   
   //Save hashed password     
        $customer->setPasswordHash($password)->save();
 
 
 
 
}
 
echo "Done!";
 
 
?>
