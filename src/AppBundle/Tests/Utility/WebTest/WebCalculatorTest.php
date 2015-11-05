<?php

namespace AppBundle\Test\Utility\WebTest;

// use Symfony\Component\Config\Definition\Exception\Exception;
// use Symfony\Component\HttpFoundation\Response;
// use AppBundle\Utility\RunTestMode;
use AppBundle\Utility\WebTest\WebCalculator;

class WebCalculatorTest extends \PHPUnit_Framework_TestCase
{
    public function testAdd() 
    {
      // $cal = new WebCalculator();
      // $cal = $this->container->get('my_web_calculator');

      $result = WebCalculator::add( 20, 30 );

      $this->assertEquals( 50, $result );
    }

    public function testStringToJson()
    {
      $str = '{"data": "10"}';
      // $str = array(1, 2, 3);
      // $str = {data: 10};
      // $str = array("data" => "10");
      // $str = array('data' => '10');
      // $cal = new WebCalculator();
      // $cal = $this->container->get('my_web_calculator');

      $result = WebCalculator::stringToJson($str);
      // $result = $str['data'];

      // $expect = array('data' => '10');
      $expect = "10";
      // var_dump($result);
      // $result = json_decode($str);
      $result = $result->{"data"};
      $this->assertEquals( $expect, $result );

      $str02 = '{"data":{"price":"20.00",
                        "skuProps":
                          [{
                            "prop":"颜色",
                            "skuMap":{
                               "白色L":{"canBookCount":1990},
                               "白M":{"canBookCount":1989},
                               "白色S":{"canBookCount":1988},
                               "白色XL":{"canBookCount":1997},
                               "黑色L":{"canBookCount":1996},
                               "黑色":{"canBookCount":1997}
                             }
                          }]
                       }
                }';
      $str02 = "{'data': {'price': 100}}";
      $result02 = WebCalculator::stringToJson($str02);
      // var_dump($result02);
      // var_dump($result02->{"data"}->{"price"});
    }

    public function testJsonToString()
    {
      // $str = '{"data": "10"}';
      // // $str = {data: 10};
      // // $str = array("data" => "10");
      // // $str = array('data' => '10');
      // // $cal = new WebCalculator();
      // // $cal = $this->container->get('my_web_calculator');

      // $result = WebCalculator::jsonToString($str);
      // // $result = $str['data'];

      // // $expect = array('data' => '10');
      // $expect = "10";
      // // var_dump($result);
      // // $result = json_decode($str);
      // $result = $result->{"data"};
      // $this->assertEquals( $expect, $result );
    }

    public function testJsonMethod()
    {
      // $json = '{"a":1,"b":2,"c":3,"d":4,"e":5}';
      // $json_01 = json_decode($json);
      // $json_02 = json_decode($json, true);

      // var_dump(json_decode($json));
      // var_dump(json_decode($json, true));

      // echo "json_01: ";
      // echo $json_01->{"a"};
      // echo ", ";
      // echo "json_02: ";
      // echo $json_02["a"];

      // $arr = array('a'=>'10','b'=>'20','c'=>'30');
      // $json_03 = json_encode($arr);
      // var_dump($json_03);

      // $str = "10";
      // $json_04 = json_encode($str);
      // var_dump($json_04);

      // $splstack = new \SplStack();
      // $splstack->push(10);
      // $splstack->push(10);
      // var_dump($splstack);

      // $array = ['4', '5', '6', '7'];
      // echo json_encode(new ArrayValue($array), JSON_PRETTY_PRINT);
    }
}

// class ArrayValue implements \JsonSerializable {
//     public function __construct(array $array) {
//         $this->array = $array;
//     }

//     public function jsonSerialize() {
//         return array('1','2','3');
//     }
// }