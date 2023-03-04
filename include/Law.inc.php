<?php
/*
-----------------------------------------------------------
    Class Law ใช้ในการเก็บการ Mapping Data
        - showData -> ใช้ในการเอาข้อมูล 2 ตาราง (ข่าว, กฏหมาย)
          มา Mapping Keyword แล้วนำไปแสดง
        - Summery -> ใช้ในการสรุปข้อมูลข่าวตามกลุ่มมาตรากฎหมาย
-----------------------------------------------------------
*/
date_default_timezone_set('Asia/Bangkok');
require_once 'Database/DatabaseConnect.inc.php';

class Law{
    use Database\DatabaseConnect;

    function showData($dt,$dt2){
        $filter = '';
        if (isset($dt) && isset($dt2)){
            $filter = "AND d.update_dt >= '$dt' AND d.update_dt <= '$dt2'";
        }else{
            $filter = '';
        }

        $sql = "
            SELECT
                d.data_id as id,
                d.`subject` as `Subject`,
                d.details AS Detail,
                d.update_dt AS Datetimes,
                d.province_location AS Location,
                l.law_id AS law_id,
                l.law AS Law,
                l.keyword as keyword,
                CASE
                    WHEN LENGTH(d.`subject`) - LENGTH(REPLACE(l.`keyword`, l.keyword, '')) + 1  < 10 THEN '~10%'
                    WHEN LENGTH(d.`subject`) - LENGTH(REPLACE(l.`keyword`, l.keyword, '')) + 1  < 90 THEN '~70%'
                    WHEN LENGTH(d.`subject`) - LENGTH(REPLACE(l.`keyword`, l.keyword, '')) + 1 < 99 THEN '80~%'
                    WHEN LENGTH(d.`subject`) - LENGTH(REPLACE(l.`keyword`, l.keyword, '')) + 1 < 190 THEN '90~%'
                    WHEN LENGTH(d.`subject`) - LENGTH(REPLACE(l.`keyword`, l.keyword, '')) + 1 >= 190 THEN '100%'
                ELSE 'Matching Failure'
            END AS matching
            FROM
                tbl_data d
                JOIN tbl_law l
            WHERE
                d.`subject`
                RLIKE (
                    SELECT
                        DISTINCT GROUP_CONCAT(keyword SEPARATOR '|')
                    FROM
                        tbl_law
                    WHERE
                        law = l.law
                ) {$filter}
            GROUP BY
                d.`subject`
        ";
        //กรณีเอามาหลายมาตรา
        // l.law,
        // l.keyword
        $query = $this->Connect()->query($sql);
        if ($query->num_rows > 0){
            return $query;
        }
    }
    function lawReport($search){
        $sql = "
            SELECT
                *,
                CONCAT(details,' ',keyword, ' ','synonyms') as search
            FROM
                tbl_law
            WHERE
                CONCAT(details,' ',keyword, ' ','synonyms') LIKE '%{$search}%'
            ORDER BY
                `group` ASC
        ";
        $query = $this->Connect()->query($sql);
        if ($query->num_rows > 0){
            return $query;
        }
    }
    function Summery(){
        $sql = "
                SELECT
                    COUNT(*) as total,
                    l.group as `Group`
                FROM
                    tbl_data d
                JOIN tbl_law l
                WHERE
                    d.`subject` RLIKE (
                        SELECT
                            DISTINCT GROUP_CONCAT(keyword SEPARATOR '|')
                        FROM
                            tbl_law
                        WHERE
                            law = l.law
                    )
                GROUP BY
                    l.group
        ";
        $query = $this->Connect()->query($sql);
        if ($query->num_rows > 0){
            return $query;
        }
    }
    function barChart(){
        $sql = "
            SELECT
                COUNT(*) as total,
                l.group as `strgroup`
            FROM
                tbl_data d
                JOIN tbl_law l
            WHERE
            d.`subject` RLIKE (
                SELECT
                    DISTINCT GROUP_CONCAT(keyword SEPARATOR '|')
                FROM
                    tbl_law
                WHERE
                    law = l.law
            )
            GROUP BY
                l.group
            ORDER BY total DESC
        ";
        $query = $this->Connect()->query($sql);
        if ($query->num_rows > 0){
            return $query;
        }
    }
    function __destruct(){
      $this->Connect()->close();
    }
}
