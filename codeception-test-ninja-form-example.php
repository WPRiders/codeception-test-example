<?php
// Generate a random string
function random_string( $len = 10 ) {
	return substr( md5( uniqid( rand() ) ), 0, $len );
}

$rand = random_string();

$I = new AcceptanceTester( $scenario );
$I->amOnPage( '/free-dental-samples/' );

$I->checkOption( '#ninja_forms_field_19_0' );

// Use the random generated string for First Name to obtain different submissions
$I->fillField( 'First Name', $rand . ' Test' );
$I->fillField( 'Last Name', 'Test' );
$I->fillField( 'Company Name', 'Test' );
$I->fillField( 'Address 1', 'Test' );
$I->fillField( 'City', 'Test' );
$I->fillField( 'Zip / Post Code', '10007' );
$I->fillField( 'Email', 'test@test.com' );
$I->selectOption( 'input[name=ninja_forms_field_47]', 'Yes' );
$I->click( 'Submit' );

$I->waitForText( 'Thank You! Your Free Samples Are Being Processed.' );

// Check that the form submission in WordPress back-end
$I->loginAsAdmin();
$I->waitForElement( '#adminmenu' );
$I->amOnPage( 'wp-admin/edit.php?post_type=nf_sub' );
$I->waitForElement( 'select.nf-form-jump' );
$I->selectOption( 'form select.nf-form-jump', 'Free Sample Requests' );
$I->see( $rand . ' Test' );
