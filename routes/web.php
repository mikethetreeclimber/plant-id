<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\PlantId;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');


Route::get('/plantId', PlantId::class);
// Route::get('/test', TestController


Route::get('/test', function () {

    function curl_setopt_custom_postfields($ch, $postfields, $headers = null) {
        $algos = hash_algos();
        $hashAlgo = null;
    
        foreach (array('sha1', 'md5') as $preferred) {
            if (in_array($preferred, $algos)) {
                $hashAlgo = $preferred;
                break;
            }
        }
    
        if ($hashAlgo === null) {
            list($hashAlgo) = $algos;
        }
    
        $boundary = '----------------------------' . substr(hash(
            $hashAlgo, 'cURL-php-multiple-value-same-key-support' . microtime()
        ), 0, 12);
    
        $body = array();
        $crlf = "\r\n";
        $fields = array();
    
        foreach ($postfields as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $v) {
                    $fields[] = array($key, $v);
                }
            } else {
                $fields[] = array($key, $value);
            }
        }
    
        foreach ($fields as $field) {
            list($key, $value) = $field;
    
            if (strpos($value, '@') === 0) {
                preg_match('/^@(.*?)$/', $value, $matches);
                list($dummy, $filename) = $matches;
    
                $body[] = '--' . $boundary;
                $body[] = 'Content-Disposition: form-data; name="' . $key . '"; filename="' . basename($filename) . '"';
                $body[] = 'Content-Type: application/octet-stream';
                $body[] = '';
                $body[] = file_get_contents($filename);
            } else {
                $body[] = '--' . $boundary;
                $body[] = 'Content-Disposition: form-data; name="' . $key . '"';
                $body[] = '';
                $body[] = $value;
            }
        }
    
        $body[] = '--' . $boundary . '--';
        $body[] = '';
        dd($body);
    
        $contentType = 'multipart/form-data; boundary=' . $boundary;
        $content = join($crlf, $body);

    
        $contentLength = strlen($content);
    
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Length: ' . $contentLength,
            'Expect: 100-continue',
            'Content-Type: ' . $contentType
        ));
    
        curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
    }
    
    $data = array(
        'organs' => array(
            'bark',
            'leaf',
            'leaf'
        ),

        'images' => array(
            '@/home/arbmanX/Pictures/sw_pignut3.jpg',
            '@/home/arbmanX/Pictures/pignut-hickory-fruit-original-01.jpg',
            '@/home/arbmanX/Pictures/Pignut-Hickory-with-Hickory-nut-in-early-October.jpg'
        )
    );

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://my-api.plantnet.org/v2/identify/all?include-related-images=true&api-key=2b10FiRnqF3kK1anow3Ga9Y7e',
      CURLOPT_POST => true,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    ));

    curl_setopt_custom_postfields($curl, $data);
    $response = curl_exec($curl);
    dd($curl);
    
    curl_close($curl);
    return json_decode($response);

    // array(
    //     'images'=> array(
    //         new CURLFILE('/home/arbmanX/Pictures/sw_pignut3.jpg'),
    //         new CURLFILE('/home/arbmanX/Pictures/pignut-hickory-fruit-original-01.jpg'),
    //         new CURLFILE('/home/arbmanX/Pictures/Pignut-Hickory-with-Hickory-nut-in-early-October.jpg'),
    //     ),
    //     'organs' => array(
    //         'bark',
    //         'fruit',
    //         'leaf'
    //       ),
    // )
    
    // $ch = curl_init(); // init cURL session
    
    // curl_setopt($ch, CURLOPT_URL, $url); // set the required URL
    // curl_setopt($ch, CURLOPT_POST, true); // set the HTTP method to POST
    // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // get a response, rather than print it
    // // set the multidimensional array param
    // $response = curl_exec($ch); // execute the cURL session
    
    // curl_close($ch); // close the cURL session
    
    // echo $response;

    // // dump($a);
    // foreach($a->results as $result){
    //     foreach($result->images as $image){
    //         echo '<img src="'.$image->url->o.'"'.' style="width: 200px;"/>';
    //     }
    // }
});
