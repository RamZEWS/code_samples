<?php
AddEventHandler("main", "OnBeforeUserUpdate", Array("SiteEvent", "OnBeforeUserUpdateHandler"));

class SiteEvent {
    function OnBeforeUserUpdateHandler(&$arFields) {
        if (isset($arFields["ID"])) {
            $usr = CUserTable::Get(["ID" => $arFields["ID"]]);
            if ($usr) {
                $curActive = $usr["ACTIVE"];
                if (isset($arFields["ACTIVE"]) && $arFields["ACTIVE"] === "Y" && $curActive === "N") {
                    CEvent::SendImmediate("USER_IS_ACTIVE", 's1', [
                        "EMAIL" => $arFields["EMAIL"],
                        "USER_NAME" => $arFields["NAME"]
                    ]);
                }

                return true;
            }
        }

        return false;
    }
}

