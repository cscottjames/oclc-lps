<?php

//get the oclc number
$oclc = $_POST['oclc'];

//start up the DOM
$dom = new DOMDocument();
$dom->load('http://www.worldcat.org/oclc/' . $oclc . '.rdf');

//Store the RDF namespace URL so you don't have to have it in each getElements query
$schema_ns = "http://schema.org/";
$rdf_ns = 'http://www.w3.org/1999/02/22-rdf-syntax-ns#';

//xpath
$xpath = new DOMXPath($dom);
$xpath->registerNameSpace('rdf', 'http://www.w3.org/1999/02/22-rdf-syntax-ns#');
$xpath->registerNameSpace('schema', 'http://schema.org');

//create table headings, open data row
echo '<table style="border: 1px solid black"><tr><th>Album Title</th><th>Performer (byArtist)</th><th>Performer</th><th>Composer</th><th>Contributor</th><th>Date Published</th><th>Label</th><th>Place Published</th><th>Description</th><th>Notes</th><th>Notes (2)</th></tr><tr id="dataRow">';

//search for album name
$values = $xpath->query('//rdf:Description[@rdf:about="http://www.worldcat.org/oclc/' . $oclc . '"]//schema:name');
if($values->length>0)
foreach ($values as $value){
        echo '<td style="border: 1px solid black">' . $value->nodeValue . '</td>';
}
else echo '<td style="border: 1px solid black"></td>';

//search for performer (byArtist) *uses linked data attribute *needs additional schema:name filter
$byArtists = $xpath->query('//rdf:Description[@rdf:about="http://www.worldcat.org/oclc/' . $oclc . '"]//schema:byArtist//@rdf:resource');
echo '<td style="border: 1px solid black">';
foreach ($byArtists as $byArtist){
        $artist = $byArtist->nodeValue ;
$values = $xpath->query('//rdf:Description[@rdf:about="' . $artist . '"]//schema:name' );
if($values->length>0)
foreach ($values as $value){
        echo $value->nodeValue . '; ';
}
}
echo '</td>';

//search for performer *uses linked data attribute *uses additional schema:name filter
$performers = $xpath->query('//rdf:Description[@rdf:about="http://www.worldcat.org/oclc/' . $oclc . '"]//schema:performer//@rdf:resource');
echo '<td style="border: 1px solid black">';
foreach ($performers as $performer){
        $artist = $performer->nodeValue ;
$values = $xpath->query('//rdf:Description[@rdf:about="' . $artist . '"]//schema:name' );
if($values->length>0)
foreach ($values as $value){
        echo $value->nodeValue . '; ';
}
}
echo '</td>';

//search for composer *uses linked data attribute *uses additional schema:name filter
$composers = $xpath->query('//rdf:Description[@rdf:about="http://www.worldcat.org/oclc/' . $oclc . '"]//schema:composer//@rdf:resource');
echo '<td style="border: 1px solid black">';
foreach ($composers as $composer){
        $artist = $composer->nodeValue ;
$values = $xpath->query('//rdf:Description[@rdf:about="' . $artist . '"]//schema:name' );
if($values->length>0)
foreach ($values as $value){
        echo $value->nodeValue . '; ';
}
}
echo '</td>';

//search for contributor *uses linked data attribute *uses additional schema:name filter
$contributors = $xpath->query('//rdf:Description[@rdf:about="http://www.worldcat.org/oclc/' . $oclc . '"]//schema:contributor//@rdf:resource');
echo '<td style="border: 1px solid black">';
foreach ($contributors as $contributor){
        $artist = $contributor->nodeValue ;
$values = $xpath->query('//rdf:Description[@rdf:about="' . $artist . '"]//schema:name' );
if($values->length>0)
foreach ($values as $value){
        echo $value->nodeValue . '; ';
}
}
echo '</td>';

//search for date published
$values = $xpath->query('//rdf:Description[@rdf:about="http://www.worldcat.org/oclc/' . $oclc . '"]//schema:datePublished[1]');
if($values->length>0)
foreach ($values as $value){
        echo '<td style="border: 1px solid black">' . $value->nodeValue . '</td>';
}
else echo '<td style="border: 1px solid black"></td>';

//search for label *uses linked data attribute
$labels = $xpath->query('//rdf:Description[@rdf:about="http://www.worldcat.org/oclc/' . $oclc . '"]//schema:publisher//@rdf:resource');
foreach ($labels as $label){
        $publisher = $label->nodeValue ;
}
$values = $xpath->query('//rdf:Description[@rdf:about="' .$publisher . '"]' );
if($values->length>0)
foreach ($values as $value){
        echo '<td style="border: 1px solid black">' . $value->nodeValue . '</td>';
}
else echo '<td style="border: 1px solid black"></td>';

//search for place of publication *uses linked data attribute
$places = $xpath->query('//rdf:Description[@rdf:about="http://www.worldcat.org/oclc/' . $oclc . '"]//library:placeOfPublication[2]//@rdf:resource');
foreach ($places as $place){
        $city = $place->nodeValue ;
}
$values = $xpath->query('//rdf:Description[@rdf:about="' .$city . '"]' );
if($values->length>0)
foreach ($values as $value){
        echo '<td style="border: 1px solid black">' . $value->nodeValue . '</td>';
}
else echo '<td style="border: 1px solid black"></td>';

//search for track listings
$values = $xpath->query('//rdf:Description[@rdf:about="http://www.worldcat.org/oclc/' . $oclc . '"]//schema:description');
if($values->length>0)
foreach ($values as $value) {
    echo '<td style="border: 1px solid black">' . $value->nodeValue . '</td>';
}
else echo '<td style="border: 1px solid black"></td>';

//search for notes
$notes = $xpath->query('//rdf:Description[@rdf:about="http://www.worldcat.org/oclc/' . $oclc . '"]//schema:about//@rdf:resource');
echo '<td style="border: 1px solid black">';
foreach ($notes as $note){
        $artist = $note->nodeValue ;
$values = $xpath->query('//rdf:Description[@rdf:about="' . $artist . '"]//schema:name' );
if($values->length>0)
foreach ($values as $value){
        echo $value->nodeValue . '; ';
}
}
echo '</td>';

//search for notes (2)
$notes = $xpath->query('//rdf:Description[@rdf:about="http://www.worldcat.org/oclc/' . $oclc . '"]//rdfs:seeAlso//@rdf:resource');
echo '<td style="border: 1px solid black">';
foreach ($notes as $note){
        $artist = $note->nodeValue ;
$values = $xpath->query('//rdf:Description[@rdf:about="' . $artist . '"]//schema:name' );
if($values->length>0)
foreach ($values as $value){
        echo $value->nodeValue . '; ';
}
}
echo '</td>';

//close the table
echo '</tr></table>';

//copy button and javascript
echo '<button id="button" onclick="selectText()">Copy</button>

<button onclick="goBack()">Go Back</button>

<script type="text/javascript">
 function selectText() {
    var range = document.createRange();
    range.selectNode(document.getElementById("dataRow"));
    window.getSelection().addRange(range);
    document.execCommand("copy");
    alert("data copied to clipboard");
}

function goBack() {
    window.history.back();
}

</script>

<p>For best results copying data, use Firefox</p>';

?>
