<h1>a Laravel APIs application for a travel agency.</h1>

<h2>Glossary</h2>
<ul>
    <li>Travel is the main unit of the project: it contains all the necessary information, like the number of days, the images, title, etc. An example is Japan: road to Wonder or Norway: the land of the ICE;</li>
    <li>Tour is a specific dates-range of a travel with its own price and details. Japan: road to Wonder may have a tour from 10 to 27 May at €1899, another one from 10 to 15 September at €669 etc. At the end, you will book a tour, not a travel.</li>
</ul>
<h2>Goals</h2>
<h3>At the end, the project should have:</h3>
<ul>
    <li>A private (admin) endpoint to create new users. If you want, this could also be an artisan command, as you like. It will mainly be used to generate users for this exercise;</li>
    <li>A private (admin) endpoint to create new travels;</li>
    <li>A private (admin) endpoint to create new tours for a travel;</li>
    <li>A private (editor) endpoint to update a travel;</li>
    <li>A public (no auth) endpoint to get a list of paginated travels. It must return only public travels;</li>
    <li>A public (no auth) endpoint to get a list of paginated tours by the travel slug (e.g. all the tours of the travel foo-bar). Users can filter (search) the results by priceFrom, priceTo, dateFrom (from that startingDate) and dateTo (until that startingDate). User can sort the list by price asc and desc. They will always be sorted, after every additional user-provided filter, by startingDate asc.</li>
</ul>

<h2>Models</h2>
<h3>Users</h3>
<ul>
    <li>ID</li>
    <li>Email</li>
    <li>Password</li>
    <li>Roles (M2M relationship)</li>
</ul>
<h3>Roles</h3>
<ul>
    <li>ID</li>
    <li>Name</li>
</ul>

<h3>Travels</h3>
<ul>
    <li>ID</li>
    <li>Is Public (bool)</li>
    <li>Slug</li>
    <li>Name</li>
    <li>Description</li>
    <li>Number of days</li>
    <li>Number of nights (virtual, computed by numberOfDays - 1)</li>
</ul>

<h3>Tours</h3>
<ul>
    <li>ID</li>
    <li>Travel ID (M2O relationship)</li>
    <li>Starting date</li>
    <li>Ending date</li>
    <li>Price (integer, see below)</li>
</ul>

<h3>Notes</h3>
<ul>
    <li>Feel free to use the native Laravel authentication.</li>
    <li>We use UUIDs as primary keys instead of incremental IDs, but it's not required for you to use them, although highly appreciated;</li>
    <li>Tours prices are integer multiplied by 100: for example, €999 euro will be 99900, but, when returned to Frontends, they will be formatted (99900 / 100);</li>
    <li>Tours names inside the samples are a kind-of what we use internally, but you can use whatever you want;</li>
    <li>Every admin user will also have the editor role;</li>
    <li>Every creation endpoint, of course, should create one and only one resource. You can't, for example, send an array of resource to create;</li>
    <li>Usage of php-cs-fixer and larastan are a <b>plus</b></li>
    <li>Creating docs is <b>big plus</b></li>
    <li>Feature tests are a <b>big big plus</b></li>
</ul>


