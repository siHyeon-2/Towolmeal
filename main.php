<?php
// 현재 날짜 정보 설정
$year = date("Y");
$month = date("m");
$day = date("d");
$week = date("w"); // 0 ~ 6 (일 ~ 토)

// API 정보 설정
$apiurl = "https://open.neis.go.kr/hub/mealServiceDietInfo";
$apikey = "8c342399f5374372bcd558913742d763";

// API 요청 파라미터 설정
$params = [
    'ATPT_OFCDC_SC_CODE' => 'YOUR_EDUCATION_OFFICE_CODE', // 교육청 코드
    'SD_SCHUL_CODE' => 'YOUR_SCHOOL_CODE', // 학교 코드
    'MLSV_YMD' => $year.$month.$day, // 조회할 날짜
    'KEY' => $apikey,
    'Type' => 'json' // JSON 형태로 받기 위한 파라미터
];

// URL에 쿼리 스트링 추가
$url = $apiurl . '?' . http_build_query($params);

// cURL 초기화
$ch = curl_init();

// cURL 옵션 설정
curl_setopt($ch, CURLOPT_URL, $url); // 요청할 URL
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // 응답을 문자열로 반환

// API 호출 실행
$response = curl_exec($ch);

// 에러 체크
if (curl_errno($ch)) {
    // 에러 발생 시 메시지 출력
    echo 'Error:' . curl_error($ch);
} else {
    // JSON 응답 파싱
    $data = json_decode($response, true);
    
    if ($data === null) {
        echo "Failed to decode JSON";
    } else {
        // 원하는 값 추출
        // 예제에서는 "DDISH_NM" 값 추출
        if (isset($data['mealServiceDietInfo'][1]['row'][0]['DDISH_NM'])) {
            $lunchName = $data['mealServiceDietInfo'][1]['row'][0]['DDISH_NM'];
            echo "Dish Name: " . $dishName;
        } else {
            echo "Dish name not found in the response.";
        }
        if (isset($data['mealServiceDietInfo'][1]['row'][1]['DDISH_NM'])) {
            $dinnerName = $data['mealServiceDietInfo'][1]['row'][1]['DDISH_NM'];
            echo "Dish Name: " . $dinnerName;
        } else {
            echo "Dish name not found in the response.";
        }
    }
}

// cURL 세션 종료
curl_close($ch);