<?php
    $db_conn = null; // login credentials found in connectToDB()
    $success = true; // keep track of errors so it redirects the page only if there are no errors
    $show_debug_alert_messages = false; // set to true if you want alerts to show you which methods are being triggered - see debugAlertMessage()

    function connectToDB() {
        global $db_conn;

        // username is ora_{CWL_ID} and the password is a{student number}
        $db_conn = OCILogon("ora_shenvic", "a73048563", "dbhost.students.cs.ubc.ca:1522/stu");

        if ($db_conn) {
            debugAlertMessage("Database is Connected");
            return true;
        } else {
            debugAlertMessage("Cannot connect to Database");
            $e = OCI_Error(); // For OCILogon errors pass no handle
            echo htmlentities($e['message']);
            return false;
        }
    }

    function disconnectFromDB() {
        global $db_conn;

        debugAlertMessage("Disconnect from Database");
        OCILogoff($db_conn);
    }
?>