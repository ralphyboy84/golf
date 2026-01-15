<?php

// $url = "https://visitors.brsgolf.com/api/casualBooking/teesheet?date=2026-06-12&course_id=1";
// $url = "https://booking.royaldornoch.com/customerbooking.aspx";
// $url = "https://booking.carnoustie.com/api/v1/courses/1/diary?start_date=2026-09-21&slot_type=1&filter_today=1";

// $headers = array(
//          "x-api-key: b9eae61d-71a7-4b47-98bf-50b3823695b1",
//      );

// $ch = curl_init($url);
// // curl_setopt($ch, CURLOPT_REFERER, "https://visitors.brsgolf.com/lanark");
// curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
// curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36");
// // curl_setopt($ch, CURLOPT_COOKIE, '_ga=GA1.2.886825545.1746191124; __stripe_mid=3c60656d-418d-4367-9a38-c2f12c87bf44397b33; __utma=236013394.886825545.1746191124.1757443916.1757443916.1; __utmz=236013394.1757443916.1.1.utmcsr=(direct)|utmccn=(direct)|utmcmd=(none); _ga_J37ZM2PHBX=GS2.2.s1757443897$o1$g1$t1757444049$j48$l0$h0; _gid=GA1.2.1146807633.1767973616; cf_clearance=.PyR6ggbi88vW5yLoVjTrX7z.V4ZICaIK_MgQa274zM-1767973390-1.2.1.1-HW72JjRw057N7oll0Q7KeUygJamgiiaaTx7jv0.wVkKdwslenKUnS4i0TYUX4iGhw5fkIRJ9s2jtWGF2ZLiqQq4hLqnIjv2F5C93YeqOpPS4dktxyzd3WiWjaZ94NAbVCjA7SNbLZThpyAK4P6oGVOVcr6eid0abytx7lvXAUgEmzLpOYLS5dGMmxq5KuBWpfvqpWJjX2tPFgHI1l3gvxMXEKPumlBT5vRhtQSacUwA; _ga_28698NS42K=GS2.2.s1767973616$o3$g1$t1767973693$j60$l0$h0; INGRESSCOOKIE=1767973530.678.31.4097|dc55b8a9505905b3dde316afe2cbf6a5; BRSVisitors.Session=CfDJ8AK%2BymixmQdFu0edZp9SPdGuUqm2OI3xQ0JYcyYuIjYm1E9VWgoSajcqIPZMHeoig4mnC9E761%2F4NcPD%2F2f%2Bw2Sn2twhp8ntWBcou0i3DOsqi3UiTxmigZA%2FaG60VzM6d%2FeuHzOjI7nHXK1%2FX8bvB0uqntrDnPGBTegKwfhtRs8Q; .AspNetCore.Antiforgery.-pRt6Pu6weQ=CfDJ8AK-ymixmQdFu0edZp9SPdGa3XBgdJHWltWJLVKIUYKBmAeWhxKm2ot_theszC77x3AnhFouKuXL7D0lmALpHCUTMArw9JMyGXfsqQpf4PvCUj76sMD1O1iyokMmmhKx4IC2a0ZS9A_lV2HZtaNSWzA; __stripe_sid=e815b040-2d87-4968-a808-7fffb254b787e86c8a; _gat=1; _gat_UA-62425613-14=1; XSRF-TOKEN=CfDJ8AK-ymixmQdFu0edZp9SPdGsWZPHh35fekNpbmIlcnODctIRIDFvD6LQE_CTFDihTQfo4Xy2ll5B_rrbSCehJ-zAuFqusH8442dRJOQexEibxL_KP3vEb6TiRsWYCI9NrGs8axfF4RsmspSzV0vqKtk');
// // curl_setopt($ch, CURLOPT_POSTFIELDS, 'ctl00$MainPlaceHolder$DateText=Thursday, 02 July 2026');
// $server_output = curl_exec($ch);

// var_dump($server_output);
// echo $server_output;
// echo "<pre>";
// $ch = curl_init();

// curl_setopt_array($ch, [
//     CURLOPT_RETURNTRANSFER => true,
//     CURLOPT_HTTPHEADER => [
//         "Origin: https://visitors.brsgolf.com",
//         "Referer: https://visitors.brsgolf.com/lanark",
//     ],
//     CURLOPT_USERAGENT => "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36",
//     // CURLOPT_VERBOSE => true
// ]);
// curl_setopt($ch, CURLOPT_HEADER, true);
// curl_setopt(
//     $ch,
//     CURLOPT_URL,
//     "https://visitors.brsgolf.com/api/casualBooking/teesheet?date=2026-01-09&course_id=1",
// );
// curl_setopt($ch, CURLOPT_REFERER, "https://visitors.brsgolf.com/lanark");

// $html = curl_exec($ch);
// // var_dump($ch);

// preg_match_all("/Set-Cookie:\s*([^;]+)/i", $html, $matches);
// $cookie = implode("\n\n", $matches[1]);

// if (preg_match("/XSRF-TOKEN=([^\s]+)/", $cookie, $xsrfmatches)) {
//     $xsrfToken = $xsrfmatches[1];
// }

// if ($xsrfToken) {
//     preg_match_all("/Set-Cookie:\s*([^;]+)/i", $html, $matches);
//     $cookies = implode("; ", $matches[1]);

//     curl_setopt_array($ch, [
//         CURLOPT_RETURNTRANSFER => true,
//         CURLOPT_USERAGENT => "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36",
//         CURLOPT_HTTPHEADER => [
//             "Cookie: " . $cookies,
//             "X-XSRF-TOKEN: " . $xsrfToken,
//             "x-requested-with: XMLHttpRequest",
//             "Accept: application/json",
//             "Origin: https://visitors.brsgolf.com",
//             "Referer: https://visitors.brsgolf.com/lanark",
//         ],
//         // CURLOPT_VERBOSE => true
//     ]);
//     curl_setopt($ch, CURLOPT_HEADER, true);
//     curl_setopt(
//         $ch,
//         CURLOPT_URL,
//         "https://visitors.brsgolf.com/api/casualBooking/teesheet?date=2026-07-09&course_id=1",
//     );
//     curl_setopt($ch, CURLOPT_REFERER, "https://visitors.brsgolf.com/lanark");

//     $result = curl_exec($ch);
//     // var_dump($ch);

//     if (preg_match('/\r?\n\r?\n(.*)$/s', $result, $m)) {
//         $json = trim($m[1]);
//         $data = json_decode($json, true);
//     } else {
//         die("No JSON found");
//     }

//     print_r($data);
// }

// require_once "brsCall.php";

// $BRSCall = new BRSCall();
// $tmp = $BRSCall->getTeeTimesForDay("2026-07-11", "pitlochry");

// 57.968528102410566, -4.0109028539878295

require_once "call/intelligentCall.php";

echo "<pre>";

$IntelligentCall = new IntelligentCall();
echo $IntelligentCall->checkOpenAvailability("broragolfclub", 846);
