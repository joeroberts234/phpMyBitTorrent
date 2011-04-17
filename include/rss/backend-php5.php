<?php
/*
*-------------------------------phpMyBitTorrent--------------------------------*
*--- The Ultimate BitTorrent Tracker and BMS (Bittorrent Management System) ---*
*--------------   Created By Antonio Anzivino (aka DJ Echelon)   --------------*
*-------------               http://www.p2pmania.it               -------------*
*------------ Based on the Bit Torrent Protocol made by Bram Cohen ------------*
*-------------              http://www.bittorrent.com             -------------*
*------------------------------------------------------------------------------*
*------------------------------------------------------------------------------*
*--   This program is free software; you can redistribute it and/or modify   --*
*--   it under the terms of the GNU General Public License as published by   --*
*--   the Free Software Foundation; either version 2 of the License, or      --*
*--   (at your option) any later version.                                    --*
*--                                                                          --*
*--   This program is distributed in the hope that it will be useful,        --*
*--   but WITHOUT ANY WARRANTY; without even the implied warranty of         --*
*--   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the          --*
*--   GNU General Public License for more details.                           --*
*--                                                                          --*
*--   You should have received a copy of the GNU General Public License      --*
*--   along with this program; if not, write to the Free Software            --*
*-- Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA --*
*--                                                                          --*
*------------------------------------------------------------------------------*
*------              ©2005 phpMyBitTorrent Development Team              ------*
*-----------               http://phpmybittorrent.com               -----------*
*------------------------------------------------------------------------------*
*/

header('Content-Type: text/xml');

else $rss = new DomDocument("1.0","UTF-8");
{
     $rss->formatOutput = true;

     $rdf = $rss->appendChild( $rss->createElement( 'rdf:RDF' ) );
     $rdf->setAttribute( "xmlns:rdf" , "http://www.w3.org/1999/02/22-rdf-syntax-ns#" );
     $rdf->setAttribute( "xmlns:dc" , "http://purl.org/dc/elements/1.1/" );
     $rdf->setAttribute( "xmlns:sy" , "http://purl.org/rss/1.0/modules/syndication/" );
     $rdf->setAttribute( "xmlns:admin" , "http://webns.net/mvcb/" );
     $rdf->setAttribute( "xmlns" , "http://purl.org/rss/1.0/" );

     {
       $channel = $rss->createElement( "channel" );
       $channel->setAttribute( "rdf:about" , $siteurl );
       {
         $title = $rss->createElement( "title" );
         $title->appendChild( $rss->createTextNode( $sitename ) );
       }
       $channel->appendChild( $title );
       {
         $link = $rss->createElement( "link" );
         $link->appendChild( $rss->createTextNode( $siteurl ) );
       }
       $channel->appendChild( $link );
       {
         $description = $rss->createElement( "description" );
         $description->appendChild( $rss->createTextNode( $descr ) );
       }
       $channel->appendChild( $description );
       {
         $items = $rss->createElement( "items" );
         {
           $rdf_Seq = $rss->createElement( "rdf:Seq" );

           foreach ( $ids as $tid )
           {
             $rdf_li = $rss->createElement( "rdf:li" );
             $rdf_li->setAttribute( "rdf:resource" , $siteurl."/details.php?id=".$tid );
             $rdf_Seq->appendChild( $rdf_li );
           }

         }
         $items->appendChild( $rdf_Seq );
       }
       $channel->appendChild( $items );
     }


     $rdf->appendChild( $channel );
     for ( $i = 0; $i < count( $ids ); $i++ )
     {
       $item = $rss->createElement( "item" );
       $item->setAttribute( "rdf:about" , $siteurl . "/details.php?id=" . $ids[ $i ] );
       {
         $title = $rss->createElement( "title" );
         $title->appendChild( $rss->createTextNode( $names[ $i ] ) );
       }
       $item->appendChild( $title );
       {
         $link = $rss->createElement( "link" );
         $link->appendChild( $rss->createTextNode( $siteurl."/details.php?id=" . $ids[ $i ] ) );
       }
       $item->appendChild( $link );
       {
         $description = $rss->createElement( "description" );
         $description->appendChild( $rss->createTextNode( $descrs[ $i ] ) );
       }
       $item->appendChild( $description );
       {
         $seeders = $rss->createElement( "seeders" );
         $seeders->appendChild( $rss->createTextNode( $seeds[ $i ] ) );
       }
       $item->appendChild( $seeders );
       {
         $leechers = $rss->createElement( "leechers" );
         $leechers->appendChild( $rss->createTextNode( $leeches[ $i ] ) );
       }
       $item->appendChild( $leechers );

       $rdf->appendChild( $item );
     }
}

$rss->appendChild( $rdf );

echo $rss->saveXML( $rss->documentElement );
?>
