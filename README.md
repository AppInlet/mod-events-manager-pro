# events-manager-pro

PayFast Events Manager Pro v2 Module v1.00 for Events Manager Pro v2.3.9
------------------------------------------------------------------------
INTEGRATION INSTRUCTIONS:
-------------------------

WHAT ARE THE INSTALLATION REQUIREMENTS?
You will need a working installation of WordPress with Events Manager and Events Manager Pro

In order to integrate EM Pro with PayFast you will need to include gateway.payfast.php on line 464 of
events-manager-pro/add-ons/gateways/gateways.php as follows:
include('gateway.payfast.php');

You will also need to add South African Rand to the currency options. This is done in 
events-manager/em-functions.php as follows: 
On line 223 add " 'ZAR' => 'ZAR - South African Rand' " to the array
On line 224 and 225 add " 'ZAR' => 'R' " to the array

HOW DO I INSTALL THE PAYFAST MODULE?
1. Download and unzip the file.
2. Using FTP copy the wp-content file to your root WordPress directory.
3. Log in to the admin dashboard of your website, navigate to Events>Payment Gateways
4. Click on PayFast settings and setup the settings page accordingly 
   - If you are testing in sandbox mode leave the Merchant ID and Key fields blank.
   - If you are ready to go live insert your merchant ID and Key, as well as 
   passphrase (only if you have the passphrase set on your PayFast account).
5. Click save changes
6. Navigate back to Events>Payment Gateways and click on activate PayFast.
7. Navigate to Settings>Bookings>Pricing Options and select currency ZAR.

Please [click here](https://payfast.io/integration/shopping-carts/events-manager-pro/) for more information concerning this module.
