<?php
require_once("include/config.php");

echo '<?xml version="1.0" encoding="UTF-8"?>
<OpenSearchDescription xmlns="http://a9.com/-/spec/opensearch/1.1/">
    <ShortName>'.$sitename.'</ShortName>
    <Description>movies games</Description>
    <Url type="text/html" template="'.$siteurl.'/search.php?search={searchTerms}" />
    <Tags>movies,games,music</Tags>
    <LongName>'.$sitename.'</LongName>
    <Image height="16" width="16" type="image/vnd.microsoft.icon">'.$$siteurl.'/themes/'.$theme.'/favicon.JPG</Image>
    <Developer>joeroberts</Developer>
    
</OpenSearchDescription>';
?> 