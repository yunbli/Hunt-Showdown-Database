<?php
    include 'dbconn.php';
    include 'handlers.php';

    // HANDLE ALL API REQUEST VIA ISSETS
    function handleAPIRequest() {
        if (isset($_POST['POST'])) {
            handlePOSTRequest();
        }
        if (isset($_GET['GET'])) {
            handleGETRequest();
        }
    }

    // HANDLE ALL POST ROUTES
    function handlePOSTRequest() {
        if (connectToDB()) {
            if (array_key_exists('insertQueryRequest', $_POST)) {
                handleInsertRequest();
            }
            if (array_key_exists('deleteQueryRequest', $_POST)) {
                handleDeleteRequest();
            }
            if (array_key_exists('updateQueryRequest', $_POST)) {
                handleUpdateRequest();
            }        
            if (array_key_exists('dropSingleTableRequest', $_POST)) {
                handleDropSingleTableRequest();
            }
            if (array_key_exists('dropAllTablesRequest', $_POST)) {
                handleDropAllTablesRequest();
            }
            if (array_key_exists('resetTablesRequest', $_POST)) {
                handleResetTablesRequest();
            }

            disconnectFromDB();
        }
    }

    // HANDLE ALL GET ROUTES
    function handleGETRequest() {
        if (connectToDB()) {
            // basic table display requests
            if (array_key_exists('displayTuplesFirearm', $_GET)) {
                handleDisplayRequest("Firearm");
            }
            if (array_key_exists('displayTuplesAmmo', $_GET)) {
                handleDisplayRequest("Ammo");
            }
            if (array_key_exists('displayTuplesConsumable', $_GET)) {
                handleDisplayRequest("Consumable");
            }
            if (array_key_exists('displayTuplesSyringe', $_GET)) {
                handleDisplayRequest("Syringe");
            }
            if (array_key_exists('displayTuplesExplosive', $_GET)) {
                handleDisplayRequest("Explosive");
            }
            if (array_key_exists('displayTuplesTool', $_GET)) {
                handleDisplayRequest("Tool");
            }
            if (array_key_exists('displayTuplesTrait', $_GET)) {
                handleDisplayRequest("Trait");
            }
            if (array_key_exists('displayTuplesLocation', $_GET)) {
                handleDisplayRequest("Location");
            }
            if (array_key_exists('displayTuplesMonster', $_GET)) {
                handleDisplayRequest("Monster");
            }
            if (array_key_exists('displayTuplesHunter', $_GET)) {
                handleDisplayRequest("Hunter");
            }
            if (array_key_exists('displayTuplesAcquires', $_GET)) {
                handleDisplayRequest("Acquires");
            }
            if (array_key_exists('displayTuplesConsumes', $_GET)) {
                handleDisplayRequest("Consumes");
            }
            if (array_key_exists('displayTuplesHunts', $_GET)) {
                handleDisplayRequest("Hunts");
            }
            if (array_key_exists('displayTuplesSpawns', $_GET)) {
                handleDisplayRequest("Spawns");
            }
            if (array_key_exists('displayTuplesWields', $_GET)) {
                handleDisplayRequest("Wields");
            }

            // complex query displays requests
            if (array_key_exists('handleSelectionAndProjectionRequest', $_GET)) {
                handleSelectionAndProjectionRequest();
            }
            if (array_key_exists('handleJoinAndSelectionRequest', $_GET)) {
                handleJoinAndSelectionRequest();
            }
            if (array_key_exists('handleAggregationWithGroupByRequest', $_GET)) {
                handleAggregationWithGroupByRequest();
            }
            if (array_key_exists('handleAggregationWithHavingRequest', $_GET)) {
                handleAggregationWithHavingRequest();
            }
            if (array_key_exists('handleNestedAggregationWithGroupByRequest', $_GET)) {
                handleNestedAggregationWithGroupByRequest();
            }
            if (array_key_exists('handleDivisionRequest', $_GET)) {
                handleDivisionRequest();
            }

            disconnectFromDB();
        }
    }
?>