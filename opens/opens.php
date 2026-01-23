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
            $sql = "
            INSERT INTO opens(clubid, courseid, openid, name, date, availability, slots)
            VALUES
            ('{$club}', '{$courseId}', '{$competitionId}', '{$openName}', '{$date}', '{$slotsAvailable}', '1')
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
}
