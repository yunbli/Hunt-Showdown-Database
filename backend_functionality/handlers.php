<?php
    include 'utils.php';
    function handleDisplayRequest($table) {
        global $db_conn;
        
        switch($table) {
            case 'Hunter':
                $result = executePlainSQL("SELECT * FROM Hunter NATURAL JOIN subHunter");
                break;
            case 'Monster':
                $result = executePlainSQL("SELECT * FROM Monster NATURAL JOIN subMonster");
                break;
            case 'Consumable':
                $result = executePlainSQL("SELECT * FROM Consumable NATURAL LEFT OUTER JOIN Syringe NATURAL LEFT OUTER JOIN Explosive");
                break;
            case 'Syringe':
                $result = executePlainSQL("SELECT * FROM Consumable NATURAL JOIN Syringe");
                break;
            case 'Explosive':
                $result = executePlainSQL("SELECT * FROM Consumable NATURAL JOIN Explosive");
                break;
            default: 
                $result = executePlainSQL("SELECT * FROM " . $table);
                break;
        }
        printResult($result);
    }

    function handleInsertRequest() {
        global $db_conn;

        $tuple = array (
            ":bind1" => $_POST['traitName'],
            ":bind2" => $_POST['traitDescription'],
            ":bind3" => $_POST['traitCost']
        );

        $alltuples = array (
            $tuple
        );

        executeBoundSQL("INSERT INTO Trait VALUES (:bind1, :bind2, :bind3)", $alltuples);
        OCICommit($db_conn);
    }

    function handleDeleteRequest() {
        global $db_conn;

        $name = $_POST['name'];
        
        executePlainSQL("DELETE FROM Consumable WHERE consumableName='" . $name . "'");
        OCICommit($db_conn);
    }

    function handleUpdateRequest() {
        global $db_conn;

        $name = $_POST['name'];
        $attr = $_POST['attr'];
        $val = $_POST['val'];

        if (is_string($val)) {
            executePlainSQL("UPDATE Tool SET " . $attr . "=" . "'" . $val . "'" . " WHERE " . "toolName=" . "'" . $name . "'");
        } else {
            executePlainSQL("UPDATE Tool SET " . $attr . "=" . $val . " WHERE " . "toolName=" . "'" . $name . "'");
        }
        OCICommit($db_conn);
    }

    function handleSelectionAndProjectionRequest() {
        global $db_conn;

        $table = $_GET['table'];
        $columns = $_GET['columns'];
        $attr = $_GET['attr'];
        $comparator = $_GET['comparator'];
        $val = $_GET['val'];

        switch($table) {
            case 'Hunter':
                if (is_string($val)) {
                    $result = executePlainSQL("SELECT " . $columns . " FROM " . "Hunter NATURAL JOIN subHunter" . " WHERE " . $attr . $comparator . "'" . $val . "'");
                } else {
                    $result = executePlainSQL("SELECT " . $columns . " FROM " . "Hunter NATURAL JOIN subHunter" . " WHERE " . $attr . $comparator . $val);
                }
                break;
            case 'Monster':
                if (is_string($val)) {
                    $result = executePlainSQL("SELECT " . $columns . " FROM " . "Monster NATURAL JOIN subMonster" . " WHERE " . $attr . $comparator . "'" . $val . "'");
                } else {
                    $result = executePlainSQL("SELECT " . $columns . " FROM " . "Monster NATURAL JOIN subMonster" . " WHERE " . $attr . $comparator . $val);
                }
                break;
            case 'Consumable':
                if (is_string($val)) {
                    $result = executePlainSQL("SELECT " . $columns . " FROM " . "Consumable NATURAL LEFT OUTER JOIN Syringe NATURAL LEFT OUTER JOIN Explosive" . " WHERE " . $attr . $comparator . "'" . $val . "'");
                } else {
                    $result = executePlainSQL("SELECT " . $columns . " FROM " . "Consumable NATURAL LEFT OUTER JOIN Syringe NATURAL LEFT OUTER JOIN Explosive" . " WHERE " . $attr . $comparator . $val);
                }
                break;
            case 'Syringe':
                if (is_string($val)) {
                    $result = executePlainSQL("SELECT " . $columns . " FROM " . "Consumable NATURAL JOIN Syringe" . " WHERE " . $attr . $comparator . "'" . $val . "'");
                } else {
                    $result = executePlainSQL("SELECT " . $columns . " FROM " . "Consumable NATURAL JOIN Syringe" . " WHERE " . $attr . $comparator . $val);
                }
                break;
            case 'Explosive':
                if (is_string($val)) {
                    $result = executePlainSQL("SELECT " . $columns . " FROM " . "Consumable NATURAL JOIN Explosive" . " WHERE " . $attr . $comparator . "'" . $val . "'");
                } else {
                    $result = executePlainSQL("SELECT " . $columns . " FROM " . "Consumable NATURAL JOIN Explosive" . " WHERE " . $attr . $comparator . $val);
                }
                break;
            case 'Ammo':
                if (is_string($val)) {
                    $result = executePlainSQL("SELECT " . $columns . " FROM " . "Firearm NATURAL JOIN Ammo" . " WHERE " . $attr . $comparator . "'" . $val . "'");
                } else {
                    $result = executePlainSQL("SELECT " . $columns . " FROM " . "Firearm NATURAL JOIN Ammo" . " WHERE " . $attr . $comparator . $val);
                }
                break;
            default: 
                if (is_string($val)) {
                    $result = executePlainSQL("SELECT " . $columns . " FROM " . $table . " WHERE " . $attr . $comparator . "'" . $val . "'");
                } else {
                    $result = executePlainSQL("SELECT " . $columns . " FROM " . $table . " WHERE " . $attr . $comparator . $val);
                }
                break;
        }
        printResult($result);
    }

    function handleJoinAndSelectionRequest() {
        global $db_conn;

        $t1_attr = $_GET['t1_attr'];
        $t1_comparator = $_GET['t1_comparator'];
        $t1_val = $_GET['t1_val'];
        $t2_attr = $_GET['t2_attr'];
        $t2_comparator = $_GET['t2_comparator'];
        $t2_val = $_GET['t2_val'];

        if (is_string($t1_val) && is_string($t2_val)) {
            $result = executePlainSQL("SELECT DISTINCT * FROM Hunter JOIN Firearm ON Hunter.firearmName = Firearm.firearmName WHERE " . "Hunter." . $t1_attr . $t1_comparator . "'" . $t1_val . "'" . " AND " . "Firearm." . $t2_attr . $t2_comparator . "'" . $t2_val . "'");
        } else if (is_string($t1_val)) {
            $result = executePlainSQL("SELECT DISTINCT * FROM Hunter JOIN Firearm ON Hunter.firearmName = Firearm.firearmName WHERE " . "Hunter." . $t1_attr . $t1_comparator . "'" . $t1_val . "'" . " AND " . "Firearm." . $t2_attr . $t2_comparator . $t2_val);
        } else if (is_string($t2_val)) {
            $result = executePlainSQL("SELECT DISTINCT * FROM Hunter JOIN Firearm ON Hunter.firearmName = Firearm.firearmName WHERE " . "Hunter." . $t1_attr . $t1_comparator . $t1_val . " AND " . "Firearm." . $t2_attr . $t2_comparator . "'" . $t2_val . "'");
        } else {
            $result = executePlainSQL("SELECT DISTINCT * FROM Hunter JOIN Firearm ON Hunter.firearmName = Firearm.firearmName WHERE " . "Hunter." . $t1_attr . $t1_comparator . $t1_val . " AND " . "Firearm." . $t2_attr . $t2_comparator . $t2_val);
        }
        printResult($result);
        
    }

    function handleAggregationWithGroupByRequest() {
        global $db_conn;

        $result = executePlainSQL('SELECT traitCost, COUNT(*) FROM Trait GROUP BY traitCost');
        printResult($result);
    }

    function handleAggregationWithHavingRequest() {
        global $db_conn;

        $result = executePlainSQL('SELECT f.firearmName, COUNT(*) FROM Firearm f, Ammo a WHERE f.firearmName = a.firearmName GROUP BY f.firearmName HAVING COUNT(*) > 1');
        printResult($result);
    }

    function handleNestedAggregationWithGroupByRequest() {
        global $db_conn;

        $result = executePlainSQL("SELECT h1.hunterName, h1.hunterLevel FROM Hunter h1 WHERE h1.hunterLevel >= ALL (SELECT AVG(h2.hunterLevel) FROM Hunter h2, Hunts h, Monster m WHERE h2.hunterName = h.hunterName AND m.monsterName = h.monsterName AND m.monsterType = 'Boss' GROUP BY m.monsterName)");
        printResult($result);
    }

    function handleDivisionRequest() {
        global $db_conn;

        $result = executePlainSQL("SELECT hunterName FROM Hunter WHERE NOT EXISTS ((SELECT Tool.toolName FROM Tool WHERE Tool.toolName = 'Knife' OR Tool.toolName = 'Throwing Knives') MINUS (SELECT Wields.toolName FROM Wields WHERE Hunter.hunterName = Wields.hunterName))");
        printResult($result);

        OCICommit($db_conn);
    }

    function handleDropSingleTableRequest() {
        global $db_conn;

        $table = $_POST['table'];
    
        executePlainSQL("drop table " . $table);
        OCICommit($db_conn);
    }

    function handleDropAllTablesRequest() {
        global $db_conn;

        executePlainSQL("drop table FIREARM cascade constraints");
        executePlainSQL("drop table CONSUMABLE cascade constraints ");
        executePlainSQL("drop table SYRINGE cascade constraints");
        executePlainSQL("drop table EXPLOSIVE cascade constraints");
        executePlainSQL("drop table TOOL cascade constraints");
        executePlainSQL("drop table TRAIT cascade constraints");
        executePlainSQL("drop table LOCATION cascade constraints");
        executePlainSQL("drop table AMMO cascade constraints");
        executePlainSQL("drop table SUBMONSTER cascade constraints");
        executePlainSQL("drop table SUBHUNTER cascade constraints");
        executePlainSQL("drop table MONSTER cascade constraints");
        executePlainSQL("drop table HUNTER cascade constraints");
        executePlainSQL("drop table CONSUMES cascade constraints");
        executePlainSQL("drop table WIELDS cascade constraints");
        executePlainSQL("drop table ACQUIRES cascade constraints");
        executePlainSQL("drop table HUNTS cascade constraints");
        executePlainSQL("drop table SPAWNS cascade constraints");
        OCICommit($db_conn);
    }

    function handleResetTablesRequest() {
        global $db_conn;
        // drop old tables
        handleDropAllTablesRequest();

        // intialize initial tables and tuples
        executePlainSQL("CREATE TABLE Firearm(firearmName char(100) PRIMARY KEY, firearmDescription char(2000) NOT NULL, firearmCapacity int NOT NULL, firearmRateOfFire int NOT NULL, firearmHandling int NOT NULL, firearmCost int NOT NULL)");
        executePlainSQL("CREATE TABLE Ammo(firearmName char(100), ammoType char(100), ammoDescription char(2000) NOT NULL, ammoDamage int NOT NULL, ammoEffectiveRange int NOT NULL, ammoVelocity int NOT NULL, ammoCost int DEFAULT 0, PRIMARY KEY(firearmName, ammoType), FOREIGN KEY(firearmName) REFERENCES Firearm(firearmName) ON DELETE CASCADE)");
        executePlainSQL("CREATE TABLE Consumable(consumableName char(100) PRIMARY KEY, consumableDescription char(2000) NOT NULL, consumableCost int NOT NULL)");
        executePlainSQL("CREATE TABLE Syringe(consumableName char(100) PRIMARY KEY, syringeHealing int, syringeEffectDuration int, FOREIGN KEY(consumableName) REFERENCES Consumable(consumableName) ON DELETE CASCADE)");
        executePlainSQL("CREATE TABLE Explosive(consumableName char(100) PRIMARY KEY, explosiveEffectiveRange int NOT NULL, explosiveEffectiveRadius int NOT NULL, explosiveDamage int NOT NULL, FOREIGN KEY(consumableName) REFERENCES Consumable(consumableName) ON DELETE CASCADE)");
        executePlainSQL("CREATE TABLE Tool(toolName char(100) PRIMARY KEY, toolDescription char(2000) NOT NULL, toolMeleeDamage int, toolHeavyMeleeDamage int, toolCost int NOT NULL)");
        executePlainSQL("CREATE TABLE Trait(traitName char(100) PRIMARY KEY, traitDescription char(2000) NOT NULL, traitCost int NOT NULL)");
        executePlainSQL("CREATE TABLE Location(locationName char(100) PRIMARY KEY, locationCoordinates char(100) NOT NULL UNIQUE)");
        executePlainSQL("CREATE TABLE subMonster(monsterType char(100), monsterSize char(100), monsterHealth int NOT NULL, PRIMARY KEY(monsterType, monsterSize))");
        executePlainSQL("CREATE TABLE Monster(monsterName char(100) PRIMARY KEY, monsterDescription char(2000) NOT NULL, monsterType char(100) NOT NULL, monsterSize char(100) NOT NULL, FOREIGN KEY(monsterType, monsterSize) REFERENCES subMonster(monsterType, monsterSize))");
        executePlainSQL("CREATE TABLE subHunter(hunterLevel int, hunterHealth int NOT NULL, PRIMARY KEY(hunterLevel))");
        executePlainSQL("CREATE TABLE Hunter(hunterName char(100) PRIMARY KEY, hunterDescription char(2000) NOT NULL, hunterFunds int DEFAULT 0, hunterLevel int DEFAULT 1, locationName char(100), firearmName char(100), FOREIGN KEY (hunterLevel) REFERENCES subHunter(hunterLevel), FOREIGN KEY (locationName) REFERENCES Location(locationName) ON DELETE SET NULL, FOREIGN KEY (firearmName) REFERENCES Firearm(firearmName) ON DELETE SET NULL)");
        executePlainSQL("CREATE TABLE Consumes(hunterName char(100), consumableName char(100), PRIMARY KEY(hunterName, consumableName), FOREIGN KEY(hunterName) REFERENCES Hunter(hunterName) ON DELETE CASCADE, FOREIGN KEY(consumableName) REFERENCES Consumable(consumableName) ON DELETE CASCADE)");
        executePlainSQL("CREATE TABLE Wields(hunterName char(100), toolName char(100), PRIMARY KEY(hunterName, toolName), FOREIGN KEY(hunterName) REFERENCES Hunter(hunterName) ON DELETE CASCADE, FOREIGN KEY(toolName) REFERENCES Tool(toolName) ON DELETE CASCADE)");
        executePlainSQL("CREATE TABLE Acquires(hunterName char(100), traitName char(100), PRIMARY KEY(hunterName, traitName), FOREIGN KEY(hunterName) REFERENCES Hunter(hunterName) ON DELETE CASCADE, FOREIGN KEY(traitName) REFERENCES Trait(traitName) ON DELETE CASCADE)");
        executePlainSQL("CREATE TABLE Hunts(hunterName char(100), monsterName char(100), PRIMARY KEY(hunterName, monsterName), FOREIGN KEY(hunterName) REFERENCES Hunter(hunterName) ON DELETE CASCADE, FOREIGN KEY(monsterName) REFERENCES Monster(monsterName) ON DELETE CASCADE)");
        executePlainSQL("CREATE TABLE Spawns(locationName char(100), monsterName char(100), PRIMARY KEY(locationName, monsterName), FOREIGN KEY(locationName) REFERENCES Location(locationName) ON DELETE CASCADE, FOREIGN KEY(monsterName) REFERENCES Monster(monsterName) ON DELETE CASCADE)");
        executePlainSQL("INSERT INTO Firearm(firearmName, firearmDescription, firearmCapacity, firearmRateOfFire, firearmHandling, firearmCost) VALUES ('Mosin-Nagant M1891', 'Modern Imperial Russian bolt-action service rifle with an internal magazine, firing powerful long cartridges. When fully emptied, can be reloaded fast with a five-round stripper clip.', 5, 34, 75, 490)");
        executePlainSQL("INSERT INTO Firearm(firearmName, firearmDescription, firearmCapacity, firearmRateOfFire, firearmHandling, firearmCost) VALUES ('Lebel 1886', 'The Lebel 1886, groundbreaking for its time, is a bolt-action rifle with an internal 10-round magazine. Slightly outperformed by more modern designs, it remains a powerful weapon of choice.', 10, 34, 83, 397)");
        executePlainSQL("INSERT INTO Firearm(firearmName, firearmDescription, firearmCapacity, firearmRateOfFire, firearmHandling, firearmCost) VALUES ('Berthier Mle 1892', 'The lighter alternative to the Lebel 1886, the Berthier Mle 1892 is a bolt-action mousqueton that does not lose power for the sake of its convenience.', 3, 36, 79, 356)");
        executePlainSQL("INSERT INTO Firearm(firearmName, firearmDescription, firearmCapacity, firearmRateOfFire, firearmHandling, firearmCost) VALUES ('Sparks LRR', 'Renowned, large-bore, single-shot rifle with good sights. Can put down a bison across a prairie.', 1, 38, 73, 130)");
        executePlainSQL("INSERT INTO Firearm(firearmName, firearmDescription, firearmCapacity, firearmRateOfFire, firearmHandling, firearmCost) VALUES ('Martini-Henry IC1', 'The workhorse rifle of the British Empire, the Martini-Henry Carbine is a single-shot breech-loading rifle that values simplicity and power.', 1, 45, 70, 122)");
        executePlainSQL("INSERT INTO Ammo(firearmName, ammoType, ammoDescription, ammoDamage, ammoEffectiveRange, ammoVelocity) VALUES ('Mosin-Nagant M1891', 'Long', 'Large caliber rifle cartridge with high penetration damage and low damage dropoff. Pierces wooden walls, small trees, thin stone walls and single metal sheets.', 136, 319, 615)");
        executePlainSQL("INSERT INTO Ammo(firearmName, ammoType, ammoDescription, ammoDamage, ammoEffectiveRange, ammoVelocity, ammoCost) VALUES ('Mosin-Nagant M1891', 'Spitzer', 'Spitzer rounds revolutionize rifle ballistics, improving both penetration and muzzle velocity, though adding slightly stronger recoil. They are more stable in flight and can punch clean through multiple targets, but often cause less severe wounds.', 116, 335, 820, 150)");
        executePlainSQL("INSERT INTO Ammo(firearmName, ammoType, ammoDescription, ammoDamage, ammoEffectiveRange, ammoVelocity) VALUES ('Lebel 1886', 'Long', 'Large caliber rifle cartridge with high penetration damage and low damage dropoff. Pierces wooden walls, small trees, thin stone walls and single metal sheets.', 132, 310, 630)");
        executePlainSQL("INSERT INTO Ammo(firearmName, ammoType, ammoDescription, ammoDamage, ammoEffectiveRange, ammoVelocity) VALUES ('Berthier Mle 1892', 'Long', 'Large caliber rifle cartridge with high penetration damage and low damage dropoff. Pierces wooden walls, small trees, thin stone walls and single metal sheets.', 130, 305, 590)");
        executePlainSQL("INSERT INTO Ammo(firearmName, ammoType, ammoDescription, ammoDamage, ammoEffectiveRange, ammoVelocity, ammoCost) VALUES ('Berthier Mle 1892', 'Incendiary', 'This bullet contains a small phosphorous charge that ignites when fired and sets flammable targets alight. A visible tracer can give the shooters position away.', 130, 305, 590, 10)");
        executePlainSQL("INSERT INTO Ammo(firearmName, ammoType, ammoDescription, ammoDamage, ammoEffectiveRange, ammoVelocity, ammoCost) VALUES ('Berthier Mle 1892', 'Spitzer', 'Spitzer rounds revolutionize rifle ballistics, improving both penetration and muzzle velocity, though adding slightly stronger recoil. They are more stable in flight and can punch clean through multiple targets, but often cause less severe wounds.', 111, 318, 780, 75)");
        executePlainSQL("INSERT INTO Ammo(firearmName, ammoType, ammoDescription, ammoDamage, ammoEffectiveRange, ammoVelocity) VALUES ('Sparks LRR', 'Long', 'Large caliber rifle cartridge with high penetration damage and low damage dropoff. Pierces wooden walls, small trees, thin stone walls and single metal sheets.', 149, 347, 533)");
        executePlainSQL("INSERT INTO Ammo(firearmName, ammoType, ammoDescription, ammoDamage, ammoEffectiveRange, ammoVelocity, ammoCost) VALUES ('Sparks LRR', 'Incendiary', 'This bullet contains a small phosphorous charge that ignites when fired and sets flammable targets alight. A visible tracer can give the shooters position away.', 149, 347, 533, 10)");
        executePlainSQL("INSERT INTO Ammo(firearmName, ammoType, ammoDescription, ammoDamage, ammoEffectiveRange, ammoVelocity, ammoCost) VALUES ('Sparks LRR', 'Poison', 'This bullet shatters on impact, releasing a toxic agent fatal in high doses. But the cost is reduced stopping power and penetration.', 149, 347, 533, 30)");
        executePlainSQL("INSERT INTO Ammo(firearmName, ammoType, ammoDescription, ammoDamage, ammoEffectiveRange, ammoVelocity) VALUES ('Martini-Henry IC1', 'Long', 'Large caliber rifle cartridge with high penetration damage and low damage dropoff. Pierces wooden walls, small trees, thin stone walls and single metal sheets.', 143, 334, 400)");
        executePlainSQL("INSERT INTO Consumable(consumableName, consumableDescription, consumableCost) VALUES ('Vitality Shot (Weak)', 'A shot which immediately restores 75 health.', 20)");
        executePlainSQL("INSERT INTO Consumable(consumableName, consumableDescription, consumableCost) VALUES ('Vitality Shot', 'A shot which immediately restores all health.', 85)");
        executePlainSQL("INSERT INTO Consumable(consumableName, consumableDescription, consumableCost) VALUES ('Regeneration Shot', 'A shot that continually restores health over a long duration. However, health regenerates at a reduced rate.', 85)");
        executePlainSQL("INSERT INTO Consumable(consumableName, consumableDescription, consumableCost) VALUES ('Stamina Shot', 'A shot which immediately restores all stamina and stops further depletion for 10 minutes.', 100)");
        executePlainSQL("INSERT INTO Consumable(consumableName, consumableDescription, consumableCost) VALUES ('Antidote Shot', 'Instantly cures and prevents all poison effects. Physical damage associated with poison attacks still applies.', 55)");
        executePlainSQL("INSERT INTO Consumable(consumableName, consumableDescription, consumableCost) VALUES ('Waxed Dynamite Stick', 'A dynamite stick with a modified powder fuse that enables detonation under water.', 24)");
        executePlainSQL("INSERT INTO Consumable(consumableName, consumableDescription, consumableCost) VALUES ('Dynamite Bundle', 'A bundle of several dynamite sticks. Why only bring one?', 75)");
        executePlainSQL("INSERT INTO Consumable(consumableName, consumableDescription, consumableCost) VALUES ('Frag Bomb', 'Frag bombs send lethal shrapnel over a large area, lacerating nearby enemies.', 103)");
        executePlainSQL("INSERT INTO Consumable(consumableName, consumableDescription, consumableCost) VALUES ('Flash Bomb', 'Home made, mercury based, blinding light bomb. Capable of disorienting several targets at once.', 47)");
        executePlainSQL("INSERT INTO Consumable(consumableName, consumableDescription, consumableCost) VALUES ('Sticky Bomb', 'Dynamite charge in a sticky frame that can be attached to objects and enemies. Its eight-second fuse doubles the detonation time of a dynamite stick.', 64)");
        executePlainSQL("INSERT INTO Syringe(consumableName, syringeHealing) VALUES ('Vitality Shot (Weak)', 75)");
        executePlainSQL("INSERT INTO Syringe(consumableName, syringeHealing) VALUES ('Vitality Shot', 150)");
        executePlainSQL("INSERT INTO Syringe(consumableName, syringeEffectDuration) VALUES ('Regeneration Shot', 600)");
        executePlainSQL("INSERT INTO Syringe(consumableName, syringeEffectDuration) VALUES ('Stamina Shot', 600)");
        executePlainSQL("INSERT INTO Syringe(consumableName, syringeEffectDuration) VALUES ('Antidote Shot', 1200)");
        executePlainSQL("INSERT INTO Explosive(consumableName, explosiveDamage, explosiveEffectiveRadius, explosiveEffectiveRange) VALUES ('Waxed Dynamite Stick', 750, 8, 20)");
        executePlainSQL("INSERT INTO Explosive(consumableName, explosiveDamage, explosiveEffectiveRadius, explosiveEffectiveRange) VALUES ('Dynamite Bundle', 1500, 9, 15)");
        executePlainSQL("INSERT INTO Explosive(consumableName, explosiveDamage, explosiveEffectiveRadius, explosiveEffectiveRange) VALUES ('Frag Bomb', 150, 10, 20)");
        executePlainSQL("INSERT INTO Explosive(consumableName, explosiveDamage, explosiveEffectiveRadius, explosiveEffectiveRange) VALUES ('Flash Bomb', 1, 8, 20)");
        executePlainSQL("INSERT INTO Explosive(consumableName, explosiveDamage, explosiveEffectiveRadius, explosiveEffectiveRange) VALUES ('Sticky Bomb', 1000, 8, 15)");
        executePlainSQL("INSERT INTO Tool(toolName, toolDescription, toolMeleeDamage, toolHeavyMeleeDamage, toolCost) VALUES ('Knife', 'An all-purpose tool and melee weapon that has saved many lives - and taken just as many.', 52, 105, 30)");
        executePlainSQL("INSERT INTO Tool(toolName, toolDescription, toolMeleeDamage, toolHeavyMeleeDamage, toolCost) VALUES ('Dusters', 'A row of metal rings worn on the hand in order to increase the damage caused in hand-to-hand combat.', 31, 72, 15)");
        executePlainSQL("INSERT INTO Tool(toolName, toolDescription, toolMeleeDamage, toolHeavyMeleeDamage, toolCost) VALUES ('Knuckle Knife', 'The savage knuckle knife is a roughshod specialization for close quarters combat, suited for both bludgeoning and brutal thrusting deathblows.', 58, 92, 15)");
        executePlainSQL("INSERT INTO Tool(toolName, toolDescription, toolMeleeDamage, toolHeavyMeleeDamage, toolCost) VALUES ('Throwing Axes', 'Silent and deadly short-ranged projectile weapon. Can be retrieved and reused.', 74, 142, 30)");
        executePlainSQL("INSERT INTO Tool(toolName, toolDescription, toolMeleeDamage, toolHeavyMeleeDamage, toolCost) VALUES ('Throwing Knives', 'Silent, but short-ranged projectile weapon. Thrown knives can be retrieved and re-used.', 22, 52, 40)");
        executePlainSQL("INSERT INTO Trait(traitName, traitDescription, traitCost) VALUES ('Adrenaline', 'Instantly start regenerating Stamina while your Health is critically low.', 1)");
        executePlainSQL("INSERT INTO Trait(traitName, traitDescription, traitCost) VALUES ('Ambidextrous', 'Quicker reloading of matched pairs, and custom clip reloads for semi-auto pistol sets.', 3)");
        executePlainSQL("INSERT INTO Trait(traitName, traitDescription, traitCost) VALUES ('Assailant', 'Increases melee damage of throwing knives and throwing axes.', 2)");
        executePlainSQL("INSERT INTO Trait(traitName, traitDescription, traitCost) VALUES ('Beastface', 'Reduced reaction range of animals.', 4)");
        executePlainSQL("INSERT INTO Trait(traitName, traitDescription, traitCost) VALUES ('Blade Seer', 'Bolts, arrows, throwing axes, and throwing knives are highlighted in Dark Sight for better visibility.', 1)");
        executePlainSQL("INSERT INTO Location(locationName, locationCoordinates) VALUES ('Alice Farm', '60, 60')");
        executePlainSQL("INSERT INTO Location(locationName, locationCoordinates) VALUES ('Darrow Livestock', '50, 70')");
        executePlainSQL("INSERT INTO Location(locationName, locationCoordinates) VALUES ('Port Reeker', '60, 80')");
        executePlainSQL("INSERT INTO Location(locationName, locationCoordinates) VALUES ('Scupper Lake', '90, 80')");
        executePlainSQL("INSERT INTO Location(locationName, locationCoordinates) VALUES ('Blanchett Graves', '20, 60')");
        executePlainSQL("INSERT INTO subMonster(monsterType, monsterSize, monsterHealth) VALUES ('Boss', 'Small', 1000)");
        executePlainSQL("INSERT INTO subMonster(monsterType, monsterSize, monsterHealth) VALUES ('Boss', 'Medium', 2000)");
        executePlainSQL("INSERT INTO subMonster(monsterType, monsterSize, monsterHealth) VALUES ('Boss', 'Large', 3000)");
        executePlainSQL("INSERT INTO subMonster(monsterType, monsterSize, monsterHealth) VALUES ('Basic', 'Small', 100)");
        executePlainSQL("INSERT INTO subMonster(monsterType, monsterSize, monsterHealth) VALUES ('Basic', 'Medium', 200)");
        executePlainSQL("INSERT INTO subMonster(monsterType, monsterSize, monsterHealth) VALUES ('Basic', 'Large', 300)");
        executePlainSQL("INSERT INTO Monster(monsterName, monsterDescription, monsterType, monsterSize) VALUES ('Assassin', 'The Assassin is characterized by a fast moving pool of insects that can form into a cloaked humanoid when stationary.', 'Boss', 'Medium')");
        executePlainSQL("INSERT INTO Monster(monsterName, monsterDescription, monsterType, monsterSize) VALUES ('Butcher', 'The Butcher is characterized by a huge bloated body, the head of a pig, and a flaming hook.', 'Boss', 'Medium')");
        executePlainSQL("INSERT INTO Monster(monsterName, monsterDescription, monsterType, monsterSize) VALUES ('Spider', 'The Spider is characterized by a sentient mass of limbs, poisonous in both body and intent.', 'Boss', 'Medium')");
        executePlainSQL("INSERT INTO Monster(monsterName, monsterDescription, monsterType, monsterSize) VALUES ('Scrapbeak', 'Scrapbeak is characterized by a beak-structure fused with the bone of the skull.', 'Boss', 'Medium')");
        executePlainSQL("INSERT INTO Monster(monsterName, monsterDescription, monsterType, monsterSize) VALUES ('Grunt', 'Slow-moving and mostly human creatures that are possibly the victims of a viral infection.', 'Basic', 'Small')");
        executePlainSQL("INSERT INTO Monster(monsterName, monsterDescription, monsterType, monsterSize) VALUES ('Meathead', 'A headless and massive, almost bloated, humanoid monster with leeches for hair.', 'Basic', 'Large')");
        executePlainSQL("INSERT INTO subHunter(hunterLevel, hunterHealth) VALUES (1, 50)");
        executePlainSQL("INSERT INTO subHunter(hunterLevel, hunterHealth) VALUES (2, 55)");
        executePlainSQL("INSERT INTO subHunter(hunterLevel, hunterHealth) VALUES (3, 60)");
        executePlainSQL("INSERT INTO subHunter(hunterLevel, hunterHealth) VALUES (4, 65)");
        executePlainSQL("INSERT INTO subHunter(hunterLevel, hunterHealth) VALUES (5, 70)");
        executePlainSQL("INSERT INTO Hunter(hunterName, hunterDescription, hunterLevel, locationName, firearmName) VALUES ('The Night Acolyte', 'Nadine Orville is a member of the doomsday cult, Night of the Hunter, and founder Isaac Powells right-hand fighter.', 1, 'Alice Farm', 'Mosin-Nagant M1891')");
        executePlainSQL("INSERT INTO Hunter(hunterName, hunterDescription, hunterLevel, locationName, firearmName) VALUES ('Redshirt', 'After having drunk too much whiskey one night, Jonathan Redshirt accepted a bet from his companions: to enter the bayou with a target on his back.', 2, 'Alice Farm', 'Lebel 1886')");
        executePlainSQL("INSERT INTO Hunter(hunterName, hunterDescription, hunterLevel, locationName, firearmName) VALUES ('Carcass Gunrunner', 'A butcher, clandestine arms dealer, and hobby apothecarist, Jason Trevors is a brutal Hunter, and known for being coldly logical and just unhinged enough that his opponents never know what to expect.', 3, 'Darrow Livestock', 'Lebel 1886')");
        executePlainSQL("INSERT INTO Hunter(hunterName, hunterDescription, hunterLevel, locationName, firearmName) VALUES ('The Black Coat', 'William Durant is a Hunter, a scoundrel, and a murderer with a complicated past.', 4, 'Port Reeker', 'Berthier Mle 1892')");
        executePlainSQL("INSERT INTO Hunter(hunterName, hunterDescription, hunterLevel, locationName, firearmName) VALUES ('Sheriff Hardin', 'During the early days of the infection, Sheriff Wayne Hardin was instrumental in halting the rapid spread of the infection.', 5, 'Scupper Lake', 'Sparks LRR')");
        executePlainSQL("INSERT INTO Consumes(hunterName, consumableName) VALUES ('The Night Acolyte', 'Vitality Shot')");
        executePlainSQL("INSERT INTO Consumes(hunterName, consumableName) VALUES ('The Night Acolyte', 'Regeneration Shot')");
        executePlainSQL("INSERT INTO Consumes(hunterName, consumableName) VALUES ('The Night Acolyte', 'Frag Bomb')");
        executePlainSQL("INSERT INTO Consumes(hunterName, consumableName) VALUES ('Redshirt', 'Vitality Shot')");
        executePlainSQL("INSERT INTO Consumes(hunterName, consumableName) VALUES ('Redshirt', 'Flash Bomb')");
        executePlainSQL("INSERT INTO Wields(hunterName, toolName) VALUES ('The Night Acolyte', 'Knife')");
        executePlainSQL("INSERT INTO Wields(hunterName, toolName) VALUES ('The Night Acolyte', 'Throwing Knives')");
        executePlainSQL("INSERT INTO Wields(hunterName, toolName) VALUES ('Redshirt', 'Knuckle Knife')");
        executePlainSQL("INSERT INTO Wields(hunterName, toolName) VALUES ('Carcass Gunrunner', 'Knife')");
        executePlainSQL("INSERT INTO Wields(hunterName, toolName) VALUES ('Carcass Gunrunner', 'Throwing Knives')");
        executePlainSQL("INSERT INTO Acquires(hunterName, traitName) VALUES ('The Night Acolyte', 'Adrenaline')");
        executePlainSQL("INSERT INTO Acquires(hunterName, traitName) VALUES ('The Night Acolyte', 'Beastface')");
        executePlainSQL("INSERT INTO Acquires(hunterName, traitName) VALUES ('Redshirt', 'Beastface')");
        executePlainSQL("INSERT INTO Acquires(hunterName, traitName) VALUES ('Redshirt', 'Blade Seer')");
        executePlainSQL("INSERT INTO Acquires(hunterName, traitName) VALUES ('Carcass Gunrunner', 'Beastface')");
        executePlainSQL("INSERT INTO Hunts(hunterName, monsterName) VALUES ('The Night Acolyte', 'Assassin')");
        executePlainSQL("INSERT INTO Hunts(hunterName, monsterName) VALUES ('Redshirt', 'Butcher')");
        executePlainSQL("INSERT INTO Hunts(hunterName, monsterName) VALUES ('Carcass Gunrunner', 'Spider')");
        executePlainSQL("INSERT INTO Hunts(hunterName, monsterName) VALUES ('The Black Coat', 'Spider')");
        executePlainSQL("INSERT INTO Hunts(hunterName, monsterName) VALUES ('Sheriff Hardin', 'Assassin')");
        executePlainSQL("INSERT INTO Spawns(locationName, monsterName) VALUES ('Alice Farm', 'Grunt')");
        executePlainSQL("INSERT INTO Spawns(locationName, monsterName) VALUES ('Darrow Livestock', 'Grunt')");
        executePlainSQL("INSERT INTO Spawns(locationName, monsterName) VALUES ('Port Reeker', 'Grunt')");
        executePlainSQL("INSERT INTO Spawns(locationName, monsterName) VALUES ('Scupper Lake', 'Grunt')");
        executePlainSQL("INSERT INTO Spawns(locationName, monsterName) VALUES ('Blanchett Graves', 'Grunt')");
        OCICommit($db_conn);
    }
?>