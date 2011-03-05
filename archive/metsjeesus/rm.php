<?php
for($i=1751;$i<1764;$i++)
{
    unlink("thumbs/IMG_$i.jpg");
}

for($i=9220;$i<9229;$i++)
{
    unlink("thumbs/IMG_$i.jpg");
}

rmdir("thumbs");
?>