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

            .page {
                text-align: center;
                position: relative;
                right: -5%;
                width: 60%;
                margin: auto;
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
                margin: 15px;
            }
            
        </style>
    </head>
    <body>
        <div class= "sidebar">
                <header>
                    <img src="https://cdn2.downdetector.com/static/uploads/logo/Hunt_Logo_Black.png">
                </header>
                <ul>
                    <li><a href="../main.php">Home</a></li>
                    <li><a href="../entity_pages/hunters.php">Hunters</a></li>
                    <li><a href="../entity_pages/monsters.php">Monsters</a></li>
                    <li><a href="../entity_pages/locations.php">Locations</a></li>
                    <li><a href="../entity_pages/traits.php">Traits</a></li>
                    <li><a href="../entity_pages/tools.php">Tools</a></li>
                    <li><a href="../entity_pages/consumables.php">Consumables</a></li>
                    <ul>
                        <li><a href="../entity_pages/syringes.php">Syringes</a></li>
                        <li><a href="../entity_pages/explosives.php">Explosives</a></li>
                    </ul>
                    <li><a href="../entity_pages/firearms.php">Firearms</a></li>
                    <ul>
                        <li><a href="../entity_pages/ammo.php">Ammo</a></li>
                    </ul>
                    <li><a href="../entity_pages/more.php">More...</a></li>
            </ul>
            </div>

        <div class="page">
            <center>
                <h1>UPDATE</h1>
            </center>

            <center>
                <h2>TABLE: Tool</h2>
            </center>

            <div class="update">
                <form method="Post" action="update.php">
                    <input type="hidden" id="updateQueryRequest" name="updateQueryRequest">

                    <center>
                        <label for="name">Tool Name:</label>
                        <input type="text" name="name" id="name">
                        
                    </center>

                    <center>
                        <label for="attr">Attribute to Update:</label>
                        <select name="attr" id="attr">
                            <option value="toolName">toolName</option>
                            <option value="toolDescription">toolDescription</option>
                            <option value="toolMeleeDamage">toolMeleeDamage</option>
                            <option value="toolHeavyMeleeDamage">toolHeavyMeleeDamage</option>
                            <option value="toolCost">toolCost</option>
                        </select>
                    </center>
                    
                    <center>
                        <label for="val">New Value:</label>
                        <input type="text" name="val" id="val">
                        </select>
                    </center>
                    <center>
                        <input type="submit" value="Update" name="POST">
                    </center>
                </form>

            </div>
        </div>

        <?php
            include '../backend_functionality/api.php';
            handleAPIRequest();
        ?>
    </body>
</html> 