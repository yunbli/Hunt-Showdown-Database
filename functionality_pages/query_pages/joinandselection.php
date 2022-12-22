<html>
    <head>
        <style>
            body {
                overflow-x: hidden;
                background-color: #dbd9da;
                font-family: 'Roboto', sans-serif;
            }
            * {
                margin: 0;
                padding: 0;
                list-style: none;
                text-decoration: none;
            }

            .sidebar {
                position: fixed;
                left: 0;
                width: 250px;
                height: 100%;
                background: #575555; 
            }

            .sidebar header img{
                display: block;
                margin-left: auto;
                margin-right: auto;
                width: 75%;
                height: 22.5%;
            }

            .sidebar ul li a {
                display: block;
                height: 6%;
                width: 100%;
                line-height: 15px;
                padding-left: 50px;
                pading-top: 50px;
                font-size: 20px;
                color: #ab998c;
                box-sizing: border-box;
                border-top: 1px solid rgba(87, 85, 85, 0.8);
                border-bottom: 1px solid rgba(87, 85, 85, 0.8);
            }

            .sidebar ul ul li a {
                display: block;
                height: 6%;
                width: 100%;
                line-height: 15px;
                padding-left: 80px;
                pading-top: 50px;
            }

            .page {
                text-align: center;
                position: relative;
                right: -5%;
                width: 60%;
                margin: auto;
            }


            .return {
                text-decoration: "none";
                padding: 20px 50px;
                font-size: 20px;
                position: relative;
                margin: 38px;
            }

            .btn {
                text-decoration: "none";
                padding: 10px;
                font-size: 20px;
                position: relative;
                margin: 38px;
                text-align: center;
                width: 75%;
                top: -20;
            }
            
            .return-btn {
                background: #575555;
                color: #ab998c;
                border-radius: 10px;
            }


            input[type=submit] {
                background: #575555;
                color: #ab998c;
                padding: 10px;
                border-radius: 10px;
            }


            input[type="text"] {
                border-radius: 4px;
                border: 2px solid #575555;
                margin: 25px;
            }


            select {
                border-radius: 4px;
                border: 2px solid #575555;
                margin: 25px;
                background: #f0ebef;
                color: #575555;
                text-align: center;
                font-size: 15px;
                margin: 20px;
            }

            table {
                display: block;
                position: absolute;
                top:350;
                right: 1%;
                width: 85%;
                font-size: 11px;
            }

        </style>
    </head>
    

    <body>
        <div class= "sidebar">
            <header>
                <img src="https://cdn2.downdetector.com/static/uploads/logo/Hunt_Logo_Black.png">
            </header>
            <ul>
                <li><a href="../../main.php">Home</a></li>
                <li><a href="../.././entity_pages/hunters.php">Hunters</a></li>
                <li><a href="../.././entity_pages/monsters.php">Monsters</a></li>
                <li><a href="../.././entity_pages/locations.php">Locations</a></li>
                <li><a href="../.././entity_pages/traits.php">Traits</a></li>
                <li><a href="../.././entity_pages/tools.php">Tools</a></li>
                <li><a href="../.././entity_pages/consumables.php">Consumables</a></li>
                <ul>
                    <li><a href="../.././entity_pages/syringes.php">Syringes</a></li>
                    <li><a href="../.././entity_pages/explosives.php">Explosives</a></li>
                </ul>
                <li><a href="../.././entity_pages/firearms.php">Firearms</a></li>
                <ul>
                    <li><a href="../.././entity_pages/ammo.php">Ammo</a></li>
                </ul>
                <li><a href="../.././entity_pages/more.php">More...</a></li>
            </ul>
        </div>
        
        <div class="page">
            <center>
                <h1>JOIN AND SELECT</h1>
                <h2>TABLES: Hunter, Firearm</h2>
            </center>

            <div class="join-select"> 
                <form method="GET" action="joinandselection.php">
                    <input type="hidden" name="GET" id="GET">
                    <center>
                        <label for="t1_attr">Hunter:</label>
                        <select name="t1_attr" id="t1_attr">
                            <option value="hunterName">Hunter Name</option>
                            <option value="hunterLevel">Hunter Level</option>
                            <option value="hunterDescription">Hunter Description</option>
                            <option value="hunterFunds">Hunter Funds</option>
                            <option value="locationName">Location Name</option>
                            <option value="firearmName">Firearm Name</option>
                            <option value="hunterHealth">Hunter Health</option>
                        </select>
                        <select name="t1_comparator" id="t1_comparator">
                            <option value="<"><</option>
                            <option value=">">></option>
                            <option value="=">=</option>
                            <option value="<="><=</option>
                            <option value=">=">>=</option>
                            <option value="<>">=/=</option>
                        </select>
                        <input type="text" name="t1_val">
                    </center>

                    <center>
                        <label for="t2_attr">Firearm:</label>
                        <select name="t2_attr" id="t2_attr">
                            <option value="firearmName">Firearm Name</option>
                            <option value="firearmDescription">Firearm Description</option>
                            <option value="firearmCapacity">Firearm Capacity</option>
                            <option value="firearmRateOfFire">Firearm Rate of Fire</option>
                            <option value="firearmHandling">Firearm Handling</option>
                            <option value="firearmCost">Firearm Cost</option>
                        </select>
                        <select name="t2_comparator" id="t2_comparator">
                            <option value="<"><</option>
                            <option value=">">></option>
                            <option value="=">=</option>
                            <option value="<="><=</option>
                            <option value=">=">>=</option>
                            <option value="<>">=/=</option>
                        </select>
                        <input type="text" name="t2_val">
                    </center>

                    <center>
                        <input type="submit" value="Execute" name="handleJoinAndSelectionRequest">
                    </center>
                </form>

            </div>


            <div class="return">
                <a href="../queries.php" class="btn return-btn">Return</a>
            </div>
        </div>

        <?php
            include '../../backend_functionality/api.php';
            handleAPIRequest();
        ?>
    </body>
    <!-- </body> -->
</html>