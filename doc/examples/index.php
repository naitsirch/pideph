<?php

$pdf = <<<PDF
%PDF-1.4
1 0 obj
    << /Type /Catalog
       /Outlines 2 0 R
       /Pages 3 0 R
    >>
endobj

2 0 obj
    << /Type Outlines
       /Count 0
    >>
endobj

3 0 obj
    << /Type /Pages
       /Kids [4 0 R]
       /Count 1
    >>
endobj

4 0 obj
    << /Type /Page
       /Parent 3 0 R
       /MediaBox [0 0 612 792]
       /Contents [5 0 R 6 0 R]
       /Resources << /ProcSet 6 0 R 
                     /Font << /F1  7 0 R >>
                  >>
    >>
endobj
        
5 0 obj
    << /Length 883 >>
stream
    % Draw a black line segment, using the default line width.
    150 250 m
    150 350 l
    S
    
    % Draw a thicker, dashed line segment.
    4 w                                     % set line width t 4 points
    [4 6] 0 d                               % set dash pattern to 4 units on, 6 units off
    150 250 m
    400 250 l
    S
    [] 0 d                                  % reset dash pattern to a solid line
    1 w                                     % reset line width to 1 unit

    % Draw a rectangle with a 1-unit red border, filled with light blue .
    1.0 0.0 0.0 RG                          % Red for stroke color
    0.5 0.75 1.0 rg                         % Light blue for fill color
    200 300 50 75 re
    B

    % Draw a curve filled with gray and with a colored border.
    0.5 0.1 0.2 RG
    0.7 g
    300 300 m
    300 400 400 400 400 300 c
    b
endstream
endobj


6 0 obj
    << /Length 73 >>
stream
    BT
        /F1 24 Tf
        100 100 Td
        (Hello World) Tj
    ET
endstream
endobj

7 0 obj
    [/PDF /Text]
endobj
        
8 0 obj
    << /Type /Font
       /Subtype Type1
       /Name /F1
       /BaseFont /Helvetica
       /Encoding /MacRomanEncoding
    >>
endobj

xref
0 9
0000000000 65535 f 
0000000009 00000 n 
0000000097 00000 n 
0000000158 00000 n 
0000000238 00000 n 
0000000465 00000 n 
0000001400 00000 n 
0000001530 00000 n 
0000001571 00000 n 

trailer
    << /Size 9
       /Root 1 0 R
    >>
startxref
1715
%%EOF
PDF;

file_put_contents(dirname(__FILE__).'/test.pdf', $pdf);

$s = 'xref';
echo 'position of "'.$s.'": '.strpos($pdf, $s).PHP_EOL;