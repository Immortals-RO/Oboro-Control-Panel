<?php
$tmp = $FNC->getOnlineForumUser();
$tmp2 = $FNC->getOnlineForumUserAtDay();

echo '
    <div class="row">
        <div class="col-12">
            <h6 class="title-plugin"> 
            <div class="h4-container">
                    ['.sizeof($tmp).'] Users Online, in the past (20 minutes).</div>
            </h6>
        </div>
            
        <div class="col-12">
            <div class="whoisonline_plugin">
';

$i =0;
foreach($tmp as $user) {
    echo $user . (++$i < sizeof($tmp) ? ', ' :'');
}

echo '
    <hr>
    <div class="subcategory-description">All day Online</div>
';

$i =0;
foreach($tmp2 as $user) {
    echo $user . ($i++ < sizeof($tmp) ? ', ' :'');
}

echo '
            </div>
        </div>
';
?>