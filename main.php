
<html>
    <head>
        <title>CPSC 304 PHP/Oracle Hunt: Showdown Database Project</title>
        <link rel="stylesheet" href="main.css" type="text/css">
        <style>
            body {
                overflow-x: hidden;
                background-color: #dbd9da;
                font-family: 'Roboto', sans-serif;
                background-position: top 100px right 110px;
                position: relative;
                background-size: contain;
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

            .container {
                height: 100%;
                display: flex;
                align-items: center;
                justify-content: center;
                position: relative;
                right: -50;
                top: 0;
                flex-direction: column;
                left: 5%;
                width: 60%;
                margin: auto
            }

            .top {
                display: flex;
                flex-direction: row;
                margin: 10;
            }

            .bottom {
                display: flex;
                flex-direction: row;
                margin: 10;
            }

            .btn {
                text-decoration: "none";
                padding: 20px 30px;
                font-size: 20px;
                position: relative;
                margin: 10px;
            }

            .insert {
                background: #575555;
                color: #ab998c;
                border-radius: 10px;
            }

            .queries {
                background: #575555;
                color: #ab998c;
                border-radius: 10px;
            }

            .delete {
                background: #575555;
                color: #ab998c;
                border-radius: 10px;
            }

            .drop {
                background: #575555;
                color: #ab998c;
                border-radius: 10px;
            }

            .update {
                background: #575555;
                color: #ab998c;
                border-radius: 10px;
            }

            .reset {
                background: #575555;
                color: #ab998c;
                border-radius: 10px;
            }

        </style>
    </head>

    <body>
        <div class= "sidebar">
            <header>
                <img src="https://cdn2.downdetector.com/static/uploads/logo/Hunt_Logo_Black.png">
            </header>
            <ul>
                <li><a href="main.php">Home</a></li>
                <li><a href="./entity_pages/hunters.php">Hunters</a></li>
                <li><a href="./entity_pages/monsters.php">Monsters</a></li>
                <li><a href="./entity_pages/locations.php">Locations</a></li>
                <li><a href="./entity_pages/traits.php">Traits</a></li>
                <li><a href="./entity_pages/tools.php">Tools</a></li>
                <li><a href="./entity_pages/consumables.php">Consumables</a></li>
                <ul>
                    <li><a href="./entity_pages/syringes.php">Syringes</a></li>
                    <li><a href="./entity_pages/explosives.php">Explosives</a></li>
                </ul>
                <li><a href="./entity_pages/firearms.php">Firearms</a></li>
                <ul>
                    <li><a href="./entity_pages/ammo.php">Ammo</a></li>
                </ul>
                <li><a href="./entity_pages/more.php">More...</a></li>
            </ul>
        </div>

        <div class= "container">
            <div class="image">
                <img src= "https://cdn2.downdetector.com/static/uploads/logo/Hunt_Logo_Black.png" style="width:960px;height:540px;"">
            </div>

            <div class="top">
                <a href="./functionality_pages/insert.php" class="btn insert">INSERT</a>
                <a href="./functionality_pages/delete.php" class="btn delete">DELETE</a>
                <a href="./functionality_pages/update.php" class="btn update">UPDATE</a>
            </div>
            
            <div class="bottom">
                <a href="./functionality_pages/queries.php" class="btn queries">QUERIES</a>
                <a href="./functionality_pages/drop.php" class="btn drop">DROP</a>
                <a href="./functionality_pages/reset.php" class="btn reset">RESET</a>
            </div>
        </div>
	</body>
</html>
