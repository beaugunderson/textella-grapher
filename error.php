<?="<?xml version=\"1.0\"?>"?>
<svg xmlns="http://www.w3.org/2000/svg" width="800px" height="600px">
 <text transform="matrix(1 0 0 1 400 200)" style="text-anchor: middle;"><tspan x="0" y="0" fill="#BFB900" stroke="none" font-family="'Arial-BoldMT'" font-size="72">Server error!</tspan></text>
 <text transform="matrix(1 0 0 1 402 202)" style="text-anchor: middle;"><tspan x="0" y="0" fill="#FFFF33" stroke="none" font-family="'Arial-BoldMT'" font-size="72">Server error!</tspan></text>
 <text transform="matrix(1 0 0 1 400 250)" style="text-anchor: middle;"><tspan x="0" y="0" fill="#AAAAAA" stroke="none" font-family="'Arial-BoldMT'" font-size="16"><?=$errstr?>. (Error <?=$errno?>)</tspan></text>
 <text transform="matrix(1 0 0 1 400 280)" style="text-anchor: middle;"><tspan x="0" y="0" fill="#AAAAAA" stroke="none" font-family="'Arial-BoldMT'" font-size="16">(<?=$form_ip?>:<?=$form_port?>)</tspan></text>

 <text transform="matrix(1 0 0 1 400 362)" style="text-anchor: middle;">
  <tspan x="0" y="0" fill="#000000" stroke="none" font-family="'Arial-BoldMT'" font-size="32">T</tspan>
 </text>

 <g transform="translate(400 350) rotate(-25)" style="stroke: black; stroke-width: 0.5; fill: none">
  <ellipse id="ellipse1" cx="0" cy="0" rx="20" ry="20"/>
  <ellipse id="ellipse2" cx="0" cy="0" rx="20" ry="20"/>
 </g>

 <g transform="translate(400 350) rotate(65)"  style="stroke: black; stroke-width: 0.5; fill: none">
  <ellipse id="ellipse3" cx="0" cy="0" rx="20" ry="20"/>
  <ellipse id="ellipse4" cx="0" cy="0" rx="20" ry="20"/>
 </g>

 <animate xlink:href="#ellipse1" attributeName="rx" values="20;0;20" begin="1s" dur="1s" repeatCount="indefinite"/>
 <animate xlink:href="#ellipse2" attributeName="rx" values="20;0;20" begin="2s" dur="2s" repeatCount="indefinite"/>
 <animate xlink:href="#ellipse3" attributeName="rx" values="20;0;20" begin="3s" dur="1s" repeatCount="indefinite"/>
 <animate xlink:href="#ellipse4" attributeName="rx" values="20;0;20" begin="4s" dur="2s" repeatCount="indefinite"/>
</svg>