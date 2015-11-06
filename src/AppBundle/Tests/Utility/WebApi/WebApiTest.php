<?php

namespace AppBundle\Test\Utility\WebApi;

use AppBundle\Utility\WebUtility\WebAuto;

class WebApiTest extends \PHPUnit_Framework_TestCase
{
    public function testResult()
    {
      // $body = '
      //         <div>
      //         <p>I like pickles and herring.</p>
      //         <a href="pickle.php"><img src="pickle.jpg"/>A pickle picture</a>
      //         I have a herringbone-patterned toaster cozy.
      //         <herring>Herring is not a real HTML element!</herring>
      //         </div>
      //         ';

      $body = '
              <div class="course-list">
                      <ul>
                        <li class="course-item clearfix">
                             <dl class="module-list course-hour-item">
                                <h4>第1章： 一级建造师工程管理</h4>
                                <dd class="module-item clearfix"><dl class="module-list course-hour-item">
                                  <dd class="module-item clearfix">
                                    <div class="course-tit-info">
                                      <span class="course-tit" style="background-position: 0 11px;">课时1 : 2014曹明铭二建-市政-精讲班17</span>
                                      <span class="right duration">时长20分10秒</span>
                                      </div>
                                    <div class="study-tit-info-bg" style="display: none;"></div>
                                    <div class="study-tit-info" style="display: none;">
                                      <a href="javascript:;">时长20分10秒</a>
                                              |<a href="javascript:;">可学习无限次</a>
                                              <a class="nowlisten preview canBroadcast" href="javascript:;" data-coursecontenttype="1" data-status="trial" data-coursecontentid="1708690" data-convertstatus="done" data-isfree="true" data-canmodify="false" data-ispdf="false" data-type="clickCourse" data-ep="">
                                            立即试听
                                          </a>
                                        </div>
                                  </dd>
                                </dl></dd>
                          </dl>
                    </li>
                </ul>
              </div>
              ';
      $words = array('pickle', 'herring');
      $replacements = array();
      foreach ( $words as $i => $word ) {
        $replacements[] = "<span class='word-$i'>$word</span>";
      }

      $parts = preg_split("{(<(?:\"[^\"]*\"|'[^']*'|[^'\">])*>)}",
                           $body,
                           -1, // Unlimited number of chunks
                           PREG_SPLIT_DELIM_CAPTURE);

      // $body01 = implode( '', $parts );
      // print $body01;
      // var_dump($parts);

      foreach ( $parts as $i => $part ) {
        // Skip if this part is an THML element
        if ( isset( $part[0] ) && ( $part[0] == '<' )) { continue; }
        // $parts[$i] = str_replace($words, $replacements, $part);
      }

      $body = implode( '', $parts );
      // print $body;
    }

    public function testResult02()
    {
      $body = '
              <body class="course-list">
                      <ul>
                        <li class="course-item clearfix">
                             <dl class="module-list course-hour-item">
                                <h4>第1章： 一级建造师工程管理</h4>
                                <dd class="module-item clearfix"><dl class="module-list course-hour-item">
                                  <dd class="module-item clearfix">
                                    <div class="course-tit-info">
                                      <span class="course-tit" style="background-position: 0 11px;">课时1 : 2014曹明铭二建-市政-精讲班17</span>
                                      <span class="right duration">时长20分10秒</span>
                                      </div>
                                    <div class="study-tit-info-bg" style="display: none;"></div>
                                    <div class="study-tit-info" style="display: none;">
                                      <a href="javascript:;">时长20分10秒</a>
                                              |<a href="javascript:;">可学习无限次</a>
                                              <a class="nowlisten preview canBroadcast" href="javascript:;" data-coursecontenttype="1" data-status="trial" data-coursecontentid="1708690" data-convertstatus="done" data-isfree="true" data-canmodify="false" data-ispdf="false" data-type="clickCourse" data-ep="">
                                            立即试听
                                          </a>
                                        </div>
                                  </dd>
                                </dl></dd>
                          </dl>
                    </li>
                </ul>
              </body>
              ';
      $doc = new \DOMDocument();
      $opts = array('output-xhtml' => true,
                    // Prevent DOMDocument from being confused about entities
                    'numeric-entities' => true);
      // $doc->loadXML( tidy_repair_string($body, $opts) );
      $doc->loadXML( $body );
      $xpath = new \DOMXPath($doc);

      $body = $doc->getElementsByTagName('body')->item(0);
      // var_dump($body);

      foreach ($xpath->query("descendant-or-self::text()", $body) as $textNode) {
        // print $textNode->wholeText;
      }
    }

    public function testResult03() 
    {
      // $html = '
      //         <div>
      //           <p>Some things I enjoy eating are:</p>
      //           <ul>
      //             <li><a href="http://en.wikipedia.org/wiki/Pickle">Pickles</a></li>
      //             <li><a href="http://www.eatingintranslation.com/2011/03/great_ny_noodle.html">
      //             Salt-Baked Scallops</a></li>
      //             <li><a href="http://www.thestoryofchocolate.com/">Chocolate</a></li>
      //           </ul>
      //         </div>
      //         ';

      // $doc = new \DOMDocument();
      // // $opts = array('output-xhtml' => true,
      // //               // Prevent DOMDocument from being confused about entities
      // //               'numeric-entities' => true);
      // // $doc->loadXML(tidy_repair_string($html,$opts));

      // $doc->loadXML( $html );
      // $xpath = new \DOMXPath($doc);
      // $xpath->registerNamespace('xhtml', 'http://www.w3.org/1999/xhtml');

      // foreach ($xpath->query('//xhtml:a/@href') as $node) {
      //   $link = $node->nodeValue;
      //   print $link . "\n";
      // }
    }
}