<?php

class Opens
{
    public function updateOpenInformation(
        $dbh,
        $club,
        $competitionId,
        $courseId,
        $date,
        $openName,
        $slotsAvailable,
        $token = false,
    ) {
        $sql = "
        SELECT *
        FROM opens
        WHERE clubid = '{$club}'
        AND courseid = '{$courseId}'
        AND date = '{$date}'
        ";

        $result = $dbh->query($sql);

        if ($result->num_rows == 0) {
            $openName = str_replace("'", "", $openName);

            $sql = "
            INSERT INTO opens(clubid, courseid, openid, name, date, availability, slots, token)
            VALUES
            ('{$club}', '{$courseId}', '{$competitionId}', '{$openName}', '{$date}', '{$slotsAvailable}', '1', '$token')
            ";

            $dbh->query($sql);
        } else {
            $updatedDate = date("Y-m-d H:i:s");

            $sql = "
            UPDATE opens
            SET availability = '{$slotsAvailable}',
            openid = '{$competitionId}',
            slots = '2',
            lastupdate = '$updatedDate'
            WHERE clubid = '{$club}'
            AND courseid = '{$courseId}'
            AND date = '{$date}'
            ";

            $dbh->query($sql);
        }
    }

    public function getAllOpens($dbh)
    {
        $sql = "
        SELECT *, 
        opens.name as 'compName'
        FROM opens, clubs
        WHERE opens.date >= NOW()
        AND opens.clubid = clubs.id
       -- AND region=  'highlands'
        ";

        $result = $dbh->query($sql);

        $tmp = [];
        $count = 0;

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $backgroundColor = "orange";

                if ($row["availability"] == "Yes") {
                    $backgroundColor = "green";
                }

                $openBookingLink = "";

                if ($row["openBookingSystem"] == "intelligent") {
                    $openBookingLink = "{$row["baseUrl"]}/competition2.php?tab=details&compid={$row["openid"]}";
                } elseif ($row["openBookingSystem"] == "brs") {
                    $openBookingLink =
                        str_replace(
                            "course/1",
                            "open-competitions",
                            $row["openBookingLink"],
                        ) . "/{$row["openid"]}/teesheet";
                } elseif ($row["openBookingSystem"] == "clubv1") {
                    $openBookingLink = "https://howdidido-whs.clubv1.com/hdidbooking/open?token={$row["token"]}&cid={$row["openid"]}&rd=1";
                }

                $tmp[$count] = [
                    "date" => $row["date"],
                    "title" => $row["name"] . " - " . $row["compName"],
                    "availability" => $row["availability"],
                    "backgroundColor" => $backgroundColor,
                    "url" => $openBookingLink,
                ];

                $count++;
            }
        }

        return $tmp;
    }
}
