<?php

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

include( 'includes/database.php' );
include( 'includes/config.php' );
include( 'includes/functions.php' );

// Define images to use if there is no image
$camera = 'data:image/gif;base64,R0lGODlh6ANYAsQAAOTk5N7e3ufn5+jo6Ozs7Obm5vPz89/f3/T09ODg4PHx8e/v7/Dw8PLy8uPj4+3t7eLi4u7u7urq6uHh4eXl5enp6evr693d3fX19QAAAAAAAAAAAAAAAAAAAAAAAAAAACH5BAAAAAAALAAAAADoA1gCAAX/ICaOZGmeaKqubOu+cCzPdG3feK7vfO//wKBwSCwaj8ikcslsOp/QqHRKrVqv2Kx2y+16v+CweEwum8/otHrNbrvf8Lh8Tq/b7/i8fs/v+/+AgYKDhIWGh4iJiouMjY6PkJGSk5SVlpeYmZqbnJ2en6ChoqOkpaanqKmqq6ytrq+wsbKztLW2t7i5uru8vb6/wMHCw8TFxsfIycrLzM3Oz9DR0tPU1dbX2Nna29zd3t/g4eLj5OXm5+jp6uvs7e7v8PHy8/T19vf4+fr7/P3+/wADChxIsKDBgwgTKlzIsKHDhxAjSpxIsaLFixgzatzIsaPHjyBDihxJsqTJkyhT/6pcybKly5cwY8qcSbOmzZs4c+rcybOnz59AgwodSrSo0aNIkypdyrSp06dQo0qdSrWq1atYs2rdyrWr169gw4odS7as2bNo06pdy7at27dw48qdS7eu3bt48+rdy7ev37+AAwseTLiw4cOIEytezLix48eQI0ueTLmy5cuYM2vezLmz58+gQ4seTbq06dOoU6tezbq169ewY8ueTbu27du4c+vezbu379/AgwsfTry48ePIkytfzry58+fQo0ufTr269evYs2vfzr279+/gw4sfT768+fPo06tfz769+/fw48ufT7++/fv48+vfz7+///8ABijggAQWaOCBCCao4P+CDDbo4IMQRijhhBRWaOGFGGao4YYcdujhhyCGKOKIJJZo4okopqjiiiy26OKLMMYo44w01mjjjTjmqOOOPPbo449ABinkkEQWaeSRSCap5JJMNunkk1BGKeWUVFZp5ZVYZqnlllx26eWXYIYp5phklmnmmWimqeaabLbp5ptwxinnnHTWaeedeOap55589unnn4AGKuighBZq6KGIJqrooow26uijkEYq6aSUVmrppZhmqummnHbq6aeghirqqKSWauqpqKaq6qqsturqq7DGKuurCDBgQQEOAKDrrrz26uuvwAYrLK8OFCDBAgjM+pIBFjiQQAAXRCvttNRWa+3/tdhm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';
$person = 'data:image/jpeg;base64,/9j/4QAYRXhpZgAASUkqAAgAAAAAAAAAAAAAAP/sABFEdWNreQABAAQAAAA8AAD/4QMraHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLwA8P3hwYWNrZXQgYmVnaW49Iu+7vyIgaWQ9Ilc1TTBNcENlaGlIenJlU3pOVGN6a2M5ZCI/PiA8eDp4bXBtZXRhIHhtbG5zOng9ImFkb2JlOm5zOm1ldGEvIiB4OnhtcHRrPSJBZG9iZSBYTVAgQ29yZSA1LjMtYzAxMSA2Ni4xNDU2NjEsIDIwMTIvMDIvMDYtMTQ6NTY6MjcgICAgICAgICI+IDxyZGY6UkRGIHhtbG5zOnJkZj0iaHR0cDovL3d3dy53My5vcmcvMTk5OS8wMi8yMi1yZGYtc3ludGF4LW5zIyI+IDxyZGY6RGVzY3JpcHRpb24gcmRmOmFib3V0PSIiIHhtbG5zOnhtcE1NPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvbW0vIiB4bWxuczpzdFJlZj0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL3NUeXBlL1Jlc291cmNlUmVmIyIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bXBNTTpEb2N1bWVudElEPSJ4bXAuZGlkOjE4MDcwRTFGQjZGQzExRTVCN0I0RDI5QTQwNzA1QjVBIiB4bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOjE4MDcwRTFFQjZGQzExRTVCN0I0RDI5QTQwNzA1QjVBIiB4bXA6Q3JlYXRvclRvb2w9IkFkb2JlIFBob3Rvc2hvcCBDUzYgKFdpbmRvd3MpIj4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6MDVFRTVGRDhCNkZDMTFFNUI0QjlFQkMyQjFGQTJBQjIiIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6MDVFRTVGRDlCNkZDMTFFNUI0QjlFQkMyQjFGQTJBQjIiLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz7/7gAOQWRvYmUAZMAAAAAB/9sAhAAGBAQEBQQGBQUGCQYFBgkLCAYG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';

switch( $_GET['type'] )
{

  case 'project':
    
    $query = 'SELECT photo 
      FROM projects
      WHERE id = '.$_GET['id'].'
      LIMIT 1';
    $result = mysqli_query( $connect, $query );
    $record = mysqli_fetch_assoc( $result );

    if( !$record['photo'] ) $record['photo'] = $camera;
    
    break;
      
}

include 'includes/wideimage/WideImage.php';

$data = base64_decode( explode( ',', $record['photo'] )[1] );
$img = WideImage::loadFromString( $data );

if( isset( $_GET['width'] ) and isset( $_GET['height'] ) )
{

  $img = $img->resize( $_GET['width'], $_GET['height'], isset($_GET['format']) ? $_GET['format'] : 'outside' );
  $img = $img->crop( 'center', 'center', $_GET['width'], $_GET['height'] );

}

$img->output( 'png', 8 );
