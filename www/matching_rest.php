
<?php

require_once('config.php');
require_once('../include/PlantList.php');
require_once('../include/TaxonRecord.php');
require_once('../include/content_negotiate.php'); // handles content negotiation so saves us having .htaccess

require_once('header.php');
?>

<h1>Name Matching REST API</h1>

<p style="color: red;">This isn't implemented yet. Just sketching out documentation.</p>

<p>
    The most powerful way to query the name matching service is via the <a href="gql_index.php">GraphQL API</a> 
    however for some application a very simple <a href="https://en.wikipedia.org/wiki/Representational_state_transfer">REST</a> service is sufficient.
    That is what is provided here.
    This is service should be seen as a chopped down version of the GraphQL API. 
    Behind the scenes it uses the same code.
    If you need more complex behaviour you are encouraged to explore the GraphQL API which can be called without the use of client side libraries if necessary.
</p>

<h2>Requests and Responses</h2>

<p>
    Only GET requests are supported. All parameters are optional. Calling without the "input_string" parameter will return this page.
    All requests that provide a value in the "q" parameter will be responded to with a JSON object equivalent to the matching response object provided by the 
    GraphQL API.
</p>

<h2>Request Parameters</h2>

<ul>
    <li><strong>input_string</strong> The name string to be searched for. It should contain a single botanical name. This should include the authors of the name if available. It should be URL encoded.</li>
    <li><strong>check_homonyms</strong> If present with the value "true" then homonyms will be checked for. If a single, exact match of name and author string is found but there are other names with the same letters but a different author strings present the match won't be considered unambiguous. </li>
    <li><strong>check_rank</strong> If present with the value "true" then the rank will be checked for. If a precise match of name and author string is found and it is possible to extract the rank from the name string but the rank isn't the same the match won't be considered unambiguous.</li>
</ul>

<h2>Response</h2>

<p>A JSON object is returned with the following properties</p>

    <ul>
        <li><strong>inputString (string)</strong> The string provided in the input_string parameter.</li>
        <li><strong>searchString (string)</strong> The cleaned up input string used for matching.</li>
        <li><strong>match (name object)</strong> An unambiguous match. Null if an unambiguous match couldn't be found.</li>
        <li><strong>candidates (array of name objects)</strong> An array of name objects that are close matches but not unambiguous.</li>
        <li><strong>method (string)</strong> The name of the matching method used internally.</li>
        <li><strong>error (bool)</strong> True if there was an error to report.</li>
        <li><strong>error (string)</strong> The error message should an error have occured. </li>
        <li><strong>narrative (array of strings)</strong> An explanation of the steps taken to parse the name and match it to the index. This is useful for debugging or explaining to the user what happened!</li>
    </ul>

    <p>The name objects will have the following properties.</p>

    <ul>
        <li><strong>WFO ID</strong> The WFO ID that should be used to refer to this name.</li>

    </ul>

    <p>If you would like more complex information back about the name and its placement in different classifications you are encouraged to use 
        the GraphQL API or you could call the names Stable URI and walk the Semantic Web graph of objects.
    </p>

<h2>Examples</h2>



<?php
require_once('footer.php');
?>