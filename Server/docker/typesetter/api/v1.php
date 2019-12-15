<?php

@ini_set("display_errors", 1);
error_reporting(E_ALL);

require "Medoo.php";
use Medoo\Medoo;



function get_params() {
    reset($_GET);
    $parts = explode("/", key($_GET));
    if(sizeof($parts) == 0 || strlen($parts[0]) == 0)
        exit;
    return $parts;
}

function post_json() {
    return json_decode(file_get_contents("php://input"), true);
}

function open_database() {
    return new Medoo([
        "database_type" => "sqlite",
        "database_file" => __DIR__ . "/db/T-Race.sqlite",
        "option" => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ]
    ]);
}



$params = get_params();
$database = open_database();
$method = $_SERVER["REQUEST_METHOD"];
header("Content-Type: application/json");
$config = json_decode(file_get_contents(__DIR__ . "/config.json"), true);



// vouchers/generate/{S_ID}/{n}
if(sizeof($params) == 4 && $params[0] == "vouchers" && $params[1] == "generate") {
    $player_id = intval($params[2]);
    $player_start_time = $database->select("Spieler", "Spielstart", ["S_ID" => $player_id])[0];
    $num_vouchers = intval($params[3]);

    if($num_vouchers <= 0 || $num_vouchers > $config["vouchers"]["maxGenerate"]) {
        echo json_encode(["success" => false, "message" => "parameter-out-of-bounds"]);
    }
    else {
        $vouchers = array();
        for ($i = 0; $i < $num_vouchers; $i++) {
            $laden = $database->select("Laden", ["L_ID", "Name"], Medoo::raw("ORDER BY RANDOM() LIMIT 1"))[0];
            $rabatt = $database->select("Rabatt", ["R_ID", "Text"], Medoo::raw("ORDER BY RANDOM() LIMIT 1"))[0];
            
            $database->insert("Gutscheine", [
                "Ausstellungszeitpunkt" => time() - $player_start_time,
                "RID" => $rabatt["R_ID"],
                "SID" => $player_id,
                "LID" => $laden["L_ID"]
            ]);

            $vouchers[] = [
                "GutscheinID" => $database->id(),
                "Laden" => $laden,
                "Rabatt" => $rabatt
            ];
        }
        echo json_encode($vouchers);
    }
}



// vouchers/redemption/{G_ID}
// GET = retrieve Aktivierungszeitpunkt, POST = set Aktivierungszeitpunkt to current time
if(sizeof($params) == 3 && $params[0] == "vouchers" && $params[1] == "redemption") {
    $voucher_id = $params[2];

    if($method == "GET") {
        $redemption = $database->select("Gutscheine", "Aktivierungszeitpunkt", ["G_ID" => $voucher_id]);
        echo json_encode($redemption);
    }
    else if($method == "POST") {
        $player_id = $database->select("Gutscheine", "SID", ["G_ID" => $voucher_id])[0];
        $player_start_time = $database->select("Spieler", "Spielstart", ["S_ID" => $player_id])[0];
        $database->update("Gutscheine", ["Aktivierungszeitpunkt" => time() - $player_start_time], ["G_ID" => $voucher_id]);
        echo json_encode(["success" => true]);
    }
}

// Hau-den-Dino minigame score:
// player/{player_name}/hdd/score/{score_val}
if(sizeof($params) == 5 && $params[0] == "player" && $params[2] == "hdd" && $params[3] == "score") {
    $credits = (int)$database->select("Spieler", "Guthaben", ["Spielername" => $params[1]])[0];
    
    // The player gets 0.5 credits for every score-point (rounded down).
    $database->update("Spieler", ["Guthaben[+]" => (int)($params[4]/2), "HDD_Score[+]" => (int)$params[4], "Fitness[+]" => (int)($params[4]/2)], ["Spielername" => $params[1]]);
    echo json_encode(["success" => true]);
}

// Heisser-Dino minigame score:
// player/{player_name}/hd/score/{score_val}/hits/{hits_val}
if(sizeof($params) == 7 && $params[0] == "player" && $params[2] == "hd" && $params[3] == "score" && $params[5] == "hits") {
    $credits = (int)$database->select("Spieler", "Guthaben", ["Spielername" => $params[1]])[0];
    // Max the player can lose is 5 points.
    $guthaben = 20 - (int)($params[4]/2) - $params[6];
    //($guthaben<0)?$guthaben=0;
    // Der Spieler bekommt 20-Hälfte der Spielzeit-Drahtberührungen, anschließend halbiert und abgerundet.
    $database->update("Spieler", ["Guthaben[+]" => max(-5, (int)($guthaben/2)), "HD_Score[+]" => (int)$params[4]], ["Spielername" => $params[1]]);
    echo json_encode(["success" => true]);
}


// Get id corresponding to name:
// player/{name}/getID
if(sizeof($params) == 3 && $params[0] == "player" && $params[2] == "getID") {
    $ids = $database->select("Spieler", "S_ID", ["Spielername" => $params[1]]);
    //NOTE(Alex): We do not want to pass this as JSON. This is intentional.
    echo empty($ids) ? -1 : (int)$ids[0];
}

// players/{S_ID}, players/{S_ID}/start_game, players/{S_ID}/webshop, players/{S_ID}/result, players/{SID}/buy/{AID}
else if(sizeof($params) >= 2 && $method == "GET" && $params[0] == "players") {
    $res = ["success" => true];

    if(sizeof($params) == 2) {
        $playerState = $database->select("Spieler", ["Fitness", "Essen"], ["S_ID" => $params[1]])[0];
        if(($playerState["Fitness"] -= 0.5) < 0) $playerState["Fitness"] = 0;
        if(($playerState["Essen"] -= 1) < 0) $playerState["Essen"] = 0;
        $database->update("Spieler", $playerState, ["S_ID" => $params[1]]);


        $player_info = $database->select("Spieler", ["Vorname", "Name", "Spielername", "Guthaben", "Fitness", "Essen", "AnzahlGutscheine"], ["S_ID" => $params[1]]);
        if(sizeof($player_info) != 1)
            $res = ["success" => false, "message" => "unknown-player-id"];
        else
            $res = $player_info[0];
    }
    else if(sizeof($params) == 3 && $params[2] == "start_game") {
        // NOTE: do not set Spielstart here, but on login already
        //$database->update("Spieler", ["Spielstart" => time()], ["S_ID" => $params[1]]);
    }
    else if(sizeof($params) == 3 && $params[2] == "expiry_penalty") {
        $curr = round(floatval($database->select("Spieler", "Guthaben", ["S_ID" => $params[1]])[0]) * (1.0 - $config["vouchers"]["expiryPenalty"]));
        $database->update("Spieler", ["Guthaben" => $curr, "AnzahlGutscheine[-]" => 1], ["S_ID" => $params[1]]);
    }
    
    else if(sizeof($params) == 3 && $params[2] == "webshop") {
        $credits = (int)$database->select("Spieler", "Guthaben", ["S_ID" => $params[1]])[0];
        //hard-coded articles atm, bad :\
        $webshopArticles = array();
        
        $dinobildActive =($credits>(int)$database->select("Artikel", "Preis", ["A_ID" => 24])[0]);
        $dinosongActive =($credits>(int)$database->select("Artikel", "Preis", ["A_ID" => 25])[0]);

        $webshopArticles[] = [
            "Name" => "dinobild",
            "aktiv" => $dinobildActive,
            "Preis" => 10
        ];
        
        $webshopArticles[] = [
            "Name" => "dinosong",
            "aktiv" => $dinosongActive,
            "Preis" => 5
        ];
        $res = $webshopArticles;
    }
    
    else if(sizeof($params) == 3 && $params[2] == "result") {

        $fitnessValue = (float)$database->select("Spieler", "Fitness", ["S_ID" => $params[1]])[0];
        if($fitnessValue < 50) {
            $fitnessChangeTrendStr = "gesunken";
            $fitnessChange = round(100.0 - 2 * $fitnessValue, 2);
        } else if($fitnessValue >= 50) {
            $fitnessChangeTrendStr = "gestiegen";
            $fitnessChange = round(2 * $fitnessValue - 100.0, 2);
        }
        
        $numSpendedTraceys = (int)$database->query(
            "SELECT SUM(Artikel.Preis) 
            FROM Artikel, GekaufteArtikel 
            WHERE 
                GekaufteArtikel.SID = ".$params[1]." AND 
                GekaufteArtikel.AID = Artikel.A_ID"
            )->fetchAll()[0][0];

        $gameStartTime = (int)$database->select("Spieler", "Spielstart", ["S_ID" => $params[1]])[0];
        
        $firstTimePurchase = (int)$database->min("GekaufteArtikel", "Kaufzeitpunkt", ["SID" => $params[1]]);

        $mostExpPurchase = $database->query(
            "SELECT Artikel.Bezeichnung
            FROM Artikel, GekaufteArtikel 
            WHERE 
                GekaufteArtikel.SID = ".$params[1]." AND 
                GekaufteArtikel.AID = Artikel.A_ID 
            ORDER BY Artikel.Preis DESC"
            )->fetchAll();
        $mostExpPurchase = sizeof($mostExpPurchase) == 0 ? null : $mostExpPurchase[0][0];

        //NOTE(alex): This query is really ugly because we cant do MAX(COUNT(*))
        $mostUsedVoucher = $database->query(
                "SELECT Rabatt.Text
                FROM Rabatt, 
                    (
                        SELECT RID, MAX(y.num)
                        FROM (
                            SELECT COUNT(*) as num, RID 
                            FROM Gutscheine 
                            WHERE 
                                SID = ".$params[1]." AND 
                                Aktivierungszeitpunkt != 0
                            GROUP BY RID
                            ORDER BY COUNT(*) DESC
                        )y
                    ) rid_max
                WHERE Rabatt.R_ID = rid_max.RID"
                )->fetchAll();
        $mostUsedVoucher = sizeof($mostUsedVoucher) == 0 ? null : $mostUsedVoucher[0][0];

        $numRedeemedVouchers = $database->count("Gutscheine", 
                    ["SID" => $params[1], "Aktivierungszeitpunkt[!]" => 0]);

        $numTotalVouchers = $database->count("Gutscheine", ["SID" => $params[1]]);

        $guthabenScore = 0;
        $fitnessScore = 0;
        $essenScore = 0;
        
        $player_info = $database->select("Spieler", ["Vorname", "Name", "Spielername", "Guthaben", "Fitness", "Essen", "Alter"], ["S_ID" => $params[1]])[0];
        
        if ($player_info["Fitness"]>=25) $fitnessScore = 1;
        if ($player_info["Essen"]>=40) $essenScore = 1;
        if ($player_info["Guthaben"]>=50) $guthabenScore = 1;
        
        $dinoID = $fitnessScore*4 + $essenScore*2 + $guthabenScore;
        
        $mostPurchasedArticles = $database->query("select count(*) as Anzahl, aid from GekaufteArtikel where sid =" . $params[1] . " group by aid order by Anzahl desc limit 3")->fetchAll();
        $mostPurchasedArticles = sizeof($mostPurchasedArticles) == 0 ? null : $mostPurchasedArticles;
        
        $grade = "";
        if($player_info["Alter"] < 10) $grade = "K";
        else if($player_info["Alter"] == 10 || $player_info["Alter"] == 11) $grade = "5-6";
        else if($player_info["Alter"] == 12 || $player_info["Alter"] == 13) $grade = "7-8";
        else if($player_info["Alter"] == 14 || $player_info["Alter"] == 15) $grade = "9-10";
        else if($player_info["Alter"] == 16 || $player_info["Alter"] == 17) $grade = "11";
        else $grade = "Lehrer";
        
        $ageGroupComparisons = null;
        if($grade != "K" && $mostPurchasedArticles != null) {
            $ageGroupComparisons = [];
            foreach($mostPurchasedArticles as $article) {
                $numLikemindedParticipants = $database->query("select \"" . $grade . "\" from UmfrageArtikel where aid =" . $article[0])->fetchAll();
                if(sizeof($numLikemindedParticipants) == 0)
                    $numLikemindedParticipants = 0;

                $numTotalParticipants = $database->query("select sum(\"" . $grade . "\") from UmfrageArtikel WHERE AID in (1,2,3,4,5,6)")->fetchAll()[0][0];
                $likemindedPercentage = round((float)$numLikemindedParticipants / (float)$numTotalParticipants * 100.0, 1);
                
                $articleName = $database->select("Artikel", "Bezeichnung", ["A_ID" => $article[0]])[0];
                $ageGroupComparisons[] = ["Anteil" => $likemindedPercentage, "Name" => $articleName];
            }
        }
        
        $shopVisitsRaw = $database->query("SELECT Laden.Name, COUNT( distinct GekaufteArtikel.Kaufzeitpunkt) FROM Laden, Artikel, Spieler, GekaufteArtikel WHERE GekaufteArtikel.SID = 1 AND Artikel.A_ID = GekaufteArtikel.AID AND Artikel.LID = Laden.L_ID GROUP BY Laden.L_ID")->fetchAll();
        $shopVisits = [];
        foreach($shopVisitsRaw as $val)
            $shopVisits[] = [ "name" => $val[0], "visits" => $val[1] ];
        
        $buyTimestamps = $database->select("GekaufteArtikel", "Kaufzeitpunkt", ["SID" => $params[1]]);
        $buyTimestamps = array_map('intval', $buyTimestamps);
        sort($buyTimestamps);

        $redeemTimestamps = $database->select("Gutscheine", "Aktivierungszeitpunkt", ["SID" => $params[1]]);
        $redeemTimestamps = array_map('intval', $redeemTimestamps);
        sort($redeemTimestamps);

        $totalPlayTime = sizeof($buyTimestamps) == 0 ? -1 : max($buyTimestamps);
        $totalPlayTime = sizeof($redeemTimestamps) == 0 ? $totalPlayTime : max($totalPlayTime, max($redeemTimestamps));
        if($totalPlayTime == -1)
            $totalPlayTime = 100;

        $res = [
            "fitnessChangeTrendStr" => $fitnessChangeTrendStr,
            "fitnessChange" => $fitnessChange,
            "numSpendedTraceys" => $numSpendedTraceys,
            "timeFirstPurchase" => $firstTimePurchase,
            "mostExpensivePurchase" => $mostExpPurchase,
            "mostUsedVoucher" => $mostUsedVoucher,
            "numRedeemedVouchers" => $numRedeemedVouchers,
            "numTotalVouchers" => $numTotalVouchers,
            "classifications" => [
                "Guthaben" => ($guthabenScore==0)?"wenig":"viel",
                "Fitness" => ($fitnessScore==0)?"wenig":"viel",
                "Essen" => ($essenScore==0)?"wenig":"viel",
                "dinosaurName" => $database->select("Dinos", "Name", ["D_ID" => $dinoID]),
                "dinosaurProps" => $database->select("Dinos", "Eigenschaften", ["D_ID" => $dinoID])
            ],
            "totalPlayTime" => $totalPlayTime,
            "buyTimestamps" => $buyTimestamps,
            "redeemTimestamps" => $redeemTimestamps,
            "shopVisits" => $shopVisits,
            "ageGroupComparisons" => $ageGroupComparisons
        ];
    }
        
    
    
    else if(sizeof($params) == 4 && $params[2] == "buy") {
        //Buying something and potentially redeeming a voucher
        
        
        $credits = $database->select("Spieler", "Guthaben", ["S_ID" => $params[1]]);
        $price = $database->select("Artikel", "Preis", ["A_ID" => $params[3]]);

        if(empty($credits) || empty($price)) {
            //Player not found
            $res = ["success" => false];
        }else {
            $credits = $credits[0];
            $price = $price[0];
            
            if($credits >= $price) {
                
                $shop_id = (int)$database->select("Artikel", "LID", ["A_ID" => $params[3]])[0];
                $vouchers = $database->select("Gutscheine", 
                            ["G_ID", "Aktivierungszeitpunkt", "RID"], 
                            ["AND" => [
                                "LID" => $shop_id, 
                                "SID" => $params[1], 
                                "Aktivierungszeitpunkt[>]" => 0
                                ], 
                             "ORDER" => ["Aktivierungszeitpunkt" => "ASC"]
                            ]);
                
                $discount_amount = 0;
                if(sizeof($vouchers) > 0) {
                    // We now want to find the oldest voucher which has not been used yet.
                    // Since we dont have a 'used' flag anywhere we need to check through all vouchers
                    // to see for which the player already bought an item.
                    
                    // All articles bought after the first vouchers activation time.
                    $articles = $database->select("GekaufteArtikel", 
                                ["[><]Artikel" => ["AID" => "A_ID"]], 
                                [ 
                                 "GekaufteArtikel.Kaufzeitpunkt", 
                                 "GekaufteArtikel.SID"
                                ], 
                                ["AND" => [
                                    "Artikel.LID" => $shop_id, 
                                    "GekaufteArtikel.Kaufzeitpunkt[>=]" => (int)$vouchers[0]["Aktivierungszeitpunkt"]
                                    ], 
                                 "ORDER" => ["GekaufteArtikel.Kaufzeitpunkt" => "ASC"]
                                ]);
                            
                    $voucher_index = 0;
                    $article_index = 0;
                    while($voucher_index < sizeof($vouchers) && $discount_amount == 0) {
                        //TODO(Alex): Remove hardcoded voucher IDs. Make the whole thing flexible.
                        $discount_type = $vouchers[$voucher_index]["RID"];
                        if($discount_type == 1){
                            //Buy 2 get 3
    
                            //FIXME(Alex): Edgecase missing:
                            //  If a second "Kauf 2, nimm 3" vouchers gets actived before the
                            //  first one is redeemed we land in a scenario where with the current
                            //  implementation we would mark both vouchers as completed after the
                            //  first one is redeemed 
                            
                            $item_count = 0;
                            for($i = $article_index; $i < sizeof($articles); $i++) {
                                if($articles[$i]["SID"] == $params[1] && 
                                   $articles[$i]["Kaufzeitpunkt"] >= $vouchers[$voucher_index]["Aktivierungszeitpunkt"]) {
                                    $item_count++;
                                }
                            }
                        
                            if($item_count == 2) {
                                $discount_amount = $price;
                            }
                            // NOTE(Alex): Do not advance the article_index here because it is possible
                            //             to have a "Kauf 2, nimm 3" coupon that does not get redeemed yet but
                            //             have a "Spar x" coupon with a later activation time that does get redeemed.
                            
                        }else if($discount_type == 2 || $discount_type == 3 || $discount_type == 4) {
                            //Save 1, 2, or 3 on purchase
                            while($article_index < sizeof($articles) && $vouchers[$voucher_index]["Aktivierungszeitpunkt"] > $articles[$article_index]["Kaufzeitpunkt"]) {
                                // This article has been bought before the voucher was activated.
                                $article_index++;
                            }
                            if($article_index == sizeof($articles)) {
                                // If we got here the current voucher has not been used yet.
                                $discount_amount = $discount_type - 1;
                            }
                            $article_index++;
                        }
                        $voucher_index++;
                    }
                }
                
                if($discount_amount != 0){
                    array_push($res, ["used voucher" => $vouchers[$voucher_index-1]["G_ID"], "saved" => $discount_amount]);
                }else {
                    array_push($res, ["used voucher" => "none", "saved" => 0]);
                }
                
				$artikelEssen = $database->select("Artikel", "Essen", ["A_ID" => $params[3]]);
				$artikelFitness = $database->select("Artikel", "Fitness", ["A_ID" => $params[3]]);
				
                $database->update("Spieler", ["Guthaben[-]" => ($price - $discount_amount),
				"Fitness[+]" => $artikelFitness[0], "Essen[+]" => $artikelEssen[0]], ["S_ID" => $params[1]]);
				
                $player_start_time = $database->select("Spieler", "Spielstart", ["S_ID" => $params[1]])[0];
                $database->insert("GekaufteArtikel", 
                        [
                            "SID" => $params[1], 
                            "AID" => $params[3], 
                            "Kaufzeitpunkt" => time() - $player_start_time
                        ]);
            } else {
                // Not enough money
                $res = ["success" => false];
            }
        }
        
    }
    else {
        // unknown method
        $res = ["success" => false];
    }
    echo json_encode($res);
}



// players/register and players/login (POST data needed)
if(sizeof($params) == 2 && $method == "POST" && $params[0] == "players") {
    $player = post_json();
    $resp = ["success" => true];

    if($params[1] == "register") {
        $players_same_nickname = $database->select("Spieler", "S_ID", ["Spielername" => $player["Spielername"]]);
        if(sizeof($players_same_nickname) > 0)
            $resp = ["success" => false, "message" => "nickname-already-exists"];
        else
            $database->insert("Spieler", $player);
    }
    else if($params[1] == "login") {
        $player_db = $database->select("Spieler", ["S_ID", "PIN"], ["Spielername" => $player["Spielername"]]);
        if(sizeof($player_db) == 0)
            $resp = ["success" => false, "message" => "unknown-nickname"];
        else if($player_db[0]["PIN"] != $player["PIN"])
            $resp = ["success" => false, "message" => "invalid-pin"];
        else {
            // on login, also set the player's Spielstart
            $database->update("Spieler", ["Spielstart" => time()], ["S_ID" => $player_db[0]["S_ID"]]);
            $resp["playerId"] = $player_db[0]["S_ID"];
        }
    }

    echo json_encode($resp);
}
